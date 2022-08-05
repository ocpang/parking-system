<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use DB;
use Response;
use Str;
use Excel;
use App\Exports\TransactionExport;
use App\Models\Transaction;
use App\User;

class TransactionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        if(!auth()->user()->can('read transaction')){
            abort(403);
        }

        return view('reports.index');
    }

    public function checkin()
    {        
        if(!auth()->user()->can('create transaction')){
            abort(403);
        }

        return view('transaction.check_in');
    }

    public function checkout()
    {        
        if(!auth()->user()->can('create transaction')){
            abort(403);
        }

        return view('transaction.check_out');
    }

    public function getData(Request $request)
    {
        $data = Transaction::select('transactions.*');

        if($request->rangedate != '') {
            $rangedate   = explode(',',$request->rangedate);
            $start_date  = trim($rangedate[0]);
            $end_date    = trim($rangedate[1]);

            $res_start_date  = date('Y-m-d 00:00:00',strtotime($start_date));
            $res_end_date    = date('Y-m-d 23:59:59',strtotime($end_date));

            $data = $data->whereBetween('transactions.created_at', [$res_start_date, $res_end_date]);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? with(new Carbon($row->created_at))->format('d-m-Y H:i:s') : '';
            })
            ->editColumn('updated_at', function ($row) {
                return $row->updated_at ? with(new Carbon($row->updated_at))->format('d-m-Y H:i:s') : '';
            })
            ->addColumn('action', function ($row) {
                $action = "";
                if(auth()->user()->can('read transaction')){
                    $action .= '<a class="btn btn-info btn-sm text-white" onclick="showDetail(\''.$row->id.'\')" title="View Detail"><i class="fa fa-eye"></i></a> ';
                }

                return $action;
            })
            ->rawColumns(['action'])
        	->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->can('create transaction')){
            abort(403);
        }

        return view('transaction.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        print_r($_POST);
    }

    public function save(Request $request, $id='')
    {   
        $isNewRecord = true;
        $requestData = array();
        if($request->val_code != ''){
            $model = Transaction::find($request->id);
            if( is_null( $model ) ){
                abort(404);
            }
            else{
                $isNewRecord = false;
            }

            $requestData['user_updated'] = auth()->user()->id;
        }
        else{
            $model = new Transaction;

            $code = substr(strtoupper(Str::uuid()), 0, 8);
            $requestData['code'] = $code;
            $requestData['check_in'] = date('Y-m-d H:i:s');
            $requestData['user_created'] = auth()->user()->id;
        }

        $request->flash();

        $rules = [
            'vehicle_no' => ['required', 'string', 'max:15'],
        ];

        if($isNewRecord){
            $rules['code'] = ['string', 'unique:transactions'];
        }

        $messages = [
        //   'regex' => 'The :attribute field can only be entered alphanumeric and underscore.',
        ];

        $validatedData = $request->validate($rules);

        $requestData['vehicle_no'] = strtoupper($request->vehicle_no);

        $requestData = array_merge(array_filter($request->all()), $requestData);
        $model->fill($requestData);

        DB::beginTransaction();
        try {
            if($isNewRecord){
                $check_exist = Transaction::where('vehicle_no', $request->vehicle_no)->whereNull('check_out')->first();
                if($check_exist){
                    return response()->json(array(
                        'status' => 'error',
                        'message' => 'The data has been checked-in'
                    ));
                }
                
                $check_exist = Transaction::where('code', $code)->first();
                if($check_exist){
                    return response()->json(array(
                        'status' => 'error',
                        'message' => 'The code is already exists'
                    ));
                }
            }

            if($model->save()){     
                if($isNewRecord){
                    activity()
                        ->performedOn($model)
                        ->log('created');

                    DB::commit();

                    return response()->json(array(
                        'status' => 'success',
                        'message' => trans('custom.save_success')
                    ));
                    
                }
                else{
                    activity()
                        ->performedOn($model)
                        ->log('edited');
                    DB::commit();

                    return response()->json(array(
                        'status' => 'success',
                        'message' => trans('custom.save_success')
                    ));
                }
                
            }
            else{
                DB::rollBack();
                return response()->json(array(
                    'status' => 'failed',
                    'message' => $model->errors(),
                ));
            }
        }
        catch (Exception $e) {
            DB::rollBack();
            return response()->json(array(
                'status' => 'failed',
                'message' => $e->getMessage(),
            ));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $get_data = Transaction::find($request->id);

        $check_out = "-";
        if($get_data->check_out != ""){
            $check_out = date("d-m-Y H:i:s", strtotime($get_data->check_out));
        }

        $user_updated = "-";
        if($get_data->user_updated > 0){
            $user_updated = ucwords(User::find($get_data->user_updated)->name);
        }

        $html = '<table class="table table-hover table-bordered table-striped" width="100%">';
        $html .= '<tr>';
        $html .= '<th width="40%">Code</th>';
        $html .= '<td>'.$get_data->code.'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<th>Vehicle No</th>';
        $html .= '<td>'.$get_data->vehicle_no.'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<th>Check In</th>';
        $html .= '<td>'.date("d-m-Y H:i:s", strtotime($get_data->check_in)).'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<th>Check Out</th>';
        $html .= '<td>'. $check_out .'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<th>Hours</th>';
        $html .= '<td>'.number_format($get_data->hours, 0, ",", ".").'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<th>Price per hour</th>';
        $html .= '<td>Rp '.number_format($get_data->price, 0, ",", ".").'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<th>Total</th>';
        $html .= '<td class="font-weight-bolder">Rp '.number_format($get_data->total, 0, ",", ".").'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<th>User Created</th>';
        $html .= '<td>'.ucwords(User::find($get_data->user_created)->name).'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<th>User Updated</th>';
        $html .= '<td>'. $user_updated .'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<th>Time Created</th>';
        $html .= '<td>'.date("d-m-Y H:i:s", strtotime($get_data->created_at)).'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<th>Time Updated</th>';
        $html .= '<td>'.date("d-m-Y H:i:s", strtotime($get_data->updated_at)).'</td>';
        $html .= '</tr>';
        $html .= '</table>';

        $response = array(
            'html' => $html,
        );

        return Response::json($response);
    }

    public function check(Request $request)
    {

        $rules['code'] = ['string', 'max:8'];
        
        $validatedData = $request->validate($rules);

        $get_data = Transaction::where('code', strtoupper($request->code))->first();

        if($get_data){
            if($get_data->check_out == ""){
                $check_out = date("Y-m-d H:i:s");
                $from_time = strtotime($get_data->check_in); 
                $to_time = strtotime($check_out); 
                $diff_minutes = round(abs($from_time - $to_time) / 60, 2);
                $diff_hours = round($diff_minutes / 60);
                if($diff_hours == 0){
                    $diff_hours = 1;
                }

                $price = config('app.price');
                $total = $diff_hours * $price;

                $response = array(
                    'status' => 'success',
                    'message' => 'Data valid',
                    'data' => array(
                        'id' => $get_data->id,
                        'code' => $get_data->code,
                        'vehicle_no' => $get_data->vehicle_no,
                        'check_in' => $get_data->check_in,
                        'check_out' => $check_out,
                        'hours' => $diff_hours,
                        'txt_hours' => number_format($diff_hours, 0, ",", "."),
                        'price' => $price,
                        'txt_price' => "Rp " . number_format($price, 0, ",", "."),
                        'total' => $total,
                        'txt_total' => "Rp " . number_format($total, 0, ",", "."),
                    )
                );
            }    
            else{
                return response()->json(array(
                    'status' => 'error',
                    'message' => 'The data has been checked-out'
                ));
            }
        }
        else{
            return response()->json(array(
                'status' => 'error',
                'message' => 'The data not found'
            ));
        }

        return Response::json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id=0)
    {
        if(!auth()->user()->can('update transaction')){
            abort(403);
        }

        $model = Transaction::find($id);
        if($model == null){
            abort(404);
        }

        $data = array(
            'transaction'          => $model,
        );

		return view('transaction.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $model = Transaction::find($id);
            if($model->delete()){
                activity()
                    ->performedOn($model)
                    ->log('deleted');
                
                DB::commit();

                return response()->json(array(
                    'status' => 'success',
                    'message' => trans('custom.delete_success')
                ));
            }
            else{
                DB::rollBack();

                return response()->json(array(
                    'status' => 'failed',
                    'message' => $model->getErrors()
                ));
            }
        } 
        catch (Exception $e) {
            DB::rollBack();
            
            return response()->json(array(
                'status' => 'failed',
                'message' => $e->getMessage(),
            ));
        }
    }
    
    public function export_excel(Request $request)
    {
      $res_start_date = "";
      $res_end_date = "";
      if($request->rangedate != '') {
          $rangedate   = explode(',',$request->rangedate);
          $start_date  = trim($rangedate[0]);
          $end_date    = trim($rangedate[1]);

          $res_start_date  = date('Y-m-d 00:00:00',strtotime($start_date));
          $res_end_date    = date('Y-m-d 23:59:59',strtotime($end_date));
      }

      $param = array(
          'start_date' => $res_start_date,
          'end_date' => $res_end_date,
      );

      return Excel::download(new TransactionExport($param), 'Report Transaction.xlsx');
    }
      
}

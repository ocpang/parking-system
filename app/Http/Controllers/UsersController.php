<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Auth;
use DB;
use Response;
use Validator;
use App\User;
use App\Models\Role;
use App\Models\Modelhasroles;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
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
        if(!auth()->user()->can('read user')){
            abort(403);
        }

        return view('user.index');
    }

    public function getData(Request $request)
    {
        $data = User::select('users.*');

        if($request->rangedate != '') {
            $rangedate   = explode(',',$request->rangedate);
            $start_date  = trim($rangedate[0]);
            $end_date    = trim($rangedate[1]);

            $res_start_date  = date('Y-m-d 00:00:00',strtotime($start_date));
            $res_end_date    = date('Y-m-d 23:59:59',strtotime($end_date));

            $data = $data->whereBetween('users.created_at', [$res_start_date, $res_end_date]);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                $get_role = Role::find($row->role_id);
                $role_name = '';
                if($get_role){
                    $role_name = $get_role->name;
                    if($role_name == 'admin')
                        $role_name = '<span class="badge badge-primary">'.ucwords($role_name).'</span>';
                    
                }

                $status = $row->status == '0' ? 'Not Active' : 'Active';
                return $status . '<br>' . $role_name;
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? with(new Carbon($row->created_at))->format('d-m-Y H:i:s') : '';
            })
            ->addColumn('action', function ($row) {
                $action = "";
                if(auth()->user()->can('read user')){
                    $action .= '<a class="btn btn-info btn-sm text-white" onclick="showDetail(\''.$row->id.'\')" title="View Detail"><i class="fa fa-eye"></i></a> ';
                }

                if(auth()->user()->can('update user')){
                    $action .= '<a title="Edit" class="btn btn-warning btn-sm text-white" href="'. route("user.edit") .'/'. $row->id .'"><i class="fa fa-edit"></i></a> ';
                }

                if(auth()->user()->can('delete user')){
                    $action .= '<a href="javascript:void(0);" onclick="deleteData(\''.$row->id.'\', \''. route("user.delete") .'\')" class="btn btn-danger btn-sm text-white" title="Delete"><i class="fa fa-trash"></i></a> ';
                }

                return $action;
            })
            ->rawColumns(['status', 'action'])
        	->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->can('create user')){
            abort(403);
        }

        $role = Role::orderBy('name', 'asc')->get();

        return view('user.create', compact('role'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
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
        if($id != ''){
            $model = User::find($id);
            $model->user_updated = auth()->user()->id;
            if( is_null( $model ) ){
                abort(404);
            }
            else{
                $isNewRecord = false;
            }
        }
        else{
            $model = new User;
            $requestData['user_created'] = auth()->user()->id;
        }

        $request->flash();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            // 'user_name' => ['required', 'string', 'max:255', 'regex:/[\w\s]$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ];

        $messages = [
        //   'regex' => 'The :attribute field can only be entered alphanumeric and underscore.',
        ];

        if($isNewRecord){
            $rules['role_id'] = ['required'];
            $rules['password'] = ['required', 'string', 'min:5', 'confirmed'];
        }
        else{
            // $rules['user_name'] = ['sometimes'];
            $rules['email'] = ['required', 'string', 'email', 'max:255', 
                function ($attribute, $value, $fail) {
                        
                    $model = User::whereNotIn('id', [$_POST['id']])->where('email', $value)->get()->count();
                    if ($model == 0) {
                        // The passwords match...
                    }
                    else{
                        $fail('The ' .$attribute.' has already been taken.');
                    }
                }
            ];
            $rules['password'] = ['sometimes', 'required', 'string', 
                function ($attribute, $value, $fail) {
                    
                    $model = User::find($_POST['id']);
                    if (Hash::check($value, $model->password)) {
                        // The passwords match...
                    }
                    else{
                        $fail('The ' .$attribute.' does not matches with the password you provided.');
                    }
                }
            ];
            $rules['new_password'] = ['sometimes','required','string','min:5','confirmed', 
                function ($attribute, $value, $fail){
                    $model = User::find($_POST['id']);
                    if (Hash::check($value, $model->password)) {
                        // The passwords match...
                        $attribute = str_replace('_', ' ', $attribute);
                        $fail('The ' .$attribute.' cannot be same as your current password.');
                    }
                    else{
                        // The passwords different with current password...
                    }
                }
            ];
        }

        $validatedData = $request->validate($rules);

        $requestData = array_merge(array_filter($request->all()), $requestData);
        if(!is_null($request->password)){
            $requestData['password'] = Hash::make($request->password);
        }
        if(!is_null($request->new_password)){
            $requestData['password'] = Hash::make($request->new_password);
        }

        $requestData['name'] = ucwords($request->name);

        $model->fill($requestData);

        DB::beginTransaction();
        try {
            if($model->save()){
                
                if($isNewRecord){
                    $user = User::find($model->id);
                    $user->assignRole(Role::find($request->role_id)->name);

                    activity()
                        ->performedOn($model)
                        ->log('created');
                }
                else{
                    activity()
                        ->performedOn($model)
                        ->log('edited');
                }

                DB::commit();

                return response()->json(array(
                    'status' => 'success',
                    'message' => trans('custom.save_success')
                ));
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
        $get_data = User::find($request->id);
        $status = $get_data->status == 0 ? 'Not Active' : 'Active';
        
        $html = '<table class="table table-hover table-bordered table-striped" width="100%">';
        $html .= '<tr>';
        $html .= '<th width="40%">Name</th>';
        $html .= '<td>'.ucwords($get_data->name).'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<th>Email</th>';
        $html .= '<td>'.$get_data->email.'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<th>Type</th>';
        $html .= '<td>'.ucwords($get_data->role->pluck('name')->first()).'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<th>Status</th>';
        $html .= '<td>'.$status.'</td>';
        $html .= '</tr>';
        $html .= '</table>';

        $response = array(
            'html' => $html,
        );

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
        if(!auth()->user()->can('update user')){
            abort(403);
        }

        $model = User::find($id);
        if($model == null){
            abort(404);
        }

        $role = Role::orderBy('name', 'asc')->get();

        $data = array(
            'user'          => $model,
            'role'          => $role,
        );

		return view('user.edit', $data);
    }

    public function changePassword()
    {
        return view('user.change_password');
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

    public function savePassword(Request $request, $id='')
    {   
        $isNewRecord = true;
        $requestData = array();
        $user = \Auth::user();
        if($id != ''){
            $model = User::find($id);
            $model->user_updated = auth()->user()->id;
            if( is_null( $model ) ){
                abort(404);
            }
            else{
                $isNewRecord = false;
            }
        }

        $request->flash();

        $rules = [
            'old_password' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        $messages = [
          'regex' => 'The :attribute field can only be entered alphanumeric and underscore.',
        ];

        $rules['old_password'] = ['sometimes', 'required', 'string', 
            function ($attribute, $value, $fail) {
                
                $model = User::find($_POST['id']);
                if (Hash::check($value, $model->password)) {
                    // The passwords match...
                }
                else{
                    $attribute = str_replace('_', ' ', $attribute);
                    $fail('The ' .$attribute.' does not matches with the password you provided.');
                }
            }
        ];
        $rules['new_password'] = ['sometimes','required','string','min:8','confirmed', 
            function ($attribute, $value, $fail){
                $model = User::find($_POST['id']);
                if (Hash::check($value, $model->password)) {
                    // The passwords match...
                    $attribute = str_replace('_', ' ', $attribute);
                    $fail('The ' .$attribute.' cannot be same as your current password.');
                }
                else{
                    // The passwords different with current password...
                }
            }
        ];

        $validatedData = $request->validate($rules);

        $requestData = array_merge(array_filter($request->all()), $requestData);
        if(!is_null($request->password)){
            $requestData['password'] = Hash::make($request->password);
        }
        if(!is_null($request->new_password)){
            $requestData['password'] = Hash::make($request->new_password);
        }

        $model->fill($requestData);

        DB::beginTransaction();
        try {
            if($model->save()){
                activity()
                    ->performedOn($model)
                    ->log('change password');

                DB::commit();

                return response()->json(array(
                    'status' => 'success',
                    'message' => trans('custom.save_success')
                ));
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $model = User::find($id);
            $model->user_deleted = auth()->user()->id;
            if($model->save()){
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
    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use DB;
use Response;
use Str;
use App\Models\Book;

class BooksController extends Controller
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
        if(!auth()->user()->can('read book') && !auth()->user()->can('create book')){
            abort(403);
        }

        return view('book.index');
    }

    public function getData(Request $request)
    {
        $data = Book::select('books.*');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $action = "";
                if(auth()->user()->can('read book')){
                    $action .= '<a class="btn btn-info btn-sm text-white" onclick="showDetail(\''.$row->id.'\')" title="View Detail"><i class="fa fa-eye"></i></a> ';
                }

                if(auth()->user()->can('update book')){
                    $action .= '<a title="Edit" class="btn btn-warning btn-sm text-white" href="'. route("book.edit") .'/'. $row->id .'"><i class="fa fa-edit"></i></a> ';
                }

                if(auth()->user()->can('delete book')){
                    $action .= '<a href="javascript:void(0);" onclick="deleteData(\''.$row->id.'\', \''. route("book.delete") .'\')" class="btn btn-danger btn-sm text-white" title="Delete"><i class="fa fa-trash"></i></a> ';
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
        if(!auth()->user()->can('create book')){
            abort(403);
        }

        return view('book.create');
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
            $model = Book::find($id);
            if( is_null( $model ) ){
                abort(404);
            }
            else{
                $isNewRecord = false;
            }
        }
        else{
            $model = new Book;
        }

        $request->flash();

        $rules = [
            'title' => ['required', 'string', 'max:100'],
            'author' => ['required', 'string', 'max:100'],
            'genre' => ['required', 'string', 'max:100'],
        ];

        $messages = [
        //   'regex' => 'The :attribute field can only be entered alphanumeric and underscore.',
        ];

        $validatedData = $request->validate($rules);

        $requestData = array_merge(array_filter($request->all()), $requestData);
        $model->fill($requestData);

        DB::beginTransaction();
        try {
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
        $get_data = Book::find($request->id);

        $html = '<table class="table table-hover table-bordered table-striped" width="100%">';
        $html .= '<tr>';
        $html .= '<th width="40%">Title</th>';
        $html .= '<td>'.ucwords($get_data->title).'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<th>Author</th>';
        $html .= '<td>'.$get_data->author.'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<th>Genre</th>';
        $html .= '<td>'.$get_data->genre.'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<th>Vote Count</th>';
        $html .= '<td>'.number_format($get_data->vote_count, 0).'</td>';
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
        if(!auth()->user()->can('update book')){
            abort(403);
        }

        $model = Book::find($id);
        if($model == null){
            abort(404);
        }

        $data = array(
            'book'          => $model,
        );

		return view('book.edit', $data);
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
            $model = Book::find($id);
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
    
}

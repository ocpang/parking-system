<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Auth;
use DB;
use Response;
use Str;
use Session;
use Redirect;
use Spatie\Permission\Models\Permission;


class PermissionsController extends Controller
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
        if(!auth()->user()->can('read permission')){
            abort(403);
        }

        $permissions = Permission::all()->pluck('name');
        $data = array(
            'permissions'          => $permissions,
        );

        return view('permission.index', $data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->can('create permission')){
            abort(403);
        }

        return view('permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $id = $request->id;
        $isNewRecord = true;
        $requestData = array();
        if($id != ''){
            $model = Permission::find($id);
            $model->user_updated = auth()->user()->id;
            if( is_null( $model ) ){
                abort(404);
            }
            else{
                $isNewRecord = false;
            }
        }
        else{
            $model = new Permission;
            // $requestData['id'] = Str::uuid();
            // $requestData['user_created'] = auth()->user()->id;
        }

        $request->flash();

        $rules = [
            'name' => ['required', 'string', 'max:191', 'unique:permissions'],
        ];

        $messages = [
        //   'regex' => 'The :attribute field can only be entered alphanumeric and underscore.',
        ];

        $requestData = array_merge(array_filter($request->all()), $requestData);
        $validatedData = $request->validate($rules);
        $model->fill($requestData);

        DB::beginTransaction();
        try {
            if($model->save()){     
                if($isNewRecord){
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

                // return response()->json(array(
                //     'status' => 'success',
                //     'message' => trans('custom.save_success')
                // ));

                Session::flash('success', 'Successfully created permission!');
                return Redirect::to('permission');
            }
            else{
                DB::rollBack();
                Session::flash('message', 'Failed create permission!');
                return Redirect::to('permission');
            }
        }
        catch (Exception $e) {
            DB::rollBack();
            Session::flash('message', 'Failed create permission!');
            return Redirect::to('permission');
        }
    }

}
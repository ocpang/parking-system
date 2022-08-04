<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use DB;
use Response;
use Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesController extends Controller
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
    	if(!auth()->user()->can('read role')){
            abort(403);
        }
        
        $roles = Role::all();
    	$data = array(
            'roles'          => $roles,
        );

		return view('role.index', $data);
    }

    public function assign(Request $request, $id=0)
    {
        // Create || Update
    	if(!auth()->user()->can('create role') && !auth()->user()->can('update role')){
            abort(403);
        }
        
        $permissionOfRole = array();
    	$role_id = $id;
    	$roleModel = Role::find($role_id);
        if($roleModel != null){
        	$permissionOfRole = Role::find($request->id)->permissions()->pluck('id')->toArray();
        }
        // dd($permissionOfRole);
    	$permissions = Permission::all();
    	$roles = Role::all();

    	$data = array(
    		'roles'					=> $roles,
    		'permissions'			=> $permissions,
    		'permissionOfRole'		=> $permissionOfRole,
    		'role_id'				=> $role_id
    	);
    	return view('role.assign', $data);
    }

    public function saveAssign(Request $request)
    {
    	$requestData = array();
    	$permissions = array();

    	$id = $request->role_id;
    	if(isset($request->permissions))
    		$permissions = $request->permissions;
       
        $model = Role::find($id);
        if( is_null( $model ) ){
            abort(404);
        }
        
        $request->flash();

        $rules = [
            'role_id' => ['required', 'string'],
            // 'permissions' => ['required', 'string'],
        ];

        $messages = [
        //   'regex' => 'The :attribute field can only be entered alphanumeric and underscore.',
        ];

        $requestData = array_merge(array_filter($request->all()), $requestData);
        $validatedData = $request->validate($rules);
        $model->fill($requestData);

        // dd($requestData);
        // dd($request->permissions);
        if(is_array($permissions)){
        	$model->syncPermissions($permissions);
        	\Session::flash('success', 'Successfully assigned!');
            return redirect()->route('role');
        }
        \Session::flash('error', 'Assign failed!');
        return redirect()->back();
        // DB::beginTransaction();
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Role;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    //
    public function index(){
        $roles = Role::all();

        $roles = DB::select('SELECT nama_role FROM roles');
        if(count($roles) >0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $roles
            ],200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ],404);
    }


    public function show($id){
        $role = Role::find($id);

        if(!is_null($role)){
            return response([
                'message' => 'Retrieve Role Success',
                'data' => $role
            ],200);
        }

        return response([
            'message' => 'Role Not Found',
            'data' => null
        ],404);
    }


    public function store(Request $request){
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_role'=> 'required|max:60|unique:roles',
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $role = Role::create($storeData);
        return response([
            'message' => 'Add Role Success',
            'data' => $role,
        ],200);
    }


    public function destroy($id){
        $role = Role::find($id);

        if(is_null($role)){
            return response([
                'message' => 'Role Not Found',
                'data' => null
            ],404);
        }

        if($role->delete()){
            return response([
                'message' => ' Delete Role Success',
                'data' => $role,
            ],200);
        }
        return response([
            'message' => 'Delete Role Failed',
            'data' => null,
        ],400);
    }


    public function update(Request $request, $id){
        $role = Role::find($id);
        if(is_null($role)){
            return response([
                'message' => 'Role Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_role' => ['max:60',Rule::unique('roles')->ignore($role)],
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $role->nama_role = $updateData['nama_role'];

        if($role->save()){
            return response([
                'message' => 'Update Role Success',
                'data' => $role,
            ],200);
        }
        return response([
            'message' => 'Update Role Failed',
            'data' => null,
        ],400);
    }
}

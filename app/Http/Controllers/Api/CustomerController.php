<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Customer;

class CustomerController extends Controller
{
    //
    public function index(){
        $customers = Customer::all();

        if(count($customers) >0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $customers
            ],200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ],404);
    }


    public function show($id){
        $customer = Customer::find($id);

        if(!is_null($customer)){
            return response([
                'message' => 'Retrieve Customer Success',
                'data' => $customer
            ],200);
        }

        return response([
            'message' => 'Customer Not Found',
            'data' => null
        ],404);
    }


    public function store(Request $request){
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_customer'=> 'required|max:60|unique:customers',
            'noTelp_customer'=> 'required',
            'email_customer' => 'required',
            'alamat_customer' => 'required',
            'jenisKelamin_customer' => 'required',
            'tglLahir_customer' => 'required',
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $customer = Customer::create($storeData);
        return response([
            'message' => 'Add Customer Success',
            'data' => $customer,
        ],200);
    }


    public function destroy($id){
        $customer = Customer::find($id);

        if(is_null($customer)){
            return response([
                'message' => 'Customer Not Found',
                'data' => null
            ],404);
        }

        if($customer->delete()){
            return response([
                'message' => ' Delete Customer Success',
                'data' => $customer,
            ],200);
        }
        return response([
            'message' => 'Delete Customer Failed',
            'data' => null,
        ],400);
    }


    public function update(Request $request, $id){
        $customer = Customer::find($id);
        if(is_null($customer)){
            return response([
                'message' => 'Customer Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_customer' => ['max:60',Rule::unique('customers')->ignore($customer)],
            'noTelp_customer',
            'email_customer',
            'alamat_customer',
            'jenisKelamin_customer',
            'tglLahir_customer'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $customer->nama_customer = $updateData['nama_customer'];
        $customer->noTelp_customer = $updateData['noTelp_customer'];
        $customer->email_customer = $updateData['email_customer'];
        $customer->alamat_customer = $updateData['alamat_customer'];
        $customer->jenisKelamin_customer = $updateData['jenisKelamin_customer'];
        $customer->tglLahir_customer = $updateData['tglLahir_customer'];

        if($customer->save()){
            return response([
                'message' => 'Update Customer Success',
                'data' => $customer,
            ],200);
        }
        return response([
            'message' => 'Update Customer Failed',
            'data' => null,
        ],400);
    }
}


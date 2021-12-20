<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Produk;

class ProdukController extends Controller
{
    //
    public function index(){
        $produks = Produk::all();

        if(count($produks) >0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $produks
            ],200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ],404);
    }


    public function show($id){
        $produk = Produk::find($id);

        if(!is_null($produk)){
            return response([
                'message' => 'Retrieve Produk Success',
                'data' => $produk
            ],200);
        }

        return response([
            'message' => 'Produk Not Found',
            'data' => null
        ],404);
    }


    public function store(Request $request){
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_produk'=> 'required|max:60|unique:produks',
            'berat_produk'=> 'required',
            'harga_produk' => 'required',
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $produk = Produk::create($storeData);
        return response([
            'message' => 'Add Produk Success',
            'data' => $produk,
        ],200);
    }


    public function destroy($id){
        $produk = Produk::find($id);

        if(is_null($produk)){
            return response([
                'message' => 'Produk Not Found',
                'data' => null
            ],404);
        }

        if($produk->delete()){
            return response([
                'message' => ' Delete Produk Success',
                'data' => $produk,
            ],200);
        }
        return response([
            'message' => 'Delete Produk Failed',
            'data' => null,
        ],400);
    }


    public function update(Request $request, $id){
        $produk = Produk::find($id);
        if(is_null($produk)){
            return response([
                'message' => 'Produk Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_produk' => ['max:60',Rule::unique('produks')->ignore($produk)],
            'berat_produk',
            'harga_produk',
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $produk->nama_produk = $updateData['nama_produk'];
        $produk->berat_produk = $updateData['berat_produk'];
        $produk->harga_produk = $updateData['harga_produk'];

        if($produk->save()){
            return response([
                'message' => 'Update Produk Success',
                'data' => $produk,
            ],200);
        }
        return response([
            'message' => 'Update Produk Failed',
            'data' => null,
        ],400);
    }
}


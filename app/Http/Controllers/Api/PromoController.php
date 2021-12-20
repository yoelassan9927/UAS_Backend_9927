<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Promo;

class PromoController extends Controller
{
    //
    public function index(){
        $promos = Promo::all();

        if(count($promos) >0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $promos
            ],200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ],404);
    }


    public function show($id){
        $promo = Promo::find($id);

        if(!is_null($promo)){
            return response([
                'message' => 'Retrieve Promo Success',
                'data' => $promo
            ],200);
        }

        return response([
            'message' => 'Promo Not Found',
            'data' => null
        ],404);
    }


    public function store(Request $request){
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'kode_promo'=> 'required|max:60|unique:promos',
            'keterangan_promo'=> 'required',
            'jenis_promo' => 'required',
            'tglAktif_promo' => 'required',
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $promo = Promo::create($storeData);
        return response([
            'message' => 'Add Promo Success',
            'data' => $promo,
        ],200);
    }


    public function destroy($id){
        $promo = Promo::find($id);

        if(is_null($promo)){
            return response([
                'message' => 'Promo Not Found',
                'data' => null
            ],404);
        }

        if($promo->delete()){
            return response([
                'message' => ' Delete Promo Success',
                'data' => $promo,
            ],200);
        }
        return response([
            'message' => 'Delete Promo Failed',
            'data' => null,
        ],400);
    }


    public function update(Request $request, $id){
        $promo = Promo::find($id);
        if(is_null($promo)){
            return response([
                'message' => 'Promo Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'kode_promo' => ['max:60',Rule::unique('promos')->ignore($promo)],
            'keterangan_promo',
            'jenis_promo',
            'tglAktif_promo'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $promo->kode_promo = $updateData['kode_promo'];
        $promo->keterangan_promo = $updateData['keterangan_promo'];
        $promo->jenis_promo = $updateData['jenis_promo'];
        $promo->tglAktif_promo = $updateData['tglAktif_promo'];

        if($promo->save()){
            return response([
                'message' => 'Update Promo Success',
                'data' => $promo,
            ],200);
        }
        return response([
            'message' => 'Update Promo Failed',
            'data' => null,
        ],400);
    }
}


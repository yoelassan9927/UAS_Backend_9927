<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Perawatan;

class PerawatanController extends Controller
{
    //
    public function index(){
        $perawatans = Perawatan::all();

        if(count($perawatans) >0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $perawatans
            ],200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ],404);
    }


    public function show($id){
        $perawatan = Perawatan::find($id);

        if(!is_null($perawatan)){
            return response([
                'message' => 'Retrieve Perawatan Success',
                'data' => $perawatan
            ],200);
        }

        return response([
            'message' => 'Perawatan Not Found',
            'data' => null
        ],404);
    }


    public function store(Request $request){
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_perawatan'=> 'required|max:60|unique:perawatans',
            'deskripsi_perawatan'=> 'required',
            'jenis_perawatan' => 'required',
            'potongan_poin' => 'required',
            'harga_perawatan' => 'required',
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $perawatan = Perawatan::create($storeData);
        return response([
            'message' => 'Add Perawatan Success',
            'data' => $perawatan,
        ],200);
    }


    public function destroy($id){
        $perawatan = Perawatan::find($id);

        if(is_null($perawatan)){
            return response([
                'message' => 'Perawatan Not Found',
                'data' => null
            ],404);
        }

        if($perawatan->delete()){
            return response([
                'message' => ' Delete Perawatan Success',
                'data' => $perawatan,
            ],200);
        }
        return response([
            'message' => 'Delete Perawatan Failed',
            'data' => null,
        ],400);
    }


    public function update(Request $request, $id){
        $perawatan = Perawatan::find($id);
        if(is_null($perawatan)){
            return response([
                'message' => 'Perawatan Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_perawatan' => ['max:60',Rule::unique('perawatans')->ignore($perawatan)],
            'deskripsi_perawatan',
            'jenis_perawatan',
            'potongan_poin',
            'harga_perawatan'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $perawatan->nama_perawatan = $updateData['nama_perawatan'];
        $perawatan->deskripsi_perawatan = $updateData['deskripsi_perawatan'];
        $perawatan->jenis_perawatan = $updateData['jenis_perawatan'];
        $perawatan->potongan_poin = $updateData['potongan_poin'];
        $perawatan->harga_perawatan = $updateData['harga_perawatan'];

        if($perawatan->save()){
            return response([
                'message' => 'Update Perawatan Success',
                'data' => $perawatan,
            ],200);
        }
        return response([
            'message' => 'Update Perawatan Failed',
            'data' => null,
        ],400);
    }
}


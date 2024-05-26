<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\StatusPerkawinanKk;
use Validator;

class StatusPerkawinanKkController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $status_perkawinan_kk = StatusPerkawinanKk::orderBy('id', 'asc')->get();

        return $this->sendResponse($status_perkawinan_kk, "Fetch status perkawinan kk success");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id) {
        $status_perkawinan_kk = StatusPerkawinanKk::where('id', $id)->first();

        if (!$status_perkawinan_kk) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($status_perkawinan_kk, 'Fetch status perkawinan kk success');
    }

    /**
     * Insert new resource.
     *
     * @param  request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        $status_perkawinan_kk = StatusPerkawinanKk::create($request->all());

        return $this->sendResponse($status_perkawinan_kk, "Submit status perkawinan kk success", 201);
    }

    /**
     * Modified the specific resource.
     *
     * @param  request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateById(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'nomor_sk' => '',
            'tanggal_sk' => '',
            'ttd_sk' => '',
            'keterangan' => '',
            'pegawai_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        $status_perkawinan_kk = StatusPerkawinanKk::where('id', $id)->first();

        if (!$status_perkawinan_kk) {
            return $this->sendError('Not Found', false, 404);
        }

        StatusPerkawinanKk::whereId($id)->update($request->all());
        $update = StatusPerkawinanKk::where('id', $id)->first();

        return $this->sendResponse($update, "Update status perkawinan kk success");
    }

    /**
     * Remove the specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteById($id) {
        $status_perkawinan_kk = StatusPerkawinanKk::whereId($id)->delete();

        if (!$status_perkawinan_kk) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete status perkawinan kk success');
    }

}

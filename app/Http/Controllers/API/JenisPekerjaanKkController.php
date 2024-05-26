<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\JenisPekerjaanKk;
use Validator;

class JenisPekerjaanKkController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $jenis_pekerjaan_kk = JenisPekerjaanKk::orderBy('id', 'asc')->get();

        return $this->sendResponse($jenis_pekerjaan_kk, "Fetch jenis pekerjaan kk success");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id) {
        $jenis_pekerjaan_kk = JenisPekerjaanKk::where('id', $id)->first();

        if (!$jenis_pekerjaan_kk) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($jenis_pekerjaan_kk, 'Fetch jenis pekerjaan kk success');
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

        $jenis_pekerjaan_kk = JenisPekerjaanKk::create($request->all());

        return $this->sendResponse($jenis_pekerjaan_kk, "Submit jenis pekerjaan kk success", 201);
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

        $jenis_pekerjaan_kk = JenisPekerjaanKk::where('id', $id)->first();

        if (!$jenis_pekerjaan_kk) {
            return $this->sendError('Not Found', false, 404);
        }

        JenisPekerjaanKk::whereId($id)->update($request->all());
        $update = JenisPekerjaanKk::where('id', $id)->first();

        return $this->sendResponse($update, "Update jenis pekerjaan kk success");
    }

    /**
     * Remove the specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteById($id) {
        $jenis_pekerjaan_kk = JenisPekerjaanKk::whereId($id)->delete();

        if (!$jenis_pekerjaan_kk) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete jenis pekerjaan kk success');
    }

}

<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Pekerjaan;
use Validator;

class PekerjaanController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $pegawai_id = $request->query('pegawai_id') ?? '';

        if ($pegawai_id) {
            $pekerjaan = Pekerjaan::with(['pegawai'])->where('pegawai_id', $pegawai_id)->orderBy('updated_at', 'desc')->get();
        } else {
            $pekerjaan = Pekerjaan::with(['pegawai'])->orderBy('updated_at', 'desc')->get();
        }

        return $this->sendResponse($pekerjaan, "Fetch pekerjaan success");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id) {
        $pekerjaan = Pekerjaan::with(['pegawai'])->where('id', $id)->first();

        if (!$pekerjaan) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($pekerjaan, 'Fetch pekerjaan success');
    }

    /**
     * Insert new resource.
     *
     * @param  request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
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

        $pekerjaan = Pekerjaan::create($request->all());

        return $this->sendResponse($pekerjaan, "Submit pekerjaan success", 201);
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

        $pekerjaan = Pekerjaan::where('id', $id)->first();

        if (!$pekerjaan) {
            return $this->sendError('Not Found', false, 404);
        }

        Pekerjaan::whereId($id)->update($request->all());
        $update = Pekerjaan::where('id', $id)->first();

        return $this->sendResponse($update, "Update pekerjaan success");
    }

    /**
     * Remove the specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteById($id) {
        $pekerjaan = Pekerjaan::whereId($id)->forceDelete();

        if (!$pekerjaan) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete pekerjaan success');
    }

}

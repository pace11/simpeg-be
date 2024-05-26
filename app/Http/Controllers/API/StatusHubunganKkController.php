<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\StatusHubunganKk;
use Validator;

class StatusHubunganKkController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $status_hubungan_kk = StatusHubunganKk::orderBy('id', 'asc')->get();

        return $this->sendResponse($status_hubungan_kk, "Fetch status hubungan kk success");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id) {
        $status_hubungan_kk = StatusHubunganKk::where('id', $id)->first();

        if (!$status_hubungan_kk) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($status_hubungan_kk, 'Fetch status hubungan kk success');
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

        $status_hubungan_kk = StatusHubunganKk::create($request->all());

        return $this->sendResponse($status_hubungan_kk, "Submit status hubungan kk success", 201);
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

        $status_hubungan_kk = StatusHubunganKk::where('id', $id)->first();

        if (!$status_hubungan_kk) {
            return $this->sendError('Not Found', false, 404);
        }

        StatusHubunganKk::whereId($id)->update($request->all());
        $update = StatusHubunganKk::where('id', $id)->first();

        return $this->sendResponse($update, "Update status hubungan kk success");
    }

    /**
     * Remove the specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteById($id) {
        $status_hubungan_kk = StatusHubunganKk::whereId($id)->delete();

        if (!$status_hubungan_kk) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete status hubungan kk success');
    }

}

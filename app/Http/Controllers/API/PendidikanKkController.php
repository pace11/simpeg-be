<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\PendidikanKk;
use Validator;

class PendidikanKkController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $pendidikan_kk = PendidikanKk::orderBy('id', 'asc')->get();

        return $this->sendResponse($pendidikan_kk, "Fetch pendidikankk success");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id) {
        $pendidikan_kk = PendidikanKk::where('id', $id)->first();

        if (!$pendidikan_kk) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($pendidikan_kk, 'Fetch pendidikankk success');
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

        $pendidikan_kk = PendidikanKk::create($request->all());

        return $this->sendResponse($pendidikan_kk, "Submit pendidikankk success", 201);
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

        $pendidikan_kk = PendidikanKk::where('id', $id)->first();

        if (!$pendidikan_kk) {
            return $this->sendError('Not Found', false, 404);
        }

        PendidikanKk::whereId($id)->update($request->all());
        $update = PendidikanKk::where('id', $id)->first();

        return $this->sendResponse($update, "Update pendidikankk success");
    }

    /**
     * Remove the specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteById($id) {
        $pendidikan_kk = PendidikanKk::whereId($id)->delete();

        if (!$pendidikan_kk) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete pendidikankk success');
    }

}

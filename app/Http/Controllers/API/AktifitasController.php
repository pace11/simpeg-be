<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Aktifitas;
use Validator;

class AktifitasController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $pegawai_id = $request->query('pegawai_id') ?? '';

        $filter = [];
        if ($pegawai_id) $filter = [['pegawai_id', '=', $pegawai_id]];

        $aktifitas = Aktifitas::where($filter)->orderBy('id', 'asc')->get();

        return $this->sendResponse($aktifitas, "Fetch data success");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id) {
        $aktifitas = Aktifitas::where('id', $id)->first();
        
        return $this->sendResponse($aktifitas, 'Fetch data success');
    }

    /**
     * Insert new resource.
     *
     * @param  request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'tgl_aktifitas' => 'required',
            'aktifitas' => 'required',
            'pegawai_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        $aktifitas = Aktifitas::create($request->all());

        return $this->sendResponse($aktifitas, "Submit data success", 201);
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
            'tgl_aktifitas' => 'required',
            'aktifitas' => 'required',
            'pegawai_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        $aktifitas = Aktifitas::where('id', $id)->first();

        if (!$aktifitas) {
            return $this->sendError('Not Found', false, 404);
        }

        Aktifitas::whereId($id)->update($request->all());
        $update = Aktifitas::where('id', $id)->first();

        return $this->sendResponse($update, "Update data success");
    }

    /**
     * Remove the specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteById($id) {
        $aktifitas = Aktifitas::whereId($id)->forceDelete();

        if (!$aktifitas) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete data success');
    }

}

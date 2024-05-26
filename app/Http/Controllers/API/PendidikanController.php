<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Pendidikan;
use Validator;

class PendidikanController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $pegawai_id = $request->query('pegawai_id') ?? '';

        if ($pegawai_id) {
            $pendidikan = Pendidikan::with(['pegawai', 'pendidikan_terakhir'])->where('pegawai_id', $pegawai_id)->orderBy('updated_at', 'desc')->get();
        } else {
            $pendidikan = Pendidikan::with(['pegawai', 'pendidikan_terakhir'])->orderBy('updated_at', 'desc')->get();
        }

        return $this->sendResponse($pendidikan, "Fetch pendidikan success");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id) {
        $pendidikan = Pendidikan::with(['pegawai', 'pendidikan_terakhir'])->where('id', $id)->first();

        if (!$pendidikan) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($pendidikan, 'Fetch pendidikan success');
    }

    /**
     * Insert new resource.
     *
     * @param  request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'nomor_ijazah' => '',
            'nama_instansi' => '',
            'jurusan' => '',
            'tanggal_lulus' => '',
            'pegawai_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        $pendidikan = Pendidikan::create($request->all());

        return $this->sendResponse($pendidikan, "Submit pendidikan success", 201);
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
            'nomor_ijazah' => '',
            'nama_instansi' => '',
            'jurusan' => '',
            'tanggal_lulus' => '',
            'pegawai_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        $pendidikan = Pendidikan::where('id', $id)->first();

        if (!$pendidikan) {
            return $this->sendError('Not Found', false, 404);
        }

        Pendidikan::whereId($id)->update($request->all());
        $update = Pendidikan::where('id', $id)->first();

        return $this->sendResponse($update, "Update pendidikan success");
    }

    /**
     * Remove the specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteById($id) {
        $pendidikan = Pendidikan::whereId($id)->forceDelete();

        if (!$pendidikan) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete pendidikan success');
    }

}

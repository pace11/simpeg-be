<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Pegawai;
use App\Models\Agama;
use App\Models\Golongan;
use App\Models\Jabatan;
use Validator;

class PegawaiController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $pegawai = Pegawai::with(['golongan', 'jabatan', 'agama'])->orderBy('updated_at', 'desc')->get();
        return $this->sendResponse($pegawai, "Fetch pegawai success");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id) {
        $pegawai = Pegawai::with(['golongan', 'jabatan', 'agama'])->where('id', $id)->first();

        if (!$pegawai) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($pegawai, 'Fetch pegawai success');
    }

    /**
     * Insert new resource.
     *
     * @param  request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:100',
            'tempat_lahir' => '',
            'tanggal_lahir' => '',
            'nip_lama' => '',
            'nip_baru' => '',
            'tmt_golongan' => '',
            'tmt_jabatan' => '',
            'kepala_sekolah' => '',
            'pendidikan_terakhir' => '',
            'jurusan' => '',
            'tahun_lulus' => '',
            'pd_pdp_npd' => '',
            'keterangan' => '',
            'golongan_id' => 'required',
            'jabatan_id' => 'required',
            'agama_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        $input = $request->all();
        $input['id'] = Str::uuid();
        $pegawai = Pegawai::create($input);

        return $this->sendResponse($pegawai, "Submit pegawai success");
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
            'nama' => 'required|max:100',
            'tempat_lahir' => '',
            'tanggal_lahir' => '',
            'nip_lama' => '',
            'nip_baru' => '',
            'tmt_golongan' => '',
            'tmt_jabatan' => '',
            'kepala_sekolah' => '',
            'pendidikan_terakhir' => '',
            'jurusan' => '',
            'tahun_lulus' => '',
            'pd_pdp_npd' => '',
            'keterangan' => '',
            'golongan_id' => 'required',
            'jabatan_id' => 'required',
            'agama_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        Pegawai::whereId($id)->update($request->all());
        $update = Pegawai::where('id', $id)->first();

        return $this->sendResponse($update, "Update pegawai success");
    }

    /**
     * Remove the specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteById($id) {
        $pegawai = Pegawai::whereId($id)->delete();

        if (!$pegawai) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete pegawai success');
    }

    /**
     * Display specific relation.
     *
     * @return \Illuminate\Http\Response
     */
    public function charts() {
        $agama = Agama::select('title AS name')->withCount('pegawai AS value')->get();
        $golongan = Golongan::select('title AS name')->withCount('pegawai AS value')->get();
        $jabatan = Jabatan::select('title AS name')->withCount('pegawai AS value')->get();
        $charts = [
            'agama' => $agama,
            'golongan' => $golongan,
            'jabatan' => $jabatan,
        ];
        
        return $this->sendResponse($charts, 'Fetch pegawai charts success');
    }

}

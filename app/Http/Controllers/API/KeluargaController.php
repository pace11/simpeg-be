<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Keluarga;
use Validator;

class KeluargaController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $pegawai_id = $request->query('pegawai_id') ?? '';

        if ($pegawai_id) {
            $keluarga = Keluarga::with(['pegawai', 'agama', 'pendidikan_kk', 'status_perkawinan_kk', 'status_hubungan_kk', 'jenis_pekerjaan_kk'])
                        ->where('pegawai_id', $pegawai_id)
                        ->orderBy('updated_at', 'desc')
                        ->get();
        } else {
            $keluarga = Keluarga::with(['pegawai', 'agama', 'pendidikan_kk', 'status_perkawinan_kk', 'status_hubungan_kk', 'jenis_pekerjaan_kk'])
                        ->orderBy('updated_at', 'desc')
                        ->get();
        }

        return $this->sendResponse($keluarga, "Fetch keluarga success");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id) {
        $keluarga = Keluarga::with(['pegawai', 'agama', 'pendidikan_kk', 'status_perkawinan_kk', 'status_hubungan_kk', 'jenis_pekerjaan_kk'])
                    ->where('id', $id)
                    ->first();

        if (!$keluarga) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($keluarga, 'Fetch keluarga success');
    }

    /**
     * Insert new resource.
     *
     * @param  request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'nik' => '',
            'nama_lengkap' => '',
            'jenis_kelamin' => '',
            'tanggal_lahir' => '',
            'tempat_lahir' => '',
            'tanggal_perkawinan' => '',
            'golongan_darah' => '',
            'kewarganegaraan' => '',
            'pegawai_id' => 'required',
            'agama_id' => 'required',
            'pendidikan_kk_id' => 'required',
            'status_perkawinan_kk_id' => 'required',
            'status_hubungan_kk_id' => 'required',
            'jenis_pekerjaan_kk_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        $keluarga = Keluarga::create($request->all());

        return $this->sendResponse($keluarga, "Submit keluarga success", 201);
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
            'nik' => '',
            'nama_lengkap' => '',
            'jenis_kelamin' => '',
            'tanggal_lahir' => '',
            'tempat_lahir' => '',
            'tanggal_perkawinan' => '',
            'golongan_darah' => '',
            'kewarganegaraan' => '',
            'pegawai_id' => 'required',
            'agama_id' => 'required',
            'pendidikan_kk_id' => 'required',
            'status_perkawinan_kk_id' => 'required',
            'status_hubungan_kk_id' => 'required',
            'jenis_pekerjaan_kk_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        $keluarga = Keluarga::where('id', $id)->first();

        if (!$keluarga) {
            return $this->sendError('Not Found', false, 404);
        }

        Keluarga::whereId($id)->update($request->all());
        $update = Keluarga::where('id', $id)->first();

        return $this->sendResponse($update, "Update keluarga success");
    }

    /**
     * Remove the specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteById($id) {
        $keluarga = Keluarga::whereId($id)->forceDelete();

        if (!$keluarga) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete keluarga success');
    }

}

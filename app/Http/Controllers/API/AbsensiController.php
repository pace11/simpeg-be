<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Absensi;
use Validator;

class AbsensiController extends ResponseController
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

        $absensi = Absensi::where($filter)->orderBy('id', 'asc')->get();

        return $this->sendResponse($absensi, "Fetch data success");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFilter(Request $request) {
        $pegawai_id = $request->query('pegawai_id') ?? '';

        $filter = [];
        if ($pegawai_id) $filter = [['pegawai_id', '=', $pegawai_id]];

        $absensi = Absensi::where($filter)->selectRaw('YEAR(tgl_masuk) as year, MONTH(tgl_masuk) as month, COUNT(*) as count')
                            ->groupBy('year', 'month')
                            ->orderBy('year', 'desc')
                            ->orderBy('month', 'desc')
                            ->get();

        return $this->sendResponse($absensi, "Fetch data success");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id) {
        $absensi = Absensi::where('id', $id)->first();
        
        return $this->sendResponse($absensi, 'Fetch data success');
    }

    /**
     * Insert new resource.
     *
     * @param  request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'tgl_masuk' => 'required',
            'tgl_pulang' => 'required',
            'pegawai_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        $absensi = Absensi::create($request->all());

        return $this->sendResponse($absensi, "Submit data success", 201);
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
            'tgl_masuk' => 'required',
            'tgl_pulang' => 'required',
            'pegawai_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        $absensi = Absensi::where('id', $id)->first();

        if (!$absensi) {
            return $this->sendError('Not Found', false, 404);
        }

        Absensi::whereId($id)->update($request->all());
        $update = Absensi::where('id', $id)->first();

        return $this->sendResponse($update, "Update data success");
    }

    /**
     * Remove the specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteById($id) {
        $absensi = Absensi::whereId($id)->forceDelete();

        if (!$absensi) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete data success');
    }

}

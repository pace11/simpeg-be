<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use App\Models\Golongan;
use Validator;

class GolonganController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $agama = Golongan::all();
        return $this->sendResponse($agama, 'Fetch golongan success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id) {
        $agama = Golongan::where('id', $id)->first();

        if (!$agama) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($agama, 'Fetch golongan success');
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

        $create = Golongan::create($request->all());

        return $this->sendResponse($create, "Submit golongan success");
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
            'title' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        Golongan::whereId($id)->update($request->all());
        $update = Golongan::where('id', $id)->first();

        return $this->sendResponse($update, "Update golongan success");
    }

    /**
     * Remove the specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteById($id) {
        $golongan = Golongan::whereId($id)->delete();

        if (!$golongan) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete golongan success');
    }
}

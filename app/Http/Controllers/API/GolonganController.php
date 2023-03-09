<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use App\Models\Golongan;
use Validator;

class GolonganController extends ResponseController
{
    public function index() {
        $agama = Golongan::all();
        return $this->sendResponse($agama, 'Fetch golongan success');
    }

    public function showById($id) {
        $agama = Golongan::where('id', $id)->first();

        if (!$agama) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($agama, 'Fetch golongan success');
    }

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

    public function deleteById($id) {
        $agama = Golongan::whereId($id)->delete();

        if (!$agama) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete golongan success');
    }
}

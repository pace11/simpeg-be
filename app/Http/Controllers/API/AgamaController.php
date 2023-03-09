<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use App\Models\Agama;
use Validator;

class AgamaController extends ResponseController
{
    public function index() {
        $agama = Agama::all();
        return $this->sendResponse($agama, 'Fetch agama success');
    }

    public function showById($id) {
        $agama = Agama::where('id', $id)->first();

        if (!$agama) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($agama, 'Fetch agama success');
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        $create = Agama::create($request->all());

        return $this->sendResponse($create, "Submit agama success");
    }

    public function updateById(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        Agama::whereId($id)->update($request->all());
        $update = Agama::where('id', $id)->first();

        return $this->sendResponse($update, "Update agama success");
    }

    public function deleteById($id) {
        $agama = Agama::whereId($id)->delete();

        if (!$agama) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete agama success');
    }
}

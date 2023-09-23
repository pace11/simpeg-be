<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use App\Models\Notes;
use Illuminate\Support\Str;
use Validator;

class NotesController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $notes = Notes::orderBy('updated_at', 'desc')->get();
        
        return $this->sendResponse($notes, 'Fetch notes success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id) {
        $notes = Notes::where('id', $id)->first();

        if (!$notes) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($notes, 'Fetch detail notes success');
    }

    /**
     * Insert new resource.
     *
     * @param  request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'description' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        $input = $request->all();
        $input['id'] = Str::uuid();
        $create = Notes::create($input);

        return $this->sendResponse($create, "Submit notes success", 201);
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
            'title' => 'required|max:100',
            'description' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        Notes::whereId($id)->update($request->all());
        $update = Notes::where('id', $id)->first();

        return $this->sendResponse($update, "Update notes success");
    }

    /**
     * Restore the specific deleted resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restoreById($id) {
        $golongan = Golongan::whereId($id)->withTrashed()->restore();

        if (!$golongan) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Restore pegawai success');
    }

    /**
     * Remove the specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteById($id) {
        $notes = Notes::whereId($id)->delete();

        if (!$notes) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete notes success');
    }
}

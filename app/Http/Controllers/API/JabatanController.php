<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use App\Models\Jabatan;
use Validator;

class JabatanController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $title = $request->query('title');
        $status = $request->query('status');

        if ($status == 'archived') {
            $jabatan = Jabatan::where('title', 'LIKE', '%'.$title.'%')
                        ->onlyTrashed()
                        ->get();
        } else {
            $jabatan = Jabatan::sortable()->orderBy('updated_at', 'desc')
                        ->where('title', 'LIKE', '%'.$title.'%')
                        ->get();
        }

        return $this->sendResponse($jabatan, 'Fetch jabatan success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id) {
        $jabatan = Jabatan::where('id', $id)->first();

        if (!$jabatan) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($jabatan, 'Fetch jabatan success');
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

        $create = Jabatan::create($request->all());

        return $this->sendResponse($create, "Submit jabatan success", 201);
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

        Jabatan::whereId($id)->update($request->all());
        $update = Jabatan::where('id', $id)->first();

        return $this->sendResponse($update, "Update jabatan success");
    }

    /**
     * Restore the specific deleted resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restoreById($id) {
        $jabatan = Jabatan::whereId($id)->withTrashed()->restore();

        if (!$jabatan) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Restore jabatan success');
    }

    /**
     * Remove the specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteById($id) {
        $jabatan = Jabatan::whereId($id)->delete();

        if (!$jabatan) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete jabatan success');
    }
}

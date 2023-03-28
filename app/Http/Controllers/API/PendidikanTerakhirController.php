<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use App\Models\PendidikanTerakhir;
use Validator;

class PendidikanTerakhirController extends ResponseController
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
            $pendidikan_terakhir = PendidikanTerakhir::where('title', 'LIKE', '%'.$title.'%')
                    ->onlyTrashed()
                    ->get();
        } else {
            $pendidikan_terakhir = PendidikanTerakhir::sortable()->orderBy('updated_at', 'desc')
                    ->where('title', 'LIKE', '%'.$title.'%')
                    ->get();
        }
        
        return $this->sendResponse($pendidikan_terakhir, 'Fetch pendidikan terakhir success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id) {
        $pendidikan_terakhir = PendidikanTerakhir::where('id', $id)->first();

        if (!$pendidikan_terakhir) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($pendidikan_terakhir, 'Fetch pendidikan terakhir success');
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

        $create = PendidikanTerakhir::create($request->all());

        return $this->sendResponse($create, "Submit pendidikan terakhir success", 201);
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

        PendidikanTerakhir::whereId($id)->update($request->all());
        $update = PendidikanTerakhir::where('id', $id)->first();

        return $this->sendResponse($update, "Update pendidikan terakhir success");
    }

    /**
     * Restore the specific deleted resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restoreById($id) {
        $pendidikan_terakhir = PendidikanTerakhir::whereId($id)->withTrashed()->restore();

        if (!$pendidikan_terakhir) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Restore pendidikan terakhir success');
    }

    /**
     * Remove the specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteById($id) {
        $pendidikan_terakhir = PendidikanTerakhir::whereId($id)->delete();

        if (!$pendidikan_terakhir) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete pendidikan terakhir success');
    }
}

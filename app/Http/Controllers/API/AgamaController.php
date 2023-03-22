<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use App\Models\Agama;
use Validator;

class AgamaController extends ResponseController
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
            $agama = Agama::where('title', 'LIKE', '%'.$title.'%')
                    ->onlyTrashed()
                    ->get();
        } else {
            $agama = Agama::sortable()->orderBy('updated_at', 'desc')
                    ->where('title', 'LIKE', '%'.$title.'%')
                    ->get();
        }
        
        return $this->sendResponse($agama, 'Fetch agama success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id) {
        $agama = Agama::where('id', $id)->first();

        if (!$agama) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($agama, 'Fetch agama success');
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

        $create = Agama::create($request->all());

        return $this->sendResponse($create, "Submit agama success", 201);
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

        Agama::whereId($id)->update($request->all());
        $update = Agama::where('id', $id)->first();

        return $this->sendResponse($update, "Update agama success");
    }

    /**
     * Restore the specific deleted resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restoreById($id) {
        $agama = Agama::whereId($id)->withTrashed()->restore();

        if (!$agama) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Restore agama success');
    }

    /**
     * Remove the specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteById($id) {
        $agama = Agama::whereId($id)->delete();

        if (!$agama) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete agama success');
    }
}

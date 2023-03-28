<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use App\Models\Keturunan;
use Validator;

class KeturunanController extends ResponseController
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
            $keturunan = Keturunan::where('title', 'LIKE', '%'.$title.'%')
                    ->onlyTrashed()
                    ->get();
        } else {
            $keturunan = Keturunan::sortable()->orderBy('updated_at', 'desc')
                    ->where('title', 'LIKE', '%'.$title.'%')
                    ->get();
        }
        
        return $this->sendResponse($keturunan, 'Fetch keturunan success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id) {
        $keturunan = Keturunan::where('id', $id)->first();

        if (!$keturunan) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($keturunan, 'Fetch keturunan success');
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

        $create = Keturunan::create($request->all());

        return $this->sendResponse($create, "Submit keturunan success", 201);
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

        Keturunan::whereId($id)->update($request->all());
        $update = Keturunan::where('id', $id)->first();

        return $this->sendResponse($update, "Update keturunan success");
    }

    /**
     * Restore the specific deleted resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restoreById($id) {
        $keturunan = Keturunan::whereId($id)->withTrashed()->restore();

        if (!$keturunan) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Restore keturunan success');
    }

    /**
     * Remove the specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteById($id) {
        $keturunan = Keturunan::whereId($id)->delete();

        if (!$keturunan) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete keturunan success');
    }
}

<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use App\Models\SpotifyNotif;
use Illuminate\Support\Str;
use Validator;

class SpotifyNotifController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $spotify_notif = SpotifyNotif::orderBy('updated_at', 'desc')
                    ->get();

        return $this->sendResponse($spotify_notif, 'Fetch spotify notif success');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkActive(Request $request) {
        $spotify_notif = SpotifyNotif::where('status', 'active')->first();

        return $this->sendResponse($spotify_notif, 'Fetch spotify active success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id) {
        $spotify_notif = SpotifyNotif::where('id', $id)->first();

        if (!$spotify_notif) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($spotify_notif, 'Fetch spotify notif success');
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
            'description' => '',
            'plan' => '',
            'member_count' => '',
            'expires_at' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        $input = $request->all();
        $input['id'] = Str::uuid();
        $create = SpotifyNotif::create($input);

        return $this->sendResponse($create, "Submit spotify notif success", 201);
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
            'description' => '',
            'plan' => '',
            'member_count' => '',
            'expires_at' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        SpotifyNotif::whereId($id)->update($request->all());
        $update = SpotifyNotif::where('id', $id)->first();

        return $this->sendResponse($update, "Update spotify notif success");
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
        $golongan = Golongan::whereId($id)->delete();

        if (!$golongan) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete golongan success');
    }

    /**
     * Remove the specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivateById($id) {
        $spotify_notif = SpotifyNotif::whereId($id)->update(array('status' => 'inactive'));

        if (!$spotify_notif) {
            return $this->sendError('Not Found', false, 404);
        }

        $get = SpotifyNotif::whereId($id)->first();
        
        return $this->sendResponse($get, 'Deactivate spotify notif success');
    }
}

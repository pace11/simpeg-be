<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use App\Models\Produk;
use Validator;

class ProdukController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $title = $request->query('title');
        $limit = $request->query('limit') ?? 10;
        $produk = Produk::sortable()->orderBy('updated_at', 'desc')
                ->where('title', 'LIKE', '%'.$title.'%')
                ->paginate($limit);

        return $this->sendResponsePagination($produk);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id) {
        $produk = Produk::where('id', $id)->first();

        if (!$produk) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($produk, 'Fetch produk success');
    }
}

<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use App\Models\Produk;
use Validator;

class PesananController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $user = Auth::guard('api')->user();
        $pesanan = Pesanan::with(['produk', 'users'])
                ->where('users_id', '=', $user->id)
                ->where('status', '<>', 'hold')
                ->orderBy('updated_at', 'desc')
                ->get();

        return $this->sendResponse($pesanan, "Fetch pesanan success");
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cart(Request $request) {
        $user = Auth::guard('api')->user();
        $pesanan = Pesanan::with(['produk', 'users'])
                ->where('users_id', '=', $user->id)
                ->where('status', '=', 'hold')
                ->orderBy('updated_at', 'desc')
                ->get();

        return $this->sendResponse($pesanan, 'Fetch pesanan cart success');
    }

    /**
     * Count a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function countCart(Request $request) {
        $user = Auth::guard('api')->user();
        $pesanan = Pesanan::with(['produk', 'users'])
                ->where(['users_id' => $user->id, 'status' => 'hold'])
                ->orderBy('updated_at', 'desc')
                ->count();

        return $this->sendResponse($pesanan, 'Fetch pesanan cart success');
    }

    /**
     * Insert new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addCart(Request $request) {
        $user = Auth::guard('api')->user();
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required',
        ]);

        $input = $request->all();
        $produk = Produk::whereId($input['produk_id'])->first();
        $findProduct = Pesanan::where([
            'users_id' => $user->id,
            'produk_id' => $input['produk_id'],
            'status' => 'hold'])
            ->first();

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        if ($findProduct) {
            $input['qty'] = $findProduct->qty + 1;
            $input['total_price'] = (($findProduct->qty + 1) * $findProduct->discount_price);
            Pesanan::whereId($findProduct->id)->update($input);
            $pesanan = Pesanan::whereId($findProduct->id)->first();
        } else {
            $input['qty'] = 1;
            $input['discount_price'] = $produk->discount_percentage ? ($produk->price - ($produk->price * ($produk->discount_percentage / 100))) : $produk->price;
            $input['total_price'] = $produk->discount_percentage ? ($produk->price - ($produk->price * ($produk->discount_percentage / 100))) : $produk->price;
            $input['users_id'] = $user->id;
            $pesanan = Pesanan::create($input);
        }

        return $this->sendResponse($pesanan, 'Add pesanan cart success');
    }

    /**
     * Process cart.
     *
     * @return \Illuminate\Http\Response
     */
    public function processCart(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        
        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }
        
        $input = $request->all();
        if (is_array($input['id'])) {
            Pesanan::whereIn('id', $input['id'])->update(['status' => 'waiting-payment']);
            $pesanan = Pesanan::whereIn('id', $input['id'])->get();
        } else {
            Pesanan::whereId($input['id'])->update(['status' => 'waiting-payment']);
            $pesanan = Pesanan::whereId($input['id'])->first();
        }

        return $this->sendResponse($pesanan, 'Process pesanan cart success');
    }

    /**
     * Remove the specific resource.
     *
     * @param  string[UUID]  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCartById($id) {
        $pesanan = Pesanan::whereId($id)->forceDelete();

        if (!$pesanan) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete pesanan cart success');
    }

    /**
     * Process finish.
     *
     * @return \Illuminate\Http\Response
     */
    public function finish(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        
        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }
        
        $input = $request->all();
        Pesanan::whereId($input['id'])->update(['status' => 'done']);
        $pesanan = Pesanan::whereId($input['id'])->first();

        return $this->sendResponse($pesanan, 'Process finish pesanan success');
    }
}

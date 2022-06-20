<?php

namespace App\Http\Controllers;

use App\TransaksiModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth = Auth::user()->id;
        $transaksi = TransaksiModel::where('user_id', $auth)->get()
            ->map(function ($item, $value) {
                return [
                    'id' => $item->id,
                    'user' => $item->user->name,
                    'kode_barang' => $item->barang->kode,
                    'kode_transaksi' => $item->kode_transaksi,
                    'qty' => $item->qty,
                    'total_bayar' => $item->total_bayar,
                    'status' => $item->status,
                ];
            });

            return response()->json([
                'success'   => true,
                'message'   => 'Berhasil menampilkan data transaksi',
                'data'      => $transaksi,
            ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TransaksiModel $transaksi)
    {

        $now = Carbon::now();
        $day = date("Y-m-d");
        $tanggal = $now->year . $now->month . $now->day;
        $cek = TransaksiModel::count();
        $no_trans = TransaksiModel::all()->last();

        if ($cek == 0) {
            $urut = 1001;
            $nomor = $tanggal . $urut;
        } elseif ($no_trans->created_at < $day) {
            $nomor = $tanggal . 1001;
        } elseif (substr($no_trans->kode_transaksi, -4) == 1999) {
            $nomor = $tanggal . 1001;
        } else {
            $ambil = TransaksiModel::all()->last();
            $urut = substr($ambil->kode_transaksi, -4) + 1;
            $nomor = $tanggal . $urut;
        }

        $transaksi->kode_transaksi = $nomor;
        $transaksi->status = "pending";
        $transaksi->total_bayar = $request->total_bayar;
        $transaksi->qty = $request->qty;
        $transaksi->barang_id = $request->barang_id;
        $transaksi->user_id = Auth::user()->id;

        $transaksi->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Success',
            'data'      => $transaksi,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaksi = TransaksiModel::findOrFail($id);
        if ($transaksi) {
            return response()->json([
                'success' => true,
                'message' => 'Data ' . $transaksi->id . ' berhasil ditampilkan',
                'data' => $transaksi,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan',
            ], 409);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $transaksi = TransaksiModel::find($id);
        if($transaksi){

            $transaksi->status = "lunas";

            $transaksi->save();

            return response()->json([
                'success' => true,
                'message' => 'Data ' . $transaksi->id . ' berhasil diupdate',
                'update' => $transaksi,
            ], 200);
        }
        else {
            return response()->json([
                'success' => 'Not Found',
                'message' => 'Transaksi tidak ada !',
            ], 404);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaksi = TransaksiModel::find($id);

        if($transaksi){
            $transaksi->delete();
            return response([
                'status' => 'Ok',
                'message' => 'Transaksi berhasil dihapus',
            ], 200);
        } else {
            return response([
                'status' => 'Not Found',
                'message' => 'Transaksi tidak ditemukan !',
            ], 404);
        }
    }

}

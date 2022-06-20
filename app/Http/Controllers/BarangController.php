<?php

namespace App\Http\Controllers;

use App\BarangModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Contracts\Providers\Storage;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = BarangModel::all();
        return response()->json([
            'success'   => true,
            'message'   => 'Barang berhasil ditampilkan',
            'data'      => $barang,
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
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg|max:2048',
            'nama_brg' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'deskripsi' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
        ]);

        $input = $request->all();
        $path = $request->file('gambar')->store('public/image');
        $input['gambar'] = $path;

        $barang = BarangModel::create($input);

        return response()->json([
            'success'   => true,
            'message'   => 'Barang berhasil ditambahkan',
            'data'      => $barang,
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
        $barang = BarangModel::findOrFail($id);
        if ($barang) {
            return response()->json([
                'success' => true,
                'message' => 'Data ' . $barang->id . ' berhasil ditampilkan',
                'data' => $barang,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan',
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
        $check_barang = BarangModel::firstWhere('id', $id);

        if ($check_barang) {
            $barang = BarangModel::find($id);

            if (request()->file('gambar')) {
                \Storage::delete($barang->gambar);
                $path = $request->file('gambar')->store('public/image');
            } else {
                $path = $barang->gambar;
            }

            $barang->gambar = $path;
            $barang->nama_brg = $request->nama_brg;
            $barang->kode = $request->kode;
            $barang->harga = $request->harga;
            $barang->stok = $request->stok;
            $barang->deskripsi = $request->deskripsi;
            $barang->penulis = $request->penulis;
            $barang->penerbit = $request->penerbit;
            $barang->tanggal = $request->tanggal;

            $barang->save();

            return response()->json([
                'success' => true,
                'message' => 'Data ' . $barang->id . ' berhasil diupdate',
                'update' => $barang,
            ], 200);

        } else {
            return response()->json([
                'success' => 'Not Found',
                'message' => 'Barang tidak ada !',
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
        $check_barang = BarangModel::firstWhere('id', $id);
        if ($check_barang) {
            BarangModel::destroy($id);
            return response([
                'status' => 'Ok',
                'message' => 'Barang berhasil dihapus',
            ], 200);
        } else {
            return response([
                'status' => 'Not Found',
                'message' => 'Barang tidak ditemukan !',
            ], 404);
        }
    }
}

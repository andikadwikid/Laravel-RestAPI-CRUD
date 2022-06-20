<?php

namespace App\Http\Controllers;

use App\KategoriModel;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = KategoriModel::all();
        return response()->json([
            'success'   => true,
            'message'   => 'Kategori berhasil ditampilkan',
            'data'      => $kategori,
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
        $input = $request->all();
        $kategori = KategoriModel::create($input);
        return response()->json([
            'success'   => true,
            'message'   => 'Kategori berhasil ditambahkan',
            'data'      => $kategori,
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
        $kategori = KategoriModel::findOrFail($id);
        if ($kategori) {
            return response()->json([
                'success' => true,
                'message' => 'Data ' . $kategori->id . ' berhasil ditampilkan',
                'data' => $kategori,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan',
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
        $check_kategori = KategoriModel::firstWhere('id', $id);
        if ($check_kategori) {
            $kategori = KategoriModel::find($id);
            $kategori->nama = $request->nama;

            $kategori->save();

            return response()->json([
                'success' => true,
                'message' => 'Data ' . $kategori->id . ' berhasil diupdate',
                'update' => $kategori,
            ], 200);
        } else {
            return response()->json([
                'success' => 'Not Found',
                'message' => 'Kategori tidak ada !',
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
        $check_kategori = KategoriModel::firstWhere('id', $id);
        if ($check_kategori) {
            KategoriModel::destroy($id);
            return response([
                'status' => 'Ok',
                'message' => 'Ketegori berhasil dihapus',
            ], 200);
        } else {
            return response([
                'status' => 'Not Found',
                'message' => 'Kategori tidak ditemukan !',
            ], 404);
        }
    }
}

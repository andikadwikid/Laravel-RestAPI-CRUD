<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return response()->json([
            'success'   => true,
            'message'   => 'Data Post berhasil ditampilkan',
            'data'      => $posts,

        ], 200);

        // dd($posts);
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
        $allrequest = $request->all();

        $validator = Validator::make($allrequest, [
            'title' => 'required|unique:posts',
            'description' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $posts = Post::create($request->all());

        if ($posts) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dibuat',
                'data' => $posts,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal dibuat',
            ], 409);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posts = Post::findOrFail($id);
        if ($posts) {
            return response()->json([
                'success' => true,
                'message' => 'Data ' . $posts->id . ' berhasil ditampilkan',
                'data' => $posts,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
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
        $allrequest = $request->all();

        $validator = Validator::make($allrequest, [
            'title' => 'required|unique:posts',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $check_posts = Post::firstWhere('id', $id);
        if ($check_posts) {
            $posts = Post::find($id);
            $posts->title = $request->title;
            $posts->description = $request->description;
            $posts->save();

            return response()->json([
                'success' => true,
                'message' => 'Data ' . $posts->id . ' berhasil diupdate',
                'update' => $posts,
            ], 200);
        } else {
            return response()->json([
                'success' => 'Not Found',
                'message' => 'Data tidak ada !',
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
        $check_posts = Post::firstWhere('id', $id);
        if ($check_posts) {
            Post::destroy($id);
            return response([
                'status' => 'Ok',
                'message' => 'Data berhasil dihapus',
            ], 200);
        } else {
            return response([
                'status' => 'Not Found',
                'message' => 'Data tidak ditemukan !',
            ], 404);
        }
    }
}

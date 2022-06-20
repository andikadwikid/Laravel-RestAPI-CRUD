<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::latest()->get();
        return response()->json([
            'success'   => true,
            'message'   => 'Data Post berhasil ditampilkan',
            'data'      => $comments,

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
        $allrequest = $request->all();

        $validator = Validator::make($allrequest, [
            'content' => 'required',
            'post_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $comments = Comment::create($request->all());

        if ($comments) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil dibuat',
                'data' => $comments,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User gagal dibuat',
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
        $comments = Comment::find($id);
        if ($comments) {
            return response()->json([
                'success' => true,
                'message' => 'Data ' . $comments->id . ' berhasil ditampilkan',
                'data' => $comments,
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
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $check_comments = Comment::firstWhere('id', $id);
        if ($check_comments) {
            $comments = Comment::find($id);
            $comments->content = $request->content;
            $comments->save();

            return response()->json([
                'success' => true,
                'message' => 'Comment ' . $comments->id . ' berhasil diupdate',
                'update' => $comments,
            ], 200);
        } else {
            return response()->json([
                'success' => 'Not Found',
                'message' => 'Comment tidak ada !',
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
        $check_comments = Comment::firstWhere('id', $id);
        if ($check_comments) {
            Comment::destroy($id);
            return response([
                'status' => 'Ok',
                'message' => 'Comment berhasil dihapus',
            ], 200);
        } else {
            return response([
                'status' => 'Not Found',
                'message' => 'Comment tidak ditemukan !',
            ], 404);
        }
    }
}

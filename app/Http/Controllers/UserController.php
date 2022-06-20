<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->get();
        return response()->json([
            'success'   => true,
            'message'   => 'Data User berhasil ditampilkan',
            'data'      => $users,

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
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'role_id' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $users = User::create($request->all());

        if ($users) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil dibuat',
                'data' => $users,
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
        $users = User::find($id);
        if ($users) {
            return response()->json([
                'success' => true,
                'message' => 'Data ' . $users->id . ' berhasil ditampilkan',
                'data' => $users,
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
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'role_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $check_users = User::firstWhere('id', $id);
        if ($check_users) {
            $users = User::find($id);
            $users->name = $request->name;
            $users->email = $request->email;
            $users->password = $request->password;
            $users->role_id = $request->role_id;
            $users->save();

            return response()->json([
                'success' => true,
                'message' => 'Data ' . $users->id . ' berhasil diupdate',
                'update' => $users,
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
        $check_users = User::firstWhere('id', $id);
        if ($check_users) {
            User::destroy($id);
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

<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return response()->json([
            'success'   => true,
            'message'   => 'Role berhasil ditampilkan',
            'data'      => $roles,

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
            'role_name' => 'required|unique:roles',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $roles = Role::create($request->all());

        if ($roles) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil dibuat',
                'data' => $roles,
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
        $roles = Role::find($id);
        if ($roles) {
            return response()->json([
                'success' => true,
                'message' => 'Data ' . $roles->id . ' berhasil ditampilkan',
                'data' => $roles,
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
            'role_name' => 'required|unique:roles',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $check_roles = Role::firstWhere('id', $id);
        if ($check_roles) {
            $roles = Role::find($id);
            $roles->role_name = $request->role_name;
            $roles->save();

            return response()->json([
                'success' => true,
                'message' => 'Data ' . $roles->id . ' berhasil diupdate',
                'update' => $roles,
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
        $check_roles = Role::firstWhere('id', $id);
        if ($check_roles) {
            Role::destroy($id);
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

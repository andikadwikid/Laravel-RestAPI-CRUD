<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\OtpCode;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VerificationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        // dd('masuk');
        $allrequest = $request->all();

        $validator = Validator::make($allrequest, [
            'otp' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //Cek apakah OTP code nya ada ?
        $otp_code = OtpCode::where('otp', $request->otp)->first();

        //Jika tidak ada =
        if (!$otp_code) {
            return response()->json([
                'success' => false,
                'message' => 'OTP code tidak ditemukan',
            ], 400);
        }

        $now = Carbon::now();
        //Jika Otp code kurang dari hari ini
        if ($now > $otp_code->valid_until) {
            return response()->json([
                'success' => false,
                'message' => 'OTP code sudah tidak berlaku lagi',
            ], 400);
        }

        //Jika lolos

        $user = User::find($otp_code->user_id);
        //email verified ny akan ter-update
        $user->update([
            'email_verified_at' => $now,
        ]);

        $otp_code->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diverifikasi',
            'data' => $user
        ]);
    }
}

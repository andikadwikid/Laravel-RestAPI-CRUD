<?php

namespace App\Http\Controllers\Auth;

use App\Events\RegenerateStoreEvent;
use App\Events\RegisterStoreEvent;
use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\OtpCode;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegenerateOtpController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $allrequest = $request->all();

        $validator = Validator::make($allrequest, [
            'email' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('email', $request->email)->first();

        // dd($user->otp_code()->delete());

        //Jika otp ny sudah ada, maka hapus
        if ($user->otp_code) {

            $user->otp_code()->delete();
        }

        do {
            $random = mt_rand(100000, 999999);
            $check = OtpCode::where('otp', $random)->first();
        } while ($check);

        $now  = Carbon::now();

        $otp_code = OtpCode::create([
            'data' => $user,
            'otp' => $random,
            'valid_until' => $now->addMinutes(5),
            'user_id' => $user->id,
        ]);

        //kirim email otp code ke email register

        $title = '[Confirmation] Otp Code Vertification';
        $user_detail = [
            'name' => $user->name,
            'email' => $user->email,
        ];
        $otp_detail = [
            'otp_code' => $random,
        ];
        event(new RegenerateStoreEvent($title, $user_detail, $otp_detail));


        // $sendmail = Mail::to($user_detail['email'])->send(new SendMail($title, $user_detail, $otp_detail));
        // if (empty($sendmail)) {
        //     return response()->json([
        //         'message' => 'Mail Sent Sucssfully',
        //         'to' => $user->email,
        //     ], 200);
        // } else {
        //     return response()->json([
        //         'message' => 'Mail Sent fail'
        //     ], 400);
        // }

        return response()->json([
            'success'   => true,
            'message'   => 'Data User berhasil digenerate',
            'data'      => [
                'user'      => $user,
                'otp_code'  => $otp_code,
            ]
        ]);
    }
}

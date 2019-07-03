<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckSMSCode extends ApiController
{
    public function get(Request $request) {
        $this->validate($request, [
            'activation_code' => 'required|integer',
        ]);

        $user = Auth::user();

        $metaDataCode = $user->meta
            ->where('user_id', '=', $user->id)
            ->where('meta_name', '=', 'phone_number_activation_code')
            ->where('meta_data', '=', $request->input('activation_code'))
            ->first();

        $metaDataCodeUntil = $user->meta
            ->where('user_id', '=', $user->id)
            ->where('meta_name', '=', 'phone_number_activation_code_active_until')
            ->first();

        if (!$metaDataCode) {
            return $this->error('Wrong activation code');
        } elseif (Carbon::now()->gt($metaDataCodeUntil->meta_data)) {
            return $this->error('Activation code expire');
        }

        $metaDataCode->delete();
        $metaDataCodeUntil->delete();

        $user->phone_number_activated = true;
        $user->save();

        return $this->success('Account activated!');
    }
}

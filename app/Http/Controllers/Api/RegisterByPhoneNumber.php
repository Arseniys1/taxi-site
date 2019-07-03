<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\User;
use App\UserMeta;
use App\UserSession;
use Carbon\Carbon;
use App\SMS\SMSC;
use Illuminate\Support\Str;

class RegisterByPhoneNumber extends ApiController
{

    public function get(Request $request) {
        $this->validate($request, [
            'phone_number' => 'required|phone:RU|unique:users,phone_number',
            'first_name' => 'nullable|phone',
            'last_name' => 'nullable|phone',
            'device_id' => 'nullable|string',
            'network_country_iso' => 'nullable|string',
            'sim_country_iso' => 'nullable|string',
            'operator_name' => 'nullable|string',
            'is_roaming' => 'nullable|string',
        ]);

        $phone_number_activation_code = rand(100000, 999999);
        $phone_number_activation_code_active_until = Carbon::now()->addHour();

        $smsc = new SMSC();
        $response = $smsc->send($request->input('phone_number'), 'Код регистрации ' . $phone_number_activation_code);

        if (array_key_exists('error', $response) || array_key_exists('error_code', $response)) {
            return $this->error('SMS sending error');
        }

        $user = new User();
        $user->phone_number = $request->input('phone_number');
        $user->first_name = $request->has('first_name') ? $request->input('first_name') : null;
        $user->last_name = $request->has('last_name') ? $request->input('last_name') : null;
        $user->save();

        $meta = new UserMeta();
        $meta->user_id = $user->id;
        $meta->meta_name = 'phone_number_activation_code';
        $meta->meta_data = $phone_number_activation_code;
        $meta->save();

        $meta = new UserMeta();
        $meta->user_id = $user->id;
        $meta->meta_name = 'phone_number_activation_code_active_until';
        $meta->meta_data = $phone_number_activation_code_active_until;
        $meta->save();

        $userSession = new UserSession();
        $userSession->user_id = $user->id;
        $userSession->token = Str::uuid();
        $userSession->expire_at = Carbon::now()->addDay();
        $userSession->save();

        $this->clientMetaDataSave($request, $user);

        return $this->success([
            'message' => 'Code send',
            'session' => [
                'token' => $userSession->token,
                'expire_at' => $userSession->expire_at,
            ]
        ]);
    }

    private function clientMetaDataSave(Request $request, User $user) {
        if ($request->has('device_id')) {
            $meta = new UserMeta();
            $meta->user_id = $user->id;
            $meta->meta_name = 'device_id';
            $meta->meta_data = $request->input('device_id');
            $meta->save();
        }

        if ($request->has('network_country_iso')) {
            $meta = new UserMeta();
            $meta->user_id = $user->id;
            $meta->meta_name = 'network_country_iso';
            $meta->meta_data = $request->input('network_country_iso');
            $meta->save();
        }

        if ($request->has('sim_country_iso')) {
            $meta = new UserMeta();
            $meta->user_id = $user->id;
            $meta->meta_name = 'sim_country_iso';
            $meta->meta_data = $request->input('sim_country_iso');
            $meta->save();
        }

        if ($request->has('operator_name')) {
            $meta = new UserMeta();
            $meta->user_id = $user->id;
            $meta->meta_name = 'operator_name';
            $meta->meta_data = $request->input('operator_name');
            $meta->save();
        }

        if ($request->has('is_roaming')) {
            $meta = new UserMeta();
            $meta->user_id = $user->id;
            $meta->meta_name = 'is_roaming';
            $meta->meta_data = $request->input('is_roaming');
            $meta->save();
        }
    }

}

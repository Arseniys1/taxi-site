<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public function meta() {
        return $this->hasMany('App\UserMeta', 'user_id', 'id');
    }

    public function session() {
        return $this->hasMany('App\UserSession', 'user_id', 'id');
    }
}

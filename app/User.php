<?php

namespace App;

use App\Permissions\PermissionsResult;
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

    public function permissions() {
        return $this->belongsToMany('App\Permission', 'user_permission', 'user_id', 'permission_id');
    }

    /**
     * @param $permission_names
     * @return PermissionsResult|void
     */
    public function hasPermissions($permission_names) {
        if (is_array($permission_names)) {
            return $this->hasPermissionsArray($permission_names);
        } else {
            foreach ($this->permissions as $permission) {
                if ($permission->name == $permission_names) {
                    return new PermissionsResult([$permission_names]);
                }
            }

            return new PermissionsResult([], [$permission_names]);

        }
    }

    /**
     * @param array $permission_names
     * @return PermissionsResult
     */
    private function hasPermissionsArray($permission_names = []) {
        $permissions_found = [];
        $permissions_not_found = [];

        foreach ($permission_names as $permission_name) {

            foreach ($this->permissions as $key => $permission) {

                if ($permission->name == $permission_name) {
                    $permissions_found[] = $permission_name;
                    break;
                }

                if ($this->permissions->count() == $key + 1) {
                    $permissions_not_found[] = $permission_name;
                }

            }

        }

        return new PermissionsResult($permissions_found, $permissions_not_found);
    }
}

<?php


namespace App\Permissions;


class PermissionsResult
{
    private $permissions_found = [];
    private $permissions_not_found = [];

    /**
     * PermissionsResult constructor.
     * @param array $permissions_found
     * @param array $permissions_not_found
     */
    public function __construct($permissions_found = [], $permissions_not_found = [])
    {
        $this->permissions_found = $permissions_found;
        $this->permissions_not_found = $permissions_not_found;
    }

    /**
     * @return array
     */
    public function getPermissionsFound(): array
    {
        return $this->permissions_found;
    }

    /**
     * @return array
     */
    public function getPermissionsNotFound(): array
    {
        return $this->permissions_not_found;
    }

    public function result() {
        if (count($this->permissions_not_found) > 0) {
            return false;
        } elseif (count($this->permissions_found) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function toArray() {
        return [
            'result' => $this->result(),
            'permissions_found' => $this->getPermissionsFound(),
            'permissions_not_found' => $this->getPermissionsNotFound(),
        ];
    }

}
<?php namespace Distilleries\FormBuilder\Helpers;

use Distilleries\FormBuilder\Contracts\PermissionUtilContract;
use Illuminate\Auth\AuthManager;

class PermissionUtil implements PermissionUtilContract {

    protected $auth;
    protected $config;

    public function __construct(AuthManager $auth, array $config = []) {
        $this->auth   = $auth;
        $this->config = $config;
    }

    public function hasAccess($key)
    {
        if(empty($this->config['auth_restricted'])) {
            return true;
        }

        if($this->auth->check()){

            $user = $this->auth->get();
            if(!method_exists($user,'hasAccess')) {
                return true;
            }

            return (!empty($user)) ? $user->hasAccess($key) : false;
        }

        return false;
    }
}
<?php namespace Distilleries\FormBuilder\Contracts;

interface PermissionUtilContract {

    public function hasAccess($key);
}
<?php namespace Distilleries\FormBuilder\Contracts;

interface FormStateContract {

    public function getEdit($id);
    public function postEdit();
}
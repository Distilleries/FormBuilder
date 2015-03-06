<?php namespace Distilleries\FormBuilder\Helpers;

class StaticLabel {

    const STATUS_OFFLINE = 0;
    const STATUS_ONLINE = 1;

    public static function yesNo($id = null)
    {
        $items = [
            self::STATUS_OFFLINE => trans('form-builder::form.no'),
            self::STATUS_ONLINE  => trans('form-builder::form.yes'),
        ];

        return self::getLabel($items, $id);

    }

    public static function getLabel($items, $id = null)
    {
        if (isset($id))
        {
            return isset($items[$id]) ? $items[$id] : trans('form-builder::form.na');
        }

        return $items;
    }
}
<?php namespace Distilleries\FormBuilder\Fields;


use Distilleries\FormBuilder\Fields\FormField;

class FormFieldsView extends FormField {

    public function view(array $options = [], $showLabel = true, $showField = true, $showError = false)
    {

        $this->rendered = true;
        $options        = $this->prepareOptions($options);

        if (!$this->needsLabel($options))
        {
            $showLabel = false;
        }

        if(!empty($options['noInEditView']) and $options['noInEditView'] === true){
            return '';
        }

        return $this->formHelper->getView()->make(
            $this->template, [
                'name'      => $this->name,
                'type'      => $this->type,
                'options'   => $options,
                'noEdit'    => true,
                'showLabel' => $showLabel,
                'showField' => $showField,
                'showError' => $showError
            ])
            ->render();
    }


    protected function getTemplate(){
        return '';
    }

} 
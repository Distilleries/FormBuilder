<?php
/**
 * Created by PhpStorm.
 * User: mfrancois
 * Date: 11/02/2015
 * Time: 12:14 PM
 */

namespace Distilleries\FormBuilder\Fields;


use Distilleries\FormBuilder\Form;

abstract class FormField
{
    /**
     * Name of the field
     *
     * @var
     */
    protected $name;
    /**
     * Type of the field
     *
     * @var
     */
    protected $type;
    /**
     * All options for the field
     *
     * @var
     */
    protected $options;
    /**
     * Is field rendered
     *
     * @var bool
     */
    protected $rendered = false;
    /**
     * @var Form
     */
    protected $parent;
    /**
     * @var string
     */
    protected $template;
    /**
     * @var FormHelper
     */
    protected $formHelper;
    /**
     * @param             $name
     * @param             $type
     * @param Form        $parent
     * @param array       $options
     */
    public function __construct($name, $type, Form $parent, array $options = [])
    {
        $this->name = $name;
        $this->type = $type;
        $this->parent = $parent;
        $this->formHelper = $this->parent->getFormHelper();
        $this->setTemplate();
        $this->setDefaultOptions($options);
    }
    /**
     * Get the template, can be config variable or view path
     *
     * @return string
     */
    abstract protected function getTemplate();
    /**
     * @param array $options
     * @param bool  $showLabel
     * @param bool  $showField
     * @param bool  $showError
     * @return string
     */
    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        if ($showField) {
            $this->rendered = true;
        }
        $options = $this->prepareOptions($options);
        if (!$this->needsLabel($options)) {
            $showLabel = false;
        }
        return $this->formHelper->getView()->make(
            $this->template, [
            'name' => $this->name,
            'type' => $this->type,
            'options' => $options,
            'showLabel' => $showLabel,
            'showField' => $showField,
            'showError' => $showError
        ])->render();
    }
    /**
     * Prepare options for rendering
     *
     * @param array $options
     * @return array
     */
    protected function prepareOptions(array $options = [])
    {
        $options = $this->formHelper->mergeOptions($this->options, $options);
        if ($this->parent->haveErrorsEnabled()) {
            $this->addErrorClass($options);
        }
        if ($this->getOption('attr.multiple') === true) {
            $this->name = $this->name.'[]';
        }
        $options['wrapperAttrs'] = $this->formHelper->prepareAttributes($options['wrapper']);
        $options['errorAttrs'] = $this->formHelper->prepareAttributes($options['errors']);
        if ($options['is_child']) {
            $options['labelAttrs'] = $this->formHelper->prepareAttributes($options['label_attr']);
        }
        return $options;
    }
    /**
     * Get name of the field
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Set name of the field
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    /**
     * Get field options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
    /**
     * Get single option from options array. Can be used with dot notation ('attr.class')
     *
     * @param      $option
     * @param null $default
     * @return mixed
     */
    public function getOption($option, $default = null)
    {
        return array_get($this->options, $option, $default);
    }
    /**
     * Set field options
     *
     * @param array $options
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = $this->prepareOptions($options);
        return $this;
    }
    /**
     * Get the type of the field
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * Set type of the field
     *
     * @param mixed $type
     * @return $this
     */
    public function setType($type)
    {
        if ($this->formHelper->getFieldType($type)) {
            $this->type = $type;
        }
        return $this;
    }
    /**
     * @return Form
     */
    public function getParent()
    {
        return $this->parent;
    }
    /**
     * Check if the field is rendered
     *
     * @return bool
     */
    public function isRendered()
    {
        return $this->rendered;
    }
    /**
     * Default options for field
     *
     * @return array
     */
    protected function getDefaults()
    {
        return [];
    }
    /**
     * Defaults used across all fields
     *
     * @return array
     */
    private function allDefaults()
    {
        return [
            'wrapper' => ['class' => $this->formHelper->getConfig('defaults.wrapper_class')],
            'attr' => ['class' => $this->formHelper->getConfig('defaults.field_class'), 'id' => $this->name],
            'default_value' => null,
            'label' => $this->name,
            'is_child' => false,
            'label_attr' => ['class' => $this->formHelper->getConfig('defaults.label_class')],
            'errors' => ['class' => $this->formHelper->getConfig('defaults.error_class')]
        ];
    }
    /**
     * Merge all defaults with field specific defaults and set template if passed
     *
     * @param array $options
     */
    protected function setDefaultOptions(array $options = [])
    {
        $this->options = $this->formHelper->mergeOptions($this->allDefaults(), $this->getDefaults());
        $this->options = $this->prepareOptions($options);
        if (array_get($this->options, 'template') !== null) {
            $this->template = array_pull($this->options, 'template');
        }
    }
    /**
     * Set the template property on the object
     */
    private function setTemplate()
    {
        $this->template = $this->formHelper->getConfig($this->getTemplate(), $this->getTemplate());
    }
    /**
     * Add error class to wrapper if validation errors exist
     *
     * @param $options
     */
    protected function addErrorClass(&$options)
    {
        $errors = $this->formHelper->getRequest()->getSession()->get('errors');
        if ($errors && $errors->has($this->name)) {
            $errorClass = $this->formHelper->getConfig('defaults.wrapper_error_class');
            if (!str_contains($options['wrapper']['class'], $errorClass)) {
                $options['wrapper']['class'] .= ' '.$errorClass;
            }
        }
        return $options;
    }
    /**
     * Check if fields needs label
     *
     * @param array $options
     * @return bool
     */
    protected function needsLabel(array $options = [])
    {
        // If field is <select> and child of choice, we don't need label for it
        $isChildSelect = $this->type == 'select' && array_get($options, 'is_child') === true;
        if ($this->type == 'hidden' || $isChildSelect) {
            return false;
        }
        return true;
    }
}
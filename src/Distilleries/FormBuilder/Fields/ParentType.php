<?php  namespace Distilleries\FormBuilder\Fields;

use Kris\LaravelFormBuilder\Form;

abstract class ParentType extends FormFieldsView
{

    /**
     * @var mixed
     */
    protected $children;

    abstract protected function createChildren();

    public function __construct($name, $type, Form $parent, array $options = [])
    {
        parent::__construct($name, $type, $parent, $options);
        $this->createChildren();
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $options['children'] = $this->children;

        return parent::render($options, $showLabel, $showField, $showError);
    }

    public function view(array $options = [], $showLabel = true, $showField = true, $showError = false)
    {
        $options['children'] = $this->children;

        return parent::view($options, $showLabel, $showField, $showError);
    }

    /**
     * Get all children of the choice field
     *
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Get a child of the choice field
     *
     * @return mixed
     */
    public function getChild($key)
    {
        return array_get($this->children, $key);
    }

    public function isRendered()
    {
        foreach ($this->children as $key => $child) {
            if ($child->isRendered()) {
                return true;
            }
        }

        return parent::isRendered();
    }

    /**
     * Get child dynamically
     *
     * @param $name
     * @return FormField
     */
    public function __get($name)
    {
        return $this->getChild($name);
    }
}
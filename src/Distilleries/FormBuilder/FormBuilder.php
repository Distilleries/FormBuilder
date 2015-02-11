<?php  namespace Distilleries\FormBuilder;

use Illuminate\Foundation\Application as Container;

class FormBuilder
{

    /**
     * @var Container
     */
    private $container;

    /**
     * @var FormHelper
     */
    private $formHelper;

    public function __construct(Container $container, FormHelper $formHelper)
    {
        $this->container = $container;
        $this->formHelper = $formHelper;
    }

    /**
     * @param       $formClass
     * @param array $options
     * @param array $data
     * @return Form
     */
    public function create($formClass, array $options = [], array $data = [])
    {
        $form = $this->container
            ->make($formClass)
            ->setFormHelper($this->formHelper)
            ->setFormOptions($options)
            ->addData($data);

        $form->buildForm();

        return $form;
    }

    /**
     * Get instance of the empty form which can be modified
     *
     * @param array $options
     * @param array $data
     * @return Form
     */
    public function plain(array $options = [], array $data = [])
    {
        return $this->container
            ->make('Distilleries\FormBuilder\Form')
            ->setFormHelper($this->formHelper)
            ->setFormOptions($options)
            ->addData($data);
    }
}

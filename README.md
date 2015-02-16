# Laravel 4 Form Builder

Based on laravel-form-builder (https://github.com/kristijanhusak/laravel-form-builder). 
I add default no editable form and few complex form fields.
I add the validation system directly in the form part.

This package is use into the [Expendable cms](https://github.com/Distilleries/Expendable) and [DatatableBuilder package](https://github.com/Distilleries/DatatableBuilder).
You can have look to see the usage.

##Installation

Add on your composer.json

``` json
    "require": {
        "distilleries/datatable-builder": "1.*",
    }
```

run `composer update`.

Add Service provider to `config/app.php`:

``` php
    'providers' => [
        // ...
       'Distilleries\FormBuilder\FormBuilderServiceProvider',
    ]
```

And Facade (also in `config/app.php`)
   

``` php
    'aliases' => [
        // ...
        'FormBuilder'       => 'Distilleries\FormBuilder\Facades\FormBuilder',
    ]
```



### Basic usage

Creating form classes is easy. Lets assume PSR-4 is set for loading namespace `Project` in `app/Project` folder. With a simple artisan command I can create form:

``` sh
    php artisan form:make app/Project/Forms/PostForm
```

you create form class in path `app/Project/Forms/PostForm.php` that looks like this:

``` php
<?php namespace Project\Forms;

use Distilleries\FormBuilder\FormValidator;

class PostForm extends FormValidator {

    public static $rules = [];
    public static $rules_update = null;

    public function buildForm()
    {

        $this->addDefaultActions();
    }
}
```

You can add fields which you want when creating command like this:

``` sh
php artisan form:make app/Project/Forms/SongForm --fields="name:text, lyrics:textarea, publish:checkbox"
```

And that will create form in path `app/Project/Forms/SongForm.php` with content:

``` php
<?php namespace Project\Forms;

use Distilleries\FormBuilder\FormValidator;

class SongForm extends FormValidator
{
    public static $rules        = [];
    public static $rules_update = null;

    public function buildForm()
    {
        $this
            ->add('name', 'text')
            ->add('lyrics', 'textarea')
            ->add('publish', 'checkbox');

         $this->addDefaultActions();
    }
}
```

## Type of form

### Form

This is the base class from the package  [https://github.com/kristijanhusak/laravel-form-builder/tree/laravel-4](https://github.com/kristijanhusak/laravel-form-builder/tree/laravel-4).
It use to add the fields and generate the form. Check the readme to know how use the component.

### FormView
Extend the class Form to add a render with edit.

#### Use the view
To display an not editable form you can use `form_view` or `form_rest_view`.
To display a specific field you can use `form_widget_view`.

``` blade
 {{ form_view($form) }}
```

In your form field you can add an option to not display this field on the view `noInEditView`.

For example in user form I add a choice to allow the password change. I don't want it in the view part.

``` php
    $this->add('change_password', 'checkbox', [
        'default_value' => 1,
        'label'         => _('Check it if you want change your password'),
        'checked'       => false,
        'noInEditView'  => true
    ]);
```

Other way, you have a sub form and you don't want display some fields.
You can specify an option call `do_not_display_` plus the name of the field.

Example I have a customer form and this form use a sub form user. 
On the user form I don't want display the role choice:

``` php
       $this->add('user', 'form', [
           'label' => _('User'),
           'icon'  => 'user',
           'class' => \FormBuilder::create('Distilleries\Expendable\Forms\User\UserForm', [
               'model'                  => $this->getUserModel(),
               'do_not_display_role_id' => true
           ])
       ]);
```

### FormValidator
Extend the FormView and add the system of validation.

``` php
  public static $rules = [];
  public static $rules_update = null;
```

The both table use [the rules of laravel](http://laravel.com/docs/4.2/validation).
If the `$rules_update` keep in null the `$rules` is use to validate the form.

#### Use the validation client side
 By default I use [jQuery validation Engine](https://github.com/posabsolute/jQuery-Validation-Engine) for the javascript validation.
 When you add a field you can add an option `validation` to add the javascript validation.
 
 ``` php
    $this->add('email', 'email',
     [
         'validation' => 'required,custom[email]',
     ]);
```

#### Use the validation server side

If you have a form User like this:


``` php
<?php namespace Project\Forms;

use Distilleries\FormBuilder\FormValidator;


class UserForm extends FormValidator {

    public static $rules = [
        'email'    => 'required|email|unique:users',
        'password' => 'required|min:8',
        'status'   => 'required|integer',
        'role_id'  => 'required|integer',
    ];

    public static $rules_update = [
        'id'      => 'required',
        'email'   => 'required|email|unique:users,email',
        'status'  => 'required|integer',
        'role_id' => 'required|integer',
    ];

    // ------------------------------------------------------------------------------------------------


    public function buildForm()
    {

        $this
            ->add($this->model->getKeyName(), 'hidden')
            ->add('email', 'email',
                [
                    'label'      => _('Email'),
                    'validation' => 'required,custom[email]',
                ]);

        $id = $this->model->getKey();

        if (!empty($id))
        {
            $this->add('change_password', 'checkbox', [
                'default_value' => 1,
                'label'         => _('Check it if you want change your password'),
                'checked'       => false,
                'noInEditView'  => true
            ]);
        }

        $this->add('password', 'password',
            [
                'label'      => _('Password'),
                'attr'       => ['id'=>'password'],
                'validation' => 'required',
                'noInEditView'  => true
            ])
            ->add('password_match', 'password',
                [
                    'label'      => _('Repeat Password'),
                    'validation' => 'required,equals[password]',
                    'noInEditView'  => true
                ])
            ->add('status', 'choice', [
                'choices'     => StaticLabel::status(),
                'empty_value' => _('-'),
                'validation'  => 'required',
                'label'       => _('Status')
            ])
            ->add('role_id', 'choice', [
                'choices'     => \Role::getChoice(),
                'empty_value' => _('-'),
                'validation'  => 'required',
                'label'       => _('Role')
            ])
            ->addDefaultActions();
    }

    protected function getUpdateRules()
    {
        $key                           = \Input::get($this->model->getKeyName());
        static::$rules_update['email'] = 'required|email|unique:users,email,' . $key;

        return parent::getUpdateRules();
    }

    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------
    // ------------------------------------------------------------------------------------------------

}
```

You can see the `password` field is not require on the update.
I have an other specific rule. I want check if the email address is unique without if the email is use by your-self.

In the FormValidator you have two methods to get the update or general rules (`getGeneralRules`, `getUpdateRules`) . You can override them to return the good rules.
That what I do in the UserForm. I override the method `getUpdateRules` to add the id of user for the validation.


#### Check the rules on your controller:

 ``` php
    $form = FormBuilder::create('Project\Forms\UserForm', [
     'model' => new User
    ]);
        
    if ($form->hasError())
    {
        return $form->validateAndRedirectBack();
    }
    
```

`validateAndRedirectBack` do only a redirect back with errors and Inputs.

 ``` php
    Redirect::back()->withErrors($this->validate())->withInput(Input::all());
```



## List of fields

### 1 Input

Can be one of those type: 



Field | Type
----- | -----
text  | `<input type="text" />`
email | `<input type="email" />`
url   |  `<input type="url" />`
tel   | `<input type="tel" />`
number | `<input type="number" />`
date  | `<input type="date" />`
search | `<input type="search" />`
password | `<input type="password" />`
hidden | `<input type="hidden" />`
number | `<input type="number" />`
file | `<input type="text" />`


``` php
    $this->add('first_name', 'text', [
        'validation' => 'required',
        'label'      => _('First name')
    ])
```

###2 Choice

####2.2 Select

``` php
 $this->add('subscription', 'choice', [
        'choices' => ['monthly' => 'Monthly', 'yearly' => 'Yearly'],
        'empty_value' => '==== Select subscription ===',
        'multiple' => false // This is default. If set to true, it creates select with multiple select posibility
    ])
``` 

####2.2 Radio

``` php
$this->add('subscription', 'choice', [
       'choices' => ['monthly' => 'Monthly', 'yearly' => 'Yearly'],
       'selected' => 'monthly',
       'expanded' => true
   ])
```
        

###2.3 Checkbox

``` php
$this->add('subscription', 'choice', [
     'choices' => ['monthly' => 'Monthly', 'yearly' => 'Yearly'],
     'selected' => ['monthly', 'yearly']
     'expanded' => true,
     'multiple' => true
 ])
``` 
            
###3 Tag
The tag component is base on  [select2](http://select2.github.io/select2/).

Add the javascript on your bower components:

``` json
    "dependencies": {
        "select2": "~3.5.2"
    }
```
  
``` php
    $this->add('cc', 'tag', [
        'label'       => _('CC')
    ])
```

Render editable:

![cc](http://distilleri.es/markdown/formbuilder/_images/cc.png)

Render not editable:

![cc_view](http://distilleri.es/markdown/formbuilder/_images/cc_view.png)


###4 Upload
The upload field use [moximanager](http://www.moxiemanager.com/) to link the elements with all the media components.

``` php
   $this->add('file', 'upload',
   [
       'label'      => _('File'),
       'validation' => 'required',
       'extensions' => 'csv,xls,xlsx',
       'view'       => 'files',
   ]);
```      
Render editable:

![cc](http://distilleri.es/markdown/formbuilder/_images/upload.png)


###5 TinyMce
If you want use a rich content editor you can use [tinymce](http://www.tinymce.com/).

``` php
    $this->add('description', 'tinymce', [
        'label'      => _('Description')
    ]);
```            

Render editable:
![tinymce](http://distilleri.es/markdown/formbuilder/_images/tinymce.png)

Render not editable:
![tinymce_view](http://distilleri.es/markdown/formbuilder/_images/tinymce_view.png)
 
  
###6 Textarea
The textarea work like a text field.

``` php
    $this->add('description', 'textarea', [
        'label'      => _('Description')
    ]);
```      

###7 Button
You can add a button to submit your form or to back at the last page.

``` php
    $this->add('submit', 'submit',
    [
        'label' => _('Save'),
        'attr'  => [
            'class' => 'btn green'
        ],
    ], false, true)
    ->add('back', 'button',
    [
        'label' => _('Back'),
        'attr'  => [
            'class'   => 'btn default',
            'onclick' => 'window.history.back()'
        ],
    ], false, true);
                
```          
      
Render editable:
![button](http://distilleri.es/markdown/formbuilder/_images/button.png)

The button submit for the part not editable is never render.


###8 Address Picker

The address picker base on [http://logicify.github.io/jquery-locationpicker-plugin/](http://logicify.github.io/jquery-locationpicker-plugin/)

  
Add the javascript on your bower components:

``` json
    "dependencies": {
        "jquery-locationpicker-plugin": "~0.1.12"
    }
```
  
``` php
$this->add('address', 'address_picker', [
    'default_value' => [
               'lat'     => 10,
               'lng'     => 10,
               'street'  => '42 Wallaby Way',
               'city'    => 'Sydney',
               'country' => 'Australia',
               'default' => '42 Wallaby Way, Sydney, Australia',
           ]
       ]
]);
``` 
 Render editable:
 ![address_picker](http://distilleri.es/markdown/formbuilder/_images/address_picker.png)
 
 Render not editable:
 ![address_picker_view](http://distilleri.es/markdown/formbuilder/_images/address_picker_view.png)
 
 
 
###9 Form
You can add a form in a form. 
It pretty cool when you compose a big form to split it in multiple.
For example I have a profile form with an address. I use the address on the profile form.

``` php
  $this
    ->add('address', 'form', [
        'label' => _('Address'),
        'icon'  => 'globe',
        'class' => \FormBuilder::create('Project\Forms\AddressForm', [
            'model'                     => $address,
            'do_not_display_profile_id' => true
        ])
    ]);
```

 Render editable:
 ![form](http://distilleri.es/markdown/formbuilder/_images/form.png)
 
 Render not editable:
 ![form_view](http://distilleri.es/markdown/formbuilder/_images/form_view.png)

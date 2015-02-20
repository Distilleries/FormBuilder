[![Code quality](http://img.shields.io/scrutinizer/g/distilleries/formbuilder.svg?style=flat)](https://scrutinizer-ci.com/g/distilleries/formbuilder/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/distilleries/form-builder.svg?style=flat)](https://packagist.org/packages/distilleries/form-builder)
[![Latest Stable Version](https://img.shields.io/packagist/v/distilleries/form-builder.svg?style=flat)](https://packagist.org/packages/distilleries/form-builder)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE)


# Laravel 5 Form Builder

Based on laravel-form-builder (https://github.com/kristijanhusak/laravel-form-builder). 
I add default no editable form and few complex form fields.
I add the validation system directly in the form part.



## Table of contents
1. [Installation](#installation)
2. [Basic usage](#basic-usage)
3. [Type of form](#type-of-form)
  1. [Form](#form)
  2. [FormView](#formview)
  3. [FormValidator](#formvalidator)
    1. [Use the validation client side](#use-the-validation-client-side)
    2. [Use the validation server side](#use-the-validation-server-side)
    3. [Check the rules on your controller](#check-the-rules-on-your-controller)
4. [List of fields](#list-of-fields)
  1. [Input](#1-input)
  2. [Choice](#2-choice)
    1. [Select](#21-select)
    2. [Radio](#22-radio)
    3. [Checkbox](#23-checkbox)
    4. [Ajax](#24-ajax)
  3. [Tag](#3-tag)
  4. [Upload](#4-upload)
  5. [TinyMce](#5-tinymce)
  6. [Textarea](#6-textarea)
  7. [Button](#7-button)
  8. [Address Picker](#8-address-picker)
  9. [Form](#9-form)
5. [Authorisation](#authorisation)
6. [Controller](#controller)
7. [Troubleshooting](#troubleshooting)

##Installation

Add on your composer.json

``` json
    "require": {
        "distilleries/form-builder": "2.*",
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


Export the configuration:

```ssh
php artisan vendor:publish --provider="Distilleries\FormBuilder\FormBuilderServiceProvider"
```

Export the views  (optional):

```ssh
php artisan vendor:publish --provider="Distilleries\FormBuilder\FormBuilderServiceProvider"  --tag="views"
```


###Basic usage

Creating form classes is easy.
With a simple artisan command I can create form:

``` sh
    php artisan form:make Forms/PostForm
```

you create form class in path `app/Forms/PostForm.php` that looks like this:

``` php
<?php namespace App\Forms;

use Distilleries\FormBuilder\FormValidator;

class PostForm extends FormValidator
{
    public static $rules        = [];
    public static $rules_update = null;

    public function buildForm()
    {
        // Add fields here...

         $this->addDefaultActions();
    }
}
```

You can add fields which you want when creating command like this:

``` sh
php artisan form:make Forms/SongForm --fields="name:text, lyrics:textarea, publish:checkbox"
```

And that will create form in path `app/Forms/SongForm.php` with content:

``` php
<?php namespace App\Forms;

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

##Type of form

###Form

This is the base class from the package  [https://github.com/kristijanhusak/laravel-form-builder/tree/laravel-4](https://github.com/kristijanhusak/laravel-form-builder/tree/laravel-4).
It use to add the fields and generate the form. Check the readme to know how use the component.

###FormView
Extend the class Form to add a render with edit.

####Use the view
To display an not editable form you can use `form_view` or `form_rest_view`.
To display a specific field you can use `form_widget_view`.

``` blade
 {!! form_view($form) !!}
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

###FormValidator
Extend the FormView and add the system of validation.

``` php
  public static $rules = [];
  public static $rules_update = null;
```

The both table use [the rules of laravel](http://laravel.com/docs/4.2/validation).
If the `$rules_update` keep in null the `$rules` is use to validate the form.

####Use the validation client side
 By default I use [jQuery validation Engine](https://github.com/posabsolute/jQuery-Validation-Engine) for the javascript validation.
 When you add a field you can add an option `validation` to add the javascript validation.
 
 ``` php
    $this->add('email', 'email',
     [
         'validation' => 'required,custom[email]',
     ]);
```

####Use the validation server side

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


####Check the rules on your controller:

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



##List of fields

###1 Input

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

####2.1 Select

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

###2.4 Ajax
The tag component is base on  [select2](http://select2.github.io/select2/).

Add the javascript on your bower components:

``` json
    "dependencies": {
        "select2": "~3.5.2"
    }
```

This component is use to search an element, or multiple elements.

``` php
    $this-> ->add('user_id', 'choice_ajax', [
       'action'     => action('Admin\UserController@postSearch'),
       'validation' => 'required',
       'formatter'  => [
           'id'      => 'id',
           'libelle' => 'email',
       ],
       'label'      => _('User')
   ]);
``` 

Field | Explain
----- | -------
action | The url of the action for the autocomplete 
validation | The rules of the javascript validation 
formatter | To display an element select2 need to know who is the value and who is the text. You can use `,` to concat fields ex: `'libelle' => 'first_name,last_name',`.
label | The translation of the label display
maximum_selection_size | If you want limit the number of elements selectable. By default -1 no limit
multiple | If is a select mutiple or not
minimumInputLength | Minimum of char needed before send the search request. By default 2 char.
allowClear | Allow to remove the value from the field.


This code is an example of controller method for the search:
            
 ``` php         
    // ------------------------------------------------------------------------------------------------
    public function postSearch()
    {

        $ids = Input::get('ids');


        if (!empty($ids))
        {
            $data = $this->model->whereIn($this->model->getKeyName(), $ids)->get();

            return Response::json($data);
        }

        $term  = Input::get('term');
        $page  = Input::get('page');
        $paged = Input::get('page_limit');

        if (empty($paged))
        {
            $paged = 10;
        }

        if (empty($page))
        {
            $page = 1;
        }
        if (empty($term))
        {
            $elements = array();
            $total    = 0;
        } else
        {
            $elements = $this->model->search($term)->take($paged)->skip(($page - 1) * $paged)->get();
            $total    = $this->model->search($term)->count();

        }

        return Response::json([
            'total'    => $total,
            'elements' => $elements
        ]);

    }
``` 


Render editable:

![choice_ajax](http://distilleri.es/markdown/formbuilder/_images/choice_ajax.png)

![choice_ajax_multiple](http://distilleri.es/markdown/formbuilder/_images/choice_ajax_multiple.png)

Render not editable:

![choice_ajax_view](http://distilleri.es/markdown/formbuilder/_images/choice_ajax_view.png)


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

##Authorisation
Now the form builder provide a class to check the permission.
This class use the `auth` of your application.
On your model use for the Auth add a method `hasAccess` to define if the user have access or not.
The key in param is a string action like  `UserController@getEdit`.

```php
    public function hasAccess($key)
    {
        return true;
    }
```

If the user is connected and your model haven't this method the class return true.
If the user is not connected the permission util return false.
To disabled the restriction of connected user just go in config file and put false in `auth_restricted`.

If you use multi auth package just provide the good auth you want use:

```php
    $this->app->bindShared('permission-util', function () {
            return new PermissionUtil(Auth::administrator());
    });
```

 
##Controller

You can use the trait `Distilleries\FormBuilder\States\FormStateTrait` to add in your controller the default methods use with the form.

Example:
I created a `UserForm` class:

```php
<?php namespace App\Forms;

use Distilleries\FormBuilder\FormValidator;

class UserForm extends FormValidator
{
    public static $rules        = [
        'email'=>'required'
    ];
    public static $rules_update = null;

    public function buildForm()
    {
        $this
            ->add('id', 'hidden')
            ->add('email', 'email');

         $this->addDefaultActions();
    }
}
```

I created a controller `app/Http/Controllers/FormController`:

```php
<?php namespace App\Http\Controllers;


use App\Forms\UserForm;
use Distilleries\FormBuilder\States\FormStateTrait;

class FormController extends Controller {

	use FormStateTrait;
	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(\App\User $model, UserForm $form)
	{
		$this->model = $model;
		$this->form = $form;
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getIndex()
	{

		return $this->getEdit();

	}

}

```

I add the controller on the route file :

```php
Route::controllers([
	'form' => 'FormController'
]);
```

Like you can see I inject the model and the form on the constructor.
On the published template I add my style `resources/views/vendor/form-builder/state/form.blade.php`

```php


<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.5/css/jquery.dataTables.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="/vendor/datatable-builder/js/datatable.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include('form-builder::form.partial.errors')
            <div class="tabbable tabbable-custom boxless tabbable-reversed ">
                @yield('form')
            </div>
        </div>
    </div>
</div>
</body>
</html>
```
That it you have your form link to the user model.

##Troubleshooting

When you use the trait on your controller remove the route cache to be sure the routes are correctly generated.

```ssh
php artisan route:cache && php artisan route:list
```
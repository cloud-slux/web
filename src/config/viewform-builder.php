<?php
return [
    'defaults'      => [
        'wrapper_class'       => 'form-group',
        'wrapper_error_class' => 'has-error',
        'label_class'         => 'control-label',
        'field_class'         => 'form-control',
        'field_error_class'   => '',
        'help_block_class'    => 'help-block',
        'error_class'         => 'text-danger',
        'required_class'      => 'required',
        // Override a class from a field.
        //'text'                => [
        //    'wrapper_class'   => 'form-field-text',
        //    'label_class'     => 'form-field-text-label',
        //    'field_class'     => 'form-field-text-field',
        //]
        //'radio'               => [
        //    'choice_options'  => [
        //        'wrapper'     => ['class' => 'form-radio'],
        //        'label'       => ['class' => 'form-radio-label'],
        //        'field'       => ['class' => 'form-radio-field'],
        //],
    ],
    // Templates
    'form'          => 'viewform-builder::form',
    'text'          => 'viewform-builder::text',
    'textarea'      => 'viewform-builder::textarea',
    'button'        => 'viewform-builder::button',
    'buttongroup'   => 'viewform-builder::buttongroup',
    'radio'         => 'viewform-builder::radio',
    'checkbox'      => 'viewform-builder::checkbox',
    'select'        => 'viewform-builder::select',
    'choice'        => 'viewform-builder::choice',
    'repeated'      => 'viewform-builder::repeated',
    'child_form'    => 'viewform-builder::child_form',
    'collection'    => 'viewform-builder::collection',
    'static'        => 'viewform-builder::static',
    // Remove the laravel-form-builder:: prefix above when using template_prefix
    'template_prefix'   => '',
    'default_namespace' => '',
    'custom_fields' => [
//        'datetime' => App\Forms\Fields\Datetime::class
    ],
];

<?php

namespace App\ViewForm;

use Illuminate\Contracts\View\Factory as View;
use Illuminate\Support\Arr;

class FormHelper
{
  protected $view;

  public function getView()
  {
      return $this->view;
  }

  protected $formBuilder;

  public function __construct(View $view, array $config = []){
        $this->view = $view;
        $this->config = $config;
  }



  protected static $availableFieldTypes = [
  'text'           => 'InputType',
  'number'         => 'NumberType',
  'money'          => 'MoneyType',
  'textarea'       => 'TextareaType',
  'select'         => 'SelectType',
  'choice'         => 'ChoiceType',
  'email'          => 'InputType',
  'checkbox'       => 'CheckableType',
  'picker'         => 'PickerType',
  'datepicker'     => 'DatePickerType',
   ];

  public function getFieldType($type)
  {
      $types = array_keys(static::$availableFieldTypes);
      if (!$type || trim($type) == '') {
          throw new \InvalidArgumentException('Field type must be provided.');
      }
      if (!in_array($type, $types)) {
          throw new \InvalidArgumentException(
              sprintf(
                  'Unsupported field type [%s]. Available types are: %s',
                  $type,
                  join(', ', array_merge($types, array_keys($this->customTypes)))
              )
          );
      }

      return __NAMESPACE__ . '\\Fields\\' . static::$availableFieldTypes[$type];
  }

  public function getConfig($key = null, $default = null, $customConfig = [])
  {
      $config = array_replace_recursive($this->config, $customConfig);
      if ($key) {
          return Arr::get($config, $key, $default);
      }
      return $config;
  }

}

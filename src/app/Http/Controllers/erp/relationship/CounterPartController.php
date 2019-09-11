<?php

namespace App\Http\Controllers\erp\relationship;

//use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;

use App\Http\Controllers\erp\ViewFormController;
use App\erp\models\relationship\CounterPart;
use App\ViewForm\FormBuilder;

class CounterPartController extends ViewFormController
{
   public function __construct()
   {
       $counterPart = new CounterPart();
       parent::__construct($counterPart);
   }
}

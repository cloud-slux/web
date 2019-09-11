<?php

namespace App\Http\Controllers\erp\management;

//use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;

use App\Http\Controllers\erp\ViewFormController;
use App\erp\models\management\CostCenter;
use App\ViewForm\FormBuilder;

class CostCenterController extends ViewFormController
{
   public function __construct()
   {
       $costCenter = new CostCenter();
       parent::__construct($costCenter);
   }
}

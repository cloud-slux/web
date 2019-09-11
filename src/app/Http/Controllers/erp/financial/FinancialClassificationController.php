<?php

namespace App\Http\Controllers\erp\financial;

//use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
use App\Http\Controllers\erp\ViewFormController;
use App\erp\models\financial\FinancialClassification;
use App\ViewForm\FormBuilder;


class FinancialClassificationController extends ViewFormController
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $classification = new FinancialClassification();
        parent::__construct($classification);
    }
}

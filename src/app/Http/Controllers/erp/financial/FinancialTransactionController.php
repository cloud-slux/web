<?php

namespace App\Http\Controllers\erp\financial;

//use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
use App\Http\Controllers\erp\ViewFormController;
use App\erp\models\financial\FinancialTransaction;
use App\ViewForm\FormBuilder;

class FinancialTransactionController extends ViewFormController
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $transaction = new FinancialTransaction();
        parent::__construct($transaction);
    }
}

<?php

namespace App\Http\Controllers\erp\financial;

//use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
use App\Http\Controllers\erp\ViewFormController;
use App\erp\models\financial\FinancialAccount;
use App\ViewForm\FormBuilder;

class FinancialAccountController extends ViewFormController
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $account = new FinancialAccount();
        parent::__construct($account);
    }
}

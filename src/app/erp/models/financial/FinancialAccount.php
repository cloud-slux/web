<?php

namespace App\erp\models\financial;

use App\ViewForm\Form;
use App\ViewForm\UIComponent;

class FinancialAccount extends Form
{
    public $name = 'Contas Financeiras';

    public $singularName = 'Conta Financeira';

    public $alias = 'accounts';

    public $route = '/financial/account';

    public $routeName = 'financial.account';

    public $slug = 'idAccount';

    public $icon = 'attach_money';

    public function buildForm()
    {

        $this->add('_id', 'ID', 'ID', UIComponent::TEXT, true, true)
             ->add('description', 'Descrição', 'Descrição', UIComponent::TEXT, true, true)
             ->add('createdAt', 'Data de Inserção', 'Data de Inserção', UIComponent::DATEPICKER, false, false);

    }
}

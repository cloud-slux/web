<?php

namespace App\erp\models\financial;

use App\ViewForm\Form;
use App\ViewForm\UIComponent;
use App\ViewForm\DataAdapters\PickerAdapter;

use App\erp\facades\ViewFormModuleFacade;


class FinancialTransaction extends Form
{
    public $name = 'Transações Financeiras';

    public $singularName = 'Transação Financeira';

    public $alias = 'transactions';

    public $route = '/financial/transaction';

    public $routeName = 'financial.transaction';

    public $slug = 'idTransaction';

    public $icon = 'transfer_within_a_station';

    public function buildForm()
    {

        $this->add('_id', 'ID', 'ID', UIComponent::TEXT, true, true)
             ->add('companyId', 'Código da Empresa', 'Cód. da Emp.', UIComponent::TEXT, true, false)
             ->add('companyName', 'Nome de Empresa', 'Empresa', UIComponent::TEXT, true, true)
             ->add('type', 'Tipo da Transação', 'Tipo', UIComponent::SELECT, true, true)
             ->add('origin', 'Origem', 'Origem', UIComponent::TEXT, true, false)
             ->add('date', 'Data', 'Data', UIComponent::DATEPICKER, true, true)
             ->add('description', 'Descrição', 'Descrição', UIComponent::TEXT, true, true)
             ->add('creditAccountId', 'Código da Conta Crédito', 'Cód Conta Crédito', UIComponent::PICKER, true, false)
             ->add('creditAccountName', 'Nome da Conta Crédito', 'Conta Crédito', UIComponent::TEXT, true, true)
             ->add('creditClassificationId', 'Código da Classificação de Crédito', 'Cód. Class. Crédito', UIComponent::PICKER, true, false)
             ->add('creditClassificationName', 'Nome da Classificação de Crédito', 'Class. Crédito', UIComponent::TEXT, true, false)
             ->add('creditCostCenterId', 'Código da Centro de Custo Crédito', 'Cód. CC Crédito', UIComponent::PICKER, true, false)
             ->add('creditCostCenterName', 'Nome do Centro de Custo Crédito', 'CC Crédito', UIComponent::TEXT, true, false)
             ->add('creditValue', 'Valor de Crédito', 'Valor Crédito', UIComponent::TEXT, true, true)
             ->add('debitAccountId', 'Código da Conta Débito', 'Cód. Conta Débito', UIComponent::PICKER, true, false)
             ->add('debitAccountName', 'Nome da Conta Débito', 'Conta Débito', UIComponent::TEXT, true, true)
             ->add('debitClassificationId', 'Código da Classificação de Débito', 'Cód. Class. Débito', UIComponent::PICKER, true, false)
             ->add('debitClassificationName', 'Nome da Classificação de Débito', 'Class. Débito', UIComponent::TEXT, true, false)
             ->add('debitCostCenterId', 'Código da Centro de Custo Débito', 'Cód. CC Débito', UIComponent::PICKER, true, false)
             ->add('debitCostCenterName', 'Nome do Centro de Custo Débito', 'CC Débito', UIComponent::TEXT, true, false)
             ->add('debitValue', 'Valor de Débito', 'Valor Débito', UIComponent::TEXT, true, true);

    }

    public function buildMaps()
    {
        $this->addMap('type');
    }

    public function buildPickers()
    {
        $financialAccountRouteName = 'financial.account';
        $financialAccountInstance = ViewFormModuleFacade::getFormByRouteName($financialAccountRouteName);
        $financialAccountMatchedFields = $financialAccountInstance->getFieldsByNames(['description']);

        $creditAccountIdAdapter = new PickerAdapter();
        $creditAccountIdAdapter->withRoute($financialAccountInstance->route)
            ->withSchema($financialAccountMatchedFields)
            ->withPickerDisplayExpression('${this.picked._id}')
            ->withPickerHooks(array(array('property' => 'creditAccountName', 'value' => '${_this.picked.description}')));

        $debitAccountIdAdapter = new PickerAdapter();
        $debitAccountIdAdapter->withRoute($financialAccountInstance->route)
            ->withSchema($financialAccountMatchedFields)
            ->withPickerDisplayExpression('${this.picked._id}')
            ->withPickerHooks(array(array('property' => 'debitAccountName', 'value' => '${_this.picked.description}')));

        $this->addPicker(array('creditAccountId' => $creditAccountIdAdapter))->addPicker(array('debitAccountId' => $debitAccountIdAdapter));


        $financialClassificationRouteName = 'financial.classification';
        $financialClassificationInstance = ViewFormModuleFacade::getFormByRouteName($financialClassificationRouteName);
        $financialClassificationMatchedFields = $financialClassificationInstance->getFieldsByNames(['description', 'code', 'type', 'class']);

        $creditClassificationIdAdapter = new PickerAdapter();
        $creditClassificationIdAdapter->withRoute($financialClassificationInstance->route)
                    ->withSchema($financialClassificationMatchedFields)
                    ->withPickerDisplayExpression('${this.picked._id}')
                    ->withPickerHiddenFields(['code'])
                    ->withPickerHooks(array(array('property' => 'creditClassificationName', 'value' => '${_this.picked.description}')))
                    ->withPickerPreFilter('\'type\'$eq"C".AND.\'class\'.$eq"A"');

        $debitClassificationIdAdapter = new PickerAdapter();
        $debitClassificationIdAdapter->withRoute($financialClassificationInstance->route)
                    ->withSchema($financialClassificationMatchedFields)
                    ->withPickerDisplayExpression('${this.picked._id}')
                    ->withPickerHiddenFields(['code'])
                    ->withPickerHooks(array(array('property' => 'debitClassificationName', 'value' => '${_this.picked.description}')))
                    ->withPickerPreFilter('\'type\'$eq"D".AND.\'class\'.$eq"A"');

        $this->addPicker(array('creditClassificationId' => $creditClassificationIdAdapter))->addPicker(array('debitClassificationId' => $debitClassificationIdAdapter));


        $managementCostCenterRouteName = 'management.costcenter';
        $managementCostCenterInstance = ViewFormModuleFacade::getFormByRouteName($managementCostCenterRouteName);
        $managementCostCenterMatchedFields = $managementCostCenterInstance->getFieldsByNames(['description']);

        $creditCostCenterIdAdapter = new PickerAdapter();
        $creditCostCenterIdAdapter->withRoute($managementCostCenterInstance->route)
            ->withSchema($managementCostCenterMatchedFields)
            ->withPickerDisplayExpression('${this.picked._id}')
            ->withPickerHooks(array(array('property' => 'creditCostCenterName', 'value' => '${_this.picked.description}')));

        $debitCostCenterIdAdapter = new PickerAdapter();
        $debitCostCenterIdAdapter->withRoute($managementCostCenterInstance->route)
            ->withSchema($financialClassificationMatchedFields)
            ->withPickerDisplayExpression('${this.picked._id}')
            ->withPickerHooks(array(array('property' => 'debitCostCenterName', 'value' => '${_this.picked.description}')));

        $this->addPicker(array('creditCostCenterId' => $creditCostCenterIdAdapter))->addPicker(array('debitCostCenterId' => $debitCostCenterIdAdapter));
    }
}

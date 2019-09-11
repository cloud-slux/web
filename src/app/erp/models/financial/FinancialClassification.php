<?php

namespace App\erp\models\financial;

use App\ViewForm\Form;
use App\ViewForm\DataAdapters\PickerAdapter;
//use App\ViewForm\Fields\FormField;
use App\ViewForm\UIComponent;

use App\erp\facades\ViewFormModuleFacade;

class FinancialClassification extends Form
{
    public $name = 'Classificações Financeiras';

    public $singularName = 'Classificação Financeira';

    public $alias = 'classifications';

    public $route = '/financial/classification';

    public $routeName = 'financial.classification';

    public $slug = 'idClassification';

    public $icon = 'layers';

    public function buildForm()
    {

        $this->add('_id', 'ID', 'ID', UIComponent::TEXT, true, true)
             ->add('description', 'Descrição', 'Descrição', UIComponent::TEXT, true, true)
             ->add('code', 'Código', 'Cód.', UIComponent::TEXT, true, true)
             ->add('type', 'Tipo', 'Tipo', UIComponent::SELECT, true, true)
             ->add('class', 'Classe', 'Classe', UIComponent::SELECT, true, true)
             ->add('parent', 'Classificação Pai', 'Class. Pai', UIComponent::PICKER, true, false)
             ->add('codeParent', 'Código Pai', 'Cód. Pai', UIComponent::TEXT, true, true)
             ->add('createdAt', 'Data de Inserção', 'Data de Inserção', UIComponent::TEXT, false, false);

    }

    public function buildMaps()
    {
        $this->addMap('type')->addMap('class');
    }

    public function buildPickers()
    {
        $financialClassificationRouteName = 'financial.classification';
        $financialClassificationInstance = ViewFormModuleFacade::getFormByRouteName($financialClassificationRouteName);
        $parentMatchedFields = $financialClassificationInstance->getFieldsByNames(['description', 'code', 'type', 'class']);

        $parentAdapter = new PickerAdapter();
        $parentAdapter->withRoute($financialClassificationInstance->route)
                    ->withSchema($parentMatchedFields)
                    ->withPickerDisplayExpression('${this.picked.description}')
                    ->withPickerHiddenFields(['code'])
                    ->withPickerHooks( array(array('property' => 'codeParent', 'value' => '${_this.picked.code}')))
                    ->withPickerPreFilter('\'class\'.$eq"S"');

        $this->addPicker(array('parent' => $parentAdapter));
    }
}

<?php

namespace App\erp\models\relationship;

use App\ViewForm\Form;
use App\ViewForm\UIComponent;

class CounterPart extends Form
{
    public $name = 'Contrapartes';

    public $singularName = 'ContraParte';

    public $alias = 'counterparters';

    public $route = '/relationship/counterpart';

    public $slug = 'CounterPart';

    public $routeName = 'relationship.counterpart';

    public $icon = 'group';

    public function buildForm()
    {

        $this->add('_id', 'ID', 'ID', UIComponent::TEXT, true, true)
             ->add('code', 'Código', 'Cód.', UIComponent::TEXT, true, true)
             ->add('name', 'Nome', 'Nome', UIComponent::TEXT, true, true)
             ->add('type', 'Tipo', 'Tipo', UIComponent::TEXT, true, true)
             ->add('relationType', 'Relação', 'Relação', UIComponent::TEXT, true, true)
             ->add('createdAt', 'Data de Criação', 'Data de Criação', UIComponent::TEXT, false, false);

    }
}

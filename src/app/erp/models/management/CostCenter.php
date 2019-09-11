<?php

namespace App\erp\models\management;

use App\ViewForm\Form;
use App\ViewForm\UIComponent;

class CostCenter extends Form
{
    public $name = 'Centros de Custos';

    public $singularName = 'Centro de Custo';

    public $alias = 'costcenters';

    public $route = '/management/costcenter';

    public $slug = 'idCostCenter';

    public $routeName = 'management.costcenter';

    public $icon = 'pages';

    public function buildForm()
    {

        $this->add('_id', 'ID', 'ID', UIComponent::TEXT, true, true)
             ->add('description', 'Descrição', 'Descrição', UIComponent::TEXT, true, true)
             ->add('createdAt', 'Data de Criação', 'Data de Criação', UIComponent::TEXT, false, false);

    }
}

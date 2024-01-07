<?php

require_once dirname(__FILE__) . '/../../classes/ItrProductsErrors.php';

class AdminProductsErrorsController extends AdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = ItrProductsErrors::$definition['table'];
        $this->identifier = ItrProductsErrors::$definition['primary'];
        $this->className = ItrProductsErrors::class;

        parent::__construct();

        $this->fields_list = [ //TODO filtres
            'id_product_error' => [
                'title' => 'ID',
                'align' => 'center',
                'type' => 'int',
            ],
            'id_product' => [
                'title' => 'Id du produit',
                'align' => 'center',
                'type' => 'int',
            ],
            'product_name' => [
                'title' => 'Nom du produit',
                'align' => 'center',
                'type' => 'string',
            ],
            'error' => [
                'title' => 'Erreur',
                'align' => 'center',
                'type' => 'string',
            ],
            'date_add' => [
                'title' => 'Date du signalement',
                'type' => 'date',
            ],
        ];
        $this->addRowAction('view');
    }
}
<?php

class ItrProductsErrors extends ObjectModel
{
    public $id_product;
    public $product_name;
    public $error;
    public $date_add;
    public $date_upd;

    public static $definition = [
        'table' => 'itr_products_errors',
        'primary' => 'id_product_error',
        'fields' => [
            'id_product' => ['type' => self::TYPE_INT, 'required' => true],
            'product_name' => ['type' => self::TYPE_STRING, 'required' => true],
            'error' => ['type' => self::TYPE_STRING, 'required' => true],
            'date_add' => ['type' => self::TYPE_DATE],
            'date_upd' => ['type' => self::TYPE_DATE],
        ],
    ];

    public static function getProductNameById($productId)
    {
        $sQuery = 'SELECT name FROM ' . _DB_PREFIX_ . 'product_lang ' .
            'WHERE id_product = ' . (int) $productId;

        return Db::getInstance()->getValue($sQuery);
    }
}
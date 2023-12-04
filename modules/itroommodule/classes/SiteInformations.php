<?php

class SiteInformations
{
    public static function getTotalProducts()
    {
        return Db::getInstance()->getValue('SELECT COUNT(*) FROM ' . _DB_PREFIX_ . 'product');
    }

    public static function getAverageCart()
    {
        return Db::getInstance()->getValue('SELECT AVG(total_paid) FROM ' . _DB_PREFIX_ . 'orders');
    }

    public static function getMostOrdered()
    {
        return Db::getInstance()->execute(
            'SELECT product_id, SUM(product_quantity) AS total_ordered 
                FROM ' . _DB_PREFIX_ . 'order_detail 
                GROUP BY product_id 
                ORDER BY total_ordered DESC LIMIT 1');
    }
}
<?php

$aQuery = [];

$aQuery[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'itrpets` (' .
    '`id_pets` int(11) PRIMARY KEY AUTO_INCREMENT,' .
    '`id_customer` int(11) NOT NULL,' .
    '`id_species` int(11) NOT NULL,' .
    '`firstname` varchar(100),' .
    '`race` varchar(100) NOT NULL,' .
    '`birthday` datetime,' .
    '`weight` decimal(20,6) NOT NULL' .
    ') ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$aQuery[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'itrpets_species` (' .
    '`id_species` int(11) PRIMARY KEY AUTO_INCREMENT,' .
    '`active` tinyint NOT NULL,' .
    '`picto` varchar(100) NOT NULL' .
    ') ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

$aQuery[] = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'itrpets_species_lang` (' .
    '`id_species_lang` int(11) PRIMARY KEY AUTO_INCREMENT,' .
    '`id_species` int(11) NOT NULL,' .
    '`id_lang` int(11) NOT NULL,' .
    '`label` varchar(100) NOT NULL' .
    ') ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

foreach ($aQuery as $query) {
    if (Db::getInstance()->execute($query) == false) {
        return false;
    }
}
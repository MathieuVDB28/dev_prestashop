<?php

namespace classes;

use Db;

class ItrPetsSpecies extends \ObjectModel
{
    public $active;
    public $picto;

    public static $definition = [
        'table' => 'itrpets_species',
        'primary' => 'id_species',
        'fields' => [
            'active' => ['type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true],
            'picto' => ['type' => self::TYPE_STRING, 'validate' => 'isString'],
        ],
    ];

    public static function findAll()
    {
        $sQuery = 'SELECT * FROM ' . _DB_PREFIX_ . 'itrpets_species';

        return Db::getInstance()->executeS($sQuery);
    }
}
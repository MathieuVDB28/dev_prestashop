<?php

namespace classes;

use Db;

class ItrPetsSpeciesLang extends \ObjectModel
{
    public $id_species;
    public $id_lang;
    public $label;

    public static $definition = [
        'table' => 'itrpets_species_lang',
        'primary' => 'id_species_lang',
        'fields' => [
            'id_species' => ['type' => self::TYPE_INT, 'validate' => 'isBool', 'required' => true],
            'id_lang' => ['type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true],
            'label' => ['type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true],
        ],
    ];

    public static function getLabelBySpeciesId($speciesId)
    {
        $sQuery = 'SELECT label FROM ' . _DB_PREFIX_ . 'itrpets_species_lang WHERE id_species = ' . $speciesId;

        return Db::getInstance()->getValue($sQuery);
    }
}
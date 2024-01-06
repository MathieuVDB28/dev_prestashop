<?php

namespace classes;

class ItrPets extends \ObjectModel
{
    public $id_customer;
    public $id_species;
    public $firstname;
    public $race;
    public $birthday;
    public $weight;

    public static $definition = [
        'table' => 'itrpets',
        'primary' => 'id_pets',
        'fields' => [
            'id_customer' => ['type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true],
            'id_species' => ['type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true],
            'firstname' => ['type' => self::TYPE_STRING, 'validate' => 'isString'],
            'race' => ['type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true],
            'birthday' => ['type' => self::TYPE_DATE, 'validate' => 'isDate'],
            'weight' => ['type' => self::TYPE_INT, 'validate' => 'isInt'],
        ],
    ];
}
<?php

class ItrAvatars extends ObjectModel
{
    public $id_avatar;
    public $image;

    public static $definition = [
        'table' => 'itr_avatars',
        'primary' => 'id_avatar',
        'fields' => [
            'image' => ['type' => self::TYPE_STRING, 'validate' => 'isString'],
        ],
    ];
}
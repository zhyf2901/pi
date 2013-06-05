<?php
namespace Pi\Oauth\Provider\Storage\Model;

use Pi;
use Pi\Oauth\Provider\Service;

class Loader implements LoaderInterface
{
    protected static $config;

    public static function setConfig($config)
    {
        static::$config = $config;
    }

    public static function load($identifier)
    {
        $class = __NAMESPACE__ . '\\' . Service::canonizeName($identifier);
        if ('resource_owner' == $identifier) {
            $model = Pi::model('user');
        } else {
            $model = Pi::model($identifier, static::$config['table_prefix']);
        }
        return new $class($model);
    }
}
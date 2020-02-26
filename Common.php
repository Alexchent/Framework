<?php

namespace Framework;

/**
 * 通用功能类
 */
class Common
{
    public static $suffix;

//    public static $path = 'const/';
    /**
     * 获取配置
     * @staticvar array $config
     * @param string $key
     * @param string $subKey
     * @return array|string
     */
    public static function getSystemConfig($key, $subKey = "")
    {
        $data = self::getConfigFile('SystemConfig', $key, $subKey);
        if ($data === null) {
            $data = self::getConfigFile($key, $subKey);
        }
        
        return $data;
    }

    /**
     * 获取配置文件内容
     * @param string $key 配置文件索引键
     * @param string $subKey
     * @param string $thirdKey
     */
    public static function getConfigFile($key, $subKey = "", $thirdKey = "")
    {
        static $config = array();

        if (empty($config[$key])) {
            if (static::$suffix == null) {
                $file = base_path() . "/".static::$path . $key .".php";
            } else {
                $file = base_path() . "/".static::$path . $key . '.'. static::$suffix .".php";
            }

            if (file_exists($file)) {
                $config[$key] =  require($file);
            } else {
                return null;
            }
        }
        
        if (strlen($subKey) > 0) {
            if (strlen($thirdKey) > 0) {
                return isset($config[$key][$subKey][$thirdKey]) ? $config[$key][$subKey][$thirdKey] : null;
            }
            
            return isset($config[$key][$subKey]) ? $config[$key][$subKey] : null;
        }
        
        return $config[$key];
    }



    public static function getConfig($key)
    {
        static $config = array();

        $keyPath = explode('.', $key);
        $fileName = array_shift($keyPath);
        if (empty($config[$fileName])) {
            if (function_exists('base_path')) {
                $base_path = base_path();
            } else {
                $base_path = BASE_PATH;
            }
            if (static::$suffix == null) {
//                $file = $base_path . "/".static::$path . $fileName .".php";
                $file = $base_path . "/" . $fileName .".php";
            } else {
//                $file = $base_path . "/".static::$path . $fileName . '.'. static::$suffix .".php";
                $file = $base_path . "/" . $fileName . '.'. static::$suffix .".php";
            }

            if (file_exists($file)) {
                $config[$key] =  require($file);
            } else {
                return null;
            }
        }

        $res = $config[$key];
        foreach ($keyPath as $k) {
            $res = $res[$k];
        }

        return $res;
    }
}

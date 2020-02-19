<?php

namespace Framework;

/**
 * 通用功能类
 */
class Common
{

//    const IgnoreSuffix = 'dev';//忽略的后缀

    public static $suffix;

    public static $path = 'const/';
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
//echo $file;die;
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
}

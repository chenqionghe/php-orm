<?php
/**
 * Created by PhpStorm.
 * User: linyang
 * Date: 16/9/27
 * Time: 下午9:19
 */

namespace cube\utils;

/**
 * Class SystemUtil.
 * @package com\cube\utils
 */
final class SystemUtil
{
    /**
     * check the needed extensions.
     * @param $plugins
     * @return bool
     */
    public static function check_unknown_extension($extension = null)
    {
        if (empty($extension)) {
            $extension = self::extensions();
        } elseif (!is_array($extension)) {
            $extension = array($extension);
        }
        $env_extensions = get_loaded_extensions();
        foreach ($env_extensions as $key => $ext) {
            $env_extensions[$key] = strtolower($ext);
        }
        foreach ($extension as $ext) {
            if (!in_array($ext, $env_extensions)) {
                return $ext;
            }
        }
        return null;
    }
}
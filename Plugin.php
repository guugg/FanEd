<?php

namespace TypechoPlugin\FanEd;

use Typecho\Plugin\PluginInterface;
use Typecho\Widget\Helper\Form;

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * 简单的
 *
 * @package FanEd
 * @author 烦
 * @version 1.0.0
 * @link http://typecho.org
 */


class Plugin implements PluginInterface
{


    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     */
    public static function activate()
    {
        return Magic::activate();
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     */
    public static function deactivate()
    {
    }

    /**
     * 获取插件配置面板
     *
     * @param Form $form 配置面板
     */
    public static function config($form, $action = NULL)
    {
        return Option::config($form);
    }

    /**
     * 个人用户的配置面板
     *
     * @param Form $form
     */
    public static function personalConfig(Form $form)
    {
    }
}

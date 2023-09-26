<?php

namespace TypechoPlugin\FanEd;


use Typecho\Widget\Helper\Form\Element\Text;
use Typecho\Widget\Helper\Form\Element\Radio;
use TypechoPlugin\FanEd\app\App_Option;


if (!defined('__TYPECHO_ROOT_DIR__')) exit;


class Option
{
    public static function config( $form, $action = NULL )
    {
        /** 分类名称 */
        $name = new Text('word', null, App_Option::sayHello(), _t('暂未开发到这'));
        $form->addInput($name);

        $editorjs = new Radio(
            'editorjs',
            array(
                'TypeCho' => _t('TypeCho编辑器'),
                'Cherry' => _t('Cherry编辑器'),
                'FanED' => _t('FanED编辑器'),
                'TipTap' => _t('TipTap编辑器'),
            ),
            'FanED',
            _t('后台文章编辑器选择'),
            _t('怎么选都是没反应的，因为还没有开发到')
        );
        $form->addInput($editorjs);
    }
}

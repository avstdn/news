<?php
/**
 * Created by PhpStorm.
 * User: mirocow
 * Date: 03.07.15
 * Time: 20:39
 */

namespace backend\components;

/**
 * Class View
 * @package frontend\components
 * @method \common\models\User getIdentity()
 * @property string $regionName  @readonly
 */
class Html extends \yii\bootstrap\Html
{
    public static function popover($title, $header = '',$content, $options = [], $tag = '')
    {
        $defaultOptions = [
            'data-toggle' => 'popover',
            'data-content' => $content,
            'data-html' => 'true',
            'data-trigger' => 'hover',
        ];

        self::addCssClass($options, 'popover-link');
        $options = array_merge($defaultOptions, $options);
        $header && $options['data-title'] = $header;
        if (!$tag) return self::a($title, '#', $options);
        if ($options['class'] == 'popover-link') self::addCssClass($options, 'like-link');
        return self::tag($tag, $title, $options);
    }

    public static function fa($icon, $color = null)
    {
        if ($color) {
            $icon .= " text-{$color}";
        }
        return "<i class=\"fa fa-{$icon}\"></i>";
    }

    public static function badge($content, $options)
    {
        $defaultOptions = [
            'data-toggle' => 'tooltip',
            'data-content' => $content,
            'type' => 'default'
        ];

        $options = array_merge($defaultOptions, $options);

        self::addCssClass($options, 'label');
        self::addCssClass($options, 'label-'.$options['type']);

        return self::tag('span', $content, $options);
    }

    /**
     * Красит текст с использованием классов
     * @param $content
     * @param string $colorClass
     * @param string $backgroundClass
     * @param array $options
     * @return string
     */
    public static function color($content, $colorClass = null, $backgroundClass = null, $options = [])
    {
        $defaultOptions = [];

        if ($colorClass) {
            self::addCssClass($options, 'text-'.$colorClass);
        }
        if ($backgroundClass) {
            self::addCssClass($options, $backgroundClass);
        }

        $options = array_merge($defaultOptions, $options);

        return self::tag('span', $content, $options);
    }
}
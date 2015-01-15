<?php

/**
 * @package yii2-buttons
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2014
 * @version 1.0.0
 */

namespace pavlinter\buttons;

/**
 * Class AssetInputButton
 */
class AssetInputButton extends \yii\web\AssetBundle
{
    public $sourcePath = "@vendor/pavlinter/yii2-buttons/buttons/assets";

    public $js = [
        'js/jquery.input-button.js',
    ];
}

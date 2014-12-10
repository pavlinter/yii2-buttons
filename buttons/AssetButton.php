<?php

namespace pavlinter\buttons;

/**
 * Class AssetButton
 * @link http://www.designcouch.com/home/why/2013/05/23/dead-simple-pure-css-loading-spinner
 */
class AssetButton extends \yii\web\AssetBundle
{
    public $sourcePath = "@vendor/pavlinter/yii2-buttons/buttons/assets";

    public $css = [
        'css/ajaxbutton.css',
    ];
}

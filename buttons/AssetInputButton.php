<?php

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

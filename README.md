Yii2 AjaxButton
================

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist pavlinter/yii2-buttons "dev-master"
```

or add

```
"pavlinter/yii2-buttons": "dev-master"
```

to the require section of your `composer.json` file.

Usage
------------------


Simple GET Request
------------------
```php
<?= \pavlinter\buttons\AjaxButton::widget([
    /*
    'options' => [
        'class' => 'btn btn-primary',
    ],
    'spinnerOptions' => [
        'class' => 'ab-spinner-black', //ab-spinner-red|ab-spinner-green|ab-spinner-blue|ab-spinner-white
    ],
    */
    'id' => 'my-btn',
    'label' => 'My Button',
    'ajaxOptions' => [
        /*
        'dataType' => 'json',
        'always' => 'function(jqXHR, textStatus){jQuery(".ab-show-" + abId).hide();jQuery(".ab-hide-" + abId).show();}',
        'fail' => 'function(){}',
        'then' => 'function(){}',
        */
        'url' => ['', 'id' => 5], //default current page
        'done' => 'function(data){

        }',
    ],
]);?>
```
Simple POST Request
------------------
```php
<?= \pavlinter\buttons\AjaxButton::widget([
    'ajaxOptions' => [
        'data' => [
            'id' => 6,
        ],
        'done' => 'function(data){}',
    ],
]);?>
```
Send Form
------------------
```php
<?php $form = ActiveForm::begin(['id' => 'myForm']); ?>
    <input type="text" name="name" value="Jon"/>
    <input type="text" name="phone" value="4859282"/>
    <?= \pavlinter\buttons\AjaxButton::widget([
        'ajaxOptions' => [
            'type' => 'post',
            'done' => 'function(data){}',
        ],
    ]);?>
<?php ActiveForm::end(); ?>
```
Send form and own data
------------------
```php
<?= \pavlinter\buttons\AjaxButton::widget([
    'ajaxOptions' => [
        'type' => 'post',
        'dataType' => 'html',
        'beforeSend' => 'function(jqXHR, settings){
            //defined abId = id widget;
            var data = $("#myForm").serializeArray();
            data.push({name: "id",value: abId});
            settings.data = $.param(data);
        }',
        'data' => [],
        'done' => 'function(data){

        }',
    ],
]);?>
```
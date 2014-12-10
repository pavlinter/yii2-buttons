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
-----
```php
use pavlinter\buttons\AjaxButton;

<?= AjaxButton::widget([
    'options' => [
        'class' => 'btn btn-default',
    ],
    'ajaxOptions' => [
        'data' => [
            'id' => 1,
        ],
        'done' => 'function(data){

        }',
    ],
]);?>

<?= AjaxButton::widget([
    'options' => [
        'class' => 'btn btn-default',
    ],
    'spinnerOptions' => [
        'class' => 'ab-spinner-white',
    ],
    'ajaxOptions' => [
        'data' => [
            'id' => 6,
        ],
        'done' => 'function(data){

        }',
    ],
]);?>

<?= AjaxButton::widget([
    'options' => [
        'class' => 'btn btn-default',
    ],
    'spinnerOptions' => [
        'class' => 'ab-spinner-red',
    ],
    'ajaxOptions' => [
        'data' => [
            'id' => 3,
        ],
        'done' => 'function(data){

        }',
    ],
]);?>

<?= AjaxButton::widget([
    'spinnerOptions' => [
        'class' => 'ab-spinner-black',
    ],
    'ajaxOptions' => [
        'url' => ['', 'number' => 40],
        'type' => 'get',
        'data' => [
            'id' => 2,
        ],
        'done' => 'function(data){

        }',
    ],
]); ?>

<form action="">
    <div id="name"></div>
    <input type="text" name="name" value="Jon"/>
    <input type="text" name="phone" value="4859282"/>
    <?= AjaxButton::widget([
        'options' => [
            'class' => 'btn btn-default',
        ],
        'spinnerOptions' => [
            'class' => 'ab-spinner-green',
        ],
        'ajaxOptions' => [
            'done' => 'function(data){
                $("#name").text(data.text)
            }',
        ],
    ]);?>
</form>

```
<?php
namespace pavlinter\buttons;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2014
 * @package yii2-buttons
 * @version 1.0.0
 */
class AjaxButton extends Widget
{
    public $id;
    /**
     * @var array the HTML attributes for the widget container tag.
     */
    public $options = [];
    /**
     * @var string the tag to use to render the button
     */
    public $tagName = 'button';
    /**
     * @var string the button label
     */
    public $label = 'Button';
    /**
     * @var string the button label
     */
    public $template = '<span class="ab-loading ab-show-{id} {spinnerClass}"><span><span class="ab-hide-{id}">{label}<span>';
    /**
     * @var string type loading http://css-spinners.com/#/spinners/
     */
    public $spinnerClass = 'spinner';
    /**
     * @var boolean whether the label should be HTML-encoded.
     */
    public $encodeLabel = true;
    /**
     * @var array options for ajax.
     */
    public $ajaxOptions = [];
    /**
     * Initializes the widget.
     */
    public function run()
    {
        parent::run();

        if (isset($this->options['id'])) {
            $this->id = $this->options['id'];
        } else {
            $this->id = $this->options['id'] = $this->getId();
        }

        $label = $this->encodeLabel ? Html::encode($this->label) : $this->label;

        echo Html::tag($this->tagName, strtr($this->template, [
            '{label}' => $label,
            '{id}' => $this->id,
            '{spinnerClass}' => $this->spinnerClass,
        ]) , $this->options);

        if (!empty($this->ajaxOptions)) {
            $this->registerScript();
        }


    }

    protected function registerScript()
    {
        list($assetRoot, $assetUrl) = Yii::$app->getAssetManager()->publish('@vendor/pavlinter/yii2-buttons/buttons/assets');
        $view = $this->getView();
        $view->registerCssFile($assetRoot . '/css/ajaxbutton.css');

        $this->ajaxOptions = ArrayHelper::merge([
            'url' => [''],
            'dataType' => 'json',
            'always' => 'function(jqXHR, textStatus){$(".ab-show-" + id).hide();$(".ab-hide-" + id).show();}',
        ], $this->ajaxOptions);
        $callbackScript = '';
        foreach (['done', 'always', 'fail', 'then'] as $name) {
            $f = ArrayHelper::remove($this->ajaxOptions, $name);
            if (!empty($f)) {
                if (!($f instanceof JsExpression)) {
                    $f = new JsExpression($f);
                }
                $callbackScript .= '.' . $name . '(' . $f . ')';
            }
        }

        if (is_array($this->ajaxOptions['url'])) {
            $this->ajaxOptions['url'] = Yii::$app->getUrlManager()->createUrl($this->ajaxOptions['url']);
        }

        if(isset($this->ajaxOptions['data'])) {
            if (!isset($this->ajaxOptions['type'])) {
                $this->ajaxOptions['type'] = "POST";
            }
            if (!isset($this->ajaxOptions['data'][Yii::$app->request->csrfParam])) {
                $this->ajaxOptions['data'][Yii::$app->getRequest()->csrfParam] = Yii::$app->getRequest()->csrfToken;
            }
        } else {
            if (!isset($this->ajaxOptions['type'])) {
                $this->ajaxOptions['type'] = "GET";
            }
            $this->ajaxOptions['data'] = new JsExpression('$(this).closest("form").serialize()');
        }

        $view->registerJs('
        $("#' . $this->id . '").on("click", function(){
            var id = "' . $this->id . '";
            $(".ab-show-" + id).show();
            $(".ab-hide-" + id).hide();

            $.ajax(' . Json::encode($this->ajaxOptions) . ')' . $callbackScript . ';
            return false;
        });

        ');
    }
}

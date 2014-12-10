<?php
namespace pavlinter\buttons;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;

/**
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2014
 * @package yii2-buttons
 * @version 1.0.0
 */
class AjaxButton extends Widget
{
    /**
     * @var string the id widget.
     */
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
    public $template = '<span class="ab-loading ab-show-{id}">{spinner}</span><span class="ab-hide-{id}">{label}</span>';
    /**
     * @var array the HTML attributes for the spinner.
     * [
     *      'class' => 'ab-spinner-blue', ab-spinner-red | ab-spinner-green | ab-spinner-black | ab-spinner-white
     *      'width' => '20px',
     *      'height' => '20px',
     *      'content' => '',
     * ]
     */
    public $spinnerOptions = [
        'class' => 'ab-spinner-blue',
    ];
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

        if (!isset($this->options['class'])) {
            $this->options['class'] = 'btn btn-primary';
        }


        $view = $this->getView();
        AssetButton::register($view);

        $label = $this->encodeLabel ? Html::encode($this->label) : $this->label;

        $spinnerTag = ArrayHelper::remove($this->spinnerOptions, 'tag', 'div');
        $spinnerWidth = ArrayHelper::remove($this->spinnerOptions, 'width', '20px');
        $spinnerHeight = ArrayHelper::remove($this->spinnerOptions, 'height', '20px');
        $spinnerContent = ArrayHelper::remove($this->spinnerOptions, 'content');

        Html::addCssClass($this->spinnerOptions, 'ab-spinner');
        Html::addCssStyle($this->spinnerOptions,[
            'width' => $spinnerWidth,
            'height' => $spinnerHeight,
        ]);

        $spinner   = Html::tag($spinnerTag, $spinnerContent, $this->spinnerOptions);

        echo Html::tag($this->tagName, strtr($this->template, [
            '{spinner}' => $spinner,
            '{label}' => $label,
            '{id}' => $this->id,
        ]) , $this->options);

        if (!empty($this->ajaxOptions)) {
            $this->registerScript($view);
        }


    }

    /**
     * @param $view
     */
    protected function registerScript($view)
    {

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
            $this->ajaxOptions['url'] = Url::to($this->ajaxOptions['url']);
        }

        if (!isset($this->ajaxOptions['type'])) {
            $this->ajaxOptions['type'] = "post";
        }

        if(isset($this->ajaxOptions['data'])) {
            if ($this->ajaxOptions['type'] == 'post' && !isset($this->ajaxOptions['data'][Yii::$app->request->csrfParam])) {
                $this->ajaxOptions['data'][Yii::$app->getRequest()->csrfParam] = Yii::$app->getRequest()->csrfToken;
            }
        } else {
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

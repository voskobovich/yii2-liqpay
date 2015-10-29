<?php
/**
 * @var \yii\web\View $this
 * @var \voskobovich\liqpay\forms\PaymentForm $model
 * @var integer $autoSubmit
 * @var integer $autoSubmitTimeout
 */

use yii\helpers\Html;

$this->title = 'Processing';
?>

<?php if ($model->hasErrors()): ?>
    <?= Html::errorSummary($model) ?>
<?php else: ?>
    <?= Html::beginForm('https://www.liqpay.com/api/checkout', 'post', [
        'accept-charset' => 'utf8',
        'id' => 'liqPay-form'
    ]); ?>
    <?= Html::activeHiddenInput($model, 'data'); ?>
    <?= Html::activeHiddenInput($model, 'signature'); ?>
    <?php if ($autoSubmit): ?>
        <?= Html::script("setTimeout(function(){
                document.getElementById(\"liqPay-form\").submit();
            }, {$autoSubmitTimeout});"); ?>
    <?php else: ?>
        <?= Html::submitButton(); ?>
    <?php endif; ?>
    <?= Html::endForm(); ?>
<?php endif; ?>
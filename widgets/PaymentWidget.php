<?php

namespace voskobovich\liqpay\widgets;

use Yii;
use yii\base\InvalidParamException;
use yii\base\Widget;


/**
 * Class PaymentWidget
 * @package voskobovich\liqpay\widgets
 */
class PaymentWidget extends Widget
{
    /**
     * LiqPay payment params
     * See doc: https://www.liqpay.com/ru/doc/liq_buy
     * @var array
     */
    public $data;

    /**
     * Enable auto submit form
     * @var bool
     */
    public $autoSubmit = true;

    /**
     * Amount milliseconds sleep before submit form.
     * Of course, if auto submit enable.
     * @var int
     */
    public $autoSubmitTimeout = 0;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->data)) {
            throw new InvalidParamException('Param "data" can not be empty.');
        } elseif (!is_array($this->data)) {
            throw new InvalidParamException('Param "data" must be an array.');
        }
    }

    /**
     * @return string|void
     */
    public function run()
    {
        /** @var \voskobovich\liqpay\LiqPay $liqPay */
        $liqPay = Yii::$app->get('liqpay');
        $model = $liqPay->buildForm($this->data);
        $model->validate();

        return $this->render('paymentForm', [
            'model' => $model,
            'autoSubmit' => $this->autoSubmit,
            'autoSubmitTimeout' => $this->autoSubmitTimeout
        ]);
    }
}
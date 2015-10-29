<?php

namespace voskobovich\liqpay\actions;

use voskobovich\liqpay\forms\CallbackForm;
use Yii;
use yii\base\Action;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;


/**
 * Class CallbackAction
 * @package voskobovich\liqpay\actions
 */
class CallbackAction extends Action
{
    /**
     * @var callable
     */
    public $callable;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->callable)) {
            throw new InvalidParamException('Param "callable" can not be empty.');
        }
    }

    /**
     * @return string
     * @throws BadRequestHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $post = Yii::$app->request->post();

        if (empty($post['data']) || empty($post['signature'])) {
            throw new BadRequestHttpException();
        }

        $liqPay = Yii::$app->get('liqpay');
        $sign = base64_encode(sha1($liqPay->private_key . $post['data'] . $liqPay->private_key, 1));

        $model = new CallbackForm();
        $data = json_decode(base64_decode($post['data']), true);
        $model->load($data, '');
        if (!$model->validate() || $sign !== $post['signature']) {
            throw new BadRequestHttpException('Data is corrupted');
        }

        call_user_func($this->callable, $model);
    }
}
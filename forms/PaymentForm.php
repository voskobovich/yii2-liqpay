<?php

namespace voskobovich\liqpay\forms;

use Yii;
use yii\base\Model;


/**
 * Class PaymentForm
 * @package voskobovich\liqpay\forms
 */
class PaymentForm extends Model
{
    const SUBSCRIBE_PERIODICITY_MONTH = 'month';
    const SUBSCRIBE_PERIODICITY_YEAR = 'year';

    const CURRENCY_USD = 'USD';
    const CURRENCY_EUR = 'EUR';
    const CURRENCY_RUB = 'RUB';
    const CURRENCY_UAH = 'UAH';

    const TYPE_BUY = 'buy';
    const TYPE_DONATE = 'donate';

    const PAY_WAY_CARD = 'card';
    const PAY_WAY_LIQPAY = 'liqpay';
    const PAY_WAY_DELAYED = 'delayed';
    const PAY_WAY_INVOICE = 'invoice';
    const PAY_WAY_PRIVAT24 = 'privat24';

    const LANGUAGE_RU = 'ru';
    const LANGUAGE_EN = 'en';

    public $version;
    public $public_key;
    public $amount;
    public $currency;
    public $description;
    public $order_id;
    public $recurringbytoken;
    public $type;
    public $subscribe;
    public $subscribe_date_start;
    public $subscribe_periodicity;
    public $product_url;
    public $server_url;
    public $result_url;
    public $pay_way;
    public $language;
    public $sandbox;

    /**
     * @return string
     */
    public function formName()
    {
        return '';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['version', 'public_key', 'amount', 'currency', 'description', 'order_id'], 'required'],
            ['amount', 'number'],
            [['description', 'product_url'], 'string'],
            ['order_id', 'string', 'max' => 255],
            [['server_url', 'result_url'], 'string', 'max' => 510],
            ['currency', 'in', 'range' => array_keys(self::getCurrencyItems())],
            ['type', 'in', 'range' => array_keys(self::getTypeItems())],
            [['recurringbytoken', 'subscribe', 'sandbox'], 'boolean'],
            ['subscribe_date_start', 'date', 'format' => 'php:Y-m-d H:i:s'],
            ['subscribe_periodicity', 'in', 'range' => array_keys(self::getSubscribePeriodicityItems())],
            ['pay_way', 'in', 'range' => array_keys(self::getPayWayItems())],
            ['language', 'in', 'range' => array_keys(self::getLanguageItems())],
        ];
    }

    /**
     * @param null $key
     * @return array|null
     */
    public function getCurrencyItems($key = null)
    {
        $items = [
            self::CURRENCY_USD => 'USD',
            self::CURRENCY_EUR => 'EUR',
            self::CURRENCY_RUB => 'RUB',
            self::CURRENCY_UAH => 'UAH',
        ];

        if (!is_null($key)) {
            return isset($items[$key]) ? $items[$key] : null;
        }

        return $items;
    }

    /**
     * @param null $key
     * @return array|null
     */
    public function getTypeItems($key = null)
    {
        $items = [
            self::TYPE_BUY => 'Buy',
            self::TYPE_DONATE => 'Donate',
        ];

        if (!is_null($key)) {
            return isset($items[$key]) ? $items[$key] : null;
        }

        return $items;
    }

    /**
     * @param null $key
     * @return array|null
     */
    public function getSubscribePeriodicityItems($key = null)
    {
        $items = [
            self::SUBSCRIBE_PERIODICITY_MONTH => 'Month',
            self::SUBSCRIBE_PERIODICITY_YEAR => 'Year',
        ];

        if (!is_null($key)) {
            return isset($items[$key]) ? $items[$key] : null;
        }

        return $items;
    }

    /**
     * @param null $key
     * @return array|null
     */
    public function getPayWayItems($key = null)
    {
        $items = [
            self::PAY_WAY_CARD => 'Card',
            self::PAY_WAY_LIQPAY => 'LiqPay',
            self::PAY_WAY_DELAYED => 'Delayed',
            self::PAY_WAY_INVOICE => 'Invoice',
            self::PAY_WAY_PRIVAT24 => 'Privat24',
        ];

        if (!is_null($key)) {
            return isset($items[$key]) ? $items[$key] : null;
        }

        return $items;
    }

    /**
     * @param null $key
     * @return array|null
     */
    public function getLanguageItems($key = null)
    {
        $items = [
            self::LANGUAGE_RU => 'RU',
            self::LANGUAGE_EN => 'EN',
        ];

        if (!is_null($key)) {
            return isset($items[$key]) ? $items[$key] : null;
        }

        return $items;
    }

    /**
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function getData()
    {
        $liqPay = Yii::$app->get('liqpay');
        return $liqPay->getData($this->getAttributes());
    }

    /**
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function getSignature()
    {
        $liqPay = Yii::$app->get('liqpay');
        return $liqPay->getSignature($this->getAttributes());
    }
}
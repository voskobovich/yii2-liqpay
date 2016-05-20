<?php

namespace voskobovich\liqpay\forms;

use Yii;
use yii\base\Model;


/**
 * Class CallbackForm
 * @package voskobovich\liqpay\forms
 */
class CallbackForm extends Model
{
    const CURRENCY_USD = 'USD';
    const CURRENCY_EUR = 'EUR';
    const CURRENCY_RUB = 'RUB';
    const CURRENCY_UAH = 'UAH';

    const TYPE_BUY = 'buy';
    const TYPE_DONATE = 'donate';

    const STATUS_SUCCESS = 'success';
    const STATUS_FAILURE = 'failure';
    const STATUS_OTP_VERIFY = 'otp_verify';
    const STATUS_3DS_VERIFY = '3ds_verify';
    const STATUS_WAIT_SECURE = 'wait_secure';
    const STATUS_WAIT_ACCEPT = 'wait_accept';
    const STATUS_WAIT_LC = 'wait_lc';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SANDBOX = 'sandbox';
    const STATUS_SUBSCRIBED = 'subscribed';
    const STATUS_UNSUBSCRIBED = 'unsubscribed';
    const STATUS_REVERSED = 'reversed';
    const STATUS_CASH_WAIT = 'cash_wait';
    const STATUS_HOLD_WAIT = 'hold_wait';
    const STATUS_ERROR = 'error';

    public $version;
    public $public_key;
    public $amount;
    public $currency;
    public $description;
    public $order_id;
    public $type;
    public $transaction_id;
    public $sender_phone;
    public $status;
    public $card_token;

    public $token;
    public $redirect_to;

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
            [['version', 'public_key', 'amount', 'currency', 'description', 'order_id', 'transaction_id'], 'required'],
            ['amount', 'number'],
            ['transaction_id', 'integer'],
            [['description', 'sender_phone', 'card_token'], 'string'],
            ['order_id', 'string', 'max' => 255],
            ['currency', 'in', 'range' => array_keys(self::getCurrencyItems())],
            ['type', 'in', 'range' => array_keys(self::getTypeItems())],
            ['status', 'in', 'range' => array_keys(self::getStatusItems())],
            [['token','redirect_to'], 'safe']
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
    public function getStatusItems($key = null)
    {
        $items = [
            self::STATUS_SUCCESS => 'Success',
            self::STATUS_FAILURE => 'Failure',
            self::STATUS_OTP_VERIFY => 'otp_verify',
            self::STATUS_3DS_VERIFY => '3ds_verify',
            self::STATUS_WAIT_SECURE => 'Wait Secure',
            self::STATUS_WAIT_ACCEPT => 'Wait Accept',
            self::STATUS_WAIT_LC => 'Wait LC',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_SANDBOX => 'Sandbox',
            self::STATUS_SUBSCRIBED => 'Subscribed',
            self::STATUS_UNSUBSCRIBED => 'Unsubscribed',
            self::STATUS_REVERSED => 'Reversed',
            self::STATUS_CASH_WAIT => 'Cash Wait',
            self::STATUS_HOLD_WAIT => 'Hold Wait',
            self::STATUS_ERROR => 'Error',
        ];

        if (!is_null($key)) {
            return isset($items[$key]) ? $items[$key] : null;
        }

        return $items;
    }
}



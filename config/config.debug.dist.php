<?php
/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

/**
 * Copy over the following configs to your config
 */

use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Shared\Oms\OmsConstants;
use Spryker\Shared\Sales\SalesConstants;
use Spryker\Zed\Oms\OmsConfig;
use SprykerEco\Shared\Heidelpay\HeidelpayConstants;

// Heidelpay configuration

// Merchant config values, got from Heidelpay
$config[HeidelpayConstants::CONFIG_HEIDELPAY_SECURITY_SENDER] = '31HA07BC8142C5A171745D00AD63D182';
$config[HeidelpayConstants::CONFIG_HEIDELPAY_USER_LOGIN] = '31ha07bc8142c5a171744e5aef11ffd3';
$config[HeidelpayConstants::CONFIG_HEIDELPAY_USER_PASSWORD] = '93167DE7';

$config[HeidelpayConstants::CONFIG_HEIDELPAY_TRANSACTION_CHANNEL_CC_3D_SECURE] = '31HA07BC8142C5A171749A60D979B6E4';
$config[HeidelpayConstants::CONFIG_HEIDELPAY_TRANSACTION_CHANNEL_PAYPAL] = '31HA07BC8142C5A171749A60D979B6E4';
$config[HeidelpayConstants::CONFIG_HEIDELPAY_TRANSACTION_CHANNEL_IDEAL] = '31HA07BC8142C5A171744B56E61281E5';
$config[HeidelpayConstants::CONFIG_HEIDELPAY_TRANSACTION_CHANNEL_SOFORT] = '31HA07BC8142C5A171749CDAA43365D2';

// Shop configuration values
$config[HeidelpayConstants::CONFIG_HEIDELPAY_APPLICATION_SECRET] = '39542395235ßfsokkspreipsr';
$config[HeidelpayConstants::CONFIG_HEIDELPAY_SANDBOX_REQUEST] = true;

$config[HeidelpayConstants::CONFIG_HEIDELPAY_LANGUAGE_CODE] = 'DE';
$config[HeidelpayConstants::CONFIG_HEIDELPAY_PAYMENT_RESPONSE_URL] = 'https://' . $config[ApplicationConstants::HOST_YVES] . '/heidelpay/payment';
$config[HeidelpayConstants::CONFIG_YVES_CHECKOUT_SUCCESS_URL] = 'http://' . $config[ApplicationConstants::HOST_YVES] . '/checkout/success';
$config[HeidelpayConstants::CONFIG_YVES_URL] = 'http://' . $config[ApplicationConstants::HOST_YVES];
$config[HeidelpayConstants::CONFIG_YVES_CHECKOUT_PAYMENT_FAILED_URL] = 'http://' . $config[ApplicationConstants::HOST_YVES] . '/heidelpay/payment-failed?error_code=%s';
$config[HeidelpayConstants::CONFIG_YVES_CHECKOUT_IDEAL_AUTHORIZE_URL] = 'http://' . $config[ApplicationConstants::HOST_YVES] . '/heidelpay/ideal-authorize';
$config[HeidelpayConstants::CONFIG_YVES_CHECKOUT_PAYMENT_STEP_PATH] = '/checkout/payment';
$config[HeidelpayConstants::CONFIG_YVES_CHECKOUT_SUMMARY_STEP_URL] = 'http://' . $config[ApplicationConstants::HOST_YVES] . '/checkout/summary';
$config[HeidelpayConstants::CONFIG_YVES_CHECKOUT_ASYNC_RESPONSE_URL] = 'http://' . $config[ApplicationConstants::HOST_YVES] . '/heidelpay/cc-register-response';
$config[HeidelpayConstants::CONFIG_YVES_CHECKOUT_REGISTRATION_SUCCESS_URL] = 'http://' . $config[ApplicationConstants::HOST_YVES] . '/heidelpay/cc-register-success?id_registration=%s';
$config[HeidelpayConstants::CONFIG_YVES_CHECKOUT_PAYMENT_FRAME_CUSTOM_CSS_URL] = '';
$config[HeidelpayConstants::CONFIG_YVES_CHECKOUT_PAYMENT_FRAME_PREVENT_ASYNC_REDIRECT] = "FALSE";

$config[KernelConstants::DEPENDENCY_INJECTOR_YVES] = [
    'Checkout' => [
        'Heidelpay',
    ],
];

$config[KernelConstants::DEPENDENCY_INJECTOR_ZED] = [
    'Payment' => [
        'Heidelpay',
    ],
    'Oms' => [
        'Heidelpay',
    ],
];

$config[OmsConstants::PROCESS_LOCATION] = [
    OmsConfig::DEFAULT_PROCESS_LOCATION,
    $config[HeidelpayConstants::VENDOR_ROOT] . '/heidelpay/config/Zed/Oms',
];

$config[OmsConstants::ACTIVE_PROCESSES] = [
    'HeidelpaySofort01',
    'HeidelpayPaypalAuthorize01',
    'HeidelpayPaypalDebit01',
    'HeidelpayIdeal01',
    'HeidelpayCreditCardSecureAuthorize01',
];

$config[SalesConstants::PAYMENT_METHOD_STATEMACHINE_MAPPING] = [
    HeidelpayConstants::PAYMENT_METHOD_CREDIT_CARD_SECURE => 'HeidelpayCreditCardSecureAuthorize01',
    HeidelpayConstants::PAYMENT_METHOD_SOFORT => 'HeidelpaySofort01',
    HeidelpayConstants::PAYMENT_METHOD_PAYPAL_AUTHORIZE => 'HeidelpayPaypalAuthorize01',
    HeidelpayConstants::PAYMENT_METHOD_PAYPAL_DEBIT => 'HeidelpayPaypalDebit01',
    HeidelpayConstants::PAYMENT_METHOD_IDEAL => 'HeidelpayIdeal01',
];

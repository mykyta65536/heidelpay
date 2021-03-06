<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Heidelpay\Business\Adapter\Payment;

use Generated\Shared\Transfer\HeidelpayRequestTransfer;
use Heidelpay\PhpApi\PaymentMethods\IDealPaymentMethod;
use SprykerEco\Zed\Heidelpay\Business\Payment\Type\PaymentWithAuthorizeInterface;
use SprykerEco\Zed\Heidelpay\Business\Payment\Type\PaymentWithExternalResponseInterface;

class IdealPayment extends BasePayment implements
    IdealPaymentInterface,
    PaymentWithAuthorizeInterface,
    PaymentWithExternalResponseInterface
{

    /**
     * @param \Generated\Shared\Transfer\HeidelpayRequestTransfer $authorizeRequestTransfer
     *
     * @return \Generated\Shared\Transfer\HeidelpayResponseTransfer
     */
    public function authorize(HeidelpayRequestTransfer $authorizeRequestTransfer)
    {
        $idealMethod = new IDealPaymentMethod();
        $this->prepareRequest($authorizeRequestTransfer, $idealMethod->getRequest());
        $idealMethod->authorize();
        return $this->verifyAndParseResponse($idealMethod->getResponse());
    }

}

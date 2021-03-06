<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Functional\SprykerEco\Zed\Heidelpay\Business;

use Functional\SprykerEco\Zed\Heidelpay\Business\DataProviders\OrderWithSuccessfulCreditCardSecureTransaction;
use Functional\SprykerEco\Zed\Heidelpay\Business\DataProviders\OrderWithSuccessfulIdealAuthorizeTransaction;
use Functional\SprykerEco\Zed\Heidelpay\Business\DataProviders\OrderWithSuccessfulPaypalAuthorizeTransaction;
use Functional\SprykerEco\Zed\Heidelpay\Business\DataProviders\OrderWithSuccessfulPaypalDebitTransaction;
use Functional\SprykerEco\Zed\Heidelpay\Business\DataProviders\OrderWithSuccessfulSofortAuthorizeTransaction;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Zed\Heidelpay\HeidelpayConfig;

/**
 * @group Functional
 * @group Spryker
 * @group Zed
 * @group Heidelpay
 * @group Business
 * @group HeidelpayFacadeCaptureTest
 */
class HeidelpayFacadePostSaveHookTest extends AbstractFacadeTest
{

    /**
     * @dataProvider _createOrderWithSofortAuthorizeTransaction
     * @dataProvider _createOrderWithPaypalDebitTransaction
     * @dataProvider _createOrderWithPaypalAuthorizeTransaction
     * @dataProvider _createOrderWithCreditCardSecureTransaction
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     */
    public function testPostSaveHookForSuccessfulSalesOrdersSetsExternalRedirect(
        QuoteTransfer $quoteTransfer,
        CheckoutResponseTransfer $checkoutResponseTransfer
    ) {
        $this->heidelpayFacade->postSaveHook(
            $quoteTransfer,
            $checkoutResponseTransfer
        );

        $this->assertTrue($checkoutResponseTransfer->getIsExternalRedirect());
        $this->assertEquals(
            HeidelpayTestConstants::CHECKOUT_EXTERNAL_SUCCESS_REDIRECT_URL,
            $checkoutResponseTransfer->getRedirectUrl()
        );
    }

    /**
     * @dataProvider _createOrderWithIdealAuthorizeTransaction
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     */
    public function testPostSaveHookForSuccessfulIdealAuthorizeSetsRedirectToTheIdealFormStep(
        QuoteTransfer $quoteTransfer,
        CheckoutResponseTransfer $checkoutResponseTransfer
    ) {
        $this->heidelpayFacade->postSaveHook(
            $quoteTransfer,
            $checkoutResponseTransfer
        );

        $idealAuthorizeStepUrl = (new HeidelpayConfig())
            ->getIdealAuthorizeUrl();

        $this->assertTrue($checkoutResponseTransfer->getIsExternalRedirect());
        $this->assertEquals(
            $idealAuthorizeStepUrl,
            $checkoutResponseTransfer->getRedirectUrl()
        );
    }

    /**
     * @return array
     */
    public function _createOrderWithPaypalDebitTransaction()
    {
        $orderWithPaypalAuthorize = new OrderWithSuccessfulPaypalDebitTransaction();

        return [$orderWithPaypalAuthorize->createOrderWithPaypalDebitTransaction()];
    }

    /**
     * @return array
     */
    public function _createOrderWithIdealAuthorizeTransaction()
    {
        $orderWithPaypalAuthorize = new OrderWithSuccessfulIdealAuthorizeTransaction();

        return [$orderWithPaypalAuthorize->createOrderWithIdealAuthorizeTransaction()];
    }

    /**
     * @return array
     */
    public function _createOrderWithSofortAuthorizeTransaction()
    {
        $orderWithPaypalAuthorize = new OrderWithSuccessfulSofortAuthorizeTransaction();

        return [$orderWithPaypalAuthorize->createOrderWithSofortAuthorizeTransaction()];
    }

    /**
     * @return array
     */
    public function _createOrderWithPaypalAuthorizeTransaction()
    {
        $orderWithPaypalAuthorize = new OrderWithSuccessfulPaypalAuthorizeTransaction();

        return [$orderWithPaypalAuthorize->createOrderWithPaypalAuthorizeTransaction()];
    }

    /**
     * @return array
     */
    public function _createOrderWithCreditCardSecureTransaction()
    {
        $orderWithPaypalAuthorize = new OrderWithSuccessfulCreditCardSecureTransaction();

        return [$orderWithPaypalAuthorize->createOrderWithCreditCardSecureTransaction()];
    }

}

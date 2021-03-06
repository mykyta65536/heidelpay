<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */
namespace SprykerEco\Yves\Heidelpay\Mapper;

use Generated\Shared\Transfer\HeidelpayIdealAuthorizeFormTransfer;
use Generated\Shared\Transfer\HeidelpayResponseTransfer;

class HeidelpayResponseToIdealAuthorizeForm implements HeidelpayResponseToIdealAuthorizeFormInterface
{

    /**
     * @param \Generated\Shared\Transfer\HeidelpayResponseTransfer $responseTransfer
     * @param \Generated\Shared\Transfer\HeidelpayIdealAuthorizeFormTransfer $idealAuthoriseFormTransfer
     *
     * @return void
     */
    public function map(HeidelpayResponseTransfer $responseTransfer, HeidelpayIdealAuthorizeFormTransfer $idealAuthoriseFormTransfer)
    {
        $idealAuthoriseFormTransfer
            ->setActionUrl(
                $responseTransfer->getPaymentFormUrl()
            )
            ->setCountries(
                $responseTransfer->getConfig()->getBankCountries()
            )
            ->setBanks(
                $responseTransfer->getConfig()->getBankBrands()
            );
    }

}

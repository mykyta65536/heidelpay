<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Functional\SprykerEco\Zed\Heidelpay\Business\DataProviders\Customer;

use Functional\SprykerEco\Zed\Heidelpay\Business\HeidelpayTestConstants;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\HeidelpayPaymentTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Orm\Zed\Country\Persistence\SpyCountryQuery;
use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Orm\Zed\Customer\Persistence\SpyCustomer;
use Orm\Zed\Customer\Persistence\SpyCustomerAddress;
use Orm\Zed\Heidelpay\Persistence\SpyPaymentHeidelpayTransactionLog;
use Orm\Zed\Oms\Persistence\SpyOmsOrderItemState;
use Orm\Zed\Oms\Persistence\SpyOmsOrderProcess;
use Orm\Zed\Payolution\Persistence\Map\SpyPaymentPayolutionTableMap;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Orm\Zed\Sales\Persistence\SpySalesOrderAddress;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use SprykerEco\Shared\Heidelpay\HeidelpayConstants;

trait CustomerAddressTrait
{

    /**
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerAddress
     */
    public function createCustomerAddressJohnDoe()
    {
        return $this->createAddress('John', 'Doe');
    }

    /**
     * @param string $firstName
     * @param string $lastName
     *
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerAddress
     */
    private function createAddress($firstName, $lastName)
    {
        $country = SpyCountryQuery::create()->findOneByIso2Code('DE');

        $customerAddress = (new SpyCustomerAddress())
            ->setFkCountry($country->getIdCountry())
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setAddress1('Straße des 17. Juni 135')
            ->setCity('Berlin')
            ->setZipCode('10623');
        $customerAddress->save();

        return $customerAddress;
    }

}

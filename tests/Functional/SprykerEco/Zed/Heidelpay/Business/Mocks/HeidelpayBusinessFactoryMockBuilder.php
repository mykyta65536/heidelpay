<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Functional\SprykerEco\Zed\Heidelpay\Business;

use Codeception\Util\Stub;
use PHPUnit_Framework_TestCase;
use Spryker\Zed\Money\Business\MoneyFacade;
use Spryker\Zed\Payolution\Business\Api\Adapter\AdapterInterface;
use Spryker\Zed\Payolution\Business\PayolutionBusinessFactory;
use Spryker\Zed\Payolution\Business\PayolutionFacade;
use Spryker\Zed\Payolution\Dependency\Facade\PayolutionToMoneyBridge;
use Spryker\Zed\Payolution\PayolutionConfig;
use Spryker\Zed\Payolution\Persistence\PayolutionQueryContainer;
use SprykerEco\Zed\Heidelpay\Business\HeidelpayBusinessFactory;

class HeidelpayBusinessFactoryMockBuilder
{

    /**
     * @param \Spryker\Zed\Payolution\Business\Api\Adapter\AdapterInterface $adapter
     *
     * @return \Spryker\Zed\Payolution\Business\PayolutionFacade
     */
    public static function build()
    {
        $heidelpayBusinessFactoryMock = Stub::make(
            HeidelpayBusinessFactory::class,
            [
                'createPostSaveHook' => null
            ]
        );

        // Mock business factory to override return value of createExecutionAdapter to
        // place a mocked adapter that doesn't establish an actual connection.
        $businessFactoryMock = self::getBusinessFactoryMock($testCase);
        $businessFactoryMock->setConfig(new PayolutionConfig());
        $businessFactoryMock
            ->expects($testCase->any())
            ->method('createAdapter')
            ->will($testCase->returnValue($adapter));

        // Business factory always requires a valid query container. Since we're creating
        // functional/integration tests there's no need to mock the database layer.
        $queryContainer = new PayolutionQueryContainer();
        $businessFactoryMock->setQueryContainer($queryContainer);

        // Mock the facade to override getFactory() and have it return out
        // previously created mock.
        $facade = $testCase->getMockBuilder(PayolutionFacade::class)
            ->setMethods(['getFactory'])->getMock();

        $facade->expects($testCase->any())
            ->method('getFactory')
            ->will($testCase->returnValue($businessFactoryMock));

        return $facade;
    }

    /**
     * @param \PHPUnit_Framework_TestCase $testCase
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Zed\Payolution\Business\PayolutionBusinessFactory
     */
    protected static function getBusinessFactoryMock(PHPUnit_Framework_TestCase $testCase)
    {
        $businessFactoryMock = $testCase->getMockBuilder(PayolutionBusinessFactory::class)
            ->setMethods(
                ['createAdapter', 'getMoneyFacade']
            )->getMock();

        $payolutionToMoneyBridge = new PayolutionToMoneyBridge(new MoneyFacade());
        $businessFactoryMock->method('getMoneyFacade')->willReturn($payolutionToMoneyBridge);

        return $businessFactoryMock;
    }

}

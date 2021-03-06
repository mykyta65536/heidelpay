<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\Heidelpay\Sdk;

use Generated\Shared\Transfer\HeidelpayRegistrationRequestTransfer;
use Generated\Shared\Transfer\HeidelpayResponseErrorTransfer;
use Heidelpay\PhpApi\Exceptions\HashVerificationException;
use Heidelpay\PhpApi\Response;
use SprykerEco\Client\Heidelpay\HeidelpayConfig;
use SprykerEco\Client\Heidelpay\Mapper\ApiResponseToRegistrationResponseTransferInterface;

class CreditCardRegistrationResponseParser implements CreditCardRegistrationResponseParserInterface
{

    const ERROR_CODE_INVALID_RESPONSE = 'invalid-response';

    /**
     * @var \SprykerEco\Zed\Heidelpay\HeidelpayConfig
     */
    protected $config;

    /**
     * @var \SprykerEco\Client\Heidelpay\Mapper\ApiResponseToRegistrationResponseTransferInterface
     */
    protected $apiResponseToRegistrationResponseMapper;

    /**
     * @param \SprykerEco\Client\Heidelpay\Mapper\ApiResponseToRegistrationResponseTransferInterface $apiResponseToRegistrationResponseMapper
     * @param \SprykerEco\Client\Heidelpay\HeidelpayConfig $config
     */
    public function __construct(
        ApiResponseToRegistrationResponseTransferInterface $apiResponseToRegistrationResponseMapper,
        HeidelpayConfig $config
    ) {
        $this->config = $config;
        $this->apiResponseToRegistrationResponseMapper = $apiResponseToRegistrationResponseMapper;
    }

    /**
     * @param array $responseArray
     *
     * @return \Generated\Shared\Transfer\HeidelpayRegistrationRequestTransfer
     */
    public function parseExternalResponse(array $responseArray)
    {
        $registrationRequestTransfer = new HeidelpayRegistrationRequestTransfer();

        try {
            $apiResponseObject = $this->getValidatedApiResponseObject($responseArray);
            $this->hydrateResponseToTransfer($apiResponseObject, $registrationRequestTransfer);
        } catch (HashVerificationException $exception) {
            $this->hydrateValidationErrorToRequest($registrationRequestTransfer);
        }

        return $registrationRequestTransfer;
    }

    /**
     * @param array $apiResponseArray
     *
     * @return \Heidelpay\PhpApi\Response
     */
    protected function getValidatedApiResponseObject(array $apiResponseArray)
    {
        $apiResponse = new Response($apiResponseArray);

        $apiResponse->verifySecurityHash(
            $this->getApplicationSecret(),
            $apiResponse->getIdentification()->getTransactionId()
        );

        return $apiResponse;
    }

    /**
     * @param \Generated\Shared\Transfer\HeidelpayRegistrationRequestTransfer $registrationRequestTransfer
     *
     * @return void
     */
    protected function hydrateValidationErrorToRequest(HeidelpayRegistrationRequestTransfer $registrationRequestTransfer)
    {
        $errorTransfer = new HeidelpayResponseErrorTransfer();
        $errorTransfer->setCode(static::ERROR_CODE_INVALID_RESPONSE);

        $this->apiResponseToRegistrationResponseMapper
            ->hydrateErrorToRegistrationRequest($registrationRequestTransfer, $errorTransfer);
    }

    /**
     * @return string
     */
    protected function getApplicationSecret()
    {
        return $this->config->getApplicationSecret();
    }

    /**
     * @param \Heidelpay\PhpApi\Response $apiResponseObject
     * @param \Generated\Shared\Transfer\HeidelpayRegistrationRequestTransfer $registrationRequestTransfer
     *
     * @return void
     */
    protected function hydrateResponseToTransfer(
        Response $apiResponseObject,
        HeidelpayRegistrationRequestTransfer $registrationRequestTransfer
    ) {
        $this->apiResponseToRegistrationResponseMapper
            ->map(
                $apiResponseObject,
                $registrationRequestTransfer
            );
    }

}

<?php

/*
 * This file is part of the Netaxept API package.
 *
 * (c) Andrew Plank
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FDM\Netaxept\Exception;

use Webmozart\Assert\Assert;

class Factory
{
    private $classMap = [];

    public function __construct(
        $authenticationExceptionClass = AuthenticationException::class,
        $bbsExceptionClass = BBSException::class,
        $genericErrorClass = GenericError::class,
        $merchantTranslationExceptionClass = MerchantTranslationException::class,
        $notSupportedExceptionClass = NotSupportedException::class,
        $queryExceptionClass = QueryException::class,
        $securityExceptionClass = SecurityException::class,
        $uniqueTransactionIdExceptionClass = UniqueTransactionIdException::class,
        $validationExceptionClass = ValidationException::class,
        $transactionNotFoundExceptionClass = TransactionNotFoundException::class,
        $transactionNotAuthorizedExceptionClass = TransactionNotAuthorizedException::class
    ) {
        $this->classMap = [
            'AuthenticationException' => $authenticationExceptionClass,
            'BBSException' => $bbsExceptionClass,
            'GenericError' => $genericErrorClass,
            'MerchantTranslationException' => $merchantTranslationExceptionClass,
            'NotSupportedException' => $notSupportedExceptionClass,
            'SecurityException' => $securityExceptionClass,
            'UniqueTransactionIdException' => $uniqueTransactionIdExceptionClass,
            'ValidationException' => $validationExceptionClass,
            'QueryException' => $queryExceptionClass,
            'TransactionNotFoundException' => $transactionNotFoundExceptionClass,
            'TransactionNotAuthorizedException' => $transactionNotAuthorizedExceptionClass,
        ];
    }

    public function getException(\SimpleXMLElement $xml): Exception
    {
        $exceptionType = (string) $xml->Error->attributes('xsi', true)->type;

        switch ($xml->Error->Message) {
            case 'Unable to find transaction':
                $exceptionType = 'TransactionNotFoundException';

            break;

            case 'You cannot run capture on a transaction that never is authorized':
                $exceptionType = 'TransactionNotAuthorizedException';

            break;
        }

        Assert::notEmpty(
            $this->classMap[$exceptionType],
            'Unable to instantiate Exception class for ' . $exceptionType
        );

        $exceptionClass = $this->classMap[$exceptionType];

        throw new $exceptionClass($xml);
    }
}

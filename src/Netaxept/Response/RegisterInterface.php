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

namespace FDM\Netaxept\Response;

interface RegisterInterface
{
    /**
     * Should return the transactionId contained in the XML response.
     *
     * @return string
     */
    public function getTransactionId(): string;
}

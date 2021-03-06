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

class Process extends AbstractResponse implements ProcessInterface
{
    public function getStatus(): string
    {
        return (string) $this->xml->ResponseCode;
    }

    public function getOperation(): string
    {
        return (string) $this->xml->Operation;
    }
}

<?php

declare(strict_types=1);

namespace Fabricio872\EasyRssBundle\Exceptions;

use Exception;

class NotSetException extends Exception
{
    public function __construct(string $variableName)
    {
        $this->message = sprintf('Variable "%s" not set.', $variableName);
    }
}

<?php

namespace Sol\Storage\Exception;

use Sol\Exception;

class ResourceNotFoundException extends Exception
{
    /**
     * @param string $identifier
     */
    public function __construct(string $identifier)
    {
        parent::__construct(sprintf('Resource "%s" not found.', $identifier));
    }
}

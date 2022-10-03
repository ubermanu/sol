<?php

namespace Sol\Identifier;

class Random
{
    /**
     * @return string
     * @throws \Exception
     */
    public function generate(): string
    {
        return bin2hex(random_bytes(16));
    }
}

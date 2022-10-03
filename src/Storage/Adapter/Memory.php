<?php

namespace Sol\Storage\Adapter;

use Sol\Storage\Adapter;
use Sol\Storage\Exception\ResourceNotFoundException;

class Memory implements Adapter
{
    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @inheritDoc
     */
    public function write(string $identifier, string $content, array $options = []): void
    {
        $this->data[$identifier] = $content;
    }

    /**
     * @inheritDoc
     * @throws ResourceNotFoundException
     */
    public function read(string $identifier): string
    {
        if (!isset($this->data[$identifier])) {
            throw new ResourceNotFoundException($identifier);
        }

        return $this->data[$identifier];
    }

    /**
     * @param string $identifier
     * @return void
     */
    public function delete(string $identifier): void
    {
        unset($this->data[$identifier]);
    }
}

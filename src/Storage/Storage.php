<?php

namespace Sol\Storage;

class Storage
{
    protected Adapter $adapter;

    public function __construct(
        Adapter $adapter
    ) {
        $this->adapter = $adapter;
    }

    /**
     * @param string $identifier
     * @param string $content
     * @return void
     */
    public function write(string $identifier, string $content): void
    {
        $this->adapter->write($identifier, $content);
    }

    /**
     * @param string $identifier
     * @return string
     */
    public function read(string $identifier): string
    {
        return $this->adapter->read($identifier);
    }

    /**
     * @param string $identifier
     * @param string $content
     * @return void
     */
    public function update(string $identifier, string $content): void
    {
        // TODO: Implement the resource update.
    }
}

<?php

namespace Sol\Storage\Adapter;

use Sol\Storage\Adapter;
use Sol\Storage\Exception\ResourceNotFoundException;

class Filesystem implements Adapter
{
    /**
     * @var string
     */
    protected string $rootDir;

    /**
     * @param string|null $rootDir
     */
    public function __construct(?string $rootDir = null)
    {
        $this->rootDir = dirname(getcwd()) . DIRECTORY_SEPARATOR . rtrim($rootDir ?? 'var/data', DIRECTORY_SEPARATOR);
    }

    /**
     * @inheritDoc
     */
    public function write(string $identifier, string $content, array $options = []): void
    {
        $path = $this->rootDir . DIRECTORY_SEPARATOR . $identifier;

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        file_put_contents($path, $content);
    }

    /**
     * @inheritDoc
     * @throws ResourceNotFoundException
     */
    public function read(string $identifier): string
    {
        $path = $this->rootDir . DIRECTORY_SEPARATOR . $identifier;

        if (!file_exists($path)) {
            throw new ResourceNotFoundException($identifier);
        }

        return file_get_contents($path);
    }

    /**
     * @param string $identifier
     * @return void
     */
    public function delete(string $identifier): void
    {
        $path = $this->rootDir . DIRECTORY_SEPARATOR . $identifier;

        if (file_exists($path)) {
            unlink($path);
        }
    }
}

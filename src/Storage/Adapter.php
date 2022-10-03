<?php

namespace Sol\Storage;

interface Adapter
{
    /**
     * @param string $identifier
     * @param string $content
     * @param array $options
     * @return void
     */
    public function write(string $identifier, string $content, array $options = []): void;

    /**
     * @param string $identifier
     * @return string
     */
    public function read(string $identifier): string;

    /**
     * @param string $identifier
     * @return void
     */
    public function delete(string $identifier): void;
}

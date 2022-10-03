<?php

namespace Sol\Tests\Unit\Storage\Adapter;

use PHPUnit\Framework\TestCase;
use Sol\Storage\Adapter\Memory;
use Sol\Storage\Exception\ResourceNotFoundException;

class MemoryTest extends TestCase
{
    /**
     * @var Memory
     */
    protected Memory $adapter;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->adapter = new Memory();
    }

    /**
     * @covers \Sol\Storage\Adapter\Memory::write
     * @covers \Sol\Storage\Adapter\Memory::read
     * @return void
     * @throws ResourceNotFoundException
     */
    public function testReadWrite(): void
    {
        $identifier = 'test-1234';
        $this->adapter->write($identifier, 'Cats riding on a skateboard');
        $this->assertEquals('Cats riding on a skateboard', $this->adapter->read($identifier));
    }

    /**
     * @covers \Sol\Storage\Adapter\Memory::read
     * @return void
     * @throws ResourceNotFoundException
     */
    public function testReadNotFound(): void
    {
        $this->expectException(ResourceNotFoundException::class);
        $this->adapter->read('unknown-identifier');
    }
}

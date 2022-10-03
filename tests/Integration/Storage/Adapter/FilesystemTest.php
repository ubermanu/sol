<?php

namespace Sol\Tests\Integration\Storage\Adapter;

use PHPUnit\Framework\TestCase;
use Sol\Storage\Adapter\Filesystem;
use Sol\Storage\Exception\ResourceNotFoundException;

class FilesystemTest extends TestCase
{
    /**
     * @var Filesystem
     */
    protected Filesystem $adapter;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->adapter = new Filesystem(sys_get_temp_dir() . '/.phpunit.sol/var/data');
    }

    /**
     * @covers \Sol\Storage\Adapter\Filesystem::write
     * @covers \Sol\Storage\Adapter\Filesystem::read
     * @return void
     * @throws ResourceNotFoundException
     */
    public function testReadWrite(): void
    {
        $identifier = 'test-1234';
        $this->adapter->write($identifier, 'Dogs playing poker');
        $this->assertEquals('Dogs playing poker', $this->adapter->read($identifier));
    }

    /**
     * @covers \Sol\Storage\Adapter\Filesystem::read
     * @return void
     * @throws ResourceNotFoundException
     */
    public function testReadNotFound(): void
    {
        $this->expectException(ResourceNotFoundException::class);
        $this->adapter->read('unknown-identifier');
    }

    /**
     * @covers \Sol\Storage\Adapter\Filesystem::write
     * @covers \Sol\Storage\Adapter\Filesystem::read
     * @covers \Sol\Storage\Adapter\Filesystem::delete
     * @return void
     * @throws ResourceNotFoundException
     */
    public function testWriteDelete(): void
    {
        $identifier = 'test-1234';
        $this->adapter->write($identifier, 'Dogs playing poker');
        $this->adapter->delete($identifier);
        $this->expectException(ResourceNotFoundException::class);
        $this->adapter->read($identifier);
    }
}

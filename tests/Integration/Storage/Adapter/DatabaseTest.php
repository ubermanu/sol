<?php

namespace Sol\Tests\Integration\Storage\Adapter;

use Doctrine\DBAL\Exception;
use PHPUnit\Framework\TestCase;
use Sol\Storage\Adapter\Database;
use Sol\Storage\Exception\ResourceNotFoundException;

class DatabaseTest extends TestCase
{
    /**
     * @var Database
     */
    protected Database $adapter;

    /**
     * @return void
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->adapter = new Database('mysql://db:db@db:3306/test');
        $this->adapter->dropTableIfExists();
        $this->adapter->createTableIfNotExists();
    }

    /**
     * @covers \Sol\Storage\Adapter\Database::write
     * @covers \Sol\Storage\Adapter\Database::read
     * @return void
     * @throws ResourceNotFoundException
     * @throws Exception
     */
    public function testReadWrite(): void
    {
        $identifier = 'test-1234';
        $this->adapter->write($identifier, 'Crocodiles snacking in a tree');
        $this->assertEquals('Crocodiles snacking in a tree', $this->adapter->read($identifier));
    }

    /**
     * @covers \Sol\Storage\Adapter\Database::read
     * @return void
     * @throws ResourceNotFoundException
     * @throws Exception
     */
    public function testReadNotFound(): void
    {
        $this->expectException(ResourceNotFoundException::class);
        $this->adapter->read('unknown-identifier');
    }

    /**
     * @covers \Sol\Storage\Adapter\Database::write
     * @covers \Sol\Storage\Adapter\Database::read
     * @covers \Sol\Storage\Adapter\Database::delete
     * @return void
     * @throws ResourceNotFoundException
     * @throws Exception
     */
    public function testWriteDelete(): void
    {
        $identifier = 'test-1234';
        $this->adapter->write($identifier, 'Crocodiles snacking in a tree');
        $this->adapter->delete($identifier);
        $this->expectException(ResourceNotFoundException::class);
        $this->adapter->read($identifier);
    }

    /**
     * @return void
     * @throws Exception
     */
    protected function tearDown(): void
    {
        $this->adapter->dropTableIfExists();
    }
}

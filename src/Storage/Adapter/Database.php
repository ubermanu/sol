<?php

namespace Sol\Storage\Adapter;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Sol\Storage\Adapter;
use Sol\Storage\Exception\ResourceNotFoundException;

class Database implements Adapter
{
    /**
     * @var Connection
     */
    protected Connection $connection;

    /**
     * @param string $dsn
     * @throws Exception
     */
    public function __construct(string $dsn)
    {
        $this->connection = \Doctrine\DBAL\DriverManager::getConnection(['url' => $dsn]);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function write(string $identifier, string $content, array $options = []): void
    {
        $this->connection->insert('storage', [
            'identifier' => $identifier,
            'content' => $content,
        ]);
    }

    /**
     * @inheritDoc
     * @throws ResourceNotFoundException
     * @throws Exception
     */
    public function read(string $identifier): string
    {
        $result = $this->connection->fetchOne('SELECT content FROM storage WHERE identifier = ?', [$identifier]);

        if (empty($result)) {
            throw new ResourceNotFoundException($identifier);
        }

        return $result;
    }

    /**
     * @param string $identifier
     * @return void
     * @throws Exception
     */
    public function delete(string $identifier): void
    {
        $this->connection->delete('storage', ['identifier' => $identifier]);
    }
}

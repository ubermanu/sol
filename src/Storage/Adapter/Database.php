<?php

namespace Sol\Storage\Adapter;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\ParameterType;
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
        $this->connection->executeStatement(
            'INSERT INTO storage (identifier, content) VALUES (:identifier, :content) ON DUPLICATE KEY UPDATE content = :content',
            [
                'identifier' => $identifier,
                'content' => $content,
            ],
            [
                'identifier' => ParameterType::STRING,
                'content' => ParameterType::STRING,
            ]
        );
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

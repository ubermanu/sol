<?php

namespace Sol\Storage\Adapter;

use Sol\Storage\Adapter;
use Sol\Storage\Exception\ResourceNotFoundException;

class Database implements Adapter
{
    /**
     * @var \PDO
     */
    protected \PDO $pdo;

    /**
     * @param string $dsn
     */
    public function __construct(string $dsn)
    {
        $this->pdo = new \PDO($dsn);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @inheritDoc
     */
    public function write(string $identifier, string $content, array $options = []): void
    {
        $statement = $this->pdo->prepare('INSERT INTO storage (identifier, content) VALUES (:identifier, :content)');
        $statement->execute([
            'identifier' => $identifier,
            'content' => $content,
        ]);
    }

    /**
     * @inheritDoc
     * @throws ResourceNotFoundException
     */
    public function read(string $identifier): string
    {
        $statement = $this->pdo->prepare('SELECT content FROM storage WHERE identifier = :identifier');
        $statement->execute([
            'identifier' => $identifier,
        ]);

        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        if ($result === false) {
            throw new ResourceNotFoundException($identifier);
        }

        return $result['content'];
    }

    /**
     * @param string $identifier
     * @return void
     */
    public function delete(string $identifier): void
    {
        $statement = $this->pdo->prepare('DELETE FROM storage WHERE identifier = :identifier');
        $statement->execute([
            'identifier' => $identifier,
        ]);
    }
}

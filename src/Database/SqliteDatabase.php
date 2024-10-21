<?php

namespace Rpj\Login\Database;

class SqliteDatabase implements IDatabase
{
    protected $connection;

    public function __construct(string $filePath)
    {
        $this->connection = new \PDO('sqlite:'.$filePath);
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Get filtered rows.
     *
     * @param  string  $table  The table name
     * @param  array  $columns  The columns to be returned
     * @param  string  $where  The conditions to be used
     * @param  array  $columns  The values to be used in the conditions
     * @return mixed array|null
     */
    public function select(string $table, array $columns = ['*'], ?string $where = null, array $params = [], bool $first = false): array|false
    {
        $columnList = implode(', ', $columns);

        $sql = "SELECT $columnList FROM $table";
        $sql .= ($where ? " WHERE $where" : '');

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Insert data into a table.
     *
     * @param  string  $table  The table name
     * @param  array  $data  The data to insert (associative array)
     */
    public function insert(string $table, array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($sql);

        return $stmt->execute(array_values($data));
    }
}

<?php

namespace Rpj\Login\Database;

interface IDatabase
{
    public function select(string $table, array $columns = ['*'], ?string $where = null, array $params = []): array|false;

    public function insert(string $table, array $data): bool;
}

<?php

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=localhost;dbname=project", "project_admin", "Password1!");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @param string $sql
     * @param DatabaseAction $mode
     * @param array $values = [":key1"=>"value1", ":key2"=>"value2", ...];
     * @return array|bool
     */
    public function queryDB(string $sql, DatabaseAction $mode, array $values = []): array|bool
    {
        $stmt = $this->pdo->prepare($sql);
        foreach ($values as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return match ($mode) {
            DatabaseAction::SELECTSINGLE => $stmt->fetch(PDO::FETCH_ASSOC),
            DatabaseAction::SELECTALL => $stmt->fetchAll(PDO::FETCH_ASSOC),
            DatabaseAction::EXECUTE => true,
            default => throw new InvalidArgumentException('Invalid Mode'),
        };
    }
}

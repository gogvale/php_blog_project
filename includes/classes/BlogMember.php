<?php
include_once "BlogReader.php";

class BlogMember extends BlogReader
{
    private string $username;

    /**
     * @param string $pUsername
     */
    public function __construct(string $pUsername)
    {
        parent::__construct();
        $this->username = $pUsername;
        $this->type = self::MEMBER;
    }

    /**
     * Checks if username already exists
     * @return bool
     */
    public function isDuplicateID(): bool
    {
        $sql = "SELECT COUNT(username) as num from members WHERE username = :username";
        $values = [':username' => $this->username];
        return $this->db->queryDB($sql, DatabaseAction::SELECTSINGLE, $values)['num'] != 0;
    }

    /**
     * Sign up method
     * @param string $pPassword
     * @return bool
     */
    public function insertIntoMemberDB(string $pPassword): bool
    {
        if ($this->isDuplicateID()) return false;

        $sql = "INSERT INTO members (username, password) VALUES (:username, :password)";
        $values = [
            ":username" => $this->username,
            ":password" => password_hash($pPassword, PASSWORD_DEFAULT)
        ];
        return $this->db->queryDB($sql, DatabaseAction::EXECUTE, $values);
    }

    /**
     * @param string $pPassword
     * @return bool
     */
    public function isValidLogin(string $pPassword): bool
    {
        $sql = "SELECT password FROM members WHERE username = :username";
        $values = [":username" => $this->username];
        $result = $this->db->queryDB($sql, DatabaseAction::SELECTSINGLE, $values);
        return isset($result['password']) && password_verify($pPassword, $result['password']);
    }

    private function getLatestPostID(): int
    {
        $sql = "SELECT max(id) AS max FROM posts";
        return $this->db->queryDB($sql, DatabaseAction::SELECTSINGLE)['max'] ?? 0;
    }

    /**
     * @return bool
     */
    public function updateLastViewedPost(): bool
    {
        $max = $this->getLatestPostID();
        $sql = "UPDATE members SET last_viewed = :max WHERE username = :username";
        $values = [
            ":username" => $this->username,
            ":max" => $max
        ];
        return $this->db->queryDB($sql, DatabaseAction::EXECUTE, $values);
    }

    /**
     * @return int|bool
     */
    public function getLastViewedPost(): int|bool
    {
        $sql = "SELECT last_viewed FROM members WHERE username = :username";
        $values = [':username' => $this->username];

        $result = $this->db->queryDB($sql, DatabaseAction::SELECTSINGLE, $values);
        return !$result ? $result : $result['last_viewed'];
    }
}

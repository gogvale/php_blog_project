<?php

class Admin
{
    private Database $db;
    private string $username;

    public function __construct(string $pUsername)
    {
        $this->username = $pUsername;
        $this->db = new Database();
    }

    /**
     * @param string $pPassword
     * @return bool
     */
    public function isValidLogin(string $pPassword): bool
    {
        $sql = "SELECT password FROM members WHERE username = :username AND is_admin = true";
        $values = [":username" => $this->username];
        $result = $this->db->queryDB($sql, DatabaseAction::SELECTSINGLE, $values);
        return isset($result['password']) && password_verify($pPassword, $result['password']);
    }

    /**
     * @param string $title
     * @param string $post
     * @param int $audience
     * @return bool
     */
    public function insertIntoPostDB(string $title, string $post, int $audience): bool
    {
        $sql = "INSERT INTO posts (username, title, post, audience) VALUES (:username, :title, :post, :audience)";
        $values = [
            ":username" => $this->username,
            ":title" => $title,
            ":post" => $post,
            ":audience" => $audience
        ];
        return $this->db->queryDB($sql, DatabaseAction::EXECUTE, $values);
    }
}
<?php

class BlogReader
{

    const READER = 1;
    const MEMBER = 2;

    protected Database $db;
    protected int $type;

    public function __construct()
    {

        $this->db = new Database();
        $this->type = BlogReader::READER;
    }

    /**
     * @return bool|array
     */
    public function getPostsFromDB(): bool|array
    {

        $sql = "SELECT id, unix_timestamp(post_date) as `post_date`, username, title, post, audience
                FROM posts
                WHERE audience <= :audience
                ORDER BY id DESC";
        $values = [':audience' => $this->type];
        $result = $this->db->queryDB($sql, DatabaseAction::SELECTALL, $values);
        return count($result) > 0 ? $result : false;
    }
}

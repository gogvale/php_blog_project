<?php

    class BlogMember extends BlogReader{
        
        private string $username;
        
        public function __construct($pUsername){
            parent::__construct();
            $this->username = $pUsername;
            $this->type = BlogMember::MEMBER;
        }
        
        public function isDuplicateID(): bool
        {
            
            $sql = "SELECT count(username) AS num FROM members WHERE username = :username";
            
            $values = array(
                array(':username', $this->username)
            );
        
            $result = $this->db->queryDB($sql, Database::SELECTSINGLE, $values);

            if ($result['num'] == 0)
                return false;
            else
                return true;                
            
        }
        
        public function insertIntoMemberDB($pPassword){
            
            $sql = "INSERT INTO members (username, password) VALUES (:username, :password)";
            
            $values = array(
                array(':username', $this->username),
                array(':password', password_hash($pPassword, PASSWORD_DEFAULT))
            );

            $this->db->queryDB($sql, Database::EXECUTE, $values);

        }
        
        public function isValidLogin($pPassword): bool
        {
            $sql = "SELECT password FROM members WHERE username = :username";
            
            $values = array(
                array(':username', $this->username)
            );

            $result = $this->db->queryDB($sql, Database::SELECTSINGLE, $values);
            
            if (isset($result['password']) && password_verify($pPassword, $result['password']))
                return true;
            else
                return false;

        }
        
        private function getLatestPostID(){
            $sql = "SELECT max(id) AS max FROM posts";
            
            $result = $this->db->queryDB($sql, Database::SELECTSINGLE);

            return $result['max'] ?? 0;

        }
        
        public function updateLastViewedPost(){
            $max = $this->getLatestPostID();
            
            $sql = "UPDATE members SET last_viewed = :max WHERE username = :username";
            
            $values = array(
                array(':max', $max),
                array(':username', $this->username)
            );

            $this->db->queryDB($sql, Database::EXECUTE, $values);
            
        }
        
        public function getLastViewedPost(){
            $sql = "SELECT last_viewed FROM members WHERE username = :username";

            $values = array(
                array(':username', $this->username)
            );

            $result = $this->db->queryDB($sql, Database::SELECTSINGLE, $values);

            return $result['last_viewed'] ?? 0;

        }
    }





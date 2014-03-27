<?php
namespace Model;

class User extends Base
{

    public function login($username, $password)
    {
        $query = "SELECT * FROM users WHERE username = ?";

        $stmt = $this->db->prepare($query);
        $stmt->execute(array($username));
        $rows = $stmt->fetchAll();

        $valid = false;
        if (count($rows) == 1) {
            if ($rows[0]["password"] == sha1($password)) {
                $valid = true;
            }
        }

        return $valid;
    }
}

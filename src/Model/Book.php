<?php
namespace Model;

class Book extends Base
{
    public function getAll()
    {
        $query = "SELECT * FROM books LIMIT 100;";

        $stmt = $this->db->prepare($query);
        $stmt->execute(array());
        $rows = $stmt->fetchAll();

        return $rows;
    }

    public function get($id)
    {
        $query = "SELECT * FROM books WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute(array($id));

        $row = $stmt->fetch();

        return $row;
    }

    public function add(array $book)
    {
        $this->db->beginTransaction();
        {
            $query = "INSERT INTO books (name, author, picture) VALUES (:name, :author, :picture)";
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute($book);

            $id = $this->db->lastInsertId();
        }
        $this->db->commit();

        return $id;
    }

    public function delete($id)
    {
        $query = "DELETE FROM books WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $result = $stmt->execute([$id]);

        return $result;
    }
}

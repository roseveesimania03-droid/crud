<?php
require 'db.php';

class Student {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function all() {
        return $this->db->query("SELECT * FROM students ORDER BY id DESC");
    }

    public function store($name, $course) {
        $stmt = $this->db->prepare("INSERT INTO students (fullname, course) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $course);
        return $stmt->execute();
    }

    public function update($id, $name, $course) {
        $stmt = $this->db->prepare("UPDATE students SET fullname=?, course=? WHERE id=?");
        $stmt->bind_param("ssi", $name, $course, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        return $this->db->query("DELETE FROM students WHERE id=$id");
    }
    
}
<?php
class Database {
    public function connect() {
        return new mysqli("localhost", "root", "", "student_oop_crud_db"); 
    }
}
?>
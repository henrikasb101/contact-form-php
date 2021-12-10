<?php

namespace app\models;

require_once 'app/Database.php';
use app\Database;

class Message {
    public $name;
    public $email;
    public $message;

    public function save() {
        $req = Database::get()->prepare('INSERT INTO Messages (name, email, message) VALUES (?, ?, ?)');
        return $req->execute([$this->name, $this->email, $this->message]);
    }
}

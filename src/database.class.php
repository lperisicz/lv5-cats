<?php
require 'models/cat.class.php';

class Database
{
    private $host = "ec2-174-129-227-128.compute-1.amazonaws.com";
    private $username = "qkegzynyaaqrdp";
    private $password = "1c379ba54fe9360b84cf53f3b192371aece306845bd811baac805c71bc4443d9";
    private $db = "darunuvqnkoa5f";
    public $connectionString;

    public function Connect() {
        $this->connectionString = new PDO("pgsql:host=$this->host;dbname=$this->db", $this->username, $this->password);
        $this->connectionString->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function RunMigrations() {
        $sqlList = [
            'CREATE TABLE IF NOT EXISTS cat_fighters (
            id serial PRIMARY KEY,
            img text,
            name text,
            age integer,
            catInfo text,
            wins integer,
            loss integer
         );'
        ];

        foreach ($sqlList as $sql) {
            $this->connectionString->exec($sql);
        }
    }
    public function insertCat($cat) {
        $query = "INSERT INTO cat_fighters (img, name, age, catInfo, wins, loss) Values(
            '$cat->img',
            '$cat->name',
            '$cat->age',
            '$cat->catInfo',
            '$cat->wins',
            '$cat->loss'
        )";
        $this->connectionString->query($query);
    }
    public function fetchCats() {
        $query = "SELECT * FROM cat_fighters";
        $result = $this->connectionString->query($query);
        $catsArray = [];
        while ($row = $result->fetch()) {
            array_push($catsArray, Cat::createCatWithId(
                $row['id'],
                $row['img'],
                $row['name'],
                $row['age'],
                $row['catinfo'],
                $row['wins'],
                $row['loss'],
            ));
        }
        return $catsArray;
    }

    public function fetchCat($catId) {
        $query = "SELECT * FROM cat_fighters WHERE id = $catId LIMIT 1";
        $result = $this->connectionString->query($query);
        while ($row = $result->fetch()) {
            return Cat::createCatWithId(
                $row['id'],
                $row['img'],
                $row['name'],
                $row['age'],
                $row['catinfo'],
                $row['wins'],
                $row['loss'],
            );
        }
    }
    public function Delete($id) {
        $query = "DELETE FROM cat_fighters WHERE id=" . $id;
        $this->connectionString->query($query);
    }
}

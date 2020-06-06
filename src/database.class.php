<?php

class Database
{
    /* Database Credentials */
    private $host = "ec2-174-129-227-128.compute-1.amazonaws.com";
    private $username = "qkegzynyaaqrdp";
    private $password = "1c379ba54fe9360b84cf53f3b192371aece306845bd811baac805c71bc4443d9";
    private $db = "darunuvqnkoa5f";
    public $connectionString;

    /* Connect Function */
    public function Connect()
    {
        /* Make Connection String */
        $this->connectionString = new PDO('pgsql:host=ec2-174-129-227-128.compute-1.amazonaws.com;dbname=darunuvqnkoa5f', 'qkegzynyaaqrdp', '1c379ba54fe9360b84cf53f3b192371aece306845bd811baac805c71bc4443d9');
        $this->connectionString->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        /* Check if the connection has an error, if yes then output the error, else output Connected. */
        /*if($this->connectionString->connect_error) {
            echo "Connection Error: " . $this->connectionString->connect_error;
        } else {
            echo "Connected!" . "<br>";
        }*/
    }
    /* Create Function */
    public function Create($query)
    {
        /* Execute Query, if it's completed, output that data is inserted else the error. */
        if ($this->connectionString->query($query) == TRUE) {
            echo "Data Inserted." . "<br>";
        } else {
            echo "Error: " . $query . "<br>" . $this->connectionString->error;
        }
    }
    /* Read Function */
    public function Read($query)
    {
        /* Execute $query */
        $result = $this->connectionString->query($query);

        while ($row = $result->fetch()) {
            echo $row['img'] . "<br />\n";
        }
    }
    /* Update Function */
    public function Update($query)
    {
        /* Execute query, if it's completed, ouput that data is updated else the error. */
        if ($this->connectionString->query($query) == TRUE) {
            echo "Data Updated." . "<br>";
        } else {
            echo "Error updating" . $this->connectionString->error . "<br>";
        }
    }
    /* Delete Function */
    public function Delete($id)
    {
        /* Delete Query */
        $query = "DELETE FROM feedback WHERE id=" . $id;
        /* Execute query, if it's completed, output that record is deleted else the error. */
        if ($this->connectionString->query($query) == TRUE) {
            echo "Record Deleted" . "<br>";
        } else {
            echo "Error Deleting" . $this->connectionString->error;
        }
    }
    /* Close Function */
    public function CloseConnection()
    {
        /* Close the mysqli connection */
        mysqli_close($this->connectionString);
    }
    public function RunMigrations()
    {
        $sqlList = [
            'CREATE TABLE IF NOT EXISTS cats_lu (
            id serial PRIMARY KEY,
            img text
         );'
        ];

        // execute each sql statement to create new tables
        foreach ($sqlList as $sql) {
            $this->connectionString->exec($sql);
        }
    }

    public function insertImage($image) {
        $query = "INSERT INTO cats_lu (img) Values('$image')";
        $this->Create($query);
    }

    public function testInsertImage($file_name)
    {

        $query = "INSERT INTO cats_l(id, img, file_size) Values(4, '$file_name'," . filesize($file_name) . ")";
        $this->Create($query);
    }

    public function testGetImage()
    {
        $query = "SELECT * FROM cats_lu";

        $result = $this->connectionString->query($query);

        while ($row = $result->fetch()) {
           /* ob_start();
            fpassthru($row['img']);
            $dat = ob_get_contents();
            ob_end_clean();
            $dat = "data:image/*;base64," . base64_encode($dat);*/
            echo "<img src='" . $row['img'] . "'/>";
        }
    }
}

<?php

class DB{
    protected $connection;

    public function __construct($host, $user, $password, $db_name){
        $this->connection = new mysqli($host, $user, $password, $db_name);

        $this->query('SET NAMES UTF8');

        if( mysqli_connect_error() ){
            throw new Exception('Could not connect to DB');
        }
    }

    public function query($sql){
        if ( !$this->connection ){
            return false;
        }

        $result = $this->connection->query($sql);

        if ( mysqli_error($this->connection) ){
            throw new Exception(mysqli_error($this->connection));
        }

        if ( is_bool($result) ){
            return $result;
        }

        $data = array();
        while( $row = mysqli_fetch_assoc($result) ){
            $data[] = $row;
        }
        return $data;
    }

    public function escape($str){
        return mysqli_escape_string($this->connection, $str);
    }
}

class Project {
    public $db;

    public function __construct()
    {
        $this -> db = new DB('localhost', 'root', '', 'propost');
    }

    public function nameProject ($name)
    {
        $nameProj = $this -> db -> query("SELECT * FROM projects WHERE id = {$name}");
        echo "<h2>{$nameProj[0]['project']}</h2>";
    }

    public function showProject ()
    {
        $projects = $this -> db -> query("SELECT * FROM projects WHERE 1");
        echo "<ol class='projects'>";
        foreach ($projects as $project) {
            echo "<li><a href='project.php?project={$project['id']}'>{$project['project']}</a></li>";
        }
        echo "</ol>";
    }

    public function createProject ($value)
    {
       return $createPro = $this -> db -> query("INSERT INTO projects (project) VALUES ('{$value}')");
    }

    public function deleteProject ($value)
    {
        return $deletePro =  $this -> db -> query("DELETE FROM projects WHERE id = {$value}");
    }
}
$project = new Project;

class Photo {
    public $db;

    public function __construct()
    {
        $this -> db = new DB('localhost', 'root', '', 'propost');
    }

    public function showPhoto ($value)
    {
        $photos = $this -> db -> query("SELECT * FROM photos WHERE project_id = {$value}");
        foreach ($photos as $photo) {
            echo "<img src='img/{$photo['photo']}' width='300px' alt=''>
                <form action='' method='post'><input type='hidden' name='deletePhoto' value='{$photo['id']}'>
                    <input type='submit' name='deletePho' value='Удалить Фото'></form>";
        }
    }

    public function addPhoto ($name, $id, $tmp)
    {
        $validate = $this -> db -> query("SELECT * FROM photos WHERE photo = '{$name}'");
        if (!empty($validate)) {
            echo "<p>Такое имя уже существует</p>";
        } else {
            $filePut = 'img';
            move_uploaded_file ($tmp, $filePut.'/'.$name);
            return $this->db->query("INSERT INTO photos (photo, project_id) VALUES ('{$name}', '{$id}')");
        }
    }

    public function deletePhoto ($value)
    {
        return $deletePhoto =  $this -> db -> query("DELETE FROM photos WHERE id = {$value}");
    }
}
$photo = new Photo;

?>
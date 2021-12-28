<?php
    ini_set("display_errors", 1);

    // Class for connecting to database
    class DB {
        public $host;
        public $user;
        public $password;
        public $db_name;

        function __construct($host, $user, $password, $db_name) {
            $this->host = $host;
            $this->user = $user;
            $this->password = $password;
            $this->db_name = $db_name;
        }

        function queryExec($query){
            $link = mysqli_connect($this->host, $this->user, $this->password, $this->db_name);
            if (!$link) {
                die("Connection failed: " . mysqli_connect_error());
            }
            mysqli_set_charset($link, "utf8");
            $result = mysqli_query($link, $query);
            return $result;
        }
    }

    //Instance of class
    // $link = new DB("localhost:3306", "root", "", "hw_project");
    $link = new DB("mysql-tim1.alwaysdata.net", "tim1", "tim1ikidefe", "tim1_homework_project");

?>
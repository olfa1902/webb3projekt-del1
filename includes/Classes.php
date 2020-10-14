<?php

// A Class instance named Studies is created
class Studies
{
    private $db;

    // Constructor connecting to the database is created
    function __construct()
    {

        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Error with connection: " . $this->db->connect_error);
        } 
    }

    // a function named getStudies is created which gathers all rows and exports it as an array from table studier in database olfa1902
    public function getStudies()
    {
        // SQL-question
        $sql = "SELECT * FROM studier";
        $result = $this->db->query($sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // a function named getStudy which gathers the row matching the id from table studier in database olfa1902 and exports it as an array
    public function getStudy(int $id) {
        $sql = "SELECT * FROM studier WHERE id= '$id'";
        $result = $this->db->query($sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // a function named addStudy which takes strings for each category in the table and inserts these into the table
    public function addStudy(string $utbildningsplats, string $utbildningsnamn, string $startdatum, string $slutdatum){
        $sql = "INSERT INTO studier(utbildningsplats, utbildningsnamn, startdatum, slutdatum) VALUES('$utbildningsplats','$utbildningsnamn', '$startdatum', '$slutdatum')";
        return $this->db->query($sql);
    }

    // a function named deleteCourse is tasked with deleting the course with the matching id 
    public function deleteStudy(int $id) {
        $sql = "DELETE FROM studier WHERE id= '$id'";
        return $this->db->query($sql);
    }

    // updateStudy is created which takes strings for each category and replaces this information with the study containing the matching id
    public function updateStudy(string $utbildningsplats, string $utbildningsnamn, string $startdatum, string $slutdatum, int $id){
        $sql = "UPDATE studier SET utbildningsplats = '" . $utbildningsplats ."' ,utbildningsnamn = '" . $utbildningsnamn . "',startdatum =  '" . $startdatum . "',slutdatum =  '" . $slutdatum . "' WHERE id= '$id'";
        return $this->db->query($sql);
    }
}

// Class named Experiences is created
class Experiences
{
    private $db;

    // Constructor connecting to the database is created
    function __construct()
    {

        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Error with connection: " . $this->db->connect_error);
        } 
    }

    // a function named getExperiences is created
    public function getExperiences()
    {
        // SQL-question
        $sql = "SELECT * FROM arbetslivserfarenhet";
        $result = $this->db->query($sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // a function named getExperience is created
    public function getExperience(int $id) {
        $sql = "SELECT * FROM arbetslivserfarenhet WHERE id= '$id'";
        $result = $this->db->query($sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // a function named addExperience is created
    public function addExperience(string $arbetsplats, string $titel, string $startdatum, string $slutdatum){
        $sql = "INSERT INTO arbetslivserfarenhet(arbetsplats, titel, startdatum, slutdatum) VALUES('$arbetsplats','$titel', '$startdatum', '$slutdatum')";
        return $this->db->query($sql);
    }

    // a function named deleteExperience is created
    public function deleteExperience(int $id) {
        $sql = "DELETE FROM arbetslivserfarenhet WHERE id= '$id'";
        return $this->db->query($sql);
    }

    // a function named updateExperience is created
    public function updateExperience(string $arbetsplats, string $titel, string $startdatum, string $slutdatum, int $id){
        $sql = "UPDATE arbetslivserfarenhet SET arbetsplats = '" . $arbetsplats ."' ,titel = '" . $titel . "',startdatum =  '" . $startdatum . "',slutdatum =  '" . $slutdatum . "' WHERE id= '$id'";
        return $this->db->query($sql);
    }
}

// A class called Webpages is created with the same CRUD functionality as Experiences and Studies 

class Webpages
{
    private $db;

    function __construct()
    {

        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if ($this->db->connect_errno > 0) {
            die("Error with connection: " . $this->db->connect_error);
        } 
    }

    public function getWebpages()
    {
        $sql = "SELECT * FROM webbplatser";
        $result = $this->db->query($sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }


    public function getWebpage(int $id) {
        $sql = "SELECT * FROM webbplatser WHERE id= '$id'";
        $result = $this->db->query($sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function addWebpage(string $titel, string $url, string $beskrivning){
        $sql = "INSERT INTO webbplatser(titel, url, beskrivning) VALUES('$titel', '$url', '$beskrivning')";
        return $this->db->query($sql);
    }

    public function deleteWebpage(int $id) {
        $sql = "DELETE FROM webbplatser WHERE id= '$id'";
        return $this->db->query($sql);
    }

    public function updateWebpage(string $titel, string $url, string $beskrivning, int $id){
        $sql = "UPDATE webbplatser SET titel = '" . $titel . "',url =  '" . $url . "',beskrivning =  '" . $beskrivning . "' WHERE id= '$id'";
        return $this->db->query($sql);
    }
}
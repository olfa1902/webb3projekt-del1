<?php
// Including external files from includes folder
require 'includes/config.php';
require 'includes/Classes.php';

// Headers to allow for requests to the web service from studenter.miun domain
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://studenter.miun.se/~olfa1902');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$method = $_SERVER['REQUEST_METHOD'];

// If id is set and available from the URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}

// Code to start connection with database
$db = mysqli_connect(DBHOST,DBUSER,DBPASS,DBDATABASE) or die('Something went wrong with the connection to the database...');
$experiences = new Experiences($db);


// Creates instance of class to send sql-questions to database
// Sends databaseconnection as a parameter

switch($method){
    case 'GET':
        if(isset($id)) {
            $result = $experiences->getExperience($id);
            // Run function to read row with specific id
        } else{
            // Run function to read all data from database
            $result = $experiences->getExperiences();
        }

        // Controlling if result contains any rows
        if(count($result) > 0) {
            http_response_code(200); //Ok
        } else{
            http_response_code(404); //Not found
            $result = array("message" => "No Experience found");
        }
    break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        //Removes tags and creates special characters to store and send to the class properties
        $experiences->arbetsplats = $data->arbetsplats;
        $experiences->titel = $data->titel;
        $experiences->startdatum = $data->startdatum;
        $experiences->slutdatum = $data->slutdatum;

        //Run function to create row
        if($experiences->addExperience($data->arbetsplats,$data->titel,$data->startdatum,$data->slutdatum)) {
            http_response_code(201); // Created
            $result = array("message" => "Experience created");
        } else{
            http_response_code(503); // Server error
            $result = array("message" => "Experience not created");
        }
    break;
    case 'PUT':
        // If no id is included, send an error
        if(!isset($id)) {
            http_response_code(510);
            $result = array("message" => "No id is sent");
        // If id is sent
        } else{
            $data = json_decode(file_get_contents("php://input"));

        //Removes tags and creates special characters to store and send to the class properties
        $experiences->arbetsplats = $data->arbetsplats;
        $experiences->titel = $data->titel;
        $experiences->startdatum = $data->startdatum;
        $experiences->slutdatum = $data->slutdatum;

        //Run function to update row
        if($experiences->updateExperience($data->arbetsplats,$data->titel,$data->startdatum,$data->slutdatum, $id)) {
            http_response_code(200); // OK
            $result = array("message" => "Experience updated");
        } else{
            http_response_code(503); // Server error
            $result = array("message" => "Experience not updated");
        }

    }
    break;
    case 'DELETE':
        // If no id is included, send an error
        if(!isset($id)) {
            http_response_code(510);
            $result = array("message" => "No id is sent");
        // If id is sent
    } else{
        //Run function to update row
        if($experiences->deleteExperience($id)) {
            http_response_code(200); // OK
            $result = array("message" => "Experience deleted");
        } else{
            http_response_code(503); // Server error
            $result = array("message" => "Experience not deleted");
        }
    }
    break;
}

// Return result as JSON
echo json_encode($result);

// Close database connection
$db->close();
?>
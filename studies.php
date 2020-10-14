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
$studies = new Studies($db);


// Creates instance of class to send sql-questions to database
// Sends databaseconnection as a parameter

switch($method){
    case 'GET':
        if(isset($id)) {
            $result = $studies->getStudy($id);
            // Run function to read row with specific id
        } else{
            // Run function to read all data from database
            $result = $studies->getStudies();
        }

        // Controlling if result contains any rows
        if(count($result) > 0) {
            http_response_code(200); //Ok
        } else{
            http_response_code(404); //Not found
            $result = array("message" => "No study found");
        }
    break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        //Removes tags and creates special characters to store and send to the class properties
        $studies->utbildningsplats = $data->utbildningsplats;
        $studies->utbildningsnamn = $data->utbildningsnamn;
        $studies->startdatum = $data->startdatum;
        $studies->slutdatum = $data->slutdatum;

        //Run function to create row
        if($studies->addStudy($data->utbildningsplats,$data->utbildningsnamn,$data->startdatum,$data->slutdatum)) {
            http_response_code(201); // Created
            $result = array("message" => "Study created");
        } else{
            http_response_code(503); // Server error
            $result = array("message" => "Study not created");
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
        $studies->utbildningsplats = $data->utbildningsplats;
        $studies->utbildningsnamn = $data->utbildningsnamn;
        $studies->startdatum = $data->startdatum;
        $studies->slutdatum = $data->slutdatum;

        //Run function to update row
        if($studies->updateStudy($data->utbildningsplats,$data->utbildningsnamn,$data->startdatum,$data->slutdatum, $id)) {
            http_response_code(200); // OK
            $result = array("message" => "Study updated");
        } else{
            http_response_code(503); // Server error
            $result = array("message" => "Study not updated");
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
        if($studies->deleteStudy($id)) {
            http_response_code(200); // OK
            $result = array("message" => "Study deleted");
        } else{
            http_response_code(503); // Server error
            $result = array("message" => "Study not deleted");
        }
    }
    break;
}

// Return result as JSON
echo json_encode($result);

// Close database connection
$db->close();
?>
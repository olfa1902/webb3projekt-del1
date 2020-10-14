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
$webpages = new Webpages($db);


// Creates instance of class to send sql-questions to database
// Sends databaseconnection as a parameter

switch($method){
    case 'GET':
        if(isset($id)) {
            $result = $webpages->getWebpage($id);
            // Run function to read row with specific id
        } else{
            // Run function to read all data from database
            $result = $webpages->getWebpages();
        }

        // Controlling if result contains any rows
        if(count($result) > 0) {
            http_response_code(200); //Ok
        } else{
            http_response_code(404); //Not found
            $result = array("message" => "No Webpage found");
        }
    break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        //Removes tags and creates special characters to store and send to the class properties
        $webpages->titel = $data->titel;
        $webpages->url = $data->url;
        $webpages->beskrivning = $data->beskrivning;

        //Run function to create row
        if($webpages->addWebpage($data->titel,$data->url,$data->beskrivning)) {
            http_response_code(201); // Created
            $result = array("message" => "Webpage created");
        } else{
            http_response_code(503); // Server error
            $result = array("message" => "Webpage not created");
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
        $webpages->titel = $data->titel;
        $webpages->url = $data->url;
        $webpages->beskrivning = $data->beskrivning;

        //Run function to update row
        if($webpages->updateWebpage($data->titel,$data->url,$data->beskrivning, $id)) {
            http_response_code(200); // OK
            $result = array("message" => "Webpage updated");
        } else{
            http_response_code(503); // Server error
            $result = array("message" => "Webpage not updated");
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
        if($webpages->deleteWebpage($id)) {
            http_response_code(200); // OK
            $result = array("message" => "Webpage deleted");
        } else{
            http_response_code(503); // Server error
            $result = array("message" => "Webpage not deleted");
        }
    }
    break;
}

// Return result as JSON
echo json_encode($result);

// Close database connection
$db->close();
?>
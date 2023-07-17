<?php

//*******************************************

function displays_errors()
// display error messages for troubleshooting
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

}

//*******************************************

function pdo_connect_mysql() {
    // Update the details below with your MySQL details
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = 'root';
    // $DATABASE_NAME = '2023_projects';
    $DATABASE_NAME = 'maplesyrupweb';

    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	die ('Failed to connect to database!');
    }
}

/**
 * Convert the datetime from database and output date
 */

function formatDate($input) {

    $timestamp = strtotime($input);
    $new_date_format = date('Y-m-d', $timestamp);
    echo $new_date_format;
    
}



// function numberOfRows() {
//     $pdo = pdo_connect_mysql();
//     $stmt = $pdo->prepare('SELECT count* FROM polls');
//     $numOfRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     echo implode(" ", $numOfRows);
// }

function template_header($title, $icon)
// load fontawesome, bootstrap, jquery and nav bar for each page
{


echo <<<EOT

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link href="style.css" rel="stylesheet" type="text/css">


    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <script src="js/script.js"></script>
    <script src="js/apikey.js"></script>

  </head>
  <title>$title</title>
  <body>

  <nav class="navbar bg-body-tertiary fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
        <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
      </svg>     Poll App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Poll app menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
        
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.html"><i class="bi bi-house-door menu-icon"></i><span class="nav-item-text">Home</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="create.php"><i class="bi bi-pencil-square"></i><span class="nav-item-text">Add new poll</span></a></a>
                </li>     
            </ul>
            <hr><p class="infoBar">
            <span class="data" id="weatherTemp"></span><span> F</span>
            <span class="data" id="weatherIcon">Icon</span>
            <span class="data" id="countryEmoji">Country</span>
            <span class="data" id="localTime">Time</span>
        </p>
            
        </div>
        </div>
    </div>
    </nav>

    <div class="d-flex align-items-center" style="min-height: 100vh">
      <div class="box w-100">
      <div class="col text-center">

      
EOT;
}
//*******************************************


    
    
    // Template footer
function template_footer() {
    echo <<<EOT
        </body>
    </html>
    EOT;
    }




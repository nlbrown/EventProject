<?php
session_start();
?>

<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1" /> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WDV101 Intro HTML and CSS Form Processing</title>
    <style>
         body{
            background-color: lightgray;
            text-align: center;
        }
        #col{
            display: none;
            opacity: 0;
        }
        nav li{
            background-color: azure;
            display: inline-flex;
            cursor: pointer;
            margin-right: 25px;
            padding: 10px 18px; 
            border: 1px solid #204156;
            position: relative; 
        }
        #title{
            background-color: azure;
            padding: 5px 8px; 
            border: 1px solid #204156;
            display: inline-block;
        }
    </style>
</head>

<body>
<h1>WDV341 Intro PHP</h1>
<div id="title">
<h2> Event Home Page </h2>
    </div>
<nav>
				<ul>
                    <a href="eventHome.php"><li><b>Home</b></li></a>
                    <a href="eventDisplay.php"><li><b>View Events</b></li></a>
                    <a href="eventPresenters.php"><li><b>View Presenters</b></li></a>
                    <a href="eventContact.php"><li><b>Contact Us</b></li></a>
                <?php
                     if(isset($_SESSION['validUser'])){
                         if($_SESSION['validUser'] == 'yes'){
                    ?>
                    <a href="eventAddForm.php"><li><b>Add New Event</b></li></a>
                    <a href="eventselect.php"><li><b>Update/Delete Event</b></li></a>
                    <a href="logout.php"><li><b>LOG OFF</b></li></a>
                    <?php
                    }
                     }
                    ?>
                    <a href="login.php"><li><b>SIGN IN</b></li></a>
                   
				</ul>          
    </nav> 
    
    <h1> Welcome to Event Content Manager Home Page</h1>
    
    <img src="Content-Management-System.jpg" width="350" height="200" title="Logo of a company" alt="Logo of a company" />
    
    </body>
</html>
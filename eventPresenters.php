<?php
session_start();
$eventName = "";
 $eventDesc ="";
 $eventPresenter = "";
 $eventDate ="";
 $eventTime ="";
 $nameMsg = "";
 $presenterMsg = "";
 $nameMsg = "";
 $descMsg = "";
 $dateMsg = "";
 $timeMsg = "";
 $userMsg ="";
 $errMsg ="";
 $idx = 0;  
 
 try{
            
     //require "../dbconnect.php";
     require '../dbconnectserver.php';	 //host server
           
        $sql = "SELECT event_name, event_presenter FROM wdv341_events";
                       
       	//PREPARE the SQL statement
	   $stmt = $conn->prepare($sql);
        //Bind Parameters
      
	  //EXECUTE the prepared statement
	  $stmt->execute();	
   
	  //Prepared statement result will deliver an associative array
	  $stmt->setFetchMode(PDO::FETCH_ASSOC);
     
        } 
  
  catch(PDOException $e){
	  $userMsg = "There has been a problem. The system administrator has been contacted. Please try again later.";
      echo "SQL Failed";
      //$errMsg = $e;
	  error_log($e->getMessage());			//Delivers a developer defined error message to the PHP log file at c:\xampp/php\logs\php_error_log
      
	  error_log($e->getLine());
	  error_log(var_dump(debug_backtrace()));  	
    } //catch

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
        #event{
            border: 3px solid #555;
            text-align: left;
            margin-bottom: 2%;
            margin-right: 2%;
            display: inline-table;
            background-color: whitesmoke;
            padding: 10px 18px; 
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
            padding: 10px 18px; 
            border: 1px solid #204156;
            display: inline-block;
        }
    </style>
</head>

<body>
<h1>WDV341 Intro PHP</h1>
<div id="title">
<h2>All Current Event Presenters</h2>
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

     <?php 
        $row=$stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($row as $rows )  
        {  	     
         ?>
    <span id="event">
    <span>Event Name: <strong> <?php echo $row[$idx]['event_name']; ?></strong></span><br>
    <span>Event Presenter:<strong> <?php echo $row[$idx]['event_presenter']; ?></strong></span><br>
    </span>
        <?php
          $idx++;
        }  
       ?>
     <br>
     <img src="Content-Management-System.jpg" width="350" height="200" title="Logo of a company" alt="Logo of a company" />
</body>

</html>
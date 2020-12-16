<?php
session_start();
$eventId = intval($_POST['event_id']);
if(isset($_POST['No'])){
    header('Location: eventHome.php', true, 301);
}
if (isset($_POST['delete']) && ($_SESSION['validUser'] == "yes")) {
   $validId = true;
    $eventId = intval($_POST['event_id']);
    If(!is_numeric($eventId)){
        $validId = false;
    }
     if ($validId){  
         
     try{
        
     //require "../dbconnect.php";
     require '../dbconnectserver.php';	 //host server
        
     $sql = "DELETE FROM wdv341_events WHERE event_id = :id ";

      //PREPARE the SQL statement
	   $stmt = $conn->prepare($sql);
        //Bind Parameters
        $stmt->bindParam(':id',$eventId);
    
	  //EXECUTE the prepared statement
	  $stmt->execute();	
   
	  //Prepared statement result will deliver an associative array
	  $stmt->setFetchMode(PDO::FETCH_ASSOC);
     
        } //try
  
  catch(PDOException $e){
	  $userMsg = "There has been a problem. The system administrator has been contacted. Please try again later.";
      echo "SQL Failed";
      //$errMsg = $e;
	  error_log($e->getMessage());			//Delivers a developer defined error message to the PHP log file at c:\xampp/php\logs\php_error_log
	  error_log($e->getLine());
	  error_log(var_dump(debug_backtrace()));  	
    } //catch
    } //is valid
 

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
     <h2>Event Delete </h2>
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
    
    <h1>  Event Sucessully Deleted </h1>
    </body>
</html>
<?php
     } //submit
    else{
  ?>
<!doctype html>
<html>
<head>
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
    <head>
        <style>
            #col{
            display: none;
            opacity: 0;
        }
        </style>
    </head>
    <div id="title">
     <h2>Event Delete </h2>
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
    <form id="form1" name="form1" method="POST" action="eventDelete.php"> 
        <h1> Are you sure you want to delete this event </h1>
        <input type="text" id="col" name="event_id" size="5"  value="<?php echo $eventId;?>"/>
    <input type="submit" name="delete" id="button3" value="Yes" />
    <input type="submit" name="No" id="button3" value="No" />
    </form>
    </body>
</html>
      
 <?php             
    }
 ?>
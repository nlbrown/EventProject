<?php
session_start();
if (isset($_POST['submit']) && ($_SESSION['validUser'] == "yes")) {
    $eventId = "";
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
     $updatedone = true;
    $selectedEvent = $_POST['eventselected'];
    
    try{    
       //require "../dbconnect.php";	
       require '../dbconnectserver.php';	 //host server
           
        $sql = "SELECT  event_id, event_name, event_desc, event_presenter, event_date, event_time FROM wdv341_events WHERE event_name = '$selectedEvent' ";
                       
       	//PREPARE the SQL statement
	   $stmt = $conn->prepare($sql);
        //Bind Parameters
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
  } //submit

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
        #col,#eid{
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
        #button{
            width: 70px;
        }
        #button3{
            width: 100px;
            height: 50px;
            background-color: orangered;
        }
    </style>
</head>

<body>
</head>
<h1>WDV341 Intro PHP</h1>
<div id="title"> 
<h2>Event Update / Delete </h2>
    </div>
    
    <nav>
				<ul>
                    <a href=""><li><b>Home</b></li></a>
                    <a href="eventDisplay.php"><li><b>View Events</b></li></a>
                    <a href="eventPresenters.php"><li><b>View Presenters</b></li></a>
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
 
<form id="form1" name="form1" method="POST" action="eventUpdateSql.php">
    <?php 
       global $row, $stmt;
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $eventId = $row['event_id'];
        $eventName = $row['event_name'];
        $eventDesc = $row['event_desc'];
        $eventPresenter = $row['event_presenter'];
        $eventDate = $row['event_date'];
        $eventTime = $row['event_time'];
     ?>
  <p>Event Name: 
    <input type="text" name="event_name" id="textfield" value="<?php echo $eventName ;?>" />
    <span style="color:red;"><?php echo $nameMsg;?></span>
</p>
  <p>Event Description: 
    <input type="text" name="event_desc" id="textfield2" value="<?php echo $eventDesc;?>" />
    <span style="color:red;"><?php echo $descMsg;?></span>
  </p>
    <input type="text" id="col" name="event_col" size="25"  value=""/>
    <input type="text" id="eid" name="event_id" size="5"  value="<?php echo $eventId;?>"/>
  <p>Event Presenter: 
    <input type="text" name="event_presenter" id="textfield3" value="<?php echo $eventPresenter;?>"/>
    <span style="color:red;"><?php echo $presenterMsg;?></span>
  </p>
 <p>Event Date: 
    <input type="date" name="event_date" id="datefield" value="<?php echo $eventDate;?>" />
    <span style="color:red;"><?php echo $dateMsg;?></span>
  </p> 
  <p>Event Time: 
    <input type="time" name="event_time" id="timefield" value="<?php echo $eventTime;?>" />
    <span style="color:red;"><?php echo $timeMsg;?></span>
  </p>
   
    <input type="submit" name="update" id="button" value="update" />
    <input type="reset" name="button2" id="button2" value="Reset" />
  </p>
</form>
<form id="form2" name="form2" method="POST" action="eventDelete.php">
        <input type="text" id="eid" name="event_id" size="5"  value="<?php echo $eventId;?>"/>
    <input type="submit" name="confirm" id="button3" value="delete" />
</form>
<span><?php echo $userMsg;?></span>
<p>&nbsp;</p>
</body>

</html>
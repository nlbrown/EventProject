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

 if (isset($_POST['submit']) && ($_SESSION['validUser'] == "yes")) {
     
    $eventName = $_POST['event_name'];
    $eventDesc = $_POST['event_desc'];
    $eventPresenter = $_POST['event_presenter']; 
    $eventDate  = $_POST['event_date']; 
    $eventTime  = $_POST['event_time'];
    
     
    $eventName = htmlentities($eventName);
    $eventName = strip_tags($eventName);
    $eventName = stripslashes($eventName);
     
    $eventDesc = htmlentities($eventDesc);
    $eventDesc = strip_tags($eventDesc);
    $eventDesc = stripslashes($eventDesc);
     
    $eventPresenter = htmlentities($eventPresenter);
    $eventPresenter = strip_tags($eventPresenter);
    $eventPresenter = stripslashes($eventPresenter);
     
    $eventDate = htmlentities($eventDate);
    $eventDate = strip_tags($eventDate);
    $eventDate = stripslashes($eventDate);
     
    $eventTime = htmlentities($eventTime);
    $eventTime = strip_tags($eventTime);
    $eventTime = stripslashes($eventTime);
      
   /* echo $eventName."<br>";
    echo $eventDesc."<br>";
     echo $eventPresenter."<br>";
     echo $eventDate."<br>";
     echo $eventTime."<br>";
     */
    $validForm = true;
    
     If ($eventName == ""){
         $validForm = false;
         $nameMsg = "Name is empty";
     }
     If ($eventDesc == ""){
         $validForm = false;
         $DescMsg = "Description is empty";
     }
     
    If ($eventPresenter == ""){
         $validForm = false;
         $presenterMsg = "Presenter is empty";
     }
     If ($eventDate == ""){
         $validForm = false;
         $dateMsg = "Date is empty";
     }
     If ($eventTime == ""){
         $validForm = false;
         $timeMsg = "Time is empty";
     }
    
    if ($validForm){
        
       try{
            
       //require "../dbconnect.php";	
       require '../dbconnectserver.php';	 //host server
           
        $eventDate=date("Y-m-d",strtotime($eventDate));
        $sql = "INSERT INTO wdv341_events (event_name, event_desc, event_presenter,
                            event_date, event_time)
                     values (:event,:desc,:presenter,
                            :date,:time)"; 
       	  //PREPARE the SQL statement
	   $stmt = $conn->prepare($sql);
       $stmt->bindParam(':event',$eventName);
       $stmt->bindParam(':desc',$eventDesc);
       $stmt->bindParam(':presenter',$eventPresenter);
       $stmt->bindParam(':date',$eventDate);
       $stmt->bindParam(':time',$eventTime);
        
     
	  //EXECUTE the prepared statement
	  $stmt->execute();	
   
	  //Prepared statement result will deliver an associative array
	  //$stmt->setFetchMode(PDO::FETCH_ASSOC);
     
  }
  
  catch(PDOException $e){
	  $userMsg = "There has been a problem. The system administrator has been contacted. Please try again later.";
      echo "SQL Failed";
      //$errMsg = $e;
	  error_log($e->getMessage());			//Delivers a developer defined error message to the PHP log file at c:\xampp/php\logs\php_error_log
      
	  error_log($e->getLine());
	  error_log(var_dump(debug_backtrace()));  	
  }
      $userMsg = "<h3>"."Event Sucessfully inserted"."</h3>";}
        
    } else{
        
      //if button was not submit 
        
    }
 

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
<h2>Event Input Form</h2>
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

<form id="form1" name="form1" method="POST" action="eventAddForm.php">
  <p>Event Name: 
    <input type="text" name="event_name" id="textfield" value="<?php echo $eventName;?>" />
    <span style="color:red;"><?php echo $nameMsg;?></span>
</p>
  <p>Event Description: 
    <input type="text" name="event_desc" id="textfield2" value="<?php echo $eventDesc;?>" />
    <span style="color:red;"><?php echo $descMsg;?></span>
  </p>
    <input type="text" id="col" name="event_col" size="25"  value=""/>
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
   <input type="text" id="col" name="event_place" value="";/>
    <input type="submit" name="submit" id="button" value="Submit" />
    <input type="reset" name="button2" id="button2" value="Reset" />
  </p>
</form>

<span><?php echo $userMsg;?></span>
<p>&nbsp;</p>
</body>

</html>

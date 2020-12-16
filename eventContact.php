<?php
session_start();
$firstName = "";
$lastName = "";
$email = "";
$subject = "";
$comments = "";
$fNameMsg = "";
$lNameMsg = "";
$emailMsg = "";
$subjectMsg = "";
$commentMsg = "";
$userMsg = "";
$error_message = "";
$idx = 0;
 try{
            
     //require "../dbconnect.php";	
     require '../dbconnectserver.php';	 //host server
           
        $sql = "SELECT DISTINCT event_name FROM wdv341_events";
                       
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

if(isset($_POST['submit']) && (empty($_POST['event_col']))) {
 
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "nlbrownii@nlbrownii.org";
    $email_subject = "Request from Event website!!";
 
    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
 
 
    // validation expected data exists
    if(!isset($_POST['first_name']) ||
        !isset($_POST['last_name']) ||
        !isset($_POST['email']) ||
   //     !isset($_POST['subject']) ||
        !isset($_POST['eventselected']) ||
        !isset($_POST['comments'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
 
     
 
    $first_name = $_POST['first_name']; // required
    $last_name = $_POST['last_name']; // required
    $email_from = $_POST['email']; // required
  //  $subject = $_POST['subject']; // required
    $subject = $_POST['eventselected'];
    $comments = $_POST['comments']; // required
 
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
    $emailMsg .= 'The Email Address you entered does not appear to be valid.<br />';
    $error_message = "Process failed";
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$first_name)) {
   $fNameMsg .= 'The First Name you entered does not appear to be valid.<br />';
    $error_message = "Process failed";
  }
 
  if(!preg_match($string_exp,$last_name)) {
    $lNameMsg .= 'The Last Name you entered does not appear to be valid.<br />';
    $error_message = "Process failed";
  }
    
  if(strlen($subject) < 6) {
    $subjectMsg .= ' Please select subject.<br />';
    $error_message = "Process failed";
  }
 
  if(strlen($comments) < 2) {
    $commentMsg .= 'The Comments you entered do not appear to be valid.<br />';
    $error_message = "Process failed";
  }
 
  if(strlen($error_message) > 0) {
    died($error_message);
  }
    $idx = 0;  
 


 
    $email_message = "Form details below.\n\n";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
     
 
    $email_message .= "First Name: ".clean_string($first_name)."\n";
    $email_message .= "Last Name: ".clean_string($last_name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Subject: ".clean_string($subject)."\n";
    $email_message .= "Comments: ".clean_string($comments)."\n";
 
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers); 
 $userMsg = "<h2>"."Email Sent"."</h2>";
?>
 
<!-- include your own success html here -->
<img class="page-title" src="Content-Management-System.jpg" width="200" height="100">
<h1>Thank you for contacting us about the Event. </h1>
<h2> We will be in touch with you very soon.</h2><br>
 
<?php
 
}
?>
<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1" /> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WDV341 Intro PHP Form Processing</title>
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
        #area1, #area2{
           width: 320px;
           text-align: left;
           margin: 0 auto;
        }
    </style>
</head>

<body>
<h1>WDV341 Intro PHP</h1>
<div id="title">
<h2>Event Contact Form</h2>
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

<form id="form1" name="form1" method="POST" action="eventContact.php">
 <div id="area1">
    <p>First Name:
    <input type="text" name="first_name" value="<?php echo $firstName;?>" />
    <span style="color:red;"><?php echo $fNameMsg;?></span><br>
    </p>
    <p>Last Name:</label>
    <input type="text" name="last_name" value="<?php echo $lastName;?>" />
    <span style="color:red;"><?php echo $lNameMsg;?></span><br>
    </p>
    <input type="text" id="col" name="event_col" size="25"  value=""/>
    <p>Email Address: 
    <input type="text" name="email"  value="<?php echo $email;?>"/>
    <span style="color:red;"><?php echo $emailMsg;?></span>
    </p>
</div>
<select name="eventselected">
<option value="No event">[Choose Event Below]</option>
     <?php 
        $row=$stmt->fetchAll(PDO::FETCH_COLUMN);
		foreach ($row as $rows )  
        {  	     
         ?>
        <option value="<?php echo $row[$idx]; ?>"><?php echo $row[$idx]; ?></option>
        <?php  
          $idx++;
        }                                                   
       ?>
</select>
<div id="area2">
 <!--<p>Subject: 
    <input type="text" name="subject" value="<?php echo $subject;?>" />
    <span style="color:red;"><?php echo $subjectMsg;?></span>
  </p> -->
  <p>Comments:
     <textarea rows="6" name="comments" placeholder="Enter your message here" value="<?php echo $comments;?>"></textarea>
    <span style="color:red;"><?php echo $commentMsg;?></span>
  </p>
</div> 
    <input type="submit" name="submit" id="button" value="Submit" />
    <input type="reset" name="button2" id="button2" value="Reset" />
  </p>
</form>

<span><?php echo $userMsg.$error_message;?></span>
<p>&nbsp;</p>
</body>

</html>

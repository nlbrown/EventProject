<?php
session_cache_limiter('none');			//This prevents a Chrome error when using the back button to return to this page.
session_start();

 $_SESSION['validUser'] = "no";
 $message ="";
  //  if (isset($_SESSION['validUser'])){
 	if ($_SESSION['validUser'] == "yes")				//is this already a valid user?
	{
		//User is already signed on.  Skip the rest.
	//	$message = "Welcome Back! $username";	//Create greeting for VIEW area	
        $message = "Welcome Back! ".$_SESSION['validUsername'];
	}
 //   }
	else
	{
		if (isset($_POST['submitLogin']) )			//Was this page called from a submitted form?
		{
			$inUsername = $_POST['loginUsername'];	//pull the username from the form
			$inPassword = $_POST['loginPassword'];	//pull the password from the form
			
			//include '../dbconnect.php';			//Connect to the database
            include '../dbconnectserver.php';	      //host server connect
            
			$sql = "SELECT event_user_name, event_user_password FROM event_user WHERE event_user_name = :user AND event_user_password = :pass";				
			
			$query = $conn->prepare($sql) or die("<p>SQL String: $sql</p>");	//prepare the query
			
            //echo "<h1>".$inUsername." --  ".$inPassword."</h1>";
            $query->bindParam(':user',$inUsername);
            $query->bindParam(':pass',$inPassword);
			//$query->bind_param("ss",$inUsername,$inPassword);	//bind parameters to prepared statement
			
			$query->execute() or die("<p>Execution </p>" );
			
            
			//$query->bind_result($userName,$passWord);
			$exists = $query->fetchColumn();
            //echo "<h1>".$exists." <=exists "."</h1>";
			//$query->store_result();
			
			//$query->fetch();	
			
			//echo "<h2>userName: $userName</h2>";
			//echo "<h2>password: $passWord</h2>";
		
			//echo "<h2>Number of rows affected " . $connection->affected_rows . "</h2>";	//best for Update,Insert,Delete			
			//echo "<h2>Number of rows found " . $query->num_rows . "</h2>";				//best for SELECT
			
			//if ($query->num_rows == 1 )		//If this is a valid user there should be ONE row only
      //      echo "<h1>"." exists is ".$exists."</h1>";
            if (!empty($exists))	
			{
				$_SESSION['validUser'] = "yes";				//this is a valid user so set your SESSION variable
                $_SESSION['validUsername'] = $inUsername;
		//		$message = "Welcome Back! $userName";
                $message = "Welcome! $inUsername";
				//Valid User can do the following things:
			}
			else
			{
				//error in processing login.  Logon Not Found...
				$_SESSION['validUser'] = "no";					
				$message = "Sorry, there was a problem with your username or password. Please try again.";
			}			
			
			//$query->close();
            $query = null;
			//$connection->close();
            $conn = null;
			
		}//end if submitted
		else
		{
			//user needs to see form
		}//end else submitted
		
	}//end else valid user
//turn off PHP and turn on HTML
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1" /> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Event Admin System Login Page</title>
 <style>
        body{
            background-color: lightgray;
            text-align: center;
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
<h2>Event Admin System Login Page </h2>
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

<h2><?php echo $message?></h2>

<?php
//    echo "<h1>"." Var is ".$_SESSION['validUser']."</h1>";
 //   if (isset($_SESSION['validUser'])){
    if ($_SESSION['validUser'] == "yes")	//This is a valid user.  Show them the Administrator Page
	{
		
//turn off PHP and turn on HTML
?>
        <h3>You have sucessfully Signed in </h3>
		<h3>Presenters Administrator Options</h3>
        <h3>have been added to you navigation bar</h3>
     <!--   <p><a href="eventAddForm.php">Input New Event</a></p>
        <p><a href="eventselect.php">Update/Delete Event </a></p>
        <p><a href="logout.php">Logout of Events Admin System</a></p>	
       --> 					
<?php
	}
    else									//The user needs to log in.  Display the Login Form
	{
?>
			<h2>Please login to the Administrator System</h2>
                <form method="post" name="loginForm" action="login.php" >
                  <p>Username: <input name="loginUsername" type="text" /></p>
                  <p>Password: <input name="loginPassword" type="password" /></p>
                  <p><input name="submitLogin" value="Login" type="submit" /> <input name="" type="reset" />&nbsp;</p>
                </form>
                
<?php //turn off HTML and turn on PHP
	}  //end of checking for a valid user
 //  } // end of isset check
//turn off PHP and begin HTML			
?>

<p>Return to <a href='eventHome.php'>Home Page</a></p>

</body>
</html>
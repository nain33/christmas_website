<?php
    session_start();
    
    if(!isset($_POST['inputUsername'], $_POST['inputPassword'])) {
        $message = "Please enter the username and password";
    }
    
    /*** ADD VALIDATIONS FOR USERNAME AND PASSWORD FOR STUPID PEOPLE LATER ON ***/
    
    else{
        $username = filter_var($_POST['inputUsername'], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['inputPassword'], FILTER_SANITIZE_STRING);
        
        #$password = sha1($password); #encryption
        
        $dbname = 'christmas';
		$dbuser = 'administrator';
		$dbpass = 'Pass&word123';
		$dbhost = '103.26.43.174';
		try{
		    $dbh = new PDO("mysql:host=$dbhost;port=3306;dbname=$dbname", $dbuser, $dbpass);
		    
		    $query = $dbh->prepare("SELECT username, password FROM users WHERE username= :query_username AND password= :query_password");
		    $query->bindParam(':query_username', $username);
		    $query->bindParam('query_password', $password);
		    $query->execute();
		    
		    if($query->fetchColumn() == false){
		    	$_SESSION['incorrect_details'] = 'yes';
		        $message = 'Login failed';
		    }
		    else{
		        $_SESSION['loggedIn'] = 'yes';
		        $_SESSION['username'] = ucfirst($username);
		        $message = 'Logged in successfully';
		    }
		} catch(PDOException $e){
		    print "Error!: " . $e->getMessage() . "<br/>";
            die();
		}
		
		$dbh = null;
		$query = null;
		
    }
    header( 'Location: homepage.php' );

?>
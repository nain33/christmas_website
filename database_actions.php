<?php
    session_start();

    $username = $_SESSION['username'];
    $itemName = filter_var($_POST['inputItemName'], FILTER_SANITIZE_STRING);
    $itemDescription = filter_var($_POST['inputItemDesc'], FILTER_SANITIZE_STRING);
    $itemPrice = filter_var($_POST['inputItemPrice'], FILTER_SANITIZE_STRING);
    $itemLocation = filter_var($_POST['inputItemLocation'], FILTER_SANITIZE_STRING);
    $itemLink = filter_var($_POST['inputItemLink'], FILTER_SANITIZE_STRING);
    
    #echo("<script>console.log('PHP: ".$_POST['inputItemName']."');</script>");
    
    $dbname = 'christmas';
	$dbuser = 'administrator';
	$dbpass = 'Pass&word123';
	$dbhost = '103.26.43.174';
	try{
	    $dbh = new PDO("mysql:host=$dbhost;port=3306;dbname=$dbname", $dbuser, $dbpass);
	    
	    if(isset($_GET['id']) and $_GET['task'] == 'edit'){ #edit item 
	    	$query = $dbh->prepare("UPDATE lists 
	    							SET item_name=:item_name, item_desc=:item_desc, item_price=:item_price, item_location=:item_location, item_link=:item_link
	    							WHERE id=:id");
	    	
	    	$query->execute(['id' => $_GET['id'], 'item_name' => $itemName, 'item_desc' => $itemDescription, 'item_price' => $itemPrice, 'item_location' => $itemLocation, 'item_link' => $itemLink]);
	    	
			header('Location: my_list.php');
	    }
	    else if(isset($_GET['id']) and $_GET['task'] == 'delete'){ #delete item
	    	$query = $dbh->prepare("DELETE FROM lists 
	    							WHERE id=?");
	    	
	    	$query->execute([$_GET['id']]);
	    	
	    	header('Location: my_list.php');
	    }
	    else if(isset($_GET['id']) and $_GET['task'] == 'claimed'){ #item is claimed
	    	$query = $dbh->prepare("UPDATE lists
	    							SET claimed=1, claimed_by=:username
	    							WHERE id=:id");
	    	
	    	$query->execute(['username' => $username, 'id' => $_GET['id']]);
	    	
	    	header('Location: view_lists.php');
	    }
	    else if(isset($_GET['id']) and $_GET['task'] == 'removeClaim'){ # item claim removed
	    	$query = $dbh->prepare("UPDATE lists
	    							SET claimed=0, claimed_by=null
	    							WHERE id=?");
	    							
	    	$query->execute([$_GET['id']]);
	    	
	    	header('Location: view_lists.php');
	    }
		else if(isset($_GET['id']) and $_GET['task'] == 'bought'){ # item is bought
	    	$query = $dbh->prepare("UPDATE lists
	    							SET bought=1, bought_by=:username
	    							WHERE id=:id");
	    	
	    	$query->execute(['username' => $username, 'id' => $_GET['id']]);
	    	
	    	header('Location: view_lists.php');
		}
		else if(isset($_GET['id']) and $_GET['task'] == 'removeBought'){ # item bought removed
	    	$query = $dbh->prepare("UPDATE lists
	    							SET claimed=0, claimed_by=null, bought=0, bought_by=null
	    							WHERE id=?");
	    							
	    	$query->execute([$_GET['id']]);
	    	
	    	header('Location: view_lists.php');
		}
	    else if($_GET['task'] == 'add'){ # add item
		    $query = $dbh->prepare("INSERT INTO lists(username, item_name, item_desc, item_price, item_location, item_link)
		                            VALUES (:username, :item_name, :item_desc, :item_price, :item_location, :item_link)");
		                            
	        $query->execute(['username' => $username, 'item_name' => $itemName, 'item_desc' => $itemDescription, 'item_price' => $itemPrice, 'item_location' => $itemLocation, 'item_link' => $itemLink]);
			
			header('Location: my_list.php');
	    }
	} catch(PDOException $e){
	    print "ERROR: $e" . "<br>";
	    die();
	}
	
	#close database connection
	$dbh = null;
	$query = null;
?>
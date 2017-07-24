<!DOCTYPE html>
<html lang="en-gb">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="main.css?ts=<?=time()?>&quot; ">
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>My Christmas List</title>
    <style>
        body {
            padding-top:70px;
        }
    </style>
</head>

<body>
	<?php
		session_start();
		
		if(($_SESSION['loggedIn'] == 'yes')){ ?>
		
			<nav class="navbar navbar-default navbar-fixed-top"> <!-- bootstrap navbar -->
				<div class="navbar-header"> <!-- creates a hamburger menu if screen is too small -->
					<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#CollapseNavbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span><!--Strips on the button-->
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="collapse navbar-collapse" id="CollapseNavbar">
					<ul class="nav navbar-nav">
						<li><a href="homepage.php">Homepage</a></li>
						<li class="active"><a href="#">My list</a></li>
						<li><a href="view_lists.php">View other lists</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</div>
			</nav>
			
			<div>
				<a class="btn btn-default" href="add_item.php" role="button">Add Item</a>
			</div>
			
			<?php
				$dbname = 'christmas';
				$dbuser = 'administrator';
				$dbpass = 'Pass&word123';
				$dbhost = '103.26.43.174';
				try{
			    	$dbh = new PDO("mysql:host=$dbhost;port=3306;dbname=$dbname", $dbuser, $dbpass);
			    	$query = $dbh->prepare("SELECT * from lists WHERE username= :username");
			    	$query->execute(['username' => $_SESSION['username']]);
			    	?>
			    	<div>
				    	<div class="table-responsive"> <!-- container for table -->
					    	<table class="table table-striped table-hover table-nonfluid">
					    		<tr>
					    			<th class="col-xs-3">Name</th>
					    			<th class="col-xs-3">Description</th>
					    			<th class="col-xs-1">Price</th>
					    			<th class="col-xs-2">Location</th>
					    			<th class="col-xs-3">Action</th>
					    		</tr>
					    	<?php
					    		foreach ($query as $row){
					    			echo '<tr>';
					    				if($row['item_link'] != null){ # if item has a link then show with link otherwise just plain text
					    					echo '<td><a class="underline-link" href="' . $row['item_link'] . '" target="_blank">' . $row['item_name'] . '</a/></td>';
					    				}
					    				else{
					    					echo '<td>' . $row['item_name'] . '</td>';
					    				}
					    				
					    				echo '<td>' . $row['item_desc'] . '</td>';
					    				
					    				if($row['item_price'] == 0) { # if item price is not set show nothing, otherwise show price
					    					echo '<td></td>';
					    				}
					    				else{
					    					echo '<td>' . $row['item_price'] . '</td>';
					    				}
					    				
					    				echo '<td>' . $row['item_location'] . '</td>';
					    				?>
					    				<div class="btn-toolbar pull-right" role="toolbar"> <!-- Actions for edit and delete in one table cell-->
					    					<td>
					    						<a href="edit_item.php?id=<?php echo $row['id']; ?>&task=edit">
													<button type="submit" value="Edit" class="btn btn-default" aria-label="Edit">
														<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
													</button> </a>
												<a href="database_actions.php?id=<?php echo $row['id']; ?>&task=delete">
													<button type="submit" value="Remove" class="btn btn-danger" aria-label="Delete">
														<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
													</button> </a>
											</td>
										</div>
					    			</tr>
					    		<?php }
					    		
					    	echo '</table>';
						echo '</div>';
					echo '</div>';
				} catch(PDOException $e){
					print "ERROR: $e" . "<br/>";
					die();
				}
				
				# close database connection
				$dbh = null;
				$query = null;
			?>
        <?php } else { 
            header ('Location: homepage.php'); #redirect to homepage
        } ?>
            
</body>
    
</html>
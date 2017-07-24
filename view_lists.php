<!DOCTYPE html>
<html lang="en-gb">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="main.css?ts=<?=time()?>&quot; ">
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Other Christmas Lists</title>
    <style>
        body {
            padding-top:70px;
        }
    </style>

	<!-- script to filter table -->
	<script>
	function filterTable(){
		var val = new RegExp($('#filterOption').val());
		if(val == "/all/"){
			$('.filterable').show();
		}
		else{
			$('.filterable').hide();
			$('.filterable').filter(function() {
				return val.test($(this).text());
			}).show();
		}
	}
	
	</script>
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
						<li><a href="my_list.php">My list</a></li>
						<li class="active"><a href="#">View other lists</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</div>
			</nav>
			
			<?php
			$dbname = 'christmas';
			$dbuser = 'administrator';
			$dbpass = 'Pass&word123';
			$dbhost = '103.26.43.174';
			try{
			    $dbh = new PDO("mysql:host=$dbhost;port=3306;dbname=$dbname", $dbuser, $dbpass);
			    
			    $query = $dbh->prepare('SELECT * FROM lists WHERE NOT username=?');
			    $query->execute([$_SESSION['username']]);
			    $queryUsers = $dbh->prepare('SELECT username FROM users WHERE NOT username=?');
			    $queryUsers->execute([$_SESSION['username']]);
			    ?>
			    
			    <div class="container"> <!-- container for table -->
			    	<select id="filterOption" onchange="filterTable()"> <!-- dropdown box for filtering table by username -->
						<option value="all" selected>Show all</option>;
			    		<?php
			    		foreach($queryUsers as $row){
			    			$user = $row['username'];
							if($user == $_GET['name']){
								echo "<option value=\"$user\" selected>$user</option>";
							}
							else{
			    				echo "<option value=\"$user\">$user</option>"; 
							}
			    		} ?>

			    	</select>

			    	<div class="table-responsive">
			    		<table class="table table-striped table-hover" id="lists-table">
			    			<thead>
				    			<tr>
				    				<th>Name</th>
				    				<th>Item</th>
				    				<th>Description</th>
				    				<th>Price</th>
				    				<th>Location</th>
				    				<th>Claim</th>
				    				<th>Bought</th>
				    			</tr>
			    			</thead>
			    			<tbody>
			    		<?php
			    			foreach ($query as $row) {
			    				echo '<tr class="filterable '; 
			    					if($row['bought']==1){ #set colour of table based on if item is claimed or bought 
			    						 echo 'danger';	#red
			    					} else if($row['claimed'] == 1){
			    						echo 'warning'; #yellow
			    					} else{
			    						echo '';
			    					}
			    				echo '">';
			    				
		    					echo '<td>' . $row['username'] . '</td>';
		    					
		    					if($row['item_link'] != null){ # if item has link show with link otherwise just show plain text
				    				echo '<td><a class="underline-link" href="' . $row['item_link'] . '" target="_blank">' . $row['item_name'] . '</a/></td>';
				    			}
				    			else{
				    				echo '<td>' . $row['item_name'] . '</td>';
				    			}
			    				echo '<td>' . $row['item_desc'] . '</td>';
			    				
			    				if($row['item_price'] == 0) { # if price is not set show nothing, othewise show price
				    				echo '<td></td>';
				    			}
				    			else{
				    				echo '<td>' . $row['item_price'] . '</td>';
				    			}
				    			
			    				echo '<td>' . $row['item_location'] . '</td>';
			    				
			    				if($row['claimed']==1){ #if item is claimed
			    					if($row['bought'] == 1 and $row['bought_by'] == $_SESSION['username']){ #if already bought by current user then only display claimed by you (no option to remove claim) and bought by you (with option to remove)
			    						echo '<td align="center">Claimed by you</td>';
			    						
			    						echo '<td align="center">Bought by you <br /> 
					    							<a class="button btn-default" href="database_actions.php?task=removeBought&id=' . $row['id'] . '" role="button">
					    								<span class="glyphicon glyphicon-remove danger" aria-hidden="true"></span>
					    							</a></td>';
			    					}
			    					else if($row['claimed_by'] == $_SESSION['username']){ #if only claimed by current user then show option to remove claim and option to buy
			    						echo '<td align="center">Claimed by you <br /> 
			    							<a class="button btn-danger" href="database_actions.php?task=removeClaim&id=' . $row['id'] . '" role="button">
			    								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
			    							</a></td>';
			    							
			    						echo '<td align="center"><a class="button btn-default" href="database_actions.php?task=bought&id=' . $row['id'] . '" role="button">
				    							<span class="glyphicon glyphicon-check" aria-hidden="true"></span>
				    							</a></td>';
			    					}
			    					else{ #not claimed by current user so show who it's claimed by (no option to buy)
			    						echo '<td>Claimed by ' . $row['claimed_by'] . '</td>'; 
			    						
			    						if($row['bought'] == 0){
			    							echo '<td>Cannot buy: claimed by ' . $row['claimed_by'] . '</td>';
			    						}
			    						else{
			    							echo '<td>Bought by: ' . $row['bought_by'] . '</td>';
			    						}
			    					} 

			    				}
			    				else{ #item not claimed
			    					if($row['bought']==0){ #not bought and not claimed so show options to claim and buy
			    						echo '<td align="center"><a class="button btn-default" href="database_actions.php?task=claimed&id=' . $row['id'] . '" role="button">
			    								<span class="glyphicon glyphicon-check" aria-hidden="true"></span>
			    							</a></td>';
			    							
			    						echo '<td align="center"><a class="button btn-default" href="database_actions.php?task=bought&id=' . $row['id'] . '" role="button">
				    							<span class="glyphicon glyphicon-check" aria-hidden="true"></span>
				    						</a></td>';
			    					}
			    					
			    					else{ #bought=true
				    					if($row['bought_by'] == $_SESSION['username']){ #bought buy current user so show claimed by you and bought by you (with option to remove bought)
				    						echo '<td align="center">Claimed by you</td>';
				    						
				    						echo '<td align="center">Bought by you <br /> 
						    							<a class="button btn-default" href="database_actions.php?task=removeBought&id=' . $row['id'] . '" role="button">
						    								<span class="glyphicon glyphicon-remove danger" aria-hidden="true"></span>
						    							</a></td>';
				    					}
				    					else{ #not bought by current user
				    						echo '<td>Claimed by ' . $row['claimed_by'] . '</td>';
				    						echo '<td>Bought by ' . $row['bought_by'] . '</td>';
				    					}
				    				}	
				    			}
				    			echo '</tr>';
				    		}

			    		?>
			    		</tbody>
			    		<tfoot></tfoot>
			    		</table>
			    	</div>
			    </div>
			<?php } catch(PDOException $e){
				print "ERROR: $e" . "<br/>";
				die();
			} 
			
			#close database connection
			$dbh = null;
			$query = null;
			$queryUsers = null;
			?>

			<script> filterTable(); </script>
        <?php } else { 
            header ('Location: homepage.php');
        } ?>
        

	
</body>
    
</html>
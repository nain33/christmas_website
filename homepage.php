<!DOCTYPE html>
<html lang="en-gb">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="main.css" >
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<head>
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
	<title>Hello...</title>
	<style type="text/css">
		body{
	padding-top:70px;
	text-align: center;
		}
	.checkbox label {
	font-family: Tahoma, Geneva, sans-serif;
}
    #countdown div .countdown-text div {
	color: #000;
}
    #countdown div .countdown-text div {
	font-size: 72px;
}
    #countdown div div br {
	font-size: 36px;
}
    #countdown div .countdown-text div {
	font-size: 16px;
}
    </style>
</head>

<body bgcolor="#0000FF">

	<?php
		session_start();
		
		if(!(isset($_SESSION['loggedIn']))){ ?>
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
						<li class="active"><a href="#">Homepage</a></li>
					</ul>
				</div>	
			</nav>
			
			<div> <!-- login form -->
				<form action="login_verify.php" method="post">
					<div align="center">
						<img src="pics/green_present_box.png" width="65" height="55" align="middle">  
						<img src="pics/purple_blue.png" width="65" height="55">
						<img src="pics/green_present_box.png" alt="1" width="55" height="40" align="middle"> 
						<img src="pics/purple_blue.png" alt="2" width="65" height="55">
						<img src="pics/green_present_box.png" alt="3" width="60" height="55" align="middle"> 
						<img src="pics/purple_blue.png" alt="4" width="65" height="55">
						<?php
						if(isset($_SESSION['incorrect_details'])){ ?>
							<span class="text-danger">Incorrect details. Please try again.</span>
						<?php } ?>
					</div>
					    
					<div class=form-group>
						<label for="inputUsername">Username: </label>
						<input type="text" class="form-control" id="inputUsername" name="inputUsername" placeholder="Username">
					</div>
					<div class=form-group>
						<label for="inputPassword">Password: </label>
						<input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password">
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox"> Remember me
						</label>
					</div>
					<button type="submit" class="btn btn-default">Login</button>
				</form>
			</div>
			
	    <?php
		}
		else{ ?>
		    <nav class="navbar navbar-default navbar-fixed-top"> 
			    <!-- bootstrap navbar -->
				<div class="navbar-header"> 
				    <!-- creates a hamburger menu if screen is too small -->
				    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#CollapseNavbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<!--Strips on the button-->
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
			        </button>
			    </div>
				<div class="collapse navbar-collapse" id="CollapseNavbar">
					<ul class="nav navbar-nav">
						<li class="active"><a href="#">Homepage</a></li>
						<li><a href="my_list.php">My list</a></li>
						<li><a href="view_lists.php">View other lists</a></li>
						<li><a href='logout.php'>Logout</a></li>
					</ul>
				</div>
			</nav>
			
			<div align="center">
				<?php 
				if($_SESSION['username'] != "Hemisha"){
					echo '<a href="view_lists.php?name=Hemisha"><img src="pics/boulball/boulball_H.png" alt="" width="133" height="125" border="0" usemap="#Map"></a>';
				}
				if($_SESSION['username'] != 'Ankit'){
					echo '<a href="view_lists.php?name=Ankit"><img src="pics/boulball/boulball_A.png" width="88" height="141"></a>';
				}
				if($_SESSION['username'] != 'Nainesh'){
					echo '<a href="view_lists.php?name=Nainesh"><img src="pics/boulball/boulball_N.png" width="117" height="149">';
				}
				if($_SESSION['username'] != 'Diya'){
					echo '<a href="view_lists.php?name=Diya"><img src="pics/boulball/boulball_D.png" width="125" height="105">';
				}
				if($_SESSION['username'] != 'Paresh'){
					echo '<a href="view_lists.php?name=Paresh"><img src="pics/boulball/boulball_P.png" width="107" height="127">';
				}
				?>
			</div>
			
		<?php } ?>
	<div align="center" id="countdown">
		<div>
			<span class="days"></span><br>
			<div class="countdown-text">Days</div>
		</div>
		<div>
			<span class="hours"></span><br>
			<div class="countdown-text">Hours</div>
		</div>
		<div>
			<span class="minutes"></span><br>
			<div class="countdown-text">Minutes</div>
		</div>
		<div>
			<span class="seconds"></span>
			<div class="countdown-text">Seconds</div>
		</div>
	</div>

<!-- script for countdown timer -->
<script> 
		function getTimeRemaining(endTime){
			var distance = endTime - new Date();
			console.log(distance);
			console.log(new Date());
			var seconds = Math.floor((distance/1000)%60);
			var minutes = Math.floor((distance/1000/60)%60);
			var hours = Math.floor((distance/(1000*60*60))%24);
			var days = Math.floor(distance/(1000 * 60 * 60 * 24));
	
			return {
				'total': distance,
				'days': days,
				'hours': hours,
				'minutes' : minutes,
				'seconds' : seconds
			};
		}
		
		function initialiseClock(id, endTime){
			var clock = document.getElementById(id);
			
			var daysSpan = clock.querySelector('.days');
			var hoursSpan = clock.querySelector('.hours');
			var minutesSpan = clock.querySelector('.minutes');
			var secondsSpan = clock.querySelector('.seconds');
			
			function updateClock(){
				var timeRemaining = getTimeRemaining(endTime);
				
				daysSpan.innerHTML = ('0' + timeRemaining.days).slice(-3);
				hoursSpan.innerHTML = ('0' + timeRemaining.hours).slice(-4);
				minutesSpan.innerHTML = ('0' + timeRemaining.minutes).slice(-4);
				secondsSpan.innerHTML = ('0' + timeRemaining.seconds).slice(-4);
				
				if(timeRemaining.total <= 0) {
					clearInterval(timeInterval);
				}
			}
			
			updateClock();
			var timeInterval = setInterval(updateClock, 1000);
		}
		
		var deadline = new Date('2017','11','25');
		initialiseClock('countdown', deadline);
</script>

</body>



</html>

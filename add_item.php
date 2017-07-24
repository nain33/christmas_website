<!DOCTYPE html>
<html lang="en-gb">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="main.css?ts=<?=time()?>&quot; ">
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Item</title>
    <style>
        body {
            padding-top:70px;
        }
    </style>
</head>

<body>
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
    			<li><a href="view_lists.php">View other lists</a></li>
    			<li><a href="logout.php">Logout</a></li>
    		</ul>
    	</div>
	</nav>
    
    <form action="database_actions.php?task=add" method="post"> <!-- add item form -->
        <div class="form-group">
            <label for="inputItemName">Item Name <span class="required-field">(required)</span></label>
            <input type="text" class="form-control" id="inputItemName" name="inputItemName" placeholder="Name" required>
        </div>
        <div class="form-group">
            <label for="inputItemDesc">Item Description</label>
            <input type="text" class="form-control" id="inputItemDesc" name="inputItemDesc" placeholder="Description">
        </div>
        <div class="form-group">
            <label for="inputItemPrice">Item Price</label>
            <div class="input-group">
                <div class="input-group-addon">$</div>
                <input type="text" class="form-control" id="inputItemPrice" name="inputItemPrice" placeholder="Price">
            </div>
        </div>
        <div class="form-group">
            <label for="inputItemLocation">Item Location</label>
            <input type="text" class="form-control" id="inputItemLocation" name="inputItemLocation" placeholder="Location">
        </div>
        <div class="form-group">
            <label for="inputItemLink">Link</label>
            <input type="text" class="form-control" id="inputItemLink" name="inputItemLink" placeholder="Link">
        </div>
        <button type="submit" class="btn btn-default">Add Item</button>
    </form>
</body>

</html>
<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8">
			<title>TODO List</title>
		</head>
			<body>
				<h2>TODO List</h2>
					<ul>
					<li>Do laundry</li>
					<li>Walk dog</li>
					<li>Go to the store</li>
					<li>Do Homework</li>
					<li>Go to the gym</li>
				</ul>
				<h3>Add an Item to the TODO List</h3>
					<form method="POST">
						<?php
        				var_dump($_GET);
        				var_dump($_POST);
    					?>
						<p>
							<label for="Add_Item">Item:</label>
							<input id="Add_Item" name="Add_Item" type="text" placeholder="Enter New Item Here"> 
						</p>
						<p>
						 <button type="Submit">Add</button>
						</p>
					</form>
			</body>	
	<html>
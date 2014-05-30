<?php

$items = [];
//load contents of file


$filename = 'data/list.txt'; 

//function to open a file 
function add_file($filename) {
    $items = [];
    $filename = 'data/list.txt';
    $filesize = filesize($filename);
    $read = fopen($filename, "r"); 
    $string_list = trim(fread($read, $filesize));
    $items = explode(PHP_EOL, $string_list);
    fclose($read);
    return $items;
}

$items = add_file($filename);

//function to save file
function save_file($items) {
    $filename = 'data/list.txt';
    $handle = fopen($filename, 'w');
    foreach ($items as $item) {
        fwrite($handle, $item . PHP_EOL);
    }
    fclose($handle);
}

//checking if $_POST isset and then adding item to array	
if(isset($_POST['Add_Item'])){
	$newTodo = $_POST['Add_Item'];
	$items[] = $newTodo; 
}

//calling save function to save items to list.txt once item is added
save_file($items); 

//checking if $_GET isset and then removing item from array	with unset
if (isset($_GET['removeIndex'])) {
	$removeIndex = $_GET['removeIndex'];
	unset($items[$removeIndex]);
}

//calling save function to save items to list.txt once item is removed 
save_file($items); 


// Verify there were uploaded files and no errors
if (count($_FILES) > 0 && $_FILES['file1']['error'] == 0) {
    // Set the destination directory for uploads
    $upload_dir = '/vagrant/sites/todo.dev/public/uploads/';
    // Grab the filename from the uploaded file by using basename
    $filename = basename($_FILES['file1']['name']);
    // Create the saved filename using the file's original name and our upload directory
    $saved_filename = $upload_dir . $filename;
    // Move the file from the temp location to our uploads directory
    move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);
}

// Check if we saved a file
if (isset($saved_filename)) {
    // If we did, show a link to the uploaded file
    echo "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>";
}
		
	$uploaded_file = add_file($saved_filename);

	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	$allowed = array('txt');
	if(in_array($ext, $allowed)){
	$items = array_merge($items, $uploaded_file);
	}
    



?>



<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>TODO List</title>
	</head>
	<body>
		<h2>TODO List</h2>
		<ul>
			<?php 
				foreach($items as $key => $item) {
					echo "<li>{$item}<a href=\"todo_list.php?removeIndex={$key}\"> Remove Item </a></li>" . PHP_EOL;
				}
			?>
		</ul>

		<h3>Add an Item to the TODO List</h3>

					<form method="POST" action="/todo_list.php">
						<p>
							<label for="Add_Item">Item:</label>
							<input id="Add_Item" name="Add_Item" type="text" placeholder="Enter New Item Here"> 
							
							<?php
        						var_dump($_POST);
        						var_dump($_GET);
							?>
						</p>
						<p>
						 <button type="Submit">Add</button>
						</p>
					</form>

		<h1>Upload File</h1>

					<form method="POST" enctype="multipart/form-data" action="/todo_list.php">
    					<p>
        					<label for="file1">File to upload: </label>
        					<input type="file" id="file1" name="file1">
    					</p>
   						 <p>
        				<input type="submit" value="Upload">
        				</p>
					</form>
			</body>	
	<html>
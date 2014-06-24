<?

$filename = 'data/list.txt'; 
//load contents of file
require_once('classes/filestore.php');
$fs = new Filestore($filename);



$error_message = '';


$items = $fs->read();


try{
	if(!empty($_POST)){
		if(empty($_POST['Add_Item']) || (strlen($_POST['Add_Item']) > 240)){
			throw new Exception('This post is empty or has more than 240 characters!');
		}
		$newTodo = $_POST['Add_Item'];
		$items[] = $newTodo; 
		$fs->write($items);
	}
//} catch(InvalidInputException $e) {
		//echo 'This post is empty or has more than 240 characters!';
		//$msg = $e->getMessage() . PHP_EOL;
	}catch(Exception $e) {
		//echo 'This post is empty or has more than 240 characters!';
		$msg = $e->getMessage() . PHP_EOL;
	}



	//if(empty($_POST['Add_Item'])){throw new Exception('This post is empty!');}



//checking if $_GET isset and then removing item from array	with unset
if (isset($_GET['removeIndex'])) {
	$removeIndex = $_GET['removeIndex'];
	unset($items[$removeIndex]);
	$fs->write($items); 

}


// Verify there were uploaded files and no errors
if (count($_FILES) > 0 && $_FILES['file1']['error'] == 0) {
	if($_FILES['file1']['type'] == 'text/plain') {
    // Set the destination directory for uploads
    $upload_dir = '/vagrant/sites/todo.dev/public/uploads/';
    // Grab the filename from the uploaded file by using basename
    $uploaded_filename = basename($_FILES['file1']['name']);
    // Create the saved filename using the file's original name and our upload directory
    $saved_filename = $upload_dir . $uploaded_filename;
    // Move the file from the temp location to our uploads directory
    move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);
	//Open/Upload a new file
	$upf = new Filestore($saved_filename);
	$uploaded_file = $upf->read();
	//Merge original array with new uploaded files
	$items = array_merge($items, $uploaded_file);
	//Error echoed if file type is not "text/plain"
	}else {
		$error_message = "ERROR: File Type Must be text/plain." .PHP_EOL;
	}
	$fs->write($filename, $items); 
}

// Check if we saved a file
if (isset($saved_filename)) {
    // If we did, show a link to the uploaded file
    echo "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>";
}
    



?>



<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>TODO List</title>
		 <link rel="stylesheet" href="/CSS/stylesheet.css">
	</head>
	<body>
		<? if(isset($msg)) : ?>
			<?= $msg; ?>
		<? endif; ?>
		<div id="retro">
		<h1 class="fancy-header">TODO List</h1>
		</div>
			<? if(!empty($error_message)) : ?>
				 <p><?= $error_message?></p>
			<? endif; ?>
		<ul>
			<? foreach($items as $key => $item) : ?>
					<li><?= htmlspecialchars(strip_tags($item)). "<a href=\"todo_list.php?removeIndex={$key}\"> Remove Item</a>";?></li>
			<? endforeach; ?>
		</ul>
		
		
		
		<h2 class="fancy-header">Add an Item to the TODO List</h2>

			<form method="POST" action="/todo_list.php">
				<p>
					<label for="Add_Item">Item:</label>
					<input id="Add_Item" name="Add_Item" type="text" placeholder="Enter New Item Here"> 
				</p>
				<p>
					<button type="Submit">Add</button>
				</p>
				</form>

		<h2 class="fancy-header">Upload File</h2>

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
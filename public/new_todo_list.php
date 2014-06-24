<?
// Get new instance of PDO object
$dbc = new PDO('mysql:host=127.0.0.1;dbname=todo_db', 'mallory', 'malmal');

//Tell PDO to throw exceptions on error
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$filename = 'data/list.txt'; 
//load contents of file
require_once('classes/filestore.php');
$fs = new Filestore($filename);

function getLists($dbc) {
// Bring the $dbc variable into scope and Create Limit and offset
	$page = getOffset(); 
	$stmt = $dbc->prepare('SELECT * FROM todo_list LIMIT :LIMIT OFFSET :OFFSET');
	$stmt->bindValue(':LIMIT' , 10, PDO::PARAM_INT);
    $stmt->bindValue(':OFFSET' , $page, PDO::PARAM_INT); 
    $stmt->execute(); 

    $stmt = $stmt->fetchAll((PDO::FETCH_ASSOC));
    return $stmt;
}

//Create Function to get an offset for each page 
function getOffset(){
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	return($page - 1) * 10;

}

$count = $dbc->query('SELECT COUNT(*) FROM todo_list')->fetchColumn();
$numPages = ceil($count / 10); 


//defining page variable 
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$nextPage = $page + 1;
$prevPage = $page - 1;






$error_message = '';


$items = $fs->read();



	if(!empty($_POST['todo_item'])){
		$dbc = new PDO('mysql:host=127.0.0.1;dbname=todo_db', 'mallory', 'malmal');

		//Tell PDO to throw exceptions on error
		$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stmt = $dbc->prepare("INSERT INTO todo_list(todo_item) VALUES (:todo_item)");


		$stmt->bindValue(':todo_item', $_POST['todo_item'], PDO::PARAM_STR);
		
	   
	    $stmt->execute();

	} else {
		foreach ($_POST as $key => $value) 
	       if (empty($value)) {
	            echo "<h1>" . ucfirst($key) .  " is empty.</h1>";
	    	}
	}
	
	

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

		<div id="retro">
		<h1 class="fancy-header">TODO List</h1>
		</div>
			<? if(!empty($error_message)) : ?>
				 <p><?= $error_message?></p>
			<? endif; ?>
			<table>
				<table border='1'>
     		<tr>
       			
       			<td>Todo Item</item>

     		</tr>
    
                
                    <? foreach(getLists($dbc) as $key => $item): ?>
                     <tr>
                        <td><?= htmlspecialchars(strip_tags($item['todo_item']));?> <button class="btn btn-danger btn-sm pull-right btn-remove"data-todo=<?= $item['id'];?>>Remove</button></td>
                    <? var_dump($item); ?>
                    </tr>
                    <? endforeach; ?>
               
			</table>
        
		<a href="/new_todo_list.php?page=<?= $prevPage; ?>"> Previous</a>
		<a href="/new_todo_list.php?page=<?= $nextPage;?>">Next</a>
		
		
		<h2 class="fancy-header">Add an Item to the TODO List</h2>

			<form method="POST" action="/new_todo_list.php">
				<p>
					<label for="todo_item">Item:</label>
					<input id="todo_item" name="todo_item" type="text" placeholder="Enter New Item Here"> 
				</p>
				<p>
					<button type="Submit">Add</button>
				</p>
				</form>
		<form id="removeForm" action="todo-db.php" method="post">
   		 <input id="removeId" type="hidden" name="remove" value="">
		</form>

		<h2 class="fancy-header">Upload File</h2>

			<form method="POST" enctype="multipart/form-data" action="/new_todo_list.php">
    			<p>
        			<label for="file1">File to upload: </label>
        			<input type="file" id="file1" name="file1">
    			</p>
   				<p>
        			<input type="submit" value="Upload">
        		</p>
			</form>
			
			<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
			
			<script>
			$('.btn-remove').click(function () {
    		var todoId = $(this).data('todo');
    		if (confirm('Are you sure you want to remove item ' + todoId + '?')) {
       			 $('#remove-id').val(todoId);
        		 $('#remove-form').submit();
    			}
			});

			</script>
		
	</body>	
<html>
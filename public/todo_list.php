<?php

$items = [];
//load contents of file


$filename = 'data/list.txt'; 

// function get_input($upper = false) { 
//     $result = trim(fgets(STDIN)); 
//     return $upper ? strtoupper($result) : $result;
// } 


function add_file($filename) {
     //echo "Enter the file path you want to add: \n";
    $items = [];
    $filename = 'data/list.txt';
    $filesize = filesize($filename);
    $read = fopen($filename, "r"); 
    $string_list = trim(fread($read, $filesize));
    $items = explode("\n", $string_list);
    fclose($read);
    return $items;
}

$items = add_file($filename);

function save_file($items) {
    $filename = 'data/list.txt';
    $handle = fopen($filename, 'w');
    foreach ($items as $item) {
        fwrite($handle, $item . PHP_EOL);
    }
    fclose($handle);
}

	
if(isset($_POST['Add_Item'])){
	$newTodo = $_POST['Add_Item'];
	$items[] = $newTodo; 
}

save_file($items); 

if (isset($_GET['removeIndex'])) {
	$removeIndex = $_GET['removeIndex'];
	unset($items[$removeIndex]);
}

save_file($items); 

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

					<form method="POST">
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
			</body>	
	<html>
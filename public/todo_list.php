<?php

$items = [];
 $filename = 'data/list.txt'; 

// function get_input($upper = false) { 
//     $result = trim(fgets(STDIN)); 
//     return $upper ? strtoupper($result) : $result;
// } 


function add_file($items) {
     //echo "Enter the file path you want to add: \n";
    $items = [];
    $filename = 'data/list.txt';
    $filesize = filesize($filename);
    $read = fopen($filename, "r"); 
    $string_list = trim(fread($read, $filesize));
    $list_array = explode("\n", $string_list);
    $output = array_merge($items, $list_array);
    fclose($read);
    return ($output);
}

function save_file($items) {
    $filename = 'data/list.txt';
    if (!file_exists($filename)) {
        $handle = fopen($filename, 'w');
    }
        foreach ($items as $item) {
            fwrite($handle, $item . PHP_EOL);
        } 
            fclose($handle);
}


$items = add_file($filename);




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
						$list_array = ['Go to the gym', 'Pick up laundry', 'Cook dinner']; 
							$items = add_file($filename);
							$array = array_merge($items, $list_array);
							foreach($array as $arrays) {
								echo "<li>$arrays</li>" . PHP_EOL;
							}


					?>
					</ul>

				<h3>Add an Item to the TODO List</h3>
				<?php 
					foreach($_POST as $key => $value) {
						echo "<p>{$key} => {$value}</p>";
					}
				?>

					<form method="POST">
						<p>
							<label for="Add_Item">Item:</label>
							<input id="Add_Item" name="Add_Item" type="text" placeholder="Enter New Item Here"> 
							
							<?php
        					var_dump($_POST);



    						?>

						</p>
						<p>
						 <button type="Submit">Add</button>
						</p>
					</form>
			</body>	
	<html>
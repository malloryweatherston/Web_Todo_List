<?php

class Filestore {

    public $filename = '';

    public function __construct($filename = '') 
    {
        $this->filename = $filename;

    }

    /**
     * Returns array of lines in $this->filename
     */
    function add_file($filename)
    {
        $items = []; 
        $filesize = filesize($this->filename);
        $read = fopen($this->filename, "r"); 
        $string_list = trim(fread($read, $filesize));
        $items = explode(PHP_EOL, $string_list);
        fclose($read);
        return $items;
    }

    /**
     * Writes each element in $array to a new line in $this->filename
     */
    function save_file($filename, $items)
    {
         $handle = fopen($this->filename, 'w');
        foreach ($items as $item) {
            fwrite($handle, $item . PHP_EOL);
        }
        fclose($handle);
    }

    /**
     * Reads contents of csv $this->filename, returns an array
     */
    function read_address_book()
    {
        $entries = [];
            $handle = fopen($this->filename, 'r');
            while(!feof($handle)) {
                $row = fgetcsv($handle);
                if(is_array($row)) {
                    $entries[] = $row;
                }
            }
            fclose($handle);
            return $entries;

    }

    /**
     * Writes contents of $array to csv $this->filename
     */
    function write_address_book($big_array)
    {
        $handle = fopen($this->filename, 'w');
        foreach($big_array as $fields) {
            fputcsv($handle, $fields); 
        }
        fclose($handle);


    }

}
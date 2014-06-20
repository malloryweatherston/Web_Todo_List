<?php

class Filestore {

    protected $filename = ''; 
    protected $is_csv = FALSE;

    public function __construct($filename = '') 
    {
        $this->filename = $filename;
        $extension = substr($filename, -3);

        if ($extension == 'csv')
            { $this->is_csv == TRUE;

            }else {
                $this->is_csv == FALSE; 
            }

    }


    /**
     * Returns array of lines in $this->filename
     */
    private function add_file()
    {
        $array = []; 

        if (is_readable($this->filename) && filesize($this->filename)>0){
        $filesize = filesize($this->filename);
        $read = fopen($this->filename, "r"); 
        $string_list = trim(fread($read, $filesize));
        $items = explode(PHP_EOL, $string_list);
        fclose($read);
        return $items;
        }
        return $array;
    }

    /**
     * Writes each element in $array to a new line in $this->filename
     */
    private function save_file($array)
    {
         $handle = fopen($this->filename, 'w');
         foreach ($array as $arrays) {
            fwrite($handle, $arrays . PHP_EOL);
        }
    fclose($handle);
    }

    /**
     * Reads contents of csv $this->filename, returns an array
     */
    private function read_address_book()
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
    private function write_address_book($big_array)
    {
        $handle = fopen($this->filename, 'w');
        foreach($big_array as $fields) {
            fputcsv($handle, $fields); 
        }
        fclose($handle);


    }

    public function read() {
        if ($this->is_csv == TRUE){        
            return $this->read_address_book(); 
        }else {
            return $this->add_file();
        }

    }


    public function write($array) {
        if ($this->is_csv == TRUE){        
            $this->write_address_book($array); 
        }else {
            $this->save_file($array);
        }

    }

}




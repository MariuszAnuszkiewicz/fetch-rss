<?php namespace MariuszAnuszkiewicz\src\SaveStrategy;

interface SaveStrategy {

    public function run($data);
}

class SimpleSaveCsv implements SaveStrategy {

    public function run($data) {

        $source = WEBROOT.DS."upload/simple.csv";
        if(!file_exists($source)) {
            fopen($source, "w+");
        }
        $file = fopen($source, "w");
        foreach ($data as $line) {
            fputcsv($file, explode(", ", $line));
        }
        fclose($file);
    }
}

class ExtendedSaveCsv implements SaveStrategy {

    private $_data = [];

    public function run($data) {

        $old_source = WEBROOT.DS."upload/simple.csv";
        $new_source = WEBROOT.DS."upload/extended.csv";
        $old_file = fopen($old_source, "a+");
        $str_data = implode(", ", $data);
        $len = strlen($str_data);

        if(!file_exists($new_source)) {
            fopen($new_source, "a+");
        }
        if(filesize($new_source) > 120000){
            unlink($new_source);
        }
        $read_old = fread($old_file, $len);
        $this->_data[] = $read_old;

        $combine_data = array_merge($data, $this->_data);
        $new_file = fopen($new_source, "a+");
        foreach ($combine_data as $line) {

            fputcsv($new_file, explode(", ", $line));
        }
        fclose($new_file);
    }
}

class TypeSaved {

    private $_array_objects = [];
    private $_name;

    public function __construct($name, SaveStrategy $obj) {
        $this->_name = $name;
        $this->_array_objects[$this->_name] = $obj;
    }

    public function load() {
        return $this->_array_objects[$this->_name];
    }
}

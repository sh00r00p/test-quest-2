<?php

/*ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);*/

class Parser {

	public function parseData($formData) {

      $file_name = $formData['name'];
		$file_type = $formData['type'];
		$file_tmp = $formData['tmp_name'];
		$file_size = $formData['size'];
		$file_ext = end(explode('/', $file_type));

		switch($file_ext) {
         
         case 'xml':
            $xml_list = simplexml_load_file($file_tmp);
            $this->isXML($xml_list);
            break;
         
         case 'csv':
            $csv_str = file_get_contents($file_tmp);
            $lines = explode(PHP_EOL, $csv_str);
            $list = array();
            foreach ($lines as $line) {
                $list[] = str_getcsv($line);
            }

            $workers = $this->isCSV($list);
            break;
         
         /*case 'other format':
            same code        */

      }
      
      return $workers;

	}

   function isXML($list) {

      foreach($list as $worker){
         if($worker->param) 
            $format = 'xml1';
         else
            $format = 'xml2';
      }

      var_dump($format);

   }

   function isCSV($list) {

      $items = array();
      $items_keys = array('fname', 'lname', 'mname', 'birth_date', 'comment');

      foreach($list as $item) {
         $items[] = array_combine($items_keys, explode(';', $item[0]));
         
      }
      
      return $items;
   }

	public function getWorkers() {

	}
}
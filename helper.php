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
            $list = simplexml_load_file($file_tmp);
            
            /*while ($data = fgets($fp)) {
               if (!xml_parse($xml_parser, $data, feof($fp))) {
                  echo "XML Error: ".xml_error_string(xml_get_error_code($xml_parser));
                  echo " at line ".xml_get_current_line_number($xml_parser);
                  break;   
               }
            
            }
            xml_parser_free($xml_parser);*/
            $workers = $this->isXML($list);
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

   protected function isXML($list) {

      $items = array();
      
      foreach($list->worker as $worker) {
          if($worker->param) { 
            $format = 'xml1';
            
         } else {
            $format = 'xml2';
         }

         $items[] = $worker;  
      }
     
      return $items;
   }

   protected function isCSV($list) {

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
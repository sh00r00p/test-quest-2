<?php

//init  our class for parsing
class Parser {

	/*
      general input function
      must be access anywere
   */
   public function parseData($formData) {

      $file_name = $formData['name'];
		$file_type = $formData['type'];
		$file_tmp = $formData['tmp_name'];
		$file_size = $formData['size'];
		$file_ext = end(explode('/', $file_type));

		if(!empty($file_name)) {
         switch($file_ext) {
         
            case 'xml':
               
               //chech errors
               $parser = xml_parser_create();
               $handle = fopen($file_tmp, "r");
               while ($data = fread($handle, filesize($file_tmp))) {
                  if (!xml_parse($parser, $data, feof($file_tmp))) {
                     echo "XML Error: ".xml_error_string(xml_get_error_code($parser));
                     echo " at line ".xml_get_current_line_number($parser);
                     break;   
                  }
               
               }
               xml_parser_free($parser);
               //chech errors

               $list = simplexml_load_file($file_tmp);
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
      }

      //for alter sources in form input
      /*if(($formData['file_link']) || ($formData['file_code'])) {

      }*/
      
      return $workers;

	}

   /*
      parse function for xml
   */
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

   /*
      parse function for csv
   */
   protected function isCSV($list) {

      $items = array();
      $items_keys = array('fname', 'lname', 'mname', 'birth_date', 'comment');

      foreach($list as $item) {
         $items[] = array_combine($items_keys, explode(';', $item[0]));
         
      }
      
      return $items;
   }

   /*
      parse function for 
      other format
   */
	/*protected function isFormat() {
         
         same code
	}*/
}
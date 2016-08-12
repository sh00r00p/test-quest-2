<?php

/*ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);*/

//if(isset($_POST['submit'])) {
  if(isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $data = $_POST;
    $formData = array_merge($file, $data);

    require_once __DIR__ . '/helper.php';

    $class = new Parser();
    $list = $class->parseData($formData);
  }
//}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Simple PHP class for parse XML, CSV files</title>
    <style type="text/css" media="screen">
      .workers {
        width: 100%;
        border: 1px solid #000;
        border-collapse: collapse;
      } 
      .workers td {
        padding: 5px;
        border: 1px solid #000;
      }
      .workers th {
        text-align: left;
        background: #ccc;
        padding: 5px;
        border: 1px solid #000;
      }
      .header { text-align: center; }
      body { font-family: sans-serif; }
    </style>
  </head>
  <body>
    <?php if(isset($list)) : ?>
      <div class="table">
        <p class="header"><?php echo 'Полученные из источника данные необходимо выводить на страницу в виде таблицы.©'; ?></p>
        <table class="workers">
          <tr>
            <th>First name</th>
            <th>Last name</th>
            <th>Middle name</th>
            <th>Birth date</th>
            <th>Comment</th>
          </tr>
          <?php foreach($list as $value) : 
            
                  foreach($value as $item) : ?>
                    
                    <td><?php echo $item; ?></td>
          
                  <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
        </table>
      </div>
      <div class="new"><p><a href="/">Upload new file</a></p></div>
    <?php else : ?>
    <div class="form">
      <form id="upload" action="" method="post" enctype="multipart/form-data">
        <div class="fieldlist">
          <div class="field">
            <label>Upload file:</label>
            <input type="file" name="file">
          </div>
          <!--div class="field">
            <label>Change format:</label>
              <input type="checkbox" name="format" value="xml">XML
              <input type="checkbox" name="format" value="csv">CSV
          </div-->
          <input type="submit" name="submit" value="Submit">
        </div>
      </form>
    </div>
  <?php endif; ?>
  </body>
</html>
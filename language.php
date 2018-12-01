<!DOCTYPE html>
<html>
<head>
	<title>Get Language File</title>
</head>
<body>
<form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
 <select class="form-control" id="sel2" name="language">
        <option value="english">English</option>
        <option value="german">German</option>        
      </select>
    <input type="submit" name="submit">
</form>
</body>
</html>


<?php

if (isset($_POST['language'])) {
$language = $_POST['language'];
$file_name =  ucfirst($language);
//echo $file_name;
read_excel($file_name);
//create_excel($file_name);
}

function create_excel($file_name){
require ('PHPExcel/Classes/PHPExcel.php');
require ('PHPExcel/Classes/PHPExcel/IOFactory.php');
require ('PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');

require('languages/'.$file_name.'.php');
//ob_start();
$objPHPExcel= new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getProperties()->setCreator("languages");
$objPHPExcel->getActiveSheet()->setTitle('English Language');
$objPHPExcel->getActiveSheet()->setCellValue('A1','KEY');
$objPHPExcel->getActiveSheet()->setCellValue('B1','VALUE');

$row = 2;
foreach ($lang as $key => $value) {
// echo $row;
// echo 'Key ' . $key . '   Value'.$value.'<br/>';
$objPHPExcel->getActiveSheet()->SetCellValue('A'.$row,$key);
$objPHPExcel->getActiveSheet()->SetCellValue('B'.$row,$value);
$row++;
}

$filename=$file_name.'.xlsx'; //save our workbook as this file name
//if you want to save it as .XLSX Excel 2007 format
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007'); 
ob_end_clean();
header('Content-Type:application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
            
 
//force user to download the Excel file without writing it to server's HD
$objWriter->save('php://output');

}

//read_excel function
function read_excel($file_name){

require ('PHPExcel/Classes/PHPExcel.php');
require ('PHPExcel/Classes/PHPExcel/IOFactory.php');
require ('PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');

	// $upload_path = 'urstarter/languages/';
       
 //       	$file = $file_name.'.xlsx';   
        $input_file ='languages/'.$file_name.'.xlsx';
       
        // echo "<a href='$input_file'>click</a>";
        $inputFileType = PHPExcel_IOFactory::identify($input_file);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($input_file); 
        $worksheet = $objPHPExcel->getSheet(0);      
        $lastRow = $worksheet->getHighestRow();        
        
       $lang = array();
      for($row=2; $row<$lastRow; $row++) {
        $key  = $worksheet->getCell('A'.$row)->getValue();
        $value = $worksheet->getCell('B'.$row)->getValue();
        $lang[$key] = $value;
        //echo $key . '' . $value ; 
        //echo '<br />';
        //$lang['.$key.'] = $value;
      }
      //echo count($lang);
    //echo '<pre>';
   // // var_dump($lang);
   //  echo $lang['lang_type'];
   //  echo '<br>';
   return $lang;    
}//read_excel ends here




?>
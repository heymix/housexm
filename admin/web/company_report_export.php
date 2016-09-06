<?php
include '../config/config.php';
$name = $_GET["name"];
$id = $_GET["id"];
$tel = $_GET["tel"];

$checkTimeStart = $_GET["checkTimeStart"];
$checkTimeEnd = $_GET["checkTimeEnd"];
$endPriceTimeStart = $_GET["endPriceTimeStart"];
$endPriceTimeEnd = $_GET["endPriceTimeEnd"];

$employeeTel = $_GET["employeeTel"];
$checkStatus = $_GET["checkStatus"];
$housePrice = $_GET["housePrice"];
$companyName = $_GET["companyName"];
$trueName = $_GET["trueName"];
$projectName = $_GET["projectName"];
$priceStatus = $_GET["priceStatus"];
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '../../Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '公司')
            ->setCellValue('B1', '佣金')
            ->setCellValue('C1', '已结')
            ->setCellValue('D1', '未结');





mysql_select_db($db_name, $con);          //选择数据库
mysql_query($char_set);

$sqlKey="";
$searchStr = $_SERVER["QUERY_STRING"];

if (strpos($searchStr,"&")>0){
    $searchStr= substr($searchStr,strpos($searchStr,"&"),strlen($searchStr));
}else{
    $searchStr="";
}



if ($endPriceTimeStart!=""){
    $sqlKey .= " and t.`end_price_time` >= DATE_FORMAT('$endPriceTimeStart','%Y-%m-%d 00:00:00')";
}

if ($endPriceTimeEnd!=""){
    $sqlKey .= " and t.`end_price_time` <= DATE_FORMAT('$endPriceTimeEnd','%Y-%m-%d 00:00:00')";
}



$yjKey="";
if($priceStatus!=""){
    $sqlKey .= " and t.`price_status` = '$priceStatus'";
    if($priceStatus==1){
        $yjKey .= " and (yj.`price_status` = 1 or yj.`price_status` is null)";
    }

    if($priceStatus==2){
        $yjKey .= " and yj.`price_status` = 2 ";
    }
}

if($companyName!=""){
    $sqlKey .= " and c.`name` like '%$companyName%'";
}


if($_SESSION["companyId"]!=0){
    $sqlKey .= " and e.`company_id` = '".$_SESSION['companyId']."'";
}

$Query = "SELECT sum(price) as price_sum,c.name as company_name
,(select count(*) from t_client as yj where yj.employee_id=t.employee_id and yj.price_status=2 $yjKey) as price_status_is
,(select count(*) from t_client as yj where yj.employee_id=t.employee_id and (yj.price_status=1 or yj.price_status is null) $yjKey) as price_status_not
FROM t_client as t 
left join t_employee as e on t.employee_id=e.id 
left join t_company as c on e.company_id=c.id
where t.is_del=0 $sqlKey group by e.company_id";

                //SQL查询语句
mysql_query($char_set);
$rs = mysql_query($Query, $con);                     //获取数据集
//echo $q;
if(!$rs){die("Valid result!");}

$i=1;
while($row = mysql_fetch_array($rs)) {
    $i=$i+1;
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue("A$i", $row['company_name'])
    ->setCellValue("B$i", $row['price_sum'])
    ->setCellValue("C$i", $row['price_status_is'])
    ->setCellValue("D$i", $row['price_status_not']);
}

mysql_close($con);
// Miscellaneous glyphs, UTF-8


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('公司统计');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename='company_report".time().".xls'");
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

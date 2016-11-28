<?php
include '../config/config.php';
$name = $_GET["name"];
$id = $_GET["id"];

$userName=$_GET['userName'];
$trueName=$_GET['trueName'];
$companyName=$_GET['companyName'];
$address=$_GET['address'];
$tel=$_GET['tel'];
$parentName=$_GET['parentName'];
$wechat=$_GET['wechat'];
$userId=$_GET['userId'];
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
            ->setCellValue('A1', '编号')
            ->setCellValue('B1', '推荐人编号')
            ->setCellValue('C1', '用户名')
            ->setCellValue('D1', '姓名')
            ->setCellValue('E1', '性别')
            ->setCellValue('F1', '身份证号')
            ->setCellValue('G1', '独立/渠道公司名')
            ->setCellValue('H1', '电话')
            ->setCellValue('I1', '微信号')
            ->setCellValue('J1', '备注');





mysql_select_db($db_name, $con);          //选择数据库
mysql_query($char_set);

$sqlKey="";
$searchStr = $_SERVER["QUERY_STRING"];

if (strpos($searchStr,"&")>0){
    $searchStr= substr($searchStr,strpos($searchStr,"&"),strlen($searchStr));
}else{
    $searchStr="";
}
if ($userName!=""){
    $sqlKey .= " and e.`user_name` like '%$userName%'";
}
if($trueName!=""){
    $sqlKey .= " and e.`true_name` like '%$trueName%'";
}
if($companyName!=""){
    $sqlKey .= " and c.`name` like '%$companyName%'";
}
if($tel!=""){
    $sqlKey .= " and e.`tel` like '%$tel%'";
}
if($wechat!=""){
    $sqlKey .= " and e.`wechat` like '%$wechat%'";
}

if($parentName!=""){
    $sqlKey .= " and ep.`true_name` like '%$parentName%'";
}

if($userId!=""){
    $sqlKey .= " and e.`user_id` like '%$userId%'";
}


if($_SESSION['channel'] == "1"){

    if(checkPower("17")){
        $sqlKey .= " and e.`company_id` = '".$_SESSION['companyId']."'";
    }

}else{

    if(checkPower("17")){
        $sqlKey .= " and e.`company_id` = '".$_SESSION['companyId']."'";
        $sqlKey .= " and (e.`id` = '". $_SESSION['userId']."' or e.`parent_id` = '".$_SESSION['userId']."')";
    }
}


$sql = "select e.*,c.name as company_name,ep.true_name as parent_name from t_employee e 
            left join t_company c on e.company_id=c.id 
            left join t_employee ep on e.parent_id=ep.id
            where e.is_del=0 $sqlKey order by e.id desc";

                //SQL查询语句
mysql_query($char_set);

$rs = mysql_query($sql, $con);                     //获取数据集
//echo $q;
if(!$rs){die("Valid result!");}

$i=1;
while($row = mysql_fetch_array($rs)) {
    $i=$i+1;
    if ($row['parent_id']<>0){
        $parentNameStr=$row['parent_name']."(".$row['parent_id'].")";
    }else{
        $parentNameStr="";
    }
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue("A$i", $row['id'])
    ->setCellValue("B$i", $parentNameStr)
    ->setCellValue("C$i", $row['user_name'])
    ->setCellValue("D$i", $row['true_name'])
    ->setCellValue("E$i", $row['sex'])
    ->setCellValue("F$i", $row['user_id'])
    ->setCellValue("G$i", $row['company_name'])
    ->setCellValue("H$i", $row['tel'])
    ->setCellValue("I$i", $row['wechat'])
    ->setCellValue("J$i", $row['remark']);
}

mysql_close($con);
// Miscellaneous glyphs, UTF-8


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('经纪人统计');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename='employee_report".time().".xls'");
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

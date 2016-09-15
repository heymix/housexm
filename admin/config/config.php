<?php
session_start();
//var_dump($_SESSION);
if (!isset($_SESSION["userName"])){
    //重定向浏览器
    header("Location: ../index.php");
    exit;
}


//数据库相关设置
include '../config/conn.php';







//截取字符串
	function sysSubStr($String,$Length,$Append = false){   
		
		if (strlen($String) <= $Length ){   
			return $String;   
		}   
		else  
		{   
			$I = 0;   
		while ($I < $Length){   
		
			$StringTMP = substr($String,$I,1);   
			
		if ( ord($StringTMP) >=224 ){   
			
			$StringTMP = substr($String,$I,3);   
			
		$I = $I + 3;   
		}   
		elseif( ord($StringTMP) >=192 ){   
			
			$StringTMP = substr($String,$I,2);   
		
			$I = $I + 2;   
		}   
		else  
		{   
		
			$I = $I + 1;   
		}   
			$StringLast[] = $StringTMP;   
		}   
		
			$StringLast = implode("",$StringLast);   
		if($Append){   
		
			$StringLast .= "...";   
		}   
		return $StringLast;   
		}   
	}   
	//截取字符串结束
	
	
	
function postArr($Arr){
	
	$str ='';
	if (is_array($Arr)) {
	    $str =',';
		foreach($Arr as $var)//通过foreach循环取出多选框中的值
		{
		$str=$str.$var.",";
		}
		
	
	}
	return $str;
	
}

function cut_str($string, $sublen, $start = 0, $code = 'UTF-8')
{
    if($code == 'UTF-8')
    {
        $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
        preg_match_all($pa, $string, $t_string);
        if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen));
        return join('', array_slice($t_string[0], $start, $sublen));
    }
    else
    {
        $start = $start*2;
        $sublen = $sublen*2;
        $strlen = strlen($string);
        $tmpstr = '';
        for($i=0; $i< $strlen; $i++)
        {
            if($i>=$start && $i< ($start+$sublen))
            {
                if(ord(substr($string, $i, 1))>129)
                {
                    $tmpstr.= substr($string, $i, 2);
                }
                else
                {
                    $tmpstr.= substr($string, $i, 1);
                }
            }
            if(ord(substr($string, $i, 1))>129) $i++;
        }
        //if(strlen($tmpstr)< $strlen ) $tmpstr.= "...";
        return $tmpstr;
    }
}

function checkPower($str){
    $strArr=explode(",",$str);
    $returnStr = false;
    foreach ($strArr as $v){
        if(strpos($_SESSION['power'], ",$v,")!==false){
            $returnStr = true;
            break;
        }
    }
    return $returnStr;
}
?>

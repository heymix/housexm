/*****
 * 密码强度计算机密码字符规则校验
 * **/
/**表单验证全局变量*/
 var accountFlag = false;
 var pwdFlag = false;
 var pwdConfFlag = false;
 var nameFlag = false;
 var numCardFlag = false;
 var vdFlage = false;
 var passwd;
 function pwdSafeLevel() {
     passwd=$('#pwd').val();
     var min_passwd_len = 6;  
     //var host = window.document.location.host;
     var pathName=window.document.location.pathname;
     var serverName = "";
     var projectName=pathName.substring(0,pathName.substr(1).indexOf('/')+1);
     if(projectName!="" && projectName=="/account"){
    	 serverName = projectName;
     }
     //var path = host+serverName;
     if (passwd.length>=min_passwd_len)  {
       var rating = checkPasswdRate(passwd);  
        switch(rating){
    	case 0:
    		//$('#pwdSafeLevel').css('display',' ');
    		$("#pwdSafeLevel").attr("style",{"display":""});
    		$('#pwdSafeLevel').html('<img src='+serverName+'/images/gr_aq0.jpg>');
    		break;
    	case 1:
    		$("#pwdSafeLevel").attr("style",{"display":""});
    		$('#pwdSafeLevel').html('<img src='+serverName+'/images/gr_aq1.jpg>');
    		break;
    	case 2:
    		$("#pwdSafeLevel").attr("style",{"display":""});
    		$('#pwdSafeLevel').html('<img src='+serverName+'/images/gr_aq2.jpg>');
    		break;
    	case 3:
    		$("#pwdSafeLevel").attr("style",{"display":""});
    		$('#pwdSafeLevel').html('<img src='+serverName+'/images/gr_aq3.jpg>');
    		break;
    	
    }   
  }else{
	  	$("#pwdSafeLevel").attr("style",{"display":""});
		$('#pwdSafeLevel').html('<img src='+serverName+'/images/gr_aq0.jpg>');
  }
}
   
   /**密码校验*/
function chk1(){
   		var pwd =$('#pwd').val();
		if(pwd==$('#userName').val())
	     {
	       $('#pwdTip').html('<nobr>对不起,用户名和密码不能相同.</nobr>').addClass('onerror');
		   return false;
	    }
   		var reg = new RegExp("^[0-9a-zA-Z]{6,10}$");
	   		if(pwd != null && pwd.length>0){
	   			if(reg.test(pwd)){
	   				  $('#pwdTip').removeClass();
                      $('#pwdTip').html('<nobr>密码可以使用.</nobr>').addClass('onSuccess');
	   			}else{
	   			
	   			     $('#pwdTip').removeClass();
                     $('#pwdTip').html('<nobr>由6-10位英文字母及数字组成！</nobr>').addClass('onerror');
	   			}
	   		}else{
	   				
	   			    $('#pwdTip').removeClass();
                    $('#pwdTip').html('<nobr>请输入密码.</nobr>').addClass('onerror');
	   		}
	   		
} 

function checkLength(){
	if(!$('#safetyPwd')) return false;
    passwd=$('#safetyPwd').val();
    var min_passwd_len = 6;  
    var max_passwd_len = 30;
    if(passwd.length > max_passwd_len){
    	alert("长度不能超过"+max_passwd_len+"位！");
    	return false;
    }
}

 function CreateRatePasswdReq1() {
    if (!isBrowserCompatible) {
      return;
    }

   // if(!document.getElementById) return false;
   // var pwd = document.getElementById("pwd");
    if(!$('#pwd')) return false;    
    passwd=$('#pwd').val();
    var min_passwd_len = 6;  
    var max_passwd_len = 30;
    if (passwd.length < min_passwd_len){
      if (passwd.length > 0) {
        //DrawBar(0);
        pwdLevel(0);
      }else {
        //ResetBar();
//    	$("#pwdSafeLevel").attr('style',{'display':'none'});
    	  $("#pwdSafeLevel").css("display","none");
    	$("#pwdSafeLevel").removeAttr("style");
    	return false;
      }
    }else {
    	if(passwd.length > max_passwd_len){
        	alert("密码长度不能超过30位！");
        	return false;
        }
       rating = checkPasswdRate(passwd);
       pwdLevel(rating);
       //DrawBar(rating);
    }
    pwdSafeLevel();
}

  function CreateRatePasswdReq(pwd) {
    if (!isBrowserCompatible) {
     return;
    }
    if(!document.getElementById) return false;
    var pwd = document.getElementById("pwd");
    if(!pwd) return false;  
    passwd=pwd.value;
  var min_passwd_len = 6;  
    if (passwd.length < min_passwd_len)  {
      if (passwd.length > 0) {
        DrawBar(0);
      } else {
        ResetBar();
      }
    } else {
    // We need to escape the password now so it won't mess up with length test
       rating = checkPasswdRate(passwd);
       DrawBar(rating);
    }
}


  function DrawBar(rating) {
    var posbar = document.getElementById('posBar');
    var negbar = document.getElementById('negBar');
    var passwdRating = document.getElementById('passwdRating');
    var barLength = document.getElementById('passwdBar').width;
    if (rating >= 0 && rating <= 4) {  //We successfully got a rating
      posbar.style.width = barLength / 4 * rating + "px";
      negbar.style.width = barLength / 4 * (4 - rating) + "px";
    } else {
      posbar.style.width = "0px";
      negbar.style.width = barLength + "px";
      rating = 5; // Not rated Rating
    }
    //密码强度
    var strongLevel = document.getElementById('strongLevel');
    switch(rating){
    	case 0:
    		strongLevel.value = 0;
    		break;
    	case 1:
    		strongLevel.value = 0;
    		break;
    	case 2:
    		strongLevel.value = 10;
    		break;
    	case 3:
    		strongLevel.value = 20;
    		break;
    	case 4:
    		strongLevel.value = 20;
    		break;
    }
    posbar.style.background = barColors[rating];
    passwdRating.innerHTML = "<font color='" + ratingMsgColors[rating] +"'>" + ratingMsgs[rating] + "</font>";

}

  function pwdLevel(rating){
	  //密码强度
	    var strongLevel = document.getElementById('strongLevel');
	    switch(rating){
	    	case 0:
	    		strongLevel.value=0;
	    		break;
	    	case 1:
	    		strongLevel.value =0;
	    		break;
	    	case 2:
	    		strongLevel.value =10;
	    		break;
	    	case 3:
	    		strongLevel.value =20;
	    		break;
	    	case 4:
	    		strongLevel.value =30;
	    		break;
	    }
  }

  //Resets the password strength bar back to its initial state without any message showing.
  function ResetBar() {
    var posbar = document.getElementById('posBar');
    var negbar = document.getElementById('negBar');
    var passwdRating = document.getElementById('passwdRating');
    var barLength = document.getElementById('passwdBar').width;
    posbar.style.width = "0px";
    negbar.style.width = barLength + "px";
    passwdRating.innerHTML = "";
  }

  /* Checks Browser Compatibility */
  var agt = navigator.userAgent.toLowerCase();
  var is_op = (agt.indexOf("opera") != -1);
  var is_ie = (agt.indexOf("msie") != -1) && document.all && !is_op;
  var is_mac = (agt.indexOf("mac") != -1);
  var is_gk = (agt.indexOf("gecko") != -1);
  var is_sf = (agt.indexOf("safari") != -1);
  function gff(str, pfx) {
    var i = str.indexOf(pfx);
    if (i != -1) {
      var v = parseFloat(str.substring(i + pfx.length));
      if (!isNaN(v)) {
      return v;
      }
    }
    return null;
  }
  
function Compatible() {
    if (is_ie && !is_op && !is_mac) {
      var v = gff(agt, "msie ");
      if (v != null) {
        return (v >= 6.0);
      }
    }
    if (is_gk && !is_sf) {
      var v = gff(agt, "rv:");
      if (v != null) {
         return (v >= 1.4);
      } else {
         v = gff(agt, "galeon/");
         if (v != null) {
           return (v >= 1.3);
         }
      }
    }
    if (is_sf) {
      var v = gff(agt, "applewebkit/");
      if (v != null) {
        return (v >= 124);
      }
    }
    return false;
  }
  /* We also try to create an xmlhttp object to see if the browser supports it */
var isBrowserCompatible = Compatible();

	//CharMode函数  
	//测试某个字符是属于哪一类.  
function CharMode(iN){  
	if (iN>=48 && iN <=57) //数字  
		return 1;  
	if ((iN>=65 && iN <=90)||(iN>=97 && iN <=122)) //大写字母  
		return 2;  
	else  
	    return 4; //特殊字符  
	//if (iN>=97 && iN <=122) //小写  -->
	//	return 4; 
	
	}  
//bitTotal函数  
//计算出当前密码当中一共有多少种模式  
	function bitTotal(num){  
		modes=0;  
		for (i=0;i<4;i++){  
			if (num & 1) 
				modes++;  
			num>>>=1;  
			}  
		return modes;  
	}  
//checkStrong函数  
//返回密码的强度级别  
	function checkPasswdRate(sPW){  
		if (sPW.length<=4)  
			return 0; //密码太短  
		Modes=0;  
		for (i=0;i<sPW.length;i++){  
		//测试每一个字符的类别并统计一共有多少种模式.  
			Modes|=CharMode(sPW.charCodeAt(i));  
		}  
		return bitTotal(Modes);  
	}
	
	
	//验证二级密码
	function checkSaftPwd(){
		var pwdValue= $('#safetyPwd').val();	
		//首先判断密码 是否 是连续相同的字符或者字母
		if(checkSame(pwdValue)){
		   return false;
		}
		return true;
	}
	
//验证密码是否是连续的字符或者数字 以
function checkDict(){
		var pwdValue= $('#pwd').val();	
		//首先判断密码 是否 是连续相同的字符或者字母
		if(checkSame(pwdValue)){
		   return false;
		}
		//检查密码是否是社会工程字典中的密码
		//var lvDicts=new Array("012345","123456","234567","345679","12345678","123456789","asdf","qwer","zxcv","654321","123123");    
	    //for(var i=0;i<lvDicts.length;i++)
		//{
		//	if(lvDicts[i]==pwdValue)
		//	{
		//	   return false;
		//	}
	    //
		CreateRatePasswdReq1();
		return true;
	}
	//判断是不是连续相同的字符 
function checkSame(s){
	var lvLastChar=s.substring(0,1);
	for(var i=1;i<s.length;i++)
	{
		var c=s.substring(i,i+1);
		if(c!=lvLastChar)
		{
		
		  return false;
		}
	
	}	
	return true;
}
/*********密码强度end********/	
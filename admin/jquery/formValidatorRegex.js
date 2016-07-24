var regexEnum = 
{
	intege:"^-?[1-9]\\d*$",					//整数
	intege1:"^[0-9]\\d*$",					//正整数
	intege2:"^-[1-9]\\d*$",					//负整数
	num:"^([+-]?)\\d*\\.?\\d+$",			//数字
	num1:"^[1-9]\\d*|0$",					//正数（正整数 + 0）
	num2:"^-[1-9]\\d*|0$",					//负数（负整数 + 0）
	decmal:"^([+-]?)\\d*\\.\\d+$",			//浮点数
	decmal1:"^[1-9]\\d*.\\d*|0.\\d*[1-9]\\d*$", 	//正浮点数
	decmal2:"^-([1-9]\\d*.\\d*|0.\\d*[1-9]\\d*)$",  //负浮点数
	decmal3:"^-?([1-9]\\d*.\\d*|0.\\d*[1-9]\\d*|0?.0+|0)$",  //浮点数
	decmal4:"^[1-9]\\d*.\\d*|0.\\d*[1-9]\\d*|0?.0+|0$",  //非负浮点数（正浮点数 + 0）
	decmal5:"^(-([1-9]\\d*.\\d*|0.\\d*[1-9]\\d*))|0?.0+|0$", //非正浮点数（负浮点数 + 0）

	email:"^\\w+((-\\w+)|(\\.\\w+))*\\@[A-Za-z0-9]+((\\.|-)[A-Za-z0-9]+)*\\.[A-Za-z0-9]+$", //邮件
	color:"^[a-fA-F0-9]{6}$",				//颜色
	url:"^http[s]?:\\/\\/([\\w-]+\\.)+[\\w-]+([\\w-./?%&=]*)?$",	//url
	chinese:"^[\\u4E00-\\u9FA5\\uF900-\\uFA2D]+$",					//仅中文
	ascii:"^[\\x00-\\xFF]+$",				//仅ACSII字符
	zipcode:"^\\d{6}$",						//邮编
	mobile:"^(13|15|18)[0-9]{9}$",				//手机
	ip4:"^(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)\\.(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)\\.(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)\\.(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)$",	//ip地址
	notempty:"^\\S+$",						//非空
	picture:"(.*)\\.(jpg|bmp|gif|ico|pcx|jpeg|tif|png|raw|tga)$",	//图片
	rar:"(.*)\\.(rar|zip|7zip|tgz)$",								//压缩文件
	date:"^\\d{4}(\\-|\\/|\.)\\d{1,2}\\1\\d{1,2}$",					//日期
	qq:"^[1-9]*[1-9][0-9]*$",				//QQ号码
	tel:"^(([0\\+]\\d{2,3}-)?(0\\d{2,3})-)?(\\d{7,8})(-(\\d{3,}))?$",	//电话号码的函数(包括验证国内区号,国际区号,分机号)
	//username:"^\\w+$",						//用来用户注册。匹配由数字、26个英文字母或者下划线组成的字符串
	username:"^[0-9a-zA-Z@._-]{6,30}$",		//字母数字@+-_.
	msn:"/^\w+@hotmail\.com$/ig",
	letter:"^[A-Za-z]+$",					//字母
	letter_u:"^[A-Z]+$",					//大写字母
	letter_l:"^[a-z]+$",					//小写字母
	letter_3:"^[A-Za-z0-9]+$",					//字母和数字组合
	letter_5:"^[a-zA-Z0-9]+",                   //字母或数字组合 
	idcard:"/(^\d{15}$)|(^\d{17}(\d|X|x)$)",	//身份证 /(^\d{15}$)|(^\d{17}(\d|X|x)$)/;
	name:"^([\u4E00-\u9FA5A-Za-z]{2,5}|[a-zA-Z\\s.]{6,20})$",//中文英文2-5、或英文6-20、英文允许空格或.相隔
	bankcard:"^([0-9]*)$",                     //银行卡号
	question:"^([\u4e00-\u9fa5]+|([a-z]+\s?)+)$", //安全问题答案
	//由于游戏密码验证问题，临时去掉&符号
	pwd:"^[0-9a-zA-Z!@#$%^*()_-]{6,30}$",////数字字母shift1至shift9和-_
	valitecode:"^[a-z0-9]{4,6}$",
	questiondate:"^(([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3})(((0[13578]|1[02])(0[1-9]|[12][0-9]|3[01]))|((0[469]|11)(0[1-9]|[12][0-9]|30))|(02(0[1-9]|[1][0-9]|2[0-8]))))|((([0-9]{2})(0[48]|[2468][048]|[13579][26])|((0[48]|[2468][048]|[3579][26])00))0229)$"
}

function ckRealName(){
  	var name = $('#trueName').val();
  	if((/^[\u4e00-\u9fa5]+$/).test(name) && name.length>=2 && name.length<=5){    
    		return true;	
   }else if((/^[A-Za-z]+$/).test(name) && name.length>=6&&name.length<=20){
    		return true;
    }else{
    	return false;
    }
}

function isCardID(idcard){
      var Errors=new Array("验证通过！","身份证号码位数不对！","身份证号码出生日期超出范围或含有非法字符！","身份证号码校验错误！","身份证地区非法！","未成年用户不能注册！","身份证号码效验错误，如号码包含英文请用大写");  
      var area={11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江",31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏",61:"陕西",62:"甘肃",63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外"}  
      var idcard,Y,JYM;  
      var S,M;  
      var idcard_array = new Array();
      idcard_array = idcard.split("");
      
      //未成年人年龄设置
      var age = 0;
      var date_now = new Date();
      var year =date_now.getFullYear();
      var month = (date_now.getMonth()+1);
      var date = date_now.getDate();
      if(idcard.length > 14 && idcard.length < 19){
    	  if(area[parseInt(idcard.substr(0,2))]==null) return Errors[4]; 
    	  switch(idcard.length){
	          case 15:  

	        	  //特殊处理
	        	  if(idcard=="111111111111111"){
	        		  return Errors[3];
	        	  }
	        	  //是否为成年人
	            if(year - (1900+parseInt(idcard.substr(6,2))) < age){
		  	    	  return Errors[5];
		  	      }else if(year - (1900+parseInt(idcard.substr(6,2))) == age){
		  	    	  if(month - (idcard.substr(8,2)) < 0){
		  	    		  return Errors[5];
		  	    	  }else if(month - (idcard.substr(8,2)) == 0){
		  	    		  if(date - (idcard.substr(10,2)) <= 0){
		  	    			  return Errors[5];  
		  	    		  }
		  	    	  }
		  	      }
	            if ((parseInt(idcard.substr(6,2))+1900) % 4 == 0 || ((parseInt(idcard.substr(6,2))+1900) % 100 == 0 && (parseInt(idcard.substr(6,2))+1900) % 4 == 0 )){  
	              ereg = /^[1-9][0-9]{5}[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))[0-9]{3}$/;//测试出生日期的合法性  
	            }else{  
	              ereg = /^[1-9][0-9]{5}[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))[0-9]{3}$/;//测试出生日期的合法性  
	            }  
	            if(ereg.test(idcard)){  
	              return true;//Errors[0];  
	            }else{ 
	              return Errors[2];
	            }
	          break;  
	        case 18:  
	      	  
	          if ( parseInt(idcard.substr(6,4)) % 4 == 0 || (parseInt(idcard.substr(6,4)) % 100 == 0 && parseInt(idcard.substr(6,4))%4 == 0 )){  
	          	ereg = /^[1-9][0-9]{5}19[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))[0-9]{3}[0-9Xx]$/;//闰年出生日期的合法性正则表达式  
	          }else{  
	          	ereg = /^[1-9][0-9]{5}19[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))[0-9]{3}[0-9Xx]$/;//平年出生日期的合法性正则表达式  
	          }
	         
	          if((/^[a-z]+$/).test(idcard.substr(17,18))){
	        	  return Errors[6];
	          }
	          if(ereg.test(idcard)){  
	            S = (parseInt(idcard_array[0]) + parseInt(idcard_array[10])) * 7 + (parseInt(idcard_array[1]) + parseInt(idcard_array[11])) * 9 + (parseInt(idcard_array[2]) + parseInt(idcard_array[12])) * 10 + (parseInt(idcard_array[3]) + parseInt(idcard_array[13])) * 5 + (parseInt(idcard_array[4]) + parseInt(idcard_array[14])) * 8 + (parseInt(idcard_array[5]) + parseInt(idcard_array[15])) * 4 + (parseInt(idcard_array[6]) + parseInt(idcard_array[16])) * 2 + parseInt(idcard_array[7]) * 1 + parseInt(idcard_array[8]) * 6 + parseInt(idcard_array[9]) * 3 ;  
	            Y = S % 11;  
	            M = "F";  
	            JYM = "10X98765432";  
	            M = JYM.substr(Y,1);  
	            if(M == idcard_array[17]){
	            	//是否为成年人
		  	  	      if((year - parseInt(idcard.substr(6,4))) < age){
		  	  	    	  return Errors[5];
		  	  	      }else if((year - parseInt(idcard.substr(6,4))) == age){
		  	  	    	  if(month - (idcard.substr(10,2)) < 0){
		  	  	    		  return Errors[5];
		  	  	    	  }else if(month - (idcard.substr(10,2)) == 0){
		  	  	    		  if(date - (idcard.substr(12,2)) < 0){
		  	  	    			  return Errors[5];  
		  	  	    		  }
		  	  	    	  }
		  	  	      }
	              return true;//Errors[0];  
	            }else{ 
	              return Errors[3];
	            }  
	          }else{ 
	            return Errors[2];
	          }  
	          break;  
	        default:  
	          return Errors[1];  
	          break;  
	       } 
      }else{
    	  return Errors[1]; 
      }
       
    } 



    function error(obj){
        alert(checkIdcard(obj.value))
    }




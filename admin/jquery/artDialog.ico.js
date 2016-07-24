	function alertWin(ico,title,con){
    $.dialog({			lock:true,
						title: title,
						content:'<img src="/jquery/skins/icons/'+ico+'.png" width="48" height="48"style="vertical-align:middle;" />'+con
					});
    
    }
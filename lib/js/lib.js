(function(){
	
	var $$={};
	
	$$.event = {
		add:function(t, m, f){
			
			//other Browser
			if (t.addEventListener){
				t.addEventListener(m, f, false);
			}
			
			//IE
			else{
				if(m=='load'){
					var d = document.body;
					if(typeof(d)!='undefined'){d = window;}
					
					if((typeof(onload)!='undefined' && typeof(d.onload)!='undefined' && onload == d.onload) || typeof(eval(onload))=='object'){
						t.attachEvent('on' + m, function() { f.call(t , window.event); });
					}
					else{
						f.call(t, window.event);
					}
				}
				else{
					t.attachEvent('on' + m, function() { f.call(t , window.event); });
				}
			}
		}
	};
	
	window.$LIB = $$;
	
	return $$;
})();
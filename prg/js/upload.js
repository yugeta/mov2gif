(function(){
	var $$={}
	
	$$.set=function(){
		
		var upload_button = document.getElementsByClassName("upload-button");
		for(var i=0;i<upload_button.length;i++){
			$$.event.add(upload_button[i],"click",$$.upload_click);
		}
		
		var upload_form = document.getElementsByClassName("upload-form");
		for(var i=0;i<upload_form.length;i++){
			$$.event.add(upload_form[i],"change",$$.upload_change);
		}
		
		var upload_submit = document.getElementsByClassName("upload-submit");
		for(var i=0;i<upload_submit.length;i++){
			$$.event.add(upload_submit[i],"click",$$.upload_submit);
		}
	};
	
	$$.upload_click=function(){
		var upload_form = document.getElementsByClassName("upload-form")[0];
		upload_form.click();
	};
	
	$$.upload_change=function(){
		var upload_value = document.getElementsByClassName("upload-value");
		for(var i=0;i<upload_value.length;i++){
			upload_value[i].innerHTML = this.value;
		}
	};
	
	$$.upload_submit=function(){
		
		//送信データチェック
		var upload_form = document.getElementsByClassName("upload-form")[0];
		if(!upload_form.value){alert("ファイルが選択されていません。");return;}
		
		//拡張子チェック
		if(!upload_form.value.match(/\.mov$/)){
			alert("mov以外の拡張子はアップできません。");
			return;
		}
		
		//送信処理
		if(!confirm("ファイルをアップロードしてよろしいですか？")){return}
		this.form.submit();
	};
	
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
	
	$$.event.add(window,"load",$$.set);
	return $$;
})();
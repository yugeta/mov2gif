<?php


$index = new libIndex();

$index->index();



class libIndex{
	// Main-template-file view
	function index(){
		// read - module
		
		$this->loadLib();
		
		$libView = new libView();
		
		//php-proc
		if($_REQUEST['php'] && is_file("prg/php/".$_REQUEST['php'].".php")){
			require_once "prg/php/".$_REQUEST['php'].".php";
		}
		
		//template-view
		$html = explode("\n",file_get_contents("lib/html/common.html"));
		for($i=0;$i<count($html);$i++){
			
			$view = "";
			$view = $libView->checkTplLine($html[$i]);
			echo $view."\n";
			//echo $html[$i];
		}
		
	}
	/*
	// template-line check
	function checkTplLine($line){
		
		$libView = new libView();
		
		
		
		return $line;
	}
	*/
	
	// loadLibrary
	function loadLib(){
		
		//基本モジュールの読み込み
		$libs = scandir("lib/php");
		for($i=0,$c=count($libs);$i<$c;$i++){
			if(!preg_match("/\.php$/",$libs[$i])){continue;}
			//include処理
			require_once "lib/php/".$libs[$i];
		}
	}
	
	
	
}

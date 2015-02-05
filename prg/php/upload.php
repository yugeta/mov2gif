<?php

$upload = new UPLOAD();
$upload->index();

class UPLOAD{
	
	function index(){
		/*
		//ファイル情報の表示（デバッグ）
		echo $_FILES['upload_file']['name']."<br>";
		echo $_FILES['upload_file']['type']."<br>";
		echo $_FILES['upload_file']['size']."<br>";
		echo $_FILES['upload_file']['tmp_name']."<br>";
		echo $_FILES['upload_file']['error']."<br>";
		*/
		
		//拡張子を取得
		$ext = $this->getExtention($_FILES['upload_file']['name']);
		
		if($ext!="mov"){die("mov以外の拡張子は使用できません。");}
		
		//ファイル名を取得
		$datetime = date('YmdHis');
		
		//データフォルダ
		$upload_dir  = "data/upload/";
		//$upload_file = $upload_dir . basename($_FILES['upload_file']['name']);
		$upload_file = $upload_dir . $datetime .".".$ext;
		
		//アップロード情報の保存(syslog)
		$log = array($datetime,
		             $_FILES['upload_file']['name'],
		             $_FILES['upload_file']['type'],
		             $_FILES['upload_file']['size'],
		             $_SERVER['REMOTE_ADDR'],
		             $_SERVER['HTTP_USER_AGENT']);
		file_put_contents($upload_dir."syslog.log" , join(",",$log)."\n",FILE_APPEND);
		
		
		//echo $upload_file;exit();
		
		//フォルダ作成
		if(!is_dir($upload_dir)){
			mkdir($upload_dir,0777,true);
		}
		
		//データアップロード
		move_uploaded_file($_FILES['upload_file']['tmp_name'], $upload_file);
		
		//変換用フォルダの作成
		$tmp_folder = $upload_file .".tmp";
		if(!is_dir($tmp_folder)){
			mkdir($tmp_folder,0777,true);
		}
		
		//png変換
		exec("/opt/ffmpeg/bin/ffmpeg -i ".$upload_file." -r 50 ".$tmp_folder."/%03d.png");
		
		//gif変換
		$outputfile = $upload_dir . $datetime .".gif";
		exec("convert -delay 2 -layers optimize ".$tmp_folder."/*.png ".$outputfile);
		
		//変換用フォルダの削除
		exec("rm -rf ".$tmp_folder);
		
		//gif表示へリダイレクト
		$libUrl = new libUrl();
		//die($getUrl->getUrl()."?html=finish&data=".$datetime);
		header("Location: ".$libUrl->getUrl()."?html=finish&data=".$datetime);
		
		
		//print_r($_FILES);
	}
	
	//ファイルパス（名）から拡張子を取得
	function getExtention($filename){
		
		$sp = explode(".",$filename);
		
		return $sp[count($sp)-1];
		
	}
	
	
}
exit();
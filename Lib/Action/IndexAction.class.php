<?php
class IndexAction extends Action {
    public function index(){
	$this->display();
   }
    public function search(){
	$keyword = $_GET["keyword"];
	$type = $_GET["type"];
	$command = "java -classpath '/home/ubuntu/myLucene:/usr/local/lucene-5.4.1/core/lucene-core-5.4.1.jar:/usr/local/lucene-5.4.1/analysis/common/lucene-analyzers-common-5.4.1.jar:/usr/local/lucene-5.4.1/queryparser/lucene-queryparser-5.4.1.jar' SearchFiles -index /home/ubuntu/myLucene/index -query ".escapeshellarg($keyword)." 2>&1"; 
	$acommand = "java -classpath '/home/ubuntu/myLucene:/usr/local/lucene-5.4.1/core/lucene-core-5.4.1.jar:/usr/local/lucene-5.4.1/analysis/common/lucene-analyzers-common-5.4.1.jar:/usr/local/lucene-5.4.1/queryparser/lucene-queryparser-5.4.1.jar' SearchFiles -index /home/ubuntu/myLucene/AIndex -query ".escapeshellarg($keyword)." 2>&1"; 
	$hcommand = "java -classpath '/home/ubuntu/myLucene:/usr/local/lucene-5.4.1/core/lucene-core-5.4.1.jar:/usr/local/lucene-5.4.1/analysis/common/lucene-analyzers-common-5.4.1.jar:/usr/local/lucene-5.4.1/queryparser/lucene-queryparser-5.4.1.jar' SearchFiles -index /home/ubuntu/myLucene/HIndex -query ".escapeshellarg($keyword)." 2>&1"; 
	//exec('export PATH=/home/ubuntu/myLucene/');
	
	//dump($type);
	
	if($type=="WAH"){
		exec($hcommand,$res,$sta);
	}elseif($type=="WA"){
		exec($acommand,$res,$sta);
	}else{
		exec($command,$res,$sta); 
	}
	
	
	//dump($res);
	//echo $sta;
	$head = array_slice($res,0,2);
	$result = array_slice($res,2);
	$url=array();
	$title=array();
	dump($result);
	for($i = 0;$i<10;$i++){
		$line=explode(" ",$result[$i*9]);
		array_push($url,$line[1]);
		$line=$result[$i*9+1].$result[$i*9+2].$result[$i*9+3].$result[$i*9+4].$result[$i*9+5].$result[$i*9+6].$result[$i*9+7];
		array_push($title,$line[1]);
		
	}
	dump($url);
	dump($result);
	for($i = 0;$i<10;$i++){
		$out[$i]["url"]=$url[$i];
		$out[$i]["title"]=$title[$i*8].$title[$i*8+1].$title[$i*8+2].$title[$i*8+3].$title[$i*8+4].$title[$i*8+5].$title[$i*8+6].$title[$i*8+7];
	}
	dump($out);
	if(count($result)==0){
		$head[3] = "</br></br><h1>no result</h1>";
	}
	
	$this->head=$head;
	$this->res=$out;
	$this->display();
   }
    public function view(){
	
	$filename = $_GET["filename"];
	$path = "/home/ubuntu/myLucene/";
	//echo $path.$filename;
	$content = file_get_contents($path.$filename);
	//echo $content;
	$this->title = $filename;
	$this->content = $content;
	$this->display();
   }
}

<?php
class IndexAction extends Action {
    public function index(){
	$this->display();
   }
    public function search(){
	$keyword = $_GET["keyword"];
	$comand = "java -classpath '/home/ubuntu/myLucene:/usr/local/lucene-5.4.1/core/lucene-core-5.4.1.jar:/usr/local/lucene-5.4.1/analysis/common/lucene-analyzers-common-5.4.1.jar:/usr/local/lucene-5.4.1/queryparser/lucene-queryparser-5.4.1.jar' SearchFiles -index /home/ubuntu/myLucene/index -query ".escapeshellarg($keyword)." 2>&1"; 
	//exec('export PATH=/home/ubuntu/myLucene/');
	exec($comand,$res,$sta); 
	
	//dump($res);
	//echo $sta;
	$head = array_slice($res,0,2);
	$result = array_slice($res,2);
	foreach ($result as $key=>$line){
		if ($key%2==0){
			$url.array_push($line);
		}else{
			$title.array_push($line);
		}
	}
	dump($url);
	dump($title);
	for($i = 0;$i<10;$i++){
		$out[$i]["url"]=$url[$i];
		$out[$i]["title"]=$title[$i];
	}
	
	if(count($result)==0){
		$head[3] = "</br></br><h1>no result</h1>";
	}
	
	dump($out);
	$this->head=$head;
	$this->res=$res;
	$this->display();
   }
    public function view(){
	
	$filename = explode(".",$_GET["filename"])[1];
	$path = "/home/ubuntu/myLucene/";
	//echo $path.$filename;
	$content = file_get_contents($path.$filename);
	//echo $content;
	$this->title = $filename;
	$this->content = $content;
	$this->display();
   }
}

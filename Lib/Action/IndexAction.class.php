<?php
class IndexAction extends Action {
    public function index(){
	$this->display();
   }
    public function search(){
	$keyword = $_GET["keyword"];
	$comand = "java -classpath '/home/ubuntu/myLucene:/usr/local/lucene-5.4.1/core/lucene-core-5.4.1.jar:/usr/local/lucene-5.4.1/analysis/common/lucene-analyzers-common-5.4.1.jar:/usr/local/lucene-5.4.1/queryparser/lucene-queryparser-5.4.1.jar' SearchFiles -index /home/ubuntu/myLucene/index -query ".$keyword." 2>&1"; 
	//exec('export PATH=/home/ubuntu/myLucene/');
	exec($comand,$res,$sta); 
	$this->res=$res;
	dump($res);
	echo $sta;
	$this->display();
   }
    public function view(){
	$filename = substr($_GET["filename"],4);
	$path = "/home/ubuntu/myLucene";
	//echo $path.$filename;
	$content = file_get_contents($path.$filename);
	echo $content;
   }
}

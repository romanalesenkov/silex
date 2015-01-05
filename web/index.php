<?php
 
require_once __DIR__.'/../vendor/autoload.php';
$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

mysql_connect("127.0.0.1", "root", "1") 
	or die(mysql_error());
mysql_select_db("web") or die(mysql_error());
$data = mysql_query("SELECT id,title,content FROM pages") or die(mysql_error());
while ($row = mysql_fetch_assoc($data))
	$fetched_array[] = $row;
//print_r($fetched_array);
$app = new Silex\Application();

$app->get('/api/pages/{id}', function(Silex\Application $app, $id) use ($fetched_array){
	return "<title>{$fetched_array[$id]['title']}</title>".
		"<p>{$fetched_array[$id]['content']}</p>";
});

$app->run();
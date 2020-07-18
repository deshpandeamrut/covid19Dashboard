<?php

header("Access-Control-Allow-Origin: *");
header("content-type: application/json");
$graphData = file_get_contents($_REQUEST['f'].".json");
		//apcu_store($_REQUEST['f'], $graphData,300);
		echo $graphData;


/*if(apcu_exists($_REQUEST['f'])){
	$graphData = apcu_fetch($_REQUEST['f']);
	echo $graphData;
}else{
	if(file_exists($_REQUEST['f'].".json")){
		$graphData = file_get_contents($_REQUEST['f'].".json");
		apcu_store($_REQUEST['f'], $graphData,300);
		echo $graphData;
	}
}*/

?>
<?php  
date_default_timezone_set('Asia/Kolkata');
$today = date("d/m/Y");
// $today= "14/07/2020";
$now = date("Mdhi");
$rawData = file_get_contents("https://api.covid19india.org/raw_data12.json");

$rawData  = json_decode($rawData);
$file = file_get_contents('./graph.json');

$fileData = json_decode($file, true);
$fileDatCopy = $fileData;
$todaysBagalkotData=[];
// print_r($rawData);
$status = ['recovered','deceased','hospitalized'];
$i=0;
$j=0;
foreach ($rawData->raw_data as $index => $obj){
	
	if(strtolower($obj->detecteddistrict) == "bagalkote"){
		if(strtolower($obj->dateannounced) == $today){
				
				$pid = explode("-",$obj->statepatientnumber)[1];
				
				array_push($todaysBagalkotData,$obj);
				
			$i++;
		}
	}
}
echo "Added: $i<br/>";
$i=0;
$addedRecords =[];
foreach ($todaysBagalkotData as $index => $obj){
	//print_r($obj);
	//echo "<br/>";
	$pid = explode("-",$obj->statepatientnumber)[1];
	if(!checkIfAlreadyAdded($fileData,$pid)){
		$new['id']= $obj->entryid;
		$new['pid']= $pid;
		$new['influence'] = 0;
		$new['zone'] =0;
		$new['source'] =$obj->source1;
		$new['place'] =$obj->detecteddistrict;
		$new['comments'] = $obj->notes;
		$new['date'] =$obj->dateannounced;
		$new['status'] =$obj->currentstatus;
		$new['recoveryDate'] ='';
		$new['deceasedDate'] ='';
		$new['age'] =$obj->agebracket;
		$new['gender'] =$obj->gender;
		array_push($fileData["nodes"], $new);
		array_push($addedRecords, $new);
		$i++;

	}
	/*else{
		$j++;
		echo $obj->statepatientnumber."<br/>";
		$fileData = updatePatientDetails($fileData,$obj);
	}*/

}
echo "Added to file: $i<br/>";
$j=0;
$updatedRecords =[];
foreach ($todaysBagalkotData as $index => $obj){
	//print_r($obj);
	//echo "<br/>";
	$pid = explode("-",$obj->statepatientnumber)[1];
	if(checkIfAlreadyAdded($fileData,$pid)){
		
		$j++;
		//echo $obj->statepatientnumber ."<br/>";
		$fileData = updatePatientDetails($fileData,$obj,$today);
		//array_push($updateSData, $value);
	}

}

echo "<br/>-------<br/>";
echo "Updated: $i<br/>";

//print_r(json_encode($fileData['nodes']));
//print_r($updateSData);

//print_r($addedRecords);
//print_r(json_encode($fileData['nodes']));
/*echo "Added ".$i ." records";
echo "<br/>";
echo "Updated ".$j ." records";
*/
if($i>0 || $j>0){
	file_put_contents("./data/backup/graph_".$now.".json", json_encode($fileDatCopy));
	file_put_contents("./graph.json", json_encode($fileData));	
	//addUpdateAndPushNotify($i." new case(s) reported today.");
}

	

	


function updatePatientDetails($fileData,$obj,$today){

	//$today = date("d/m/Y");
	//$today="13/07/2020";
	$pid = explode("-",$obj->statepatientnumber)[1];
	//echo $pid;
	foreach ($fileData['nodes'] as $key => $value) {
		if($value['pid']==$pid){
			echo "<br/>this-> ".$pid;
			if($obj->currentstatus=="Recovered"){
				if($value['status']!="Recovered"){
					$value['status'] = $obj->currentstatus;
					$value['recoveryDate'] =$today;
				}
			}else if($obj->currentstatus=="Deceased"){
				if($value['status']!="Deceased"){
					$value['status'] = $obj->currentstatus;
					$value['comments'] = $obj->notes;
					$value['deceasedDate'] =$obj->dateannounced;
				}
			}
			$fileData['nodes'][$key] = $value;
		}
		
	}
	return $fileData;
}


function checkIfAlreadyAdded($fileData,$pid){

foreach ($fileData['nodes'] as $key => $value) {
	if($value['pid']==$pid){
		//echo "Present Already with stored: $pid";
		return true;
	}

}
return false;
}

function addUpdateAndPushNotify($message){
	include "./pushNotifyUsers.php";
	$file = file_get_contents('./data/updates.json');
	date_default_timezone_set('Asia/Kolkata');
	$now = date("YmdH");   
	$dateLabel = date("M d h:i A");
	file_put_contents('./data/backup/updates_UpdateFromCID'.$now.'.json',$file);
	$data = json_decode($file, true);
	$updateSData['title'] = $message;
	$updateSData['description'] = $message;
	$updateSData['img'] = "";
	$updateSData['date'] = $dateLabel;
	$data["updates"] = array_values($data["updates"]);
	//sendMessage($message,$message);
	array_push($data["updates"], $updateSData);
	file_put_contents("./data/updates.json", json_encode($data));
}
			?>


			
<?php  
date_default_timezone_set('Asia/Kolkata');
$today = date("d/m/Y");
$today= "16/07/2020";
$now = date("Mdhi");
$rawData = file_get_contents("https://api.covid19india.org/raw_data10.json");

$rawData  = json_decode($rawData);
$file = file_get_contents('./graph.json');

$fileData = json_decode($file, true);
$fileDatCopy = $fileData;
// print_r($rawData);
$status = ['recovered','deceased'];
$i=0;
$j=0;
foreach ($rawData->raw_data as $index => $obj){
	
	if(strtolower($obj->detecteddistrict) == "bagalkote"){
		if(strtolower($obj->dateannounced) == $today){
			
				$pid = explode("-",$obj->statepatientnumber)[1];
				if(checkIfAlreadyAdded($fileData,$pid)){
						/**Only Status Update**/
					$j++;
					//echo $obj->statepatientnumber."<br/>";
					$fileData = updatePatientDetails($fileData,$obj);
					//print_r($fileData["nodes"]);
				}else{
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
					$i++;
				}
		}
	}
}

print_r(json_encode($fileData['nodes']));
echo "Added ".$i ." records";
echo "<br/>";
echo "Updated ".$j ." records";
if($i>0 || $j>0){
	file_put_contents("./data/backup/graph_".$now.".json", json_encode($fileDatCopy));
	file_put_contents("./graph.json", json_encode($fileData));	
	if($i>0){
		addUpdateAndPushNotify($i." new case(s) reported today.");
	}
}

	/**
		To update stats data timestamp
	*/
	$getfile = file_get_contents('./data/statsData.json');
    $all = json_decode($getfile, true);
    $jsonfile = $all["stats"];
    date_default_timezone_set('Asia/Kolkata');
	$lastUpdate = date("M d h:i A");
	$all["lastupdated"] = $lastUpdate;
	file_put_contents("./data/statsData.json", json_encode($all));

	


function updatePatientDetails($fileData,$obj){

	$today = date("d/m/Y");
	$today="16/07/2020";
	$pid = explode("-",$obj->statepatientnumber)[1];
	//echo $pid;
	foreach ($fileData['nodes'] as $key => $value) {
		if($value['pid']==$pid){

			if($obj->currentstatus=="Recovered"){
				echo "$pid Updating to ".$obj->currentstatus ."<br/>";
				$value['status'] = $obj->currentstatus;
				$value['recoveryDate'] =$today;
			}else if($obj->currentstatus=="Deceased"){
				//echo $pid."<br/>";
				echo "$pid  Updating to ".$obj->currentstatus. "<br/>";
				$value['status'] = $obj->currentstatus;
				$value['comments'] = $obj->notes;
				$value['deceasedDate'] =$obj->dateannounced;
			}
			$fileData['nodes'][$key] = $value;
		}
		
	}
	return $fileData;
}
/**
{"id":2,"pid":"P162","influence":30,"zone":0,"age":58,"gender":"M","source":"https:\/\/twitter.com\/nammabagalkot\/status\/1247084414669971457","place":"Bagalkot","comments":"Travel history to Kalburagi","date":"06\/04\/2020","status":"Recovered","recoveryDate":"21\/04\/2020","deceasedDate":""}

"agebracket": "",
			"contractedfromwhichpatientsuspected": "",
			"currentstatus": "Recovered",
			"dateannounced": "01/07/2020",
			"detectedcity": "",
			"detecteddistrict": "Bagalkote",
			"detectedstate": "Karnataka",
			"entryid": "95420",
			"gender": "",
			"nationality": "",
			"notes": "",
			"numcases": "1",
			"patientnumber": "",
			"source1": "https://t.me/Karnataka_KoViD19_Broadcast/4639",
			"source2": "",
			"source3": "",
			"statecode": "KA",
			"statepatientnumber": "KA-P8711",
			"statuschangedate": "",
			"typeoftransmission": ""
*/
function checkIfAlreadyAdded($fileData,$pid){

foreach ($fileData['nodes'] as $key => $value) {
	if($value['pid']==$pid){
		echo "$pid  Present already <br/>";
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


			
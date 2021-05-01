<?php  
date_default_timezone_set('Asia/Kolkata');
$today = date("d/m/Y");
//$today= "16/07/2020";
$now = date("Y-m-d");

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);  

$rawData = file_get_contents("https://api.covid19india.org/v4/min/timeseries-KA.min.json", false, stream_context_create($arrContextOptions));


$rawData  = json_decode($rawData);

//echo $now;
$state = "KA";
$key ="districts";
$district = "Bagalkote";
$dates = "dates";
//$now="2021-04-30";
$yday = date('Y-m-d',strtotime("-1 days"));

$ydayData = $rawData->$state->$key->$district->$dates->$yday;
$bgkData = $rawData->$state->$key->$district->$dates->$now;

if($bgkData->delta->confirmed!=null){

    $getfile = file_get_contents('./data/statsData.json');
    $all = json_decode($getfile, true);
    $jsonfile = $all["stats"];
    $jsonfile["date"] =  $now;
    $jsonfile["confirmed"] =  $bgkData->delta->confirmed;
    $jsonfile["deceased"] =  $bgkData->delta->deceased == null ? 0 : $bgkData->delta->deceased;
    $jsonfile["recovered"] =  $bgkData->delta->recovered;
    $jsonfile["vaccinated"] = $bgkData->delta->vaccinated;
    $jsonfile["totalConfirmed"] = $bgkData->total->confirmed;
    $jsonfile["totalRecovered"] = $bgkData->total->recovered;
    $jsonfile["totalDeceased"] = $bgkData->total->deceased;
    $jsonfile["totalVaccinated"] = $bgkData->total->vaccinated;
    date_default_timezone_set('Asia/Kolkata');
    $lastUpdate = date("M d h:i A");
    $all["lastupdated"] = $lastUpdate;
    $all["stats"] = $jsonfile; 
    file_put_contents("./data/statsData.json", json_encode($all));
    addToDailyFile($bgkData);
}else if($ydayData->delta->vaccinated!=null){
    
    $getfile = file_get_contents('./data/statsData.json');
    $all = json_decode($getfile, true);
    $jsonfile = $all["stats"];
    $jsonfile["date"] =  $yday;
    $jsonfile["vaccinated"] = $ydayData->delta->vaccinated;
    $jsonfile["totalVaccinated"] = $ydayData->total->vaccinated;
    date_default_timezone_set('Asia/Kolkata');
    $lastUpdate = date("M d h:i A");
    $all["lastupdated"] = $lastUpdate;
    $all["stats"] = $jsonfile;
    print_r($jsonfile);
    file_put_contents("./data/statsData.json", json_encode($all));
}

function addToDailyFile($bgkData){
    $dailyfile = file_get_contents('./data/dailyData.json');
    date_default_timezone_set('Asia/Kolkata');
    $today = date("Y-m-d");
    //$today="2021-04-22";
    $all = json_decode($dailyfile, true);
    
    if(!isset($all[$today])){
        $jsonfile = [];
        $jsonfile["confirmed"] =  $bgkData->delta->confirmed;
        $jsonfile["deceased"] =  $bgkData->delta->deceased == null ? 0 : $bgkData->delta->deceased;
        $jsonfile["recovered"] =  $bgkData->delta->recovered;
        $jsonfile["vaccinated"] = $bgkData->delta->vaccinated;
        $jsonfile["totalConfirmed"] = $bgkData->total->confirmed;
        $jsonfile["totalRecovered"] = $bgkData->total->recovered;
        $jsonfile["totalDeceased"] = $bgkData->total->deceased;
        $jsonfile["totalVaccinated"] = $bgkData->total->vaccinated;
        $all[$today] = $jsonfile;
        file_put_contents("./data/dailyData.json", json_encode($all));
    }
}
?>			
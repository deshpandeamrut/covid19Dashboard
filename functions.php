<?php
function write_todaysCountData($todaysFileName,$todaysDataFile){
	$html = file_get_contents($todaysFileName);
	libxml_use_internal_errors(true);
	$doc = new \DOMDocument();
	if($doc->loadHTML($html))
	{
		$result = new \DOMDocument();
		$result->formatOutput = true;

		$xpath = new \DOMXPath($doc);

		

		$todaysAdmissionUrl = "//div[@id='WebPartWPQ6' and contains(@class, 'ms-WPBody')]/div[contains(@class, 'ms-rtestate-field')]/table[contains(@class, 'ms-rteTable-default')]/tbody/tr[contains(@class, 'ms-rteTableHeaderRow-default')]/th[contains(@class, 'ms-rteTableHeaderFirstCol-default')]/table[contains(@class, 'ms-rteTable-default')]/tbody/tr[2]/td[contains(@class, 'ms-rteTable-default')][3]";
		$todaysDischargeUrl = "//div[@id='WebPartWPQ6' and contains(@class, 'ms-WPBody')]/div[contains(@class, 'ms-rtestate-field')]/table[contains(@class, 'ms-rteTable-default')]/tbody/tr[contains(@class, 'ms-rteTableHeaderRow-default')]/th[contains(@class, 'ms-rteTableHeaderFirstCol-default')]/table[contains(@class, 'ms-rteTable-default')]/tbody/tr[2]/td[contains(@class, 'ms-rteTable-default')][4]";
		$isolationUrl = "//div[@id='WebPartWPQ6' and contains(@class, 'ms-WPBody')]/div[contains(@class, 'ms-rtestate-field')]/table[contains(@class, 'ms-rteTable-default')]/tbody/tr[contains(@class, 'ms-rteTableHeaderRow-default')]/th[contains(@class, 'ms-rteTableHeaderFirstCol-default')]/table[contains(@class, 'ms-rteTable-default')]/tbody/tr[2]/td[contains(@class, 'ms-rteTable-default')][5]";
		$totalKarnatakaPositive="//div[@id='WebPartWPQ1' and contains(@class, 'ms-WPBody')]/div[contains(@class, 'ms-rtestate-field')]/div/table[contains(@class, 'ms-rteTable-default')]/tbody/tr[contains(@class, 'ms-rteTableEvenRow-default')][4]/td[contains(@class, 'ms-rteTableOddCol-default')][2]";
		$todayKarnatakaPositive="//div[@id='WebPartWPQ1' and contains(@class, 'ms-WPBody')]/div[contains(@class, 'ms-rtestate-field')]/div/table[contains(@class, 'ms-rteTable-default')]/tbody/tr[contains(@class, 'ms-rteTableEvenRow-default')][4]/td[contains(@class, 'ms-rteTableEvenCol-default')][2]";
		
		$todaysAdmissionCount = getXpathQueryData($xpath,$todaysAdmissionUrl);
		$todaysDischargeCount = getXpathQueryData($xpath,$todaysDischargeUrl);
		$totalIsolatedCount = getXpathQueryData($xpath,$isolationUrl);
		$totalKarnatakaPositiveCount = getXpathQueryData($xpath,$totalKarnatakaPositive);
		$todayKarnatakaCount = getXpathQueryData($xpath,$todayKarnatakaPositive);

		file_put_contents($todaysDataFile,$todaysAdmissionCount.",".$todaysDischargeCount.",".$totalIsolatedCount.",".$totalKarnatakaPositiveCount.",".$todayKarnatakaCount);
		
	}
}
function getTodaysData($todaysDataFile){
	$todaysData = file_get_contents($todaysDataFile);
	$arr = explode(",",$todaysData);
	$data['admissionCount'] = $arr[0];
	$data['dischargeCount'] = $arr[1];
	$data['isolationCount'] = $arr[2];
	$data['totalKarnatakaCount'] = $arr[3];
	$data['todaysKarnatakaCount'] = $arr[4];
	return $data;
}

function getXpathQueryData($xpath, $url){
	$elements = $xpath->query($url);
	if (!is_null($elements)) {
		$val = "";
		foreach ($elements as $element) {
		 $nodes = $element->childNodes;
			foreach ($nodes as $node) {
			  $val = $val.$node->nodeValue;
			}
		}
	return $val;
	}
}
function startsWith($haystack, $needle) {
    return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
}
function endsWith($haystack, $needle) {
    return substr_compare($haystack, $needle, -strlen($needle)) === 0;
}
function getGroceryStores(){
	$groceryStoresArr= [];
	$groceryStoresString = file_get_contents("data/grocery_stores.csv");
	$groceryStoresLines = explode("\n",$groceryStoresString);
	//$groceryStores= explode("\n",$groceryStoresString);
	foreach ($groceryStoresLines as $groceryStores) {
			if(startsWith($groceryStores,"#"))
			{
				continue;
			}
			$groceryStore= explode(";",$groceryStores);
			//name;description;address;mobile;comments
			$store['name'] = $groceryStore[0];
			$store['description'] = $groceryStore[1];
			$store['address'] = $groceryStore[2];
			$store['mobile'] = $groceryStore[3];
			$store['comments'] = $groceryStore[4];
			$groceryStoresArr[]= $store;
		
	}
	return $groceryStoresArr;
}
function printQuarantineTable($todaysQFileName){
$quarantineData="";
echo "<h5 id='toggle-q-list'>Show List of Home Quarantined people</h5>";
?>

<?php
if ( $xls = SimpleXLS::parse($todaysQFileName)) {
	$quarantineData= $xls->rows() ; // dump first sheet
	
} else {
	echo SimpleXLS::parseError();
}
?>
<div id="q-table-wrapper" class="table-wrapper">
<input type="text" id="search"  placeholder="Search List">
 <table id="table" class="u-full-width">
<?php
   

	echo "<thead>";
    foreach ($quarantineData as $key => $row) 
     { 
		echo "<tr>";
		if($key==0){
			echo '<th>' . $row['0'] .'</th>';
			echo '<th>' . explode(" ",$row['1'])[2] .'</th>';
			echo '<th> Quarantined Till </th>';
			echo '<th>' . $row['3'] .'</th>';
		//	echo '<th>' . $row['4'] .'</th>';
			echo '<th>' . $row['5'] .'</th>';
			echo '<th>' . $row['6'] .'</th>';
			echo '<th>' . $row['7'] .'</th>';
			//echo '<th>' . $row['8'] .'</th>';
		}
		echo "</tr>";
	 }
	echo "</thead>"; 
	 echo "<tbody>";
    foreach ($quarantineData as $key => $row) 
     { 
		echo "<tr>";
		if($key>0){
			echo '<td>' . $row['0'] .'</td>';
			echo '<td>' . explode(" ",$row['1'])[0] .'</td>';
			echo '<td>' .explode(" ",$row['2'])[0] .'</td>';
			echo '<td>' . $row['3'] .'</td>';
			//echo '<td>' . $row['4'] .'</td>';
			echo '<td>' . $row['5'] .'</td>';
			echo '<td>' . $row['6'] .'</td>';
			echo '<td>' . $row['7'] .'</td>';
			//echo '<td>' . $row['8'] .'</td>';
		}
		echo "</tr>";
	 }
	echo "</tbody>"; 
      
     
	 echo "</table></div>";
}

?>


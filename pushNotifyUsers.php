<?PHP
function sendMessage($title,$description){
    $content = array(
        "en" => str_replace("<br/>","\n" ,$description)
        );

 $headings = array(
        "en" => str_replace("<br/>","\n" ,$title)
        );
    $fields = array(
        'app_id' => "0f06be46-3b02-446e-83f2-bacc93ddcddf",
        'included_segments' => array('All'),        
        'contents' => $content,
		'headings' => $headings,
		'url' => "https://covid19.nammabagalkot.in?src=pn"
    );

    $fields = json_encode($fields);
print("\nJSON sent:\n");
print($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                               'Authorization: Basic NDY0NzU2ZDAtZmRmYi00MDFkLTg5YTktZThhNGQzNTcyZjhl'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
?>
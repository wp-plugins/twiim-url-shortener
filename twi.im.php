<?PHP

function create_twiim($link){
	
	$call_url  = 'http://twi.im/api/api.php?using=wordpress&type=wordpress&d=';
	
	$link = str_replace("&", "%26", $link);
	$link = str_replace("?", "%3F", $link);
	$link = str_replace("#", "%23", $link);
	$link = str_replace(":", "%3A", $link);
	
	$file = file_get_contents($call_url.$link, "r");
	
	if($file){
		return $file;
		fclose($file);
	} else {
		fclose($file);
		return 'There was an Error!';	
	}
}

?>
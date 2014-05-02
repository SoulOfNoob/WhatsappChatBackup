<?php
if(isset($_REQUEST["file"])){
	date_default_timezone_set("Europe/Berlin");
	$names = array();
	$count = array();
	$beigetreten = array();
	$verlassen = array();
	$entfernt = array();
	$bildaenderung = array();
	$betreffaenderung = array();
	$handle = @fopen("txts/".$_REQUEST["file"], "r"); //read line one by one
	$data = array();
	    $i = 0;
	while (!feof($handle)) // Loop til end of file.
	{
	    $line = fgets($handle, 4096); // Read a line.
	    $checkline = mb_substr($line, 0, 17);
	    if (DateTime::createFromFormat('d.m.Y G:i:s', $checkline) !== FALSE){
	    	$i++;
	    	$buffer = explode(": ", $line);
		    $data[$i]["datetime"] = $checkline;
		    unset($buffer[0]);
		    $data[$i]["name"] = $buffer[1];
			if (strpos($data[$i]["name"], "beigetreten")!==false){
				$beigetreten[] = $data[$i]["name"];
				unset($data[$i]["name"]);
				$i--;
			}elseif (strpos($data[$i]["name"], "Gruppe verlassen")!==false){
				$verlassen[] = $data[$i]["name"];
				unset($data[$i]["name"]);
				$i--;
			}elseif (strpos($data[$i]["name"], "‬entfernt")!==false){
				$entfernt[] = $data[$i]["name"];
				unset($data[$i]["name"]);
				$i--;
			}elseif (strpos($data[$i]["name"], "‬Gruppenbild")!==false){
				$bildaenderung[] = $data[$i]["name"];
				unset($data[$i]["name"]);
				$i--;
			}elseif (strpos($data[$i]["name"], "Betreff")!==false){
				$betreffaenderung[] = $data[$i]["name"];
				unset($data[$i]["name"]);
				$i--;
			}else{
				unset($buffer[1]);
				$buffer = implode(": ", $buffer);
				$data[$i]["message"] = $buffer;
				if(!in_array ($data[$i]["name"], $names)){
					$names[] = $data[$i]["name"];
					$count[$data[$i]["name"]] = 1;
				}elseif(in_array ($data[$i]["name"], $names)){
					$count[$data[$i]["name"]] = $count[$data[$i]["name"]] + 1;
				}
			}
	    }elseif($i > 0){
	    	$data[$i]["message"].= "<br />".$line;
	    }
	}
	echo json_encode($data);
}
/*if ($_FILES['chatfile']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['chatfile']['tmp_name'])) { //checks that file is uploaded
	$path = "txts/".$_FILES['chatfile']['name'];
	echo $path;
	if (!file_exists($path)){
		if (!move_uploaded_file($_FILES['chatfile']['tmp_name'], $path)){
		    die('Datei wurde nicht Erfolgreich hochgeladen');
		}
	}else{
		echo "Datei vorhanden: <br />";
	}
}*/
?>
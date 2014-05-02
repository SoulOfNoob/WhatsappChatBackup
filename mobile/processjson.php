<?php
date_default_timezone_set("Europe/Berlin");
$names = array();
$count = array();
$beigetreten = array();
$verlassen = array();
$entfernt = array();
$bildaenderung = array();
if(isset($_REQUEST["file"])){
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
			}elseif (strpos($data[$i]["name"], "Gruppe verlassen")!==false){
				$verlassen[] = $data[$i]["name"];
			}elseif (strpos($data[$i]["name"], "‬entfernt")!==false){
				$entfernt[] = $data[$i]["name"];
			}elseif (strpos($data[$i]["name"], "‬Gruppenbild")!==false){
				$bildaenderung[] = $data[$i]["name"];
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
	    }else{
	    	$data[$i]["message"].= "<br />".$line;
	    }
	}

	//$tablestring = '<table data-role="table" id="table-custom-2" data-mode="columntoggle" class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="Columns to display..." data-column-popup-theme="a">';
	//$tablestring = '<thead> <tr class="ui-bar-d"> <th data-priority="2">Datum</th> <th data-priority="1">Zeit</th> <th data-priority="1">Verfasser</th> <th data-priority="1">Nachricht</abbr></th> </tr> </thead>';
	//$tablestring.= '<tbody>';
	//foreach($data as $line){
	//	$tablestring.= "<tr class=\"custom_row\"><td>".$data[4]["datetime"]->format('d.m')."</td><td>".$data[4]["datetime"]->format('H:i')."</td><td nowrap>".$line["name"]."</td><td>".$line["message"]."</td><tr>";
	//	
	//}
	//$tablestring.= "</tbody>";

	//echo $tablestring;
	echo json_encode($data);
}
?>
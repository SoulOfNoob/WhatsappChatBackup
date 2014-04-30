<?php
date_default_timezone_set("Europe/Berlin");
$names = array();
$count = array();
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
		    $datetime = explode(" ", $buffer[0]);
	    	$data[$i]["date"] = $datetime[0];
		    $data[$i]["time"] = $datetime[1];
		    unset($datetime);
		    unset($buffer[0]);
		    $data[$i]["name"] = $buffer[1];
			unset($buffer[1]);
			$buffer = implode(": ", $buffer);
		    $data[$i]["message"] = $buffer;

		    if(!in_array ($data[$i]["name"], $names)){
				$names[] = $data[$i]["name"];
				$count[$data[$i]["name"]] = 1;
			}elseif(in_array ($data[$i]["name"], $names)){
				$count[$data[$i]["name"]] = $count[$data[$i]["name"]] + 1;
			}
	    }else{
	    	$data[$i]["message"].= "<br />".$line;
	    }
	}
	$beigetreten = array();
	$verlassen = array();
	$entfernt = array();
	$tablestring = '<table data-role="table" id="table-custom-2" data-mode="columntoggle" class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="Columns to display..." data-column-popup-theme="a">';
	$tablestring.= '<thead> <tr class="ui-bar-d"> <th data-priority="1">Datum</th> <th data-priority="1">Zeit</th> <th data-priority="1">Verfasser</th> <th data-priority="1">Nachricht</abbr></th> </tr> </thead>';
	$tablestring.= '<tbody>';
	foreach($data as $line){
		if (strpos($line["name"], "beigetreten")!==false){
			$beigetreten[] = $line["name"];
		}elseif (strpos($line["name"], "Gruppe verlassen")!==false){
			$verlassen[] = $line["name"];
		}elseif (strpos($line["name"], "‬entfernt")!==false){
			$entfernt[] = $line["name"];
		}elseif (strpos($line["name"], "‬Gruppenbild")!==false){
			$bildaenderung[] = $line["name"];
		}else{
			$tablestring.= "<tr><td>".$line["date"]."</td><td>".$line["time"]."</td><td>".$line["name"]."</td><td>".$line["message"]."</td><tr>";
		}
	}
	$tablestring.= "</tbody></table>";

	echo $tablestring;
}
?>
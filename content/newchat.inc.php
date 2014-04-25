<?php /*
The MIT License (MIT)

Copyright (c) 2014 Jan

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/ ?>
<?php
if ($handle = opendir('txts')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
            echo "<a href='newchat.php?file=$file'>$file<a><br />";
        }
    }
    closedir($handle);
}

if ($_FILES['chatfile']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['chatfile']['tmp_name'])) { //checks that file is uploaded
	$path = "txts/".$_FILES['chatfile']['name'];
	echo $path;
	if (!file_exists($path)){
		if (!move_uploaded_file($_FILES['chatfile']['tmp_name'], $path)){
		    die('Datei wurde nicht Erfolgreich hochgeladen');
		}
	}else{
		echo "Datei vorhanden: <br />";
	}
}

if(isset($_REQUEST["file"])){
	echo $_REQUEST["file"];
	$handle = @fopen("txts/".$_REQUEST["file"], "r"); //read line one by one
	$data = array();
	    $i = 0;
	while (!feof($handle)) // Loop til end of file.
	{
	    $string = fgets($handle, 4096); // Read a line.
	    if(strpos($string,": ")!==false){
	    	$buffer = explode(": ", $string);
		    $datetime = explode(" ", $buffer[0]);
		    $data[$i]["date"] = $datetime[0];
		    $data[$i]["time"] = $datetime[1];
		    unset($datetime);
		    unset($buffer[0]);
		    $data[$i]["name"] = $buffer[1];
			unset($buffer[1]);
			$buffer = implode(": ", $buffer);
		    $data[$i]["message"] = $buffer;
		    $i++;
	    }
	}
	?>
	<table border="1">
	<tr><th>am</th><th>um</th><th>wer</th><th>was</th></tr>
	<?php
	foreach($data as $line){
		echo "<tr><td>".$line["date"]."</td><td>".$line["time"]."</td><td>".$line["name"]."</td><td>".$line["message"]."</td><tr>";
	}
}

?>
</table>
<form action="newchat.php" method="POST" enctype="multipart/form-data" id="newchat">
	<label for="chatname">Unter welchem Namen soll der Chat gespeichert werden: </label>
        <input name="chatname" type="text">
    <br />
	<label for="username">Gib bitte deinen Namen oder deine Whatsapp-Nummer ein: </label>
		<input name="username" type="text">
	<br />
	<label for="password">Setze ein Passwort zum schutz deines Chats: </label>
        <input name="password" type="password">
    <br />
   	<label for="password">Bestätige das Passwort zum schutz deines Chats: </label>
        <input name="password" type="password">
    <br />
	<label for="chatfile">Hier die von Whatsapp generierte textdatei hochladen: </label>
		<input type="file" id="input-chatfile" name="chatfile">
	<br />
	<input type="submit" value="Auswerten">
</form>
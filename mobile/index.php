<?php 
    session_start (); 
    include("config.php"); 
    global $GLOBALS; 
    require_once 'functions.php'; 
?>
<!DOCTYPE html>
<html>
<head>

    <meta name="author" content="Jan Ryklikas"/>
    <meta name="keywords" lang="de" content="Whatsapp"/>
    <meta name="description" content=
            "Noch keine Beschreibung vorhanden."
    />
    <meta http-equiv="language" content="<?= $GLOBALS["defaultLanguage"] ?>"/>
    <meta http-equiv="imagetoolbar" content="no"/>
    <meta name="robots" content="index,follow"/>
    <link rel="shortcut icon" href="img/favico.ico" type="image/x-icon"/>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= $GLOBALS["defaultCharset"] ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css" />
	<link href="css/style.css" rel="stylesheet" type="text/css" media="screen"/>
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>

    <title>WhatsappChatBackup</title>
</head>
<body>
	<?php
		if (isset($_REQUEST["chat"])){
			echo "<script>var filename = '".$_REQUEST["chat"]."';</script>";
		}else{
			echo "<script>var filename = false;</script>";
		}
	?>
    <script>
		function getTable(filename) {
       		var chat = "fehler";
			console.log("filename: "+filename);
			$.ajax({
				url: "processjson.php",
				data: { file: filename },
				type: "POST",
				success: function(response) { chat = jQuery.parseJSON(response); }
			}).done(function() {	
				console.log(chat);
				var table = '<table data-role="table" id="chattable" data-mode="columntoggle" class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="Columns to display..." data-column-popup-theme="a">';
				table = table + '<thead> <tr class="ui-bar-d"> <th data-priority="3">Jahr</th> <th data-priority="2">Datum</th> <th data-priority="1">Zeit</th> <th data-priority="1">Verfasser</th> <th data-priority="1">Nachricht</abbr></th> </tr> </thead>';
				table = table + '<tbody>';
				var i = 0;
				console.log("start generating");
				for(line in chat){
					i++;
					//console.log(chat[line]);
					//console.log(chat[1].datetime);
				//##### Split the date ####
					ds = chat[line].datetime; //29.03.14 22:20:18 
					var first_part = ds.split(" ")[0],
					day = first_part.split(".")[0],
					month = first_part.split(".")[1],
					year = "20"+first_part.split(".")[2],
					last_part = ds.split(" ")[1],
					hour = last_part.split(":")[0],
					minute =  last_part.split(":")[1],
					second =  last_part.split(":")[2];
				//##### Split the date ####
					//console.log(day+' '+month+' '+year+' '+hour+' '+minute+' '+second);
					
					var date = new Date ( Date.UTC ( year, month, day, hour, minute, second ) );
					//console.log(date);
					table = table + '<tr class=\"custom_row\"><td>'+year+'</td><td>'+day+'.'+month+'</td><td>'+hour+'.'+minute+'</td><td nowrap>'+chat[line].name+'</td><td>'+chat[line].message+'</td><tr>';
				}
				table = table + '</tbody>';
				console.log("table generated");
				//console.log(table);
				$("#chattable").html("");
				console.log("field empty");
				$("#chattable").html(table);
				console.log("table written");
				//$("#chattable").trigger("create");
				console.log("table created");
				$.mobile.navigate( "#view" );
				console.log("view switched");
				
			});
        }
        $( document ).ready(function() {
        	if(filename !== false){
        		getTable(filename);
        	}
        	$("#callAjax").click( function(){
        		var filename = $("#filename").val();
        		getTable(filename);
        	});
        });
    </script>
<!-- Start of first page -->
<div data-role="page" id="start">

	<div data-role="header">
		<h1>Start</h1>
	</div><!-- /header -->

	<div role="main" class="ui-content">
		<p>Wilkommen in meiner WebApp zum auswerten von Whatsapp Chats</p>
		<p>was möchten sie als nächstes tun?</p>
		<p><a href="#overview" class="ui-btn ui-shadow ui-corner-all">vorhandene Chats anzeigen</a></p>
		<p><a href="#upload" class="ui-btn ui-shadow ui-corner-all" data-rel="dialog" data-transition="pop">Neuen Chat hochladen</a></p>
	</div><!-- /content -->

	<div data-role="footer">
		<h4><a href="https://github.com/SoulOfNoob/WhatsappChatBackup">https://github.com/SoulOfNoob/WhatsappChatBackup</a></h4>
	</div><!-- /footer -->
</div><!-- /page -->

<!-- Start of second page -->
<div data-role="page" id="upload">

	<div data-role="header">
		<h1>Hochladen</h1>
	</div><!-- /header -->
	<?php
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
	?>
	<div role="main" class="ui-content">
		<p>Hier kannst du deinen von Whatsapp exportierten Chat hochladen.</p>
		<form action="index.php" method="POST" enctype="multipart/form-data" id="newchat">
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
		<p><a href="#start" data-direction="reverse" class="ui-btn ui-shadow ui-corner-all ui-btn-b">Zurück zur Startseite</a></p>
	</div><!-- /content -->

	<div data-role="footer">
		<h4><a href="https://github.com/SoulOfNoob/WhatsappChatBackup">https://github.com/SoulOfNoob/WhatsappChatBackup</a></h4>
	</div><!-- /footer -->
</div><!-- /page -->

<!-- Start of third page -->
<div data-role="page" id="overview">

	<div data-role="header">
		<h1>Vorhandene Chats</h1>
	</div><!-- /header -->

	<div role="main" class="ui-content">
		<p>welchen hochgeladenen chat möchtest du auswerten?</p>
		<p><select id="filename">
		  	<option value="test">Auswählen</option>
			<?php
			if ($handle = opendir('txts')) {
			    while (false !== ($file = readdir($handle))) {
			        if ($file != "." && $file != "..") {
			            echo '<option value="'.$file.'">'.$file.'</option>';
			        }
			    }
			    closedir($handle);
			}
			?>
		</select></p>
        <input id="callAjax" type="button" value="Auswerten" />
        <p><a href="#start" data-direction="reverse" class="ui-btn ui-shadow ui-corner-all ui-btn-b">Zurück zur Startseite</a></p>
	</div><!-- /content -->

	<div data-role="footer">
		<h4><a href="https://github.com/SoulOfNoob/WhatsappChatBackup">https://github.com/SoulOfNoob/WhatsappChatBackup</a></h4>
	</div><!-- /footer -->
</div><!-- /page -->

<!-- Start of third page -->
<div data-role="page" id="view">

	<div data-role="header">
		<h1>Auswertung: </h1>
	</div><!-- /header -->

	<div role="main" class="ui-content">
		<p><a href="#overview" class="ui-btn ui-shadow ui-corner-all ui-btn-b">Zurück zur Übersicht</a></p>
		<p><a href="#start" data-direction="reverse" class="ui-btn ui-shadow ui-corner-all ui-btn-b">Zurück zur Startseite</a></p>
		<div id="chattable"></div>
	</div><!-- /content -->

	<div data-role="footer">
		<h4><a href="https://github.com/SoulOfNoob/WhatsappChatBackup">https://github.com/SoulOfNoob/WhatsappChatBackup</a></h4>
	</div><!-- /footer -->
</div><!-- /page -->

</body>
</html>




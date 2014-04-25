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
//config.php - Config-Daten für whatsapp.ryklikas.com
$http_host = $_SERVER["HTTP_HOST"]; 
$http_host = str_replace("www.", "", $http_host);

$GLOBALS["baseUrl"] = $http_host;
$GLOBALS["defaultCharset"] = "utf-8";
$GLOBALS["defaultLanguage"] = "de";

$http_host = $_SERVER["HTTP_HOST"]; 
$http_host = str_replace("www.", "", $http_host);

if(stristr($http_host,"whatsapp.ryklikas.com")) { 
	//MySQL Server-Address
	$GLOBALS["SQL"]["Server"] = "localhost";
	 
	//MySQL User
	$GLOBALS["SQL"]["User"] = "web747";
	 
	//MySQL Password for speciefed User
	$GLOBALS["SQL"]["Pass"] = "552316274";
	 
	//MySQL DbName
	$GLOBALS["SQL"]["DbName"] = "usr_web747_3";
} 
?>
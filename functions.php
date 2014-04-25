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
function escapeString($string){
	global $GLOBALS;
    $connectionid = mysql_connect ($GLOBALS["SQL"]["Server"], $GLOBALS["SQL"]["User"], $GLOBALS["SQL"]["Pass"]);
    mysql_set_charset($GLOBALS["defaultCharset"], $connectionid);
    if (!mysql_select_db ($GLOBALS["SQL"]["DbName"], $connectionid)) {
        die ("Keine Verbindung zur Datenbank");
    }
    $string = mysql_real_escape_string ( $string, $connectionid );
    mysql_close($connectionid);
	return $string;
}
function db_query($query){
		
        global $GLOBALS;
        $connectionid = mysql_connect ($GLOBALS["SQL"]["Server"], $GLOBALS["SQL"]["User"], $GLOBALS["SQL"]["Pass"]);
        mysql_set_charset($GLOBALS["defaultCharset"], $connectionid);
        echo $query;
        if (!mysql_select_db ($GLOBALS["SQL"]["DbName"], $connectionid)) {
            die ("Keine Verbindung zur Datenbank");
        }
        if (strpos($query,'SELECT') !== false) {
            $sql_operation = "SELECT";
        }elseif (strpos($query,'INSERT') !== false) {
            $sql_operation = "INSERT";
        }elseif (strpos($query,'UPDATE') !== false) {
            $sql_operation = "UPDATE";
        }
        //$query = mysql_real_escape_string($query);
        //echo "<br/>Query: ".$query;
        $result = mysql_query($query, $connectionid);
        if ($result == false){
            //echo "<br/>Query_Rows: false, Recource: ".$result."<br/>";
            return false;
        }elseif($sql_operation != "SELECT" && $result == true){
            return true;
        }elseif($sql_operation == "SELECT"){
            if (mysql_num_rows($result) > 0) {
                //echo "<br/>Query_Rows: true, Recource: ".$result."<br/>";
                return true;
            }else{
                //echo "<br/>Query_Rows: false, Recource: ".$result."<br/>";
                return false;
            }
        }
        mysql_close($connectionid);
    }
    function db_assoc($query){
        global $GLOBALS;
        $connectionid = mysql_connect ($GLOBALS["SQL"]["Server"], $GLOBALS["SQL"]["User"], $GLOBALS["SQL"]["Pass"]);
        mysql_set_charset($GLOBALS["defaultCharset"], $connectionid);
        if (!mysql_select_db ($GLOBALS["SQL"]["DbName"], $connectionid)) {
            die ("Keine Verbindung zur Datenbank");  
        }
        //$query = mysql_real_escape_string($query);
        //echo "<br/>Assoc_Query: ".$query;
        $result = mysql_query($query, $connectionid);
        if ($result == false){
            //echo "<br/>Assoc_Rows: false<br/>";
            return false;
        }else{
            if (mysql_num_rows($result) > 1) {
                while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                    $data["ID"][] = $row['ID'];  
                }
                return $data;
            }elseif(mysql_num_rows($result) > 0){
                $data = mysql_fetch_assoc($result);
                //echo "<br/>Assoc_Rows: true, Data: ".$data."<br/>";
                return $data;
            }else{
                //echo "<br/>Assoc_Rows: false, Recource: ".$result."<br/>";
                return false;
            }
        }
        mysql_close($connectionid);
    }
?>
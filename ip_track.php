<?php
 $ip = $_SERVER['REMOTE_ADDR'];
 $agent = $_SERVER['HTTP_USER_AGENT'];
 
   
  $db_host = "localhost";
  $db_user = "user";
  $db_pass = "pass";
  $db_name = "database";
  $link = mysql_connect("$db_host", "$db_user", "$db_pass");
  mysql_select_db("$db_name", $link);
   
  if($link)
  {
    $referer = $_SERVER['HTTP_REFERER'];
    $requestUri = $_SERVER['REQUEST_URI'];
   
    $qstring = mysql_query("INSERT INTO visitor_tracking (address, agent, referer, requestUri) VALUES (\"" . $ip . "\", \"" .$agent. "\", \"" . $referer . "\", \"" . $requestUri . "\")", $link);
  }
  else
  {
    echo 'Unable connect to database.';
  }

$result=mysql_query('SELECT entry_id, address, agent, referer, requestUri, timestamp FROM visitor_tracking ORDER BY timestamp DESC LIMIT 10');
while ($row = mysql_fetch_array($result)) {
    
    $ipaddress = $row['address'];
    $reff = $row['referer'];
    $timee = $row['timestamp'];
    $ag = $row['agent'];
    $requ = $row['requestUri'];

    }
?>

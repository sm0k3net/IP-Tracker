<!DOCTYPE html>
 <html>
 <head>
  <title>Sm0k3 HQ IP Tracker</title>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <meta name="description" content="Sm0k3 HQ IP Tracker" />
  <meta name="author" content="sm0k3" />

  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <link rel="icon" href="http://static.sm0k3.net/favicon.ico" type="image/x-icon">
  <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body background="assets/img/bg.jpg">
    
    
<?php

session_start();

// ***************************************** //
// ********** DECLARE VARIABLES  ********** //
// ***************************************** //

$username = 'YourUserName';
$password = 'YourPassword';

$random1 = 'very';
$random2 = 'secretkey';

$hash = md5($random1.$pass.$random2); 

$self = $_SERVER['REQUEST_URI'];


// ************************************ //
// ********** USER LOGOUT  ********** //
// ************************************ //

if(isset($_GET['logout']))
{
  unset($_SESSION['login']);
}


// ******************************************* //
// ********** USER IS LOGGED IN ********** //
// ******************************************* //

if (isset($_SESSION['login']) && $_SESSION['login'] == $hash) {

  ?>
     
 <div class="hero-unit">
    <div class="container">
<div class="row">
 <div class="span12">

<?php
$hostname_logon = "localhost" ;
$database_logon = "database" ;
$username_logon = "user" ;
$password_logon = "pass" ;
$connections = mysql_connect($hostname_logon, $username_logon, $password_logon) or die ( "Unabale to connect to the database" );

mysql_select_db($database_logon) or die ( "Unable to select database!" );
 

$limit = 10;
 

$var = mysql_real_escape_string(@$_REQUEST['q']);
 

$s = mysql_real_escape_string($_REQUEST['s']);
 

if(strlen($var) < 2){
    $resultmsg =  "<p>Search Error</p><p>Keywords with less then three characters are omitted...</p>" ;
}

$trimmed = trim($var);
$trimmed1 = trim($var);
$trimmed_array = explode(" ",$trimmed);
$trimmed_array1 = explode(" ",$trimmed1);
 

if ($trimmed == "") {
    $resultmsg =  "<p>Search Error</p><p>Please enter a search...</p>" ;
}
 

if (!isset($var)){
    $resultmsg =  "<p>Search Error</p><p>We don't seem to have a search parameter! </p>" ;
}
 

foreach ($trimmed_array as $trimm){

$query = "SELECT * , MATCH (referer, timestamp) AGAINST ('".$trimm."') AS score FROM visitor_tracking WHERE MATCH (referer, timestamp) AGAINST ('+".$trimm."') ORDER BY score DESC";
 
 $numresults=mysql_query ($query);
 $row_num_links_main =mysql_num_rows ($numresults);
 
 
 if($row_num_links_main < 1){
    $query = "SELECT * FROM visitor_tracking WHERE referer LIKE '%$trimm%' OR timestamp LIKE '%$trimm%'  ORDER BY entry_id DESC";
    $numresults=mysql_query ($query);
    $row_num_links_main1 =mysql_num_rows ($numresults);
 }
 
 
 if (empty($s)) {
     $s=0;
 }
 
  
  $query .= " LIMIT $s,$limit" ;
  $numresults = mysql_query ($query) or die ( "Couldn't execute query" );
  $row= mysql_fetch_array ($numresults);
 
  
  do{
      $adid_array[] = $row[ 'address' ];
  }while( $row= mysql_fetch_array($numresults));
} //end foreach
 

if($row_num_links_main == 0 && $row_num_links_main1 == 0){
    $resultmsg = "<p>Search results for: ". $trimmed."</p><p>Sorry, your search returned zero results</p>" ;
}
 

$tmparr = array_unique($adid_array);
$i=0;
foreach ($tmparr as $v) {
   $newarr[$i] = $v;
   $i++;
}
 

$row_num_links_main = $row_num_links_main + $row_num_links_main1;
 

echo '<form action="iptrack.php" method="post">
        <div>
        <input class="input-medium search-query" name="q" type="text" value="'.$q.'">
        <input class="btn btn-primary" name="search" type="submit" value="Search">
        &nbsp;<a class="btn btn-warning" href="?logout=true">Logout?</a>
        </div>
</form>';


if( isset ($resultmsg)){
    echo $resultmsg;
}else{
    echo "<p>Search results for: <strong>" . $var."</strong></p>";
 
    foreach($newarr as $value){
 

    $query_value = "SELECT * FROM visitor_tracking WHERE address = '".$value."'";
    $num_value=mysql_query ($query_value);
    $row_linkcat= mysql_fetch_array ($num_value);
    $row_num_links= mysql_num_rows ($num_value);
 
   
    $introcontent = strip_tags($row_linkcat[ 'timestamp']);
    $introcontent = substr($introcontent, 0, 130)."...";
 

      $title = preg_replace ( "'($var)'si" , "<strong>\\1</strong>" , $row_linkcat[ 'referer' ] );
      $desc = preg_replace ( "'($var)'si" , "<strong>\\1</strong>" , $introcontent);
      $link = preg_replace ( "'($var)'si" , "<strong>\\1</strong>" ,  $row_linkcat[ 'address' ]  );
 
        foreach($trimmed_array as $trimm){
            if($trimm != 'b' ){
                $title = preg_replace( "'($trimm)'si" ,  "<strong>\\1</strong>" , $title);
                $desc = preg_replace( "'($trimm)'si" , "<strong>\\1</strong>" , $desc);
                $link = preg_replace( "'($trimm)'si" ,  "<strong>\\1</strong>" , $link);
             }
        }
 
        
            echo '<div class="search-result">';
                echo '<div class="search-title">'.$title.'</div>';
                echo '<div class="search-text">';
                    echo $desc;
                echo '</div>';
                echo '<div class="search-link">';
                echo $link;
                echo '</div>';
            echo '</div>';
 
    }  
 
    if($row_num_links_main > $limit){
    
        if ($s >=1) { 
            $prevs=($s-$limit);
            echo '<div class="search"><a class="btn btn-primary" href="'.$PHP_SELF.'?s='.$prevs.'&q='.$var.'">Previous</a>
            ';
        }
    
        $slimit =$s+$limit;
        if (!($slimit >= $row_num_links_main) && $row_num_links_main!=1) {
            
            $n=$s+$limit;
            echo '<a class="btn btn-primary" href="'.$PHP_SELF.'?s='.$n.'&q='.$var.'">Next</a>
            </div>';
        }
    }
}
?>
        </div>
      </div>
     
       <div class="row">
        <div class="span12">
<?php

$hostname = "localhost"; 
$username = "user"; 
$password = "pass"; 
$dbName = "database"; 
 

$table = "visitor_tracking";
 

mysql_connect($hostname, $username, $password) or die ("Не могу создать соединение");
 

mysql_select_db($dbName) or die (mysql_error());

$query = "SELECT * FROM $table ORDER BY timestamp DESC LIMIT 10";
 
$res = mysql_query($query) or die(mysql_error());
 
echo ("
<!DOCTYPE html>
<head>
 
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
 
    <title>Sm0k3 HQ - IP Tracker</title>
 
</head>
 
<body>
 
<h3>IPTracker data table: 10 latest requests</h3>
 
<table class='table table-bordered'>
 <tr class='info'>
  <td align=\"center\"><b>ID</b></td>
  <td align=\"center\"><b>IP</b></td>
  <td align=\"center\"><b>Time</b></td>
  <td align=\"center\"><b>From URL</b></td>
  <td align=\"center\"><b>To URL</b></td>
  <td align=\"center\"><b>Agent</b></td>
 </tr>
");
 

while ($row = mysql_fetch_array($res)) {
    echo "<tr>\n";
    echo "<td>".$row['entry_id']."</td>\n";
    echo "<td>".$row['address']."</td>\n";
    echo "<td>".$row['timestamp']."</td>\n";
    echo "<td>".$row['referer']."</td>\n";
    echo "<td>".$row['requestUri']."</td>\n";
    echo "<td>".$row['agent']."</td>\n</tr>\n";
}
 
echo ("</table>\n");
 
mysql_close();
?>
 </div>
 </div>
 
    </div>
 

      
  <?php
}


// *********************************************** //
// ********** FORM HAS BEEN SUBMITTED ********** //
// *********************************************** //

else if (isset($_POST['submit'])) {

  if ($_POST['username'] == $username && $_POST['password'] == $password){
  
    //IF USERNAME AND PASSWORD ARE CORRECT SET THE LOG-IN SESSION
    $_SESSION["login"] = $hash;
    header("Location: $_SERVER[PHP_SELF]");
    
  } else {
    
    // DISPLAY FORM WITH ERROR
    display_login_form();
    echo '<div class="container"><div class="row"><div class="span4 offset4"><div class="alert alert-error"><p>Username or password is invalid</p></div></div></div></div>';
    
  }
} 
  
  
// *********************************************** //
// ********** SHOW THE LOG-IN FORM  ********** //
// *********************************************** //

else { 

  display_login_form();

}


function display_login_form(){ ?>
<div class="container">
  <div class="row">
  <div class="span4 offset4">
  <div class="hero-unit">
  <form action="<?php echo $self; ?>" method='post'>
  <label for="username">Username</label>
  <input type="text" name="username" id="username">
  <label for="password">Password</label>
  <input type="password" name="password" id="password">
  <button class="btn btn-info btn-large" type="submit" name="submit" value="">Submit</button>
  &nbsp;<noindex><a rel="nofollow" class="btn btn-info btn-large" href="http://sm0k3.net">Back</a></noindex>
  <p>@ Beta testing @</p>
  </form> 
  </div>
 </div></div>
</div>
<?php } ?>

  </div>
</body>
</html>

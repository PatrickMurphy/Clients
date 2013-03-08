<?php
Session_Start();
if (isset($_GET['claimid'])){
$link = mysql_connect('localhost', 'grimhqco_slapweb', 'cowcow1');
mysql_select_db('grimhqco_slapdashwebdeisgn', $link);
mysql_query("UPDATE bids SET claimed=1, designer=".$_SESSION['userid']." WHERE id=".$_GET['claimid']) or die(mysql_error());
$bidres = mysql_query('SELECT subject, message FROM bids WHERE id='.$_GET['claimid']) or die(mysql_error());
$bid = mysql_fetch_array($bidres);
$qShowStatus         = "SHOW TABLE STATUS LIKE 'clients'";
$qShowStatusResult     = mysql_query($qShowStatus) or die ( "Query failed: " . mysql_error() . "<br/>" . $qShowStatus );
$row = mysql_fetch_assoc($qShowStatusResult);
$fromid = $row['Auto_increment']; 
$date = date('Y-m-d');

mysql_query('INSERT INTO comments VALUES(0, 1, 0, 0, 1, '.$fromid.', '.$_SESSION['userid'].', \''.$bid['subject'].'\', \''.$bid['message'].'\', \''.$date.'\')') or die(mysql_error());
header('location: index.php?act=createclient&bidid='.$_GET['claimid']);
}
?>
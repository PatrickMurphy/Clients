<?php
Session_Start();
$link = mysql_connect('localhost', 'grimhqco_slapweb', 'cowcow1');
mysql_select_db('grimhqco_slapdashwebdeisgn', $link);
//handle the form through ajax then output it.
if ($_GET['table'] == 'websites'){
	//type = websites;
	$type = 0;
}else{
	//type = photos;
	$type = 1;
}
if (isset($_GET['listid'])){
	if($_GET['action']=='delete'){
		mysql_query('DELETE FROM list WHERE id=\'' . $_GET['listid'] . ' \'');
	}else{
		mysql_query('UPDATE list SET finished=\'1\' WHERE id=\''. $_GET['listid'] .'\' ');
	}
}
if (isset($_GET['desc'])) {
	mysql_query('INSERT INTO list VALUES( 0, '.$_GET['jobid'].', \''.$_GET['desc'].'\', 0, '.$_SESSION['userid'].', '.$type.' )') or die(mysql_error());  
}
if(isset($_GET['jobid'])){
	$next = $_GET['jobid'];
}else{
$qShowStatus         = "SHOW TABLE STATUS LIKE '".$table."'";
$qShowStatusResult     = mysql_query($qShowStatus) or die ( "Query failed: " . mysql_error() . "<br/>" . $qShowStatus );
$row = mysql_fetch_assoc($qShowStatusResult);
$next = $row['Auto_increment']; 
}

?>
<div class="weblist">
<ul>
<input type="hidden" id="delete" value="delete"><input type="hidden" id="finished" value="finished">
<?php
$finishedcount = 0;
$count = 0;
$result = mysql_query('SELECT * FROM list WHERE jobid='.$next.' AND type = '.$type.' ORDER BY finished,id ASC');
while($list = mysql_fetch_array($result)){
	if($list['finished']==1){
		$strike = ' class="finished"';
		$finishedcount++;
	}else{
		$strike = NULL;
	}
	$count++;
	print '<li'.$strike.' id="'.$list['id'].'">'.$list['desc'].'<input type="hidden" id="id'.$count.$list['id'].'" value="'.$list['id'].'"> | <button onclick="javascript: MyAjaxRequest(\'lists\',\'createlistaction.php?table='.$_GET['table'].'&jobid='.$_GET['jobid'].'&listid=\',\'id'.$count.$list['id'].'\',\'&action=\',\'finished\')">Finished</button> | <button onclick="javascript: MyAjaxRequest(\'lists\',\'createlistaction.php?table='.$_GET['table'].'&jobid='.$_GET['jobid'].'&listid=\',\'id'.$count.$list['id'].'\',\'&action=\',\'delete\')">delete</button></li>';
}
if ($count==0){
	print 'No Checkpoints created yet for this project.';
}
print '</div>';
?>
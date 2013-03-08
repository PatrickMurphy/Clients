<div id="lists">
	<div class="weblist">
<ul>
<input type="hidden" id="delete" value="delete"><input type="hidden" id="finished" value="finished" />
<?php
if ($table == 'websites'){
	//type = websites;
	$type = 0;
}else{
	//type = photos;
	$type = 1;
}
if(isset($jobid)){
	$next = $jobid;
}else{
$qShowStatus         = "SHOW TABLE STATUS LIKE '".$table."'";
$qShowStatusResult     = mysql_query($qShowStatus) or die ( "Query failed: " . mysql_error() . "<br/>" . $qShowStatus );
$row = mysql_fetch_assoc($qShowStatusResult);
$next = $row['Auto_increment']; 
}


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
	print '<li'.$strike.' id="'.$list['id'].'">'.$list['desc'].'<input type="hidden" id="id'.$count.$list['id'].'" value="'.$list['id'].'"> | <button onclick="javascript: MyAjaxRequest(\'lists\',\'createlistaction.php?table='.$table.'&jobid='.$jobid.'&listid=\',\'id'.$count.$list['id'].'\',\'&action=\',\'finished\')">Finished</button> | <button onclick="javascript: MyAjaxRequest(\'lists\',\'createlistaction.php?table='.$table.'&jobid='.$jobid.'&listid=\',\'id'.$count.$list['id'].'\',\'&action=\',\'delete\')">delete</button></li>';
}
if ($count==0){
	print '<b>No Checkpoints created yet for this project.</b>';
}
print '</div>';
?>
</div>
<input type="text" id="desc" name="desc" value="Description"><input type="hidden" id="jobid" name="jobid" value="<?php print $next; ?>" />
<button id="editbutton" onclick="javascript: MyAjaxRequest('lists','createlistaction.php?table=<?php print $table; ?>&jobid=','jobid','&desc=','desc')">Add Step to List</button>
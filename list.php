<div class="weblist">
<ul>
<?php
$finishedcount = 0;
$count = 0;
if ($table == 'websites'){
	//type = websites;
	$type = 0;
}else{
	//type = photos;
	$type = 1;
}
if (isset($idjobid)){
	$jobid = $idjobid;
}else{
	$jobid = $_GET['id'];
}
$result = mysql_query('SELECT * FROM list WHERE jobid='.$jobid.' AND type = '.$type.' ORDER BY finished,id ASC');
while($list = mysql_fetch_array($result)){
	if($list['finished']==1){
		$strike = ' class="finished"';
		$finishedcount++;
	}else{
		$strike = NULL;
	}
	$count++;
	print '<li'.$strike.' id="'.$list['id'].'">'.$list['desc'].'</li>';
}
if ($count==0){
	print 'No Checkpoints created yet for this project.';
}else{
	$progress = ($finishedcount/$count);
	$progress = ceil($progress*100);
	?>
	</ul>
	<div style="background:red; width:250px;"><div style="background:green; width:<?php print $progress; ?>%;"><span style="color:white; padding:3px;"><?php print $progress;?>% Finished</span></div></div>
	<?php 
}
?>
</div>
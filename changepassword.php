<?php
if(isset($_POST['submit'])){
	if($_SESSION['ifisdesigner']){
		$table='clients';
	}else{
		$table='designers';
	}
	$clientres = mysql_query('SELECT id, password FROM '.$table.' WHERE id='.$_SESSION['userid']) or die(mysql_error());
	$client = mysql_fetch_array($clientres);
	if ($_POST['pass1'] == $_POST['pass2'] && $_POST['pass1'] != $_POST['pass3'] && md5($_POST['pass1']) == $client['password']){
		$newpassword = md5($_POST['pass3']);
		mysql_query('UPDATE '.$table.' SET password= \''.$newpassword.'\' WHERE id='.$_SESSION['userid']) or die(mysql_error());
		print'<div class="success"><b>Password Changed Successfully</b></div>';
	}else{
		print'<div class="error"><b>Error:</b> The passwords you entered where invalid for one or more reasons.</div>';
	}
}else{
?>
<h1>Change Password</h1>
<form action="index.php?act=changepassword" method="post">
	<label for="pass1">
		Current Password:
	</label>
	<input type="password" id="pass1" name="pass1" />
	<label for="pass2">
		Repeate Current Password:
	</label>
	<input type="password" id="pass2" name="pass2" />
	<label for="pass3">
		New Password:
	</label>
	<input type="password" id="pass3" name="pass3" />
	<input type="submit" name="submit" value="Change Password" class="submit" />
</form>
<?php
}
?>
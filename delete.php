<?php
if($_GET['confirm']=='YES'){
    if (isset($_GET['table'])) {
    	if($_GET['table']=='clients'){
    		mysql_query('DELETE FROM `websites` WHERE `clientid` = \'' . $_GET['id'] . '\'');
    	}
        mysql_query('DELETE FROM `' . $_GET['table'] . '` WHERE `id` = \'' . $_GET['id'] . '\'');
        print '<div class="success">Deleted Record Successfully</div>';
    }
}else{
	if($_GET['table']=='clients'){
		$clients = 'You are deleteing an entire Client. This means all the websites associated with this client will be destroyed also.';
	}
	print '<div class="error">Are you sure you want to delete this information from the table '.$_GET['table'].'?<br /> '.$clients.' <br /> This Action can not be un-done.<br />  Are you Completely Sure you want to destroy this information?</div>
	<a id="editbutton" href="index.php?act=7&confirm=YES&table='.$_GET['table'].'&id='.$_GET['id'].'">Yes Delete!</a>
	<a id="editbutton" class="reset" href="index.php">No Don\'t Delete!</a><br /><br style="clear:both;" />';

}
?>
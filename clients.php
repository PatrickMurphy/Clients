<?php
//clients.php
print'<!-- Clients.php -->';
?>
<div id="table-block">
<h1>Clients</h1>
<div>
<?php
print'
<style type="text/css">
#tableheader a:hover:after {
    content:url(images/';
    if( $_GET['dir'] == 'DESC'){
            print'up.gif';
        }else{
            print 'down.gif';
        }
    print ');
}
#tableheader a {
    color:white;    
}
</style>';
if (isset($_POST['submit'])) {
    $error = null;
    if (empty($_POST['name'])) {
        $error['name'] = 'The name field was left empty, it is required';
    }
    if (empty($_POST['clientid'])) {
        $error['clientid'] = 'The Client Id field was left empty, it is required';
    }
    if ($_POST['password'] == 'New Password') {
        if ($_POST['submit'] == 'Create Client') {
            $error['Password'] =
                'If you are creating a new client, you must set a password for them, you can not leave this empty';
        } else {
            $password = null;
        }
    }
    if ($error == null) {
        if ($_POST['submit'] == 'Create Client') {
            $query = "INSERT INTO clients VALUES(0, '" . $_POST['name'] . "', '" . $_POST['email'] .
                "', '" . $_POST['ip'] . "', '" . $_POST['clientid'] . "', '" . md5($_POST['password']) .
                "')";
        } else {
            $query = "UPDATE clients SET name = '" . $_POST['name'] . "', email = '" . $_POST['email'] .
                "', ip='" . $_POST['ip'] . "', clientid='" . $_POST['clientid'] . "'";
            if ($password != null) {
                $query = $query . ", password='" . md5($_POST['password']) . "'";
            }
            $query = $query . " WHERE id = " . $_GET['id'];
        }
        if ($ifquery = mysql_query($query)) {
            print '<div class="success">The Client <b>' . $_POST['name'] .
                '</b> was Created/Edited.';
        } else {
            print '<div class="error">MYSQL query error:' . mysql_error() . '</div>';
        }
    } else {
        foreach ($error as $errors) {
            print '<div class="error">' . $errors . '</div>';
        }
    }
} else {
    print "<table cellspacing=\"0\" cellpadding=\"0\"><tbody><tr id=\"tableheader\" class=header>";
    $n = 0;
        if(isset($_GET['orderby'])){
        if( $_GET['dir'] == 'DESC'){
            $direction = 'ASC';
        }else{
            $direction = 'DESC';
        }
        $query = "SELECT * FROM clients ORDER BY " . $_GET['orderby'] . ' ' . $_GET['dir'];
    }else{
        $query = "SELECT * FROM clients ORDER BY id DESC";
    }
    print '<td><a href="index.php?act=01&orderby=id&dir='.$direction.'">id</a>';
    if ($_GET['orderby']=='id'){
        if($_GET['dir']=='DESC'){
            print'<img src="images/down.gif" alt="down" width="10" height="10">';   
        }else{
            print'<img src="images/up.gif" alt="up" width="10" height="10">';   
        }
    }
    print '</td><td><a href="index.php?act=01&orderby=name&dir='.$direction.'">name</a>';
    if ($_GET['orderby']=='name'){
        if($_GET['dir']=='DESC'){
            print'<img src="images/down.gif" alt="down" width="10" height="10">';   
        }else{
            print'<img src="images/up.gif" alt="up" width="10" height="10">';   
        }
    }
    print '</td><td><a href="index.php?act=01&orderby=email&dir='.$direction.'">email</a>';
        if ($_GET['orderby']=='email'){
        if($_GET['dir']=='DESC'){
            print'<img src="images/down.gif" alt="down" width="10" height="10">';   
        }else{
            print'<img src="images/up.gif" alt="up" width="10" height="10">';   
        }
    }
    print '</td><td>Jobs</td><td><a href="index.php?act=01&orderby=ip&dir='.$direction.'">ip address</a>';
    if ($_GET['orderby']=='ip'){
        if($_GET['dir']=='DESC'){
            print'<img src="images/down.gif" alt="down" width="10" height="10">';   
        }else{
            print'<img src="images/up.gif" alt="up" width="10" height="10">';   
        }
    }
    print '</td><td><a href="index.php?act=01&orderby=clientid&dir='.$direction.'">clientid</a>';
    if ($_GET['orderby']=='clientid'){
        if($_GET['dir']=='DESC'){
            print'<img src="images/down.gif" alt="down" width="10" height="10">';   
        }else{
            print'<img src="images/up.gif" alt="up" width="10" height="10">';   
        }
    }
    print '</td><td>password</td><td>Actions</td></tr>';
    $tablename = "clients";
    if ($result = mysql_query($query, $link)) {
        while ($row = mysql_fetch_array($result)) {
            if ($n == 1) {
                print '<tr class="alternate">';
                $n = 0;
            } else {
                print '<tr>';
                $n = 1;
            }
            $query1 = mysql_query('SELECT id, title FROM photos WHERE clientid=' . $row['id']) or die(mysql_error());
            $query2 = mysql_query('SELECT id, title FROM websites WHERE clientid=' . $row['id']) OR die(mysql_error());
            $websites = '';
            $number = mysql_num_rows($query1);
            $number = $number + (mysql_num_rows($query2));
            $aofatwo = 100;
            $sep = '|';
            if ($number > 2){
            $aofatwo++;
            	$websites = '<ul id="sddm"><li><a href="index.php?act=clientview&id='.$row['id'].'" 
        	onmouseover="mopen(\'m'.$aofatwo.'\')" 
        	onmouseout="mclosetime()">Gigs</a><div id="m'.$aofatwo.'">';	
        	$sep = NULL;
            }
	            while ($websiteinfo = mysql_fetch_array($query1)){
	                $websites = $websites . ' '.$sep.' <a href="index.php?act=photo&id=' . $websiteinfo['id'] . ' ">' . $websiteinfo['title'] . '</a>';
	            }
	            while ($websiteinfo = mysql_fetch_array($query2)){
	                $websites = $websites . ' '.$sep.' <a href="index.php?act=04&id=' . $websiteinfo['id'] . ' ">' . $websiteinfo['title'] . '</a>';
	            }
            if ($number > 2){
            	$websites = $websites . '</div></li></ul>';
            }
            print '<td><form action="index.php?act=01&id=' . $row['id'] . '" id="' . $row['id'] .
                '" method="post">';
            print '<b><a href="index.php?act=clientview&id=' . $row['id'] . '">' . $row['id'] . '</a></b></td>';
            print '<td><input type="text" name="name" value="' . $row['name'] . '"></td>';
            print '<td><input type="text" name="email" value="' . $row['email'] . '"></td>';
            print '<td>' . $websites . '</td>';
            print '<td><input type="text" name="ip" value="' . $row['ip'] . '"></td>';
            print '<td><input type="text" name="clientid" value="' . $row['clientid'] .
                '"></td>';
            print '<td><input type="text" name="password" value="New Password"></td>';
            print '<td><input type="submit" class="submit" name="submit" value="Edit Client"></td>';
            print '</form></tr>';
        }
        if ($n == 1) {
            print '<tr class="alternate">';
            $n = 0;
        } else {
            print '<tr>';
            $n = 1;
        }
        print '<td><form action="index.php?act=01" id="new" method="post">';
        print '<b>Create New client</b></td>';
        print '<td><input type="text" name="name" value="John Doe"></td>';
        print '<td><input type="text" name="email" value="DoeJ@domain.com"></td>';
        print '<td><a href="index.php?act=05">Create new Website</a> | <a href="index.php?act=createphoto">Create new Photo</a></td>';
        print '<td><input type="text" name="ip" value="" id="readonly"></td>';
        print '<td><input type="text" name="clientid" value="johndoe"></td>';
        print '<td><input type="text" name="password" value="New Password"></td>';
        print '<td><input type="submit" class="submit" name="submit" value="Create Client"></td>';
        print '</form></tr>';

    } else {
        print 'error';
    }
    print '</tbody></table>';
}
?>
</div></div>
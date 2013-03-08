<?php
//LOGIN.php
Session_start();
if ($_GET['act'] == "logout") {
    if (isset($_COOKIE[session_name()])) {
    	$names = array();
    	$names[0] = session_name();
    	$names[1] = 'username';
    	$names[2] = 'password';
    	foreach ($names as $name){
        setcookie($name, '', time() - 42000, '/');
        }
    }
    session_destroy();
    header('location: index.php?msgtype=success&msg=You%20have%20been%20Logged%20Out.');
}
if (isset($_POST['login'])) {
    $link = mysql_connect('localhost', 'grimhqco_slapweb', 'cowcow1') or die(mysql_error());
    mysql_select_db('grimhqco_slapdashwebdeisgn', $link) or die(mysql_error());
    $query[1] = "SELECT * FROM clients WHERE clientid = '" . $_POST['username'] .
        "' LIMIT 1";
    $query[2] = "SELECT * FROM designers WHERE designerid = '" . $_POST['username'] .
        "' LIMIT 1";
        $empty=0;
    for ($i = 1; $i < 3; $i++) {
        if ($result = mysql_query($query[$i], $link)) {
        	if (mysql_num_rows($result)==0){
        		$empty++;
        	}
            while ($row = mysql_fetch_array($result)) {
                if ($row['password'] == md5($_POST['password'])) {
                    $error = 0;
                    $_SESSION['loggedin'] = 1;
                    $_SESSION['userid'] = $row['id'];
                    $_SESSION['email'] = $row['email'];
                    setcookie('username', $_POST['username'], time()+60*60*24*30);
                    setcookie('password', md5($_POST['username'].md5($_POST['password'])), time()+60*60*24*30);
                    if ($i == 1) {
                        $_SESSION['ifisdesigner'] = 2;
                        $_SESSION['username'] = $row['clientid'];
                        mysql_query("UPDATE clients SET ip='" . $_SERVER['REMOTE_ADDR'] . "' WHERE id='" . $row['id'] . "'") or die(mysql_error());
                    } else {
                        $_SESSION['ifisdesigner'] = 1;
                        $_SESSION['username'] = $row['designerid'];
                        mysql_query("UPDATE designers SET ip='" . $_SERVER['REMOTE_ADDR'] . "' WHERE id='" . $row['id'] . "'") or die(mysql_error());
                    }
                    header('location: index.php');
                } else {
                    $error = 1;
                    header('location: index.php?msgtype=error&msg=The Password you entered did not match our records.');
                }
                }
            }else{
        		die(mysql_error());
        	}	
            }
            if($empty == 2){
            	header('location: index.php?msgtype=error&msg=The Username you entered did not match our records.');	
            }
} else {
    print 'You must be directed by a login form to visit this page.';
}
?>
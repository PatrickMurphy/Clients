<?
session_start();
$link = mysql_connect('localhost', 'grimhqco_user', 'password');
mysql_select_db('grimhqco_slapdashwebdeisgn', $link);
if ($_SESSION['loggedin'] == 1) {
    switch ($_GET['act']) {
        case 01:
            if ($_SESSION['ifisdesigner'] == 1) {
                $page = "clients.php";
            } else {
                $page = "client.php";
            }
        break;
        case 02:
            $page = "payments.php";
        break;
        case 04:
            $page = "website.php";
        break;
        case 'photo':
            $page = "photos.php";
        break;
        case 05:
            $page = "createwebsite.php";
        break;
        case 'createphoto':
            $page = "createphoto.php";
        break;
        case 06:
            $page = "editwebsite.php";
            $_SESSION['ifisdesigner'] = 1;
        break;
        case 'editphoto':
            $page = "editphoto.php";
            $_SESSION['ifisdesigner'] = 1;
        break;
        case 07:
            $page = "delete.php";
        break;
        case 'editclient':
            $page="editclient.php";
        break;
        case 'Search':
            $page="search.php";
        break;
        case 'clientview':
            $page = 'clientview.php';
        break;
        case 'designerview':
            $page = 'designerview.php';
        break;
        case 'inbox':
            $page = 'inbox.php';
        break;
        case 'createlist':
        	$page = 'createlist.php';
        break;
        case 'createclient':
        	$page = 'createclient.php';
        break;
        case 'changepassword':
        	$page = 'changepassword.php';
        break;
        default:
            $page = 'home.php';
        break;
    }
    
} else {
    //login form
    if (isset($_COOKIE['username']) && isset($_COOKIE['password'])){
	$query[1] = "SELECT * FROM clients WHERE clientid = '" . $_COOKIE['username'] . "' LIMIT 1";
	    $query[2] = "SELECT * FROM designers WHERE designerid = '" . $_COOKIE['username'] . "' LIMIT 1";
	    for ($i = 1; $i < 3; $i++) {
	        if ($result = mysql_query($query[$i], $link)) {
	            while ($row = mysql_fetch_array($result)) {
	                if (md5($_COOKIE['username'].$row['password']) == $_COOKIE['password']) {
	                    $error = 0;
	                    $_SESSION['loggedin'] = 1;
	                    $_SESSION['userid'] = $row['id'];
	                    $_SESSION['email'] = $row['email'];
	                    setcookie('username', $_COOKIE['username'], time()+60*60*24*30);
	                    setcookie('password', $_COOKIE['password'], time()+60*60*24*30);
	                    if ($i == 1) {
	                        $_SESSION['ifisdesigner'] = 2;
	                        $_SESSION['username'] = $row['clientid'];
	                        mysql_query("UPDATE clients SET ip='" . $_SERVER['REMOTE_ADDR'] . "' WHERE id='" . $row['id'] . "'") or die(mysql_error());
	                    } else {
	                        $_SESSION['ifisdesigner'] = 1;
	                        $_SESSION['username'] = $row['designerid'];
	                        mysql_query("UPDATE designers SET ip='" . $_SERVER['REMOTE_ADDR'] . "' WHERE id='" . $row['id'] . "'") or die(mysql_error());
	                    }
	                    print'<!--LOGIN BY COOKIE-->';
	                    $page = 'home.php';
	                } else {
	                    $error = 1;
	                }
	                }
	            }else{
	        		die(mysql_error());
	        	}	
	            }    	
    }else{
   	$page = 'logininc.php';
   }
}
include ('top.php');
include ($page);
include ('bot.php');
?>
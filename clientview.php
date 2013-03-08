<?php
//client.php
$idtype = $_GET['id'];
print'<!-- Clientview.php -->';
$query = "SELECT * FROM clients WHERE id=" . $idtype . ' LIMIT 1';
$tablename = "clients";
if ($result = mysql_query($query)) {
    while ($row = mysql_fetch_array($result)) {
    print'<a id="editbutton" href="index.php?act=inbox&reply=1&title=&isdesigner='.$_SESSION['ifisdesigner'].'&toid=' . $_SESSION['userid'] . '">Send PM</a>';
            if ($_SESSION['ifisdesigner'] === 1) {
        print '<a id="editbutton" href="index.php?act=editclient&id=' . $row['id'] .
            '">Edit</a> <a id="editbutton" class="reset" href="index.php?act=7&table=clients&id=' . $row['id'] .
            '">Delete</a>';
    }
    print'<br /><br style="clear:both;" />';
        $websiteresult = mysql_query('SELECT id FROM websites WHERE clientid=' . $idtype);
        $photoresult = mysql_query('SELECT id FROM photos WHERE clientid=' . $idtype);
        print '<h1>' . $row['name'] . '</h1>';
        print '<table id="showwebsite">';
        print '<tr><td>Name: </td><td>' . $row['name'];
        print '</td></tr><tr><td>Email:</td><td>' . $row['email'];
        print '</td></tr><tr><td>Client IP:</td><td>' . $row['ip'];
        print '</td></tr><tr><td>Client Login:</td><td>' . $row['clientid'];
        print '</td></tr></table>';
        while ($websiteinfo = mysql_fetch_array($websiteresult)) {
            $websiteid = $websiteinfo['id'];
            print '<blockquote>';
            $idjobid = $websiteid;
            include ('website.php');
            print '</blockquote><br><br><br><br>';
        }
        while ($photoinfo = mysql_fetch_array($photoresult)) {
            $photoid = $photoinfo['id'];
            print '<blockquote>';
            $idjobid = $photoid;
            include ('photos.php');
            print '</blockquote><br><br><br><br>';
        }
    }
}
?>
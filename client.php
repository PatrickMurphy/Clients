<?php
//client.php
//include('review.php');
$idtype = $_SESSION['userid'];
$finished == TRUE;
print'<!-- Client.php -->';
$clientquery = "SELECT * FROM clients WHERE id='" . $idtype . '\' LIMIT 1';
if ($result = mysql_query($clientquery)or DIE(mysql_error().' The query was = '.$clientquery) ) {
   while($row = mysql_fetch_array($result)){
        $websiteresult = mysql_query('SELECT id, finished FROM websites WHERE clientid=' . $_SESSION['userid']);
        $photosresult = mysql_query('SELECT id, finished FROM photos WHERE clientid=' . $_SESSION['userid']);
        print '<h1>Welcome <b>' . $row['name'] . '</b>!</h1>';
        print '<p><ol><li>Your Email:' . $row['email'] . '</li>';
        print '<li>Login:' . $row['clientid'] . '</li></ol></p>';
        while ($websiteinfo = mysql_fetch_array($websiteresult)) {
            $websiteid = $websiteinfo['id'];
            $id = $websiteinfo['id'];
            $table='websites';
            print '<blockquote>';
            include ('website.php');
            print '</blockquote><br><br><br><br>';
            if($websiteinfo['finished']==0){
                $finished = FAlSE;
            }
        }
        while ($photosinfo = mysql_fetch_array($photosresult)or DIE(mysql_error()) ) {
            $photosid = $photosinfo['id'];
            $id = $photosinfo['id'];
            $idjobid = $photosinfo['id'];
            $table = 'photos';
            print '<blockquote>';
            include ('photos.php');
            print '</blockquote><br><br><br><br>';
            if($photosinfo['finished']==0){
                $finished = FAlSE;                
            }
        }
    }
} else {
  print'ERROR3: '.mysql_error();
}
?>
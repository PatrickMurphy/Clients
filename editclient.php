<?php

/**
 * @author Patrick Turner, SlapdashWebdesign.info
 * @copyright 2009, All Rights Reserved
 * editclient.php
 */
    $query = "SELECT * FROM clients WHERE id = ".$_GET['id'];
    if($result = mysql_query($query, $link)){
    while($row = mysql_fetch_array($result)){
            print '<form action="index.php?act=1&id=' . $row['id'] . '" id="' . $row['id'] . '" method="post">';
            print '<label for="name">Name</label><input type="text" id="name" name="name" value="' . $row['name'] . '"><br />';
            print '<label for="email">Email</label><input type="text" id="email" name="email" value="' . $row['email'] . '"><br />';
            print '<label for="ip">IP</label><input type="text" id="ip" name="ip" value="' . $row['ip'] . '"><br />';
            print '<label for="clientid">Client ID</label><input type="text" id="clientid" name="clientid" value="' . $row['clientid'] .'"><br />';
            print '<label for="password">Password</label><input type="text" id="password" name="password" value="New Password"><br />';
            print '<input type="submit" class="submit" name="submit" value="Edit Client">';
            print '</form>';
 }
 }else{
    print mysql_error(). 'the query was:' . $query;
 }


?>
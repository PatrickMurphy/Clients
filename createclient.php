<?php
//create client
$bidresult = mysql_query('SELECT * FROM bids WHERE id ='.$_GET['bidid']);
$bid = mysql_fetch_array($bidresult);
$username = str_replace (" ", "", $bid['name']);
        print '<form action="index.php?act=01" id="new" method="post">';
        print '<h1>Create New client</h1>';
        print '<label for="name">Name</label><input id="name" type="text" name="name" value="'.$bid['name'].'">';
        print '<label for="email">Email</label><input id="email" type="text" name="email" value="'.$bid['email'].'">';
        print '<label for="username">UserName</label><input id="username" type="text" name="clientid" value="'.$username.'">';
        print '<label for="password">Password</label><input id="password" type="text" name="password" value="New Password">';
        print '<input type="submit" class="submit" name="submit" value="Create Client">';
        print '</form>';


?>
<?php
//home.php
print '<h1>Patrick Murphy Client Center</h1>';
print '<p>Welcome to '.$domain.'\'s new Client support Center!  I have designed this application to better the experience of the client, and help my clients get the results they want quicker.  This is still in it\'s early stages but you can expect many new features, and possibly some bugs I have not yet found.  I hope you enjoy it!<small>-Patrick Murphy</small></p>';
print '<p>You have: ';
print'<a href="index.php?act=inbox"><img src="images/mail.gif" alt="mail" />'.$numofpm.'</a></span>';
print ' new messages.</p>';
if ($_SESSION['ifisdesigner'] == 1) {
   $limitedbid = ' LIMIT 10';
   include('bids.php');
}
include('help.php');
?>
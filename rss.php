<?php
session_start();
$link = mysql_connect('localhost', 'grimhqco_slapweb', 'cowcow1');
mysql_select_db('grimhqco_slapdashwebdeisgn', $link);
$timestamp1 = strtotime($item['commissiondate']);
print'<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
    <channel>
        <title>Client Patrick Murphy</title>
        <link>http://www.client.patrickmurphyphoto.com/</link>
        <description>Current Projects</description>
        <lastBuildDate>Wed, 02 Oct 2002 13:00:00 GMT</lastBuildDate>
        
        <language>en-us</language>';
        $querys[0] = 'photos';
        $querys[1] = 'websites';
        foreach($querys as $query){
            $result = mysql_query('SELECT id, clientid, title, status, price, commissiondate FROM '.$query.' WHERE finished=0 ORDER BY id DESC') or die(mysql_error());
            if ($query == 'photos'){
                $act = 'photo';
                $type = 'Photos';
            }else{
                $act = '4';
                $type = 'Website';
            }
            while($item = mysql_fetch_array($result)){
                $clientresult = mysql_query('SELECT name FROM clients WHERE id='.$item['clientid']);
                $client = mysql_fetch_array($clientresult);
                $timestamp = strtotime($item['commissiondate']);
                list($month, $day, $year) = explode('/', $item['commissiondate']);
                $key = (($month*100)+$day+($year*1000)).'.'.$n2;
                $current[$key] = '<item>
                <title>'.$client['name'].' - '.$item['title'].' - '.$type.'</title>
                <link><![CDATA[ http://client.patrickmurphyphoto.com/index.php?act='.$act.'&id='.$item['id'].' ]]></link>
                <guid><![CDATA[ http://client.patrickmurphyphoto.com/index.php?act='.$act.'&id='.$item['id'].' ]]></guid>
                <pubDate>'.date('D, d M Y g:i:s O', $timestamp).'</pubDate>
                <description><![CDATA[ Type: '.$type.'<br /> 
                Client: '.$client['name'].'<br />
                Status: '.$item['status'].'<br />
                Price: $'.$item['price'].' ]]></description>
            </item>';
                $n++;
            }
        }
        krsort($current);
        foreach($current as $val){ print $val; }
    print'
    </channel>
</rss>';
?>
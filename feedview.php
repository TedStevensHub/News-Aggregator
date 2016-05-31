<?php
//feedview.php

include 'credentials.php';

session_start();
//global session that everyone is accessing?

$Feed = $_GET['feed'];
$FeedID = $_GET['feedid'];


$sqltime = "SELECT lastUpdated FROM sp16_newsFeed WHERE FeedID=$FeedID";
$connect = @mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$result = mysqli_query($connect,$sqltime) or die(trigger_error(mysqli_error($connect), E_USER_ERROR));

//get last refresh of rss feed
while ($row = mysqli_fetch_assoc($result)) {
    $lastUpdated = $row['lastUpdated'];
}   

@mysqli_free_result($result);

//add 10 minutes. this new date is when the rss feed can be refreshed
//$pastTime = strtotime("$lastUpdated + 10 minutes");
$date = date_create("$lastUpdated");
date_add($date, date_interval_create_from_date_string('10 minutes'));
$pastTime = date_format($date, 'Y-m-d H:i:s');

echo "Next available update: $pastTime <br />";


//current time
$currentTime = date("Y-m-d H:i:s");
    
echo "Current time: $currentTime <br />";

//compare current time to time when rss feed can be refreshed
if ($currentTime > $pastTime) {
    //display refreshed rss feed then update session and db
    $sqlupdate = "UPDATE sp16_newsFeed SET lastUpdated=NOW() WHERE FeedID=$FeedID";
    $connect->query($sqlupdate);
    
    $request = "https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&q=".$Feed."&output=rss";
    $response = file_get_contents($request);
    //make xml object
    $xml = simplexml_load_string($response);
    
    echo '<h1>' . $xml->channel->title . '</h1>';
    foreach($xml->channel->item as $story)
    {
        echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
        echo '<p>' . $story->description . '</p><br /><br />';
    }
    
    //update session
    //formats object into xml string
    
    //have 1 session that stores array of feedid and response
    
    
    $_SESSION["$FeedID"] = $response;
    
} else {
    //display old cached feed
    $string = $_SESSION["$FeedID"];
    $xml = simplexml_load_string($string);
    
    echo '<h1>' . $xml->channel->title . '</h1>';
    foreach($xml->channel->item as $story)
    {
        echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
        echo '<p>' . $story->description . '</p><br /><br />';
    }

    
}

@mysqli_close($connect);

?>

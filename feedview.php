<?php
//feedview.php
namespace NewsAggregator\feedView;

include('incl/credentials.php');

// Open DB connection
$link = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD, DB_NAME) or die(trigger_error(mysqli_connect_error(), E_USER_ERROR));
$feedID = $_GET['feedID'];
// Query NewsCategories
$sql = "SELECT FullUrl FROM sp16_newsFeed WHERE FeedId=".$feedID;
$result = mysqli_query($link, $sql);

mysqli_close($link);

foreach ($result as $row) {
    $feedUrl = $row['FullUrl'];
}

$response = file_get_contents($feedUrl);
$xml = simplexml_load_string($response);
mysqli_free_result($result);

print '<h1>' . $xml->channel->title . '</h1>';
foreach($xml->channel->item as $story)
{
  echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
  echo '<p>' . $story->description . '</p><br /><br />';
}

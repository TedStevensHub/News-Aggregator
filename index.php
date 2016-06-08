<?php
// index.php

include('incl/credentials.php');
include('Category.php');
include('Feed.php');

// Start Session if needed.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check Session for pre-loaded inormation
if(array_key_exists("Categories",$_SESSION))
{
    // This is where HTML generation begins.
echo '<h3 align="center">News Aggregator</h3>';

// Loop through each category element in SESSION and render category links
echo '<ul>';
    foreach ($_SESSION['Categories'] as $category){
        if($category->hasFeeds())
        {
            echo '<h4><b><li>'.$category->getName().'</li></h4></b>';
            echo '<ul>';

            foreach ($category->getFeeds() as $feed){
                // Print feed link
                echo '<li><a href="feedview.php?feedID='.urlencode($feed->id).'">'
                        .$feed->name.'</a></li>';
            }
            echo '</ul>';
        }
}
echo '</ul>';
echo '<p><a href="add-feed.php" value="Add a feed"><strong>Add a feed.</a></p><strong>';
}
else
{
// Open DB connection
$link = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD, DB_NAME) or die(trigger_error(mysqli_connect_error(), E_USER_ERROR));

// Query NewsCategories
$sql = "SELECT CategoryID, Category FROM sp16_newsCategory";
$result = mysqli_query($link, $sql);
$_SESSION['Categories'] = [];


foreach($result as $row){
    $newCat = new Category($row['Category']);
    $newCat->setID($row['CategoryID']);

    $sql = "SELECT FeedID, FeedName, Feed, nf.CategoryID, FullUrl
            FROM sp16_newsFeed AS nf
            INNER JOIN sp16_newsCategory AS nc
            ON nf.CategoryID = nc.CategoryID
            WHERE nf.CategoryID = '.$newCat->id.'";

    $result2 = mysqli_query($link,$sql);

    foreach($result2 as $row2){
        // Adds an array to SESSION at $catID, appending each result from 
        // the feed-by-category query as an array.
        $newFeed = new Feed();
        $newFeed->id=$row2['FeedID'];
        $newFeed->name=$row2['FeedName'];
        $newFeed->url=$row2['FullUrl'];
        $newCat->addFeed($newFeed);
    }
    array_push($_SESSION['Categories'],$newCat);
} 
// Free query results.
mysqli_free_result($result);
mysqli_free_result($result2);
// Close database connection
mysqli_close($link);
}


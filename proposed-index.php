<?php
// proposed-index.php
// Sam McHaney

/*
 * TO DO:
 * Check for articles inside a category before listing category.
 */
define('DB_NAME','seattlecentral_db');
define('DB_USER','sammch1');
define('DB_PASSWORD','PotatoPie69');
define('DB_HOST','sandbox.sammchaney.com'); 

// Start session
session_start();

echo '<pre>';
echo var_dump($_SESSION);
echo '<pre>';

// Cache NewsCategories to SESSION
// Appends each category name and ID from result table to the SESSION array
// located at its index 'Categories'
// Each result $row is an associative array having ["CategoryID"] and ["Category"]


    // Open DB connection
    $link = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD, DB_NAME) or die(trigger_error(mysqli_connect_error(), E_USER_ERROR));

    // Query NewsCategories
    $sql = "SELECT CategoryID, Category FROM sp16_newsCategory";
    $result = mysqli_query($link, $sql);
    echo '<p>made it!</p>';
    $_SESSION['Categories'] = [];

    foreach($result as $row){
        array_push($_SESSION['Categories'],$row);

        $catID=(int) $row['CategoryID'];
        $sql = "SELECT FeedName, Feed, nf.CategoryID
                FROM sp16_newsFeed AS nf
                INNER JOIN sp16_newsCategory AS nc
                ON nf.CategoryID = nc.CategoryID
                WHERE nf.CategoryID = '.$catID.'";

        $result2 = mysqli_query($link,$sql);

        // Creates a category array for each category, this stores the information
        // for related feeds.
            $_SESSION[$catID]=[];
            foreach($result2 as $row2){
                // Adds an array to SESSION at $catID, appending each result from 
                // the feed-by-category query as an array.
                array_push($_SESSION[$catID],$row2);
            }
    } 
    // Free query results.
    mysqli_free_result($result);
    mysqli_free_result($result2);
    // Close database connection
    mysqli_close($link);

// This is where HTML generation begins.
echo '<h3 align="center">News Aggregator</h3>';

// Loop through each category element in SESSION and render category links
echo '<ul>';
    foreach ($_SESSION['Categories'] as $category){
        
        echo '<h4><b><li>'.$category['Category'].'</li></h4></b>';
        echo '<ul>';
        foreach ($_SESSION[$category['CategoryID']] as $feed){
            // Print feed link
            echo '<li><a href="feedview.php?feed='.urlencode($feed['Feed']).'">'
                    .$feed['FeedName'].'</a></li>';
        }
        echo '</ul>';
}
echo '</ul>';

echo '<pre>';
echo var_dump($_SESSION);
echo '<pre>';
<?php
namespace NewsAggregator\addFeed;

// add-feed.php
define('DB_NAME','seattlecentral_db');
define('DB_USER','sammch1');
define('DB_PASSWORD','PotatoPie69');
define('DB_HOST','sandbox.sammchaney.com'); 

if(isset($_POST['feedUrl']) and isset($_POST['feedName']) and isset($_POST['feedCat']))
{
    $feedUrl = $_POST['feedUrl'];
    $feedName = $_POST['feedName'];
    $feedCat = $_POST['feedCat'];
    
    // Open DB connection
    $link = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD, DB_NAME) or die(trigger_error(mysqli_connect_error(), E_USER_ERROR));
    
    // check if category exists in table
    $sql = 'SELECT * FROM sp16_newsCategory WHERE Category=\''.$feedCat.'\';';
    $result = mysqli_query($link, $sql);
    
    // add category if it does not exist
    if (mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_row($result);
        $catID = (int) $row[0];
    }
    else
    {
        $sqlAddCat = 'INSERT INTO sp16_newsCategory (Category) VALUES (\''.$feedCat.'\');';
        mysqli_free_result($result);
        mysqli_query($link, $sqlAddCat);
        $result = mysqli_query($link,$sql);
        $row = mysqli_fetch_row($result);
        $catID = (int) $row[0];
    }
    
    mysqli_free_result($result);
    
    // Add feed to feed table
    $sql = 'INSERT INTO sp16_newsFeed(FeedName,CategoryID,FullUrl) VALUES (\''.$feedName.'\','.$catID.',\''.$feedUrl.'\');';
    
    if(mysqli_query($link,$sql))
    {
        echo 'Successfully added!';
    }
    else
    {
        echo $link->error;
    }
    
}
else
{
    echo '<form method="post">
        Feed name <br>
        <input type="text" name="feedName">
        <br>
        <br>
        New feed URL <br>
        <input type="url" name="feedUrl">
        <br>
        <br>
        Category <br>
        <input type="text" name="feedCat">
        <br>
        <br>
        <input type="submit" value="Submit">
        <br>
        </form>';
}

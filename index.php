<?php
//index2.php

include 'common_inc.php';
include 'credentials.php';



//SQL statement
$sql = "SELECT Category FROM sp16_newsCategory";



//database connection
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));



//an array of objects, an object is 1 of 9 of the feeds, each object has all the information from the database portaining to it. They are added to 1 of 3 arrays for each cateogry

echo '<h3 align="center">News Aggregator</h3>';

while ($row = mysqli_fetch_assoc($result)) {
    $category = $row['Category'];
    echo "<br/>$category<br/>";
    $sql2 = "SELECT FeedName, Feed FROM sp16_newsFeed nf INNER JOIN sp16_newsCategory nc ON nf.CategoryID = nc.CategoryID WHERE Category = '$category'";
    $result2 = mysqli_query(IDB::conn(),$sql2) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));    
    while ($row2 = mysqli_fetch_assoc($result2)) {
        $feedlink = new Feed($row2['FeedName'], $row2['Feed']);
        $feedlink->FeedLinks();
    }
    
}

//https://news.google.com/news/section?cf=all&hl=en&pz=1&ned=us&q='.$Feed.'&topicsid=en_us:'.$CategorySymbol.'&ict=tnv3

class Feed {
    public $FeedName = '';
    public $Feed = '';
    
    function __construct($FeedName, $Feed) {
        
        $this->FeedName = $FeedName;
        $this->Feed = $Feed;

    }//end constructor
    
    public function FeedLinks() {
    echo '<a href="feedview.php?feedname='.$this->FeedName.'&feed='.$this->Feed.'">'.$this->FeedName.'</a><br/>';
    }
    
}//end class

?>
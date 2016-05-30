<?php
//index2.php

include 'credentials.php';


//SQL statement selects Cateogries that exist in both tables
$sql = "SELECT Category FROM sp16_newsCategory";


$connect = @mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

$result = mysqli_query($connect,$sql) or die(trigger_error(mysqli_error($connect), E_USER_ERROR));


//an array of objects, an object is 1 of 9 of the feeds, each object has all the information from the database portaining to it. They are added to 1 of 3 arrays for each cateogry

echo '<h3 align="center">News Aggregator</h3>';

while ($row = mysqli_fetch_assoc($result)) {
    $category = $row['Category'];
    echo "<br/><b>$category</b><br/>";
    $sql2 = "SELECT FeedName, Feed, FeedID FROM sp16_newsFeed nf INNER JOIN sp16_newsCategory nc ON nf.CategoryID = nc.CategoryID WHERE Category = '$category'";
    $result2 = mysqli_query($connect,$sql2) or die(trigger_error(mysqli_error($connect), E_USER_ERROR));    
    while ($row2 = mysqli_fetch_assoc($result2)) {
        $feedlink = new Feed($row2['FeedName'], $row2['Feed'], $row2['FeedID']);
        $feedlink->FeedLinks();      
    }   
}
@mysqli_free_result($result);
@mysqli_close($connect);


class Feed {
    public $FeedName = '';
    public $Feed = '';
    public $FeedID = 0;
    
    function __construct($FeedName, $Feed, $FeedID) {
        
        $this->FeedName = $FeedName;
        $this->Feed = $Feed;
        $this->FeedID = $FeedID;

    }//end constructor
    
    public function FeedLinks() {
    echo '<a href="feedview.php?feed='.urlencode($this->Feed).'&feedid='.$this->FeedID.'">'.$this->FeedName.'</a><br/>';
    }
    
}//end class

?>
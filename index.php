<?php
class RSS{

    public function RSS(){
        require_once('pathto...../mysql_connect.php');

    }//end of rss function

    public function GetFeed(){
        return $this->getDetails() . $this->getItems();


    }//end of getfeed function


    private function dbConnect(){

        DEFINE('LINK', mysql_connect (DB_HOST, DB_USER, DB_PASSWORD));

    }//end of dbconnect function

    private function getDetails(){

        $detailsTable = "name of the view table used";// provide actual table
        $this->dbConnect($detailsTable);
        $query = "SELECT * FROM ". $detailsTable;
        $result = mysql_db_query (DB_NAME, $query, LINK);
        while($row = mysql_fetch_array($result))
        {
           
          $details = <?xml version="1.0" encoding="utf-8"?>
            <rss version="2.0">

                <channel>
                    <title>'. $row['title'] .'</title>
                    <link>'. $row['link'] .'</link>
                    <description>'. $row['description'] .'</description>
                </channel>
            </rss>
            
        }//end of while statement
        return $details;
    }//end of getDetails function

    private function getItems(){

        $itemsTable = "name of the list view table";
        $this->dbConnect($itemsTable);
        $query = "SELECT * FROM ". $itemsTable;
        $result = mysql_db_query(DB_NAME, $query, LINK);
        $items = '';
        while($row = mysql_fetch_array($result)){
            $items .= '<item>
                <title>'. $row["title"] .'</title>
                <link>'. $row["link"] .'</link>
                <description>'. $row["description"] .'</description>
                
        </item>';

        }//end of while statement

        $items .= '</channel>
        </rss>';
        return $items;
    }//end of getitems function    

}//end of rss class




?>

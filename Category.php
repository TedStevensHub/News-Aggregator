<?php
// Category.php
interface CategoryInterface
{
    // Category name
    public function getName();

    // Add feed to category
    public function addFeed($feed);

    // Return feeds as array
    public function getFeeds();
    
    // Return boolean of having feeds
    public function hasFeeds();
    
    public function setID($id);
    
}

class Category implements CategoryInterface
{
    
    public $name;
    public $feeds;
    public $id;
    
    public function __construct($name)
    {
        $this->name=$name;
        $this->feeds=array();
    }
    
    // Return Category name
    public function getName()
    {
        return $this->name;
    }

    // Add feed to category
    public function addFeed($feed)
    {
        $this->feeds[$feed->getName()]=$feed;
    }

    // Return feeds as array
    public function getFeeds()
    {
        return $this->feeds;
    }
    
    public function hasFeeds()
    {
        if((count($this->feeds)>0))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function setID($id)
    {
        $this->id=$id;
    }
}

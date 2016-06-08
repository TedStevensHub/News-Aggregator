<?php
// Feed.php

interface FeedInterface
{
    // Get URL
    public function getURL();
    
    // Get Name
    public function getName();
}

class Feed implements FeedInterface
{
    public $name;
    public $url;
    
    public function getName() {
        return $this->name;
    }

    public function getURL() {
        return $this->url;
    }

}

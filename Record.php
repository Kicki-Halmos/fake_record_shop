<?php

/****************************************************************
 * a class that describes a record post
 */
class Record{

    private $id;
    private $artist;
    private $title;
    private $description;
    private $image;
    private $price;
    private $genre;

    /**
     * constructor - creates an object
     */

    public function __construct($id, $artist, $title, $description, $image, $price, $genre){
        $this->id = $id;
        $this->artist = $artist;
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->price = $price;
        $this->genre = $genre;

   
    }
    public function toArray(){
        $array = array(
            "id" => $this->id,
            "artist" => $this->artist,
            "title" => $this->title,
            "description" => $this->description,
            "image" => $this->image,
            "price" => $this->price,
            "genre" => $this->genre
        );

        return $array;
    }


}


?>
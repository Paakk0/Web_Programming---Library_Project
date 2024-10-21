<?php

    class Book {

        public $id, $title, $pages, $image, $price, $available_pieces;

        public function __construct($id, $title, $pages, $image, $price, $available_pieces) {
            $this->id               = $id;
            $this->title            = $title;
            $this->pages            = $pages;
            $this->image            = $image;
            $this->price            = $price;
            $this->available_pieces = $available_pieces;
        }
    }
    
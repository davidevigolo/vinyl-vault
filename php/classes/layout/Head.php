<?php

class Head{
    private $path = 'layout/head.html';
    private $title;
    private $description;
    private $keywords;

    public function __construct($title, $description, $keywords){
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
    }

    public function render(){
        return Template::render($this->path, [
            'title' => $this->title,
            'description' => $this->description,
            'keywords' => $this->keywords
        ]);
    }
}
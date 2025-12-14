<?php
class Header{
    private $path = 'layout/header.html';

    /* Default constructor as there are no dynamic values */
    public function render(){
        return Template::render($this->path, []);
    }
}
<?php

namespace bachphuc\LaravelGalleryImage\Components;

use bachphuc\LaravelHTMLElements\Components\BaseElement;

class GalleryImageElement extends BaseElement
{
    protected $baseViewPath = 'bachphuc.gallery';
    protected $viewPath = 'gallery';

    public function getTitle(){
        $title = $this->getAttribute('title');
        if(!empty($title)){
            return $title;
        }
        $title = $this->getAttribute('name');
        if(!empty($title)){
            return $title;
        }
        return null;
    }

    public function render($params = []){
        $this->setAttribute('title', title_case($this->getTitle()));
        return parent::render($params);
    }
}
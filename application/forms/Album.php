<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Form_Album extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);

        $this->setMethod('post');
        
        $albumid = new Zend_Form_Element_Hidden('albumid');
        
        $artist = new Zend_Form_Element_Text('artist');
        $artist->setLabel('Artist')->setRequired(true);
       
        
        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Title')->setRequired(true);
        
        $submit = new Zend_Form_Element_Submit('submit');
        
        $this->addElements(array( $albumid,$artist,$title,$submit));
    }
}

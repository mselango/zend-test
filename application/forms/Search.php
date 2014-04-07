<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Form_Search extends Zend_Form
{
    
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setMethod('post');
        $this->addElement('text','search');
        
       $this->addElement('submit', 'submit');
    }
}

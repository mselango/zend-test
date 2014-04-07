<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Form_Login extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
      
        $length=array("min" => 3, "max" => 50);
        $namechk = array(
        'table'   => 'users',
        'field'   => 'username',
        
    );
        
        
        $this->setMethod('post');
        $this->setAttrib('id', 'login');
        $validator = new Zend_Validate_StringLength(8);

        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('username')->setRequired(true)->setAttrib('class', 'validate[required]');
         $username->setValidators(array( new Zend_Validate_Alpha(),new Zend_Validate_StringLength($length),new Zend_Validate_Db_RecordExists($namechk)));
        
        
         $username->setDecorators(array(
        'ViewHelper', 'Description', 'Errors',
        array(array('data' => 'HtmlTag'), array('tag' => 'span')),
        array('Label', array('tag' => 'span')),
        array(array('row' => 'HtmlTag'), array('tag' => 'p', 'class' => 'clear'))
        ));

          
        $password = new Zend_Form_Element_Text('password');
        $password->setLabel('password')->setRequired(true)->setAttrib('class', 'validate[required]');;
        
         $password->setDecorators(array(
        'ViewHelper', 'Description', 'Errors',
        array(array('data' => 'HtmlTag'), array('tag' => 'span')),
        array('Label', array('tag' => 'span')),
        array(array('row' => 'HtmlTag'), array('tag' => 'p', 'class' => 'clear'))
        ));
            
        $submit = new Zend_Form_Element_Submit('submit');
      
        $this->addElements(array($username,$password,$submit));
             
      
    }
}

<?php

class Application_Form_Register extends Zend_Form
{

    public function init()
    {
    	$login = new Zend_Form_Element_Text('login');
		$login->setLabel('login')
		->setRequired(true);
		
		$password = new Zend_Form_Element_Password('password');
		$password->setLabel('password')
		->setRequired(true);
		
		$submit = new Zend_Form_Element_Submit('sub');
		$submit->SetLabel('submit information');
		
		$this->addElements(array($login, $password, $submit));
    }
}


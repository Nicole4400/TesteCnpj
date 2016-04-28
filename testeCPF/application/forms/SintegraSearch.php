<?php

class Application_Form_SintegraSearch extends Zend_Form
{

    public function init()
    {
        $cnpj = new Zend_Form_Element_Text('cnpj');
		$cnpj->setLabel('cnpj')
		->setRequired(true);
		
		$submit = new Zend_Form_Element_Submit('sub');
		$submit->SetLabel('search cnpj ');
		
		$this->addElements(array($cnpj, $submit));
    }
}


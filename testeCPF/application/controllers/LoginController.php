<?php

class LoginController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	session_start();

		if ((isset($_SESSION['login']) && $_SESSION['login'] != '1')) {

			if (!empty($this->_getParam('loginsuccess')) && $this->_getParam('loginsuccess') == 'false') {
				
				echo "Wrong Username or Password";
			} else {
				echo "You are not logged in";
				
			}
		}
		
        $form = new Application_Form_Register();
		$form->setAction('/login/submit')->setMethod('post');
		$this->view->form = $form;
		
		
    }
	
	public function submitAction()
    {
    	$userAccess = new Application_Model_UserAccess;
		$login = htmlspecialchars($this->getRequest()->getPost('login', null));
		$password = htmlspecialchars($this->getRequest()->getPost('password', null));
		$isValidUser = $userAccess->authenticate($login, $password);
		
		if(!$isValidUser) {
    		$this->redirect('/login/index?loginsuccess=false');
			echo('Wrong set of username and password');
			session_start();
			$_SESSION['login'] = '0';
		}
		session_start();
		$_SESSION['login'] = "1";
		$_SESSION['id'] = $login;
		$this->redirect('/sintegra/index');
    }
	
	public function logoutAction()
	{
		session_start();
		session_destroy();
		$this->redirect('login/index');
	}
}


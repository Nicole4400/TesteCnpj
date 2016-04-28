<?php
class SintegraController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	session_start();
		if ($_SESSION['login'] != '1' || !(isset($_SESSION['login']) )) {
			$this->redirect('login/index');
		}
        $form = new Application_Form_SintegraSearch();
		$form->setAction('/sintegra/search')->setMethod('post');
		$this->view->form = $form;
    }
	
	public function searchAction()
    {
		session_start();
		if ($_SESSION['login'] != '1' || !(isset($_SESSION['login']) )) {
			$this->redirect('login/index');
		}
		
    	$cnpj = $this->getRequest()->getPost('cnpj', null);
		$sanitizedCnpj = '';
    	if (!is_null($cnpj)) {
    		$sanitizedCnpj = str_replace(['+', '-'], '', filter_var($cnpj, FILTER_SANITIZE_NUMBER_INT));
    	}
		
		$url = 'http://www.sintegra.es.gov.br/resultado.php';
		$data = array('num_cnpj' => $sanitizedCnpj, 'num_ie' => '','botao' => 'Consultar');
		
		$curl = curl_init($url);
    	curl_setopt($curl, CURLOPT_POST, true);
    	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    	$response = curl_exec($curl);
    	curl_close($curl);
		$parsedArray = array();
		
		$doc = new DOMDocument();
		$doc->loadHTML($response);
		
		$xpath = new \DOMXpath($doc);
  		$valuesTotal = $xpath->query('//td[@class="valor"]');
		
		 $values = array();
		 foreach($valuesTotal as $container) {
		 	$values[] = $container->nodeValue;
		 }
		 
		if($response != "") {
			
			$parsedArray = array(
			'cnpj' => $values[0],
			'inscricao_estadual' => $values[1],
			'razao_social' => $values[2],
			'logradouro' => $values[3],
			'numero' => $values[4],
			'complemento' => $values[5],
			'bairro' => $values[6],
			'municipio' => $values[7],
			'uf' => $values[8],
			'cep' => $values[9],
			'telefone' => $values[10],
			'atividade_economica' => $values[11],
			'data_inicio_atividades' => $values[12],
			'situacao_cadastral_vigente' => $values[13],
			'data_situacao_cadastral' => $values[14],
			'regime_apuracao' => $values[15],
			'emitente_nfe_desde' => $values[16],
			'obrigada_nfe_em' => $values[17],
			'data_consulta' => $values[18]
			
			);
			$json = json_encode($parsedArray);
			if(isset($_SESSION['id'])) {
				$access = new Application_Model_SintegraAccess;
				$access->addUnique(array('id_usuario' => $_SESSION['id'], 'cnpj' => $sanitizedCnpj, 'json' => $json));
			}
		}
			
		$this->redirect('sintegra/results');
		
	}
	
	public function resultsAction()
    {
		session_start();
		if ($_SESSION['login'] != '1' || !(isset($_SESSION['login']) )) {
			$this->redirect('login/index');
		}
		$access = new Application_Model_SintegraAccess;
		$entries = $access->getAllEntries();
		
		$this->view->results = $entries;
    }
	
	public function deleteAction()
    {
		session_start();
		if ($_SESSION['login'] != '1' || !(isset($_SESSION['login']) )) {
			$this->redirect('login/index');
		}
		$id = $this->_getParam('id');
		$access = new Application_Model_SintegraAccess;
		$access->delete($id);
		$this->redirect('sintegra/index');
    }
}


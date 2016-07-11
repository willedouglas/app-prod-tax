<?php

require_once 'API.class.php';
require_once 'Dao/TaxDao.php';

	class Taxes extends API
	{
		protected $Tax;

		public function __construct($request, $origin) {
			parent::__construct($request);

			$Tax = new TaxDao();

			if (array_key_exists('token', $this->request) &&
				 !$Tax->get('token', $this->request['token'])) {

				throw new Exception('Invalid Tax Token');
			}

			$this->TaxDao = $Tax;
		}

    	protected function taxes() {
    		
			$request = explode('/', rtrim($_REQUEST['request'], '/'));
			$data = json_decode(file_get_contents("php://input"));

	        if ($this->method == 'GET') {
    			return $this->TaxDao->getTaxes($request[1]);
	        } else if ($this->method == 'POST') {
	        	if (!is_null($data->id)) {
	        		return $this->TaxDao->updateTax($data);
	        	} else {
	        		return $this->TaxDao->insertTax($data);	
	        	}
	        } else if ($this->method == 'PUT') {

	        } else if ($this->method == 'DELETE') {
				$this->TaxDao->deleteTax($request[1]);
	        } else {
	        	return "Only accepts GET, POST, PUT, DELETE requests.";	
	        }
    	}
	}
?>
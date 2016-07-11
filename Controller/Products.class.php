<?php

require_once 'API.class.php';
require_once 'Dao/ProductDao.php';

	class Products extends API
	{
		protected $Product;

		public function __construct($request, $origin) {
			parent::__construct($request);

			$Product = new ProductDao();

			if (array_key_exists('token', $this->request) &&
				 !$Product->get('token', $this->request['token'])) {

				throw new Exception('Invalid Product Token');
			}

			$this->ProductDao = $Product;
		}

    	protected function products() {
    		
			$request = explode('/', rtrim($_REQUEST['request'], '/'));
			$data = json_decode(file_get_contents("php://input"));

	        if ($this->method == 'GET') {
	        	if ($request[1] == 'invoices') {
	        		return $this->ProductDao->getProductInvoices();	
	        	} else {
	        		return $this->ProductDao->getProducts($request[1]);	
	        	}
	        } else if ($this->method == 'POST') {
	        	if (!is_null($data->id)) {
	        		return $this->ProductDao->updateProduct($data);
	        	} else {
	        		return $this->ProductDao->insertProduct($data);	
	        	}
	        } else if ($this->method == 'PUT') {

	        } else if ($this->method == 'DELETE') {
				$this->ProductDao->deleteProduct($request[1]);
	        } else {
	        	return "Only accepts GET, POST, PUT, DELETE requests.";	
	        }
    	}
	}
?>
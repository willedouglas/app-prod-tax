<?php

require_once 'API.class.php';
require_once 'Dao/CategoryDao.php';

	class Categories extends API
	{
		protected $Category;

		public function __construct($request, $origin) {
			parent::__construct($request);

			$Category = new CategoryDao();

			if (array_key_exists('token', $this->request) &&
				 !$Category->get('token', $this->request['token'])) {

				throw new Exception('Invalid Category Token');
			}

			$this->CategoryDao = $Category;
		}

    	protected function categories() {
    		
			$request = explode('/', rtrim($_REQUEST['request'], '/'));
			$data = json_decode(file_get_contents("php://input"));

	        if ($this->method == 'GET') {
    			return $this->CategoryDao->getCategories($request[1]);
	        } else if ($this->method == 'POST') {
	        	if (!is_null($data->id)) {
	        		return $this->CategoryDao->updateCategory($data);
	        	} else {
	        		return $this->CategoryDao->insertCategory($data);	
	        	}
	        } else if ($this->method == 'PUT') {

	        } else if ($this->method == 'DELETE') {
				$this->CategoryDao->deleteCategory($request[1]);
	        } else {
	        	return "Only accepts GET, POST, PUT, DELETE requests.";	
	        }
    	}
	}
?>
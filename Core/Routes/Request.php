<?php

namespace Core\Routes;

class Request
{

	protected $files;
	protected $base;
	protected $uri;
	protected $method;
	protected $protocol;
	protected $data = [];

	public function __construct()
	{
		$this->base = $_SERVER['REQUEST_URI'];
		$this->method = strtolower($_SERVER['REQUEST_METHOD']);
		$this->protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
		$this->setUri();
		$this->setData();

		if(count($_FILES) > 0) {
			$this->setFiles();
		}

	}

	protected function setData()
	{
		switch($this->method)
		{
			case 'post':
			$this->data = $_POST;
			break;
			case 'get':
			$this->data = $_GET;
			break;
			case 'head':
			case 'put':
			case 'delete':
			case 'options':
			parse_str(file_get_contents('php://input'), $this->data);
		}
	}

	protected function sefFiles() {
		foreach ($_FILES as $key => $value) {
			$this->files[$key] = $value;
		}
	}

	public function base()
	{
		return $this->base;
	}

	public function method(){
		
		return $this->method;
	}

	public function uri(){
		return $this->uri;
	}

	public function all()
	{
		return $this->data();
	}

	public function setUri(){
			$uri = $_SERVER['QUERY_STRING'] ?? '/';
			if(strpos($uri,'&')){
				$explode = \explode('&',$uri);
				$return_uri = $explode[0];
			}else{
				$return_uri = $uri;
			}
			$this->uri = $return_uri;
	}

	public function __isset($key)
	{
		return isset($this->data[$key]);
	}

	public function __get($key)
	{
		if(isset($this->data[$key])) 
		{
			return $this->data[$key];
		}
	}

	public function hasFile($key) {

		return isset($this->files[$key]);
	}

	public function file($key){

		if(isset($this->files[$key])) 
		{
			return $this->files[$key];
		}
	}

	public function get($name){
		$this-methodRequest('get',$name);
	}

	public function post($name){
		$this-methodRequest('get',$name);
	}

	private function methodRequest($method,$name){
		switch(strtolower($method)){
			case 'get': $_GET[$name];
			break;
			case 'post': $_POST[$name];
			break;
		}
	}
}
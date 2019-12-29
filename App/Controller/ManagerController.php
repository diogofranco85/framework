<?php

namespace App\Controller;

use \App\Src\AuthController;

class ManagerController extends AuthController{

public function __construct(){

  parent::__construct();

}

public function index(){

  $this->render('manager_index');

}

public function teste(){
    
  $user = $this->auth('diogo@heyletscode.com.br','150398');
   
  if(array_key_exists('authentication-code',$_COOKIE)){
   $payload = $this->getPayload($_COOKIE['authentication-code']);
   var_dump(json_decode($payload));
  }else{
    echo json_encode(['code' => 200, 'message' => 'user not authenticate']);
  }
  
}

public function login(){

  $this->render('manager_login');
}

public function userauth(){
 
 $username = $this->request->request->get('inputEmail');
 $pass = $this->request->request->get('inputPassword');

 $user = $this->auth($username, $pass);

  if($user){
    $this->redirect('manager');
  }
}

public function logout(){

  setcookie('authentication-code', "null", time()-(3600*24*30*12));
  $this->redirect('manager/login');

}

}
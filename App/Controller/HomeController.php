<?php

namespace App\Controller;

use \Core\Controller;
use \Core\Database\Transaction;
use \App\Model\Users;
use \App\Model\Groups;

class HomeController extends Controller
{

  public function index(){
    //Abrir transação no banco
    $this->userdata('senha', base64_encode('150398'));
    $this->render('home');
  }

}
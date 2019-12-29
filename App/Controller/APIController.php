<?php

namespace App\Controller;

use \Core\Controller;
use \Core\Database\Transaction;
use \App\Model\News;


class APIController extends Controller
{

  public function __construct(){
    parent::__construct();
  }

  public function articles(){
    Transaction::open();
    $news = new News();
    $rs_news = $news->getListArticlesLast();
    Transaction::close();
    
    $this->toJson($rs_news);
    
  }

}
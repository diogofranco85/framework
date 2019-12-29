<?php

namespace App\Controller;

use \Core\Controller;
use \Core\Database\Transaction;
use \App\Model\News;


class BlogController extends Controller
{

  public function __construct(){
    parent::__construct();
  }

  public function index(){
    Transaction::open();
    $news = new News();
    $this->userdata('news', $news->getListArticlesLast());
    $this->userdata('lasts', $news->lastArticle());
    $this->render('blog_index');
    Transaction::close();

  }

  public function read($id){
    Transaction::open();
    $news = new News();
    $article = $news->getListArticles($id);
    $img_name = $article[0]['cover'];
    $uri = $this->getURL('Assets/public/images/'.$img_name);
    list($width, $height, $type, $attr) = \getimagesize($uri);
    switch($type){
      case 1 : $file_ext = 'image/gif' ;
      break;
      case 2 : $file_ext = 'image/jpeg' ;
      break;
      case 3 : $file_ext = 'image/png' ;
      break;
      case 6 : $file_ext = 'image/bmp' ;
      break;
      case 17 : $file_ext = 'image/ico' ;
      break;
    }
    $this->userdata('image', array('width' => $width, 'height' => $height, 'file_ext' => $file_ext));
    $this->userdata('news', $article);
    $this->render('blog_article');
    Transaction::close();
  }

}
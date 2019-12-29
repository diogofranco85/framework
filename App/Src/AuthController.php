<?php 

namespace App\Src;

use \Core\Controller;
use \Core\Authenticate\JWT;
use \Core\Database\Transaction;
use \App\Model\Users;

class AuthController extends Controller
{

  protected $jwt;
  private $token;

  public function __construct(){
      parent::__construct();
      $this->jwt = new JWT();
  }

  public function auth($email, $pass){
    Transaction::open();
    $user = new Users();
    $user->where('email','=',$email);
    $user->where('password','=',sha1($pass));
    $user->fillable([
      'Users' => ['idUser','name','active']
    ]);
    Transaction::close();
    
    $rs_user = $user->get();

    if(count($rs_user) > 0 ){
      $rs_user = $rs_user[0];
      if($rs_user['active'] == 'F'){
        echo json_encode(['status' => '401','message' => 'user not actived']);
      }else{
        $this->setToken($rs_user);
        $session = new \Core\Session();
        $session->user = $rs_user;
        return true;
      }
    }else{
       echo json_encode(['status' => '401', 'message' => 'user not found']);
    }
    
  }


  public function getJWTToken(){
      return $_COOKIE['authentication-code'];
  }

  public function setToken(Array $value){
    $token = $this->jwt->sign($value);
    setcookie('authentication-code', "{$token}", time()+900);
  }

  public function getPayload($jwt_code){
    return $this->jwt->getPayload($jwt_code);
  }

}
<?php

namespace Core\Authenticate;

class JWT {

  private $header;
  private $payload;
  private $signature;
  public $encode_key = 'H3yL3tSC0d320191111d10G0Fr4nC0';

  public function __construct()
  {

    $header = [
      'alg' => 'HS256',
      'typ' => 'JWT',
    ];

    $header = json_encode($header);
    $this->header = base64_encode($header);

  }

  private function payload( Array $value ){
    
      $protocol = ($_SERVER['SERVER_PORT'] == 80) ? 'http'  : 'https';
      $server = $_SERVER['SERVER_NAME'];
    
      $value['iss'] = "{$protocol}://$server";
      $value['iat'] = date('Y-m-d H:i');

      $payload = json_encode($value);
      $this->payload = base64_encode($payload);
  }

  private function signature()
  {

    $signature = hash_hmac('sha256',"{$this->header}.{$this->payload}",$this->encode_key,true);    
    $this->signature = base64_encode($signature);

  }

  public function sign(Array $value){
    $this->payload($value);
    $this->signature();
    return "{$this->header}.{$this->payload}.{$this->signature}";
  }


  public function validate($jwt_token){
    $token = explode('.',$jwt_token);
    $header = $token[0];
    $payload = $token[1];
    $signature = $token[2];

    $validate_signature = hash_hmac('sha256',"{$header}.{$payload}",$this->encode_key,true);    
    $validate_code = base64_encode($validate_signature);

    if($validate_code != $signature){
      return false;
    }

    return true;   

  }

  public function getPayload($jwt_token){
    $validate = $this->validate($jwt_token);
    if($validate){
      $token = \explode('.',$jwt_token);
      $payload = $token[1];
      $payload = base64_decode($payload);
      return $payload;
   }
  }

}
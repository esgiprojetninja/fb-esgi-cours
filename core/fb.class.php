<?php

class Facebook{


  public function getPermissions(){
    $response = $this->fb->get('/me/permissions');
  }

  public function checkAccessToken(){
    if(empty($_SESSION['facebook_access_token'])) return false;
    try{
      $response = $this->fb->get('/debug_token?input_token='.$_SESSION['facebook_access_token']);
      $graphObject = $response->getGraphObject();
    }catch(Exception $e){
      die($e->getMessage());
      return false;
    }
    return true;
  }

  public function getUser(){
    $response = $this->get->get('/me');
    return $response->getDecodedBody();
  }
}






 ?>

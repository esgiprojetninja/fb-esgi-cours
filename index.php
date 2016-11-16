
<?php
session_start();

require __DIR__.'/vendor/autoload.php';

$fb =  new Facebook\Facebook([
  'app_id' => '981155468659615',
  'app_secret' => 'f4b38c41c5203d6b0f827a3d709fc54e',
  'default_graph_version'=>'v2.8',
]);

$helper = $fb->getRedirectLoginHelper();
$permissionsNeed = ["email","user_likes"];
$loginUrl = $helper->getLoginUrl("http://localhost:8888/facebook2/login-callback.php",$permissionsNeed);
/*
{
"data": [
{
"permission": "user_birthday",
"status": "granted"
},
]
}
*/
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Facebook </title>
  <meta name="description" content="ceci est mon app facebook">
</head>
<body>
  <h1>Application Facebook test</h1>
  <?php
  if(isset($_SESSION['facebook_access_token'])){
    $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    //$response = $fb->get('/me?fields=email,name');
    $response = $fb->get('/me/permissions');
    //$userNode = $response->getGraphUser();
    $permissions = $response->getGraphEdge();

    $scopeGrantedNow = [];
    $error = false;
    foreach($permissions as $key=>$permission){
      if($permission['status'] == "granted"){
        $scopeGrantedNow[] = $permission['permission'];
      }
    }

    foreach($permissionsNeed as $key=>$val){
      if(!in_array($val,$scopeGrantedNow)){
        echo "Il manque la permission".$val;
        $error = true;
      }
    }

    if($error){
      $status = 2;
    }else{
      $status =1;
    }
  }else{
    $status = 0;
  }

  ?>

  <?php if($status ===1 ): ?>
    <a href="logout.php">Se déconnecter</a>
  <?php elseif($status === 2): ?>
    <a href="<?php echo $fb->getLoginUrlAgain(); ?>">Se connecter</a>
  <?php else: ?>
    <a href="<?php echo $loginUrl; ?>">Se connecter</a>
  <?php endif; ?>

</body>
</html>

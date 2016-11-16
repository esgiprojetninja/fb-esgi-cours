
<?php
session_start();

require __DIR__.'/vendor/autoload.php';

$fb =  new Facebook\Facebook([
  'app_id' => '981155468659615',
  'app_secret' => 'f4b38c41c5203d6b0f827a3d709fc54e',
  'default_graph_version'=>'v2.8',
]);

$helper = $fb->getRedirectLoginHelper();
$permissionsNeed = ["email","user_likes","user_photos"];

$loginUrl = $helper->getLoginUrl("http://localhost:8888/facebook2/login-callback.php",$permissionsNeed);
$reLoginUrl =  $helper->getReRequestUrl("http://localhost:8888/facebook2/login-callback.php",$permissionsNeed);

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
  $status = 0;

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
      $status =1 ;
    }
  }
  ?>

  <?php if($status ===1 ): ?>
    <a href="logout.php">Se déconnecter</a>
    <?php
      //$fb->getUser();
      $photos = $fb->get('/me?fields=albums{name,photos}');
      $photos = $photos->getGraphUser();
      //var_dump($photos);
      echo '<pre>';
      print_r($photos);
      foreach($photos as $photo){
        print_r($photo);
      }

    ?>
    <!-- ALL PHOTOS USER -->
  <?php elseif($status === 2): ?>
    <a href="<?php echo $reLoginUrl; ?>">Se connecter</a>
  <?php else: ?>
    <a href="<?php echo $loginUrl; ?>">Se connecter</a>
  <?php endif; ?>

</body>
</html>

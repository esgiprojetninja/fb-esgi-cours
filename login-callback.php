<?php
session_start();

require __DIR__."/vendor/autoload.php" ;

$fb = new Facebook\Facebook([
  'app_id' => '981155468659615',
  'app_secret' => 'f4b38c41c5203d6b0f827a3d709fc54e',
  'default_graph_version' => 'v2.8',
]);


$helper = $fb->getRedirectLoginHelper();


try {
  $accessToken = $helper->getAccessToken();


} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (isset($accessToken)) {
  // Logged in!
  $_SESSION['facebook_access_token'] = (string) $accessToken;

  // Now you can redirect to another page and use the
  // access token from $_SESSION['facebook_access_token']
  header("Location: index.php");
}

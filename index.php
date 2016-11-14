
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Facebook</title>
    <meta name="description" content="ceci est mon app facebook">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="fb-esgi-cours/public/js/script.js"></script>
  </head>
  <body>
      <h1>Application Facebook</h1>
      <!--
      <fb:login-button scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button>
      <div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" data-auto-logout-link="false"></div>-->
      <div id="button">
        <button id="facebookLogin">Se connecter</button>
        <button id="facebookLogout">Se déconnecter</button>
      </div>
      <div id="status">
</div>
  </body>
</html>

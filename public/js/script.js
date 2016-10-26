$(document).ready(function(){

  var scope = ["public_profile","email"]
  var maxNumberAskingScope = 1;
  var numberAskingScope = 0;


     // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      verifyScope(testAPI)

    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
        $("#login").show();
        $("#logout").hide();
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
        $("#login").show();
        $("#logout").hide();
    }
  }


  function verifyScope(callback){
    var scopeGrantedNow = [];
    var error = false;

    FB.api('/me/permissions', function(response) {
      $.each(response.data, function(key, permission){
        if(permission.status == "granted"){
          scopeGrantedNow.push(permission.permission);
        }
      })

      $.each(scope, function(key, permissionNeed){
        if($.inArray(permissionNeed, scopeGrantedNow) == -1){
          console.log("Il manque la permission "+permissionNeed);
          error = true;
        }
      })

      if(error){
        authAgain();
      }else{

        $("#login").hide();
        $("#logout").show();
        callback();
      }

    });

  }

  function authAgain(){
    if(numberAskingScope < maxNumberAskingScope){
      FB.login(function(response){
        checkLoginState();
      },{scope:scope.join(), auth_type: "rerequest"});
      numberAskingScope++;
    }else{
      alert("Vous devez accepter les permissions !!!")
    }
  }

  function checkLoginState() {


    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });

  }

  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');

    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });

  }

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/fr_FR/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));


  window.fbAsyncInit = function() {
      FB.init({
        appId      : '1462037537430458',
        cookie     : true,  // enable cookies to allow the server to access
                            // the session
        xfbml      : true,  // parse social plugins on this page
        version    : 'v2.5' // use graph api version 2.5
      });

      checkLoginState();
  };


  $("#login").click(function(){
    numberAskingScope = 0;
    FB.login(function(response){
        statusChangeCallback(response)
    },{scope:scope.join()})
  })

  $("#logout").click(function(){
    FB.logout(function(response){
        statusChangeCallback(response)
    })

  })

})

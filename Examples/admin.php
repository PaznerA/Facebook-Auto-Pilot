<?php

require '../bootstrap.php';


if (!isset($_SESSION['userId'])) {
    echo '<h1>Nejste přihlášen/a!</h1>';
    echo 'Pokračujte <a href="' . SITE_URL . '"><strong>tudy</strong> a klikněte na tlačítko "LogIn"</a>';
    die();
}
;
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/Examples/../Src/Assets/Css/style.css">
<script>
    // This is called with the results from from FB.getLoginStatus().
    function statusChangeCallback(response) {
        // The response object is returned with a status field that lets the
        // app know the current login status of the person.
        // Full docs on the response object can be found in the documentation
        // for FB.getLoginStatus().
        if (response.status === 'connected') {
            $(".main_controls .overlay").removeClass('visible');
        } else {
            document.location.replace('<?php echo SITE_URL; ?>');
        }
    }

    // This function is called when someone finishes with the Login
    // Button.  See the onlogin handler attached to it in the sample
    // code below.
    function checkLoginState() {
        FB.getLoginStatus(function (response) {
            statusChangeCallback(response);
        });
    }

    window.fbAsyncInit = function () {
        FB.init({
            appId: '<?php echo FB_APP_ID; ?>',
            cookie: true,  // enable cookies to allow the server to access
                           // the session
            xfbml: true,  // parse social plugins on this page
            version: 'v2.8' // use graph api version 2.8
        });

        // Now that we've initialized the JavaScript SDK, we call
        // FB.getLoginStatus().  This function gets the state of the
        // person visiting this page and can return one of three states to
        // the callback you provide.  They can be:
        //
        // 1. Logged into your app ('connected')
        // 2. Logged into Facebook, but not your app ('not_authorized')
        // 3. Not logged into Facebook and can't tell if they are logged into
        //    your app or not.
        //
        // These three cases are handled in the callback function.

        FB.getLoginStatus(function (response) {
            statusChangeCallback(response);
        });

    };
    // Load the SDK asynchronously
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "https://connect.facebook.net/cs_CZ/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    // Here we run a very simple test of the Graph API after login is
    // successful.  See statusChangeCallback() for when this call is made.
    function getMyProfile() {
        FB.api('/me', function (response) {
        });
    }

    function getEvents() {
        console.log('Getting available events.... ');

        FB.api('me/events?limit=500', function (response) {
            console.log(response);
            data = response.data;
            $('#main').append('<h2> MY EVENTS </h2>');
            $.each(data, function (key, value) {
                $('#main').append(decorateFbEvent(value));
            });
        });
    }

    function getGroups() {
        console.log('Getting available groups.... ');

        FB.api('me/groups?limit=500', function (response) {
            console.log(response);
            data = response.data;
            $('#main').append('<h2> MY GROUPS </h2>');
            $.each(data, function (key, value) {
                $('#main').append(decorateFbGroup(value));
            });
        });
    }

    function getPages() {
        console.log('Getting available pages.... ');

        FB.api('/me/pages', function (response) {
            console.log(response);
            data = response.data;
            $.each(data, function (key, value) {
                //$('#main').append(decorateFbGroup(value));
            });
        });
    }

    function getPosts() {
        console.log('Getting available posts.... ');

        FB.api('/me/feed', function (response) {
            console.log(response);
            data = response.data;
            $.each(data, function (key, value) {
                console.log(value.name);
                //$('#main').append(decorateFbGroup(value));
            });
        });
    }

</script>

<body>
<div class="container">
    <div class="row text-center">
        <div class="col-md-12">
            <h1>Vítejte, uživateli Č.: <?php echo $_SESSION['userId'] ?></h1>
        </div>
    </div>
    <div class="row text-center main_controls">
        <div class="overlay visible"></div>
        <div class="col-md-12">
            <button class="btn" onclick="getMyProfile();">Můj profil</button>
            <button class="btn" onclick="getPosts();">Moje příspěvky</button>
            <button class="btn" onclick="getEvents();">Moje události</button>
            <button class="btn" onclick="getGroups();">Výčet mých FB skupin</button>
            <button class="btn" onclick="getPages();">Výčet mých FB stránek</button>
        </div>
    </div>
    <div class="row" id="main">

    </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="/Examples/../Src/Assets/Js/FbPostTemplate.js"></script>
<script src="/Examples/../Src/Assets/Js/FbGroupTemplate.js"></script>
<script src="/Examples/../Src/Assets/Js/FbEventTemplate.js"></script>


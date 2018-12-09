function statusChangeCallback(response) {
    if (response.status === 'connected') {
        $(".main_controls .overlay").removeClass('visible');
    } else {
        document.location.replace('<?php echo SITE_URL; ?>');
    }
}

function checkLoginState() {
    FB.getLoginStatus(function (response) {
        statusChangeCallback(response);
    });
}



function fbLogout() {
    FB.logout(function (response) {
        //Do what ever you want here when logged out like reloading the page
        window.location.reload();
    });
}

function fbDialog(method,link){
    FB.ui(
        {
            method: method,
            href: link,
        },
        function(response) {
            if (response && !response.error_message) {
                alert('Hotovo');
            } else {
                alert('Akce nebyla dokončena');
            }
        }
    );
}

function getMyAccount() {
    FB.api('/me/accounts', function (response) {
        console.log(response);
        data = response.data;
        $('#main').html('');
        $('#main').append('<h2> MY SITES </h2>');
        $.each(data, function (key, value) {
            $('#main').append(decorateFbSite(value));
        });
    });
}

function getMyProfile() {
    FB.api('/me', function (response) {
        console.log(response);
        data = response.data;
        $('#main').html('');
    });
}

function getEvents() {
    console.log('Getting available events.... ');

    FB.api('me/events?limit=500', function (response) {
        console.log(response);
        data = response.data;
        $('#main').html('');
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
        $('#main').html('');
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

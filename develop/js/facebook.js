const facebook = {
    // will be set dynamically in PHP code
    appId: null,
    groupId: null,
    groupPage: null,
    run
};

function run() {
    const { appId, groupId } = facebook;
    if (!appId || !groupId) {
        return;
    }

    facebook.groupPage = facebook.groupPage || `https://www.facebook.com/groups/${groupId}/`;

    window.fbAsyncInit = function() {
        FB.init({
            appId,
            xfbml: false,
            status: true,
            version: 'v2.9'
        });
        FB.AppEvents.logPageView();

        checkLoginStatus()
        .then(fetchPosts)
        .then(console.info)
        .catch(goToGroupPage);
        // 2) POST to /fb-save-token.php
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/uk_UA/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
}


function checkLoginStatus() {
    return new Promise((resolve, reject) => {
        FB.getLoginStatus((response) => {
            if (response.status === 'connected') {
                resolve(response.authResponse.accessToken);
            } else {
                FB.login((response) => {
                    if (response.status === 'connected') {
                        resolve(response.authResponse.accessToken);
                    } else {
                        reject('Not logged in');
                    }
                }, { scope: 'email', auth_type: 'rerequest' });
            }
        });
    });
}


function fetchPosts(token) {
    return new Promise((resolve, reject) => {
        FB.api(
            `/${facebook.groupId}/feed`,
            'get',
            {
                access_token: token,
                fields: 'id,message,full_picture,updated_time',
                limit: 10
            },
            (response) => {
                if (response && response.data && response.data.length > 0) {
                    resolve(response.data);
                } else {
                    reject(response);
                }
            });
    });
}


function sendToken(token) {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = () => {
            if (xhr.readyState !== 4) {
                return;
            }

            if (xhr.status === 200) {
                console.info(xhr);
                resolve(true);
            } else {
                reject(xhr);
            }
        };

        xhr.open('POST', '/fb-save-token.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        xhr.send(`access_token=${token}`);
    });
}


function goToGroupPage(e) {
    console.error(e);
    setTimeout(() => {
        // TODO Uncomment me!
        // location.href = facebook.groupPage;
    }, 5000);
}

module.exports = facebook;

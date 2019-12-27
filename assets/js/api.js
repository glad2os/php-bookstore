function request(target, body, callback) {
    const request = new XMLHttpRequest();
    request.open("POST", "/api/" + target, true);
    request.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
    request.onreadystatechange = function () {
        if (request.readyState === XMLHttpRequest.DONE) {
            callback(request.status, request.responseText);
        }
    };
    request.send(JSON.stringify(body));
}

function reg(form) {
    request('user/register',
        {
            ['login']: form.login.value,
            ['password']: form.password.value,
            ['first_name']: form.first_name.value,
            ['second_name']: form.second_name.value,
            ['last_name']: form.last_name.value
        },
        function (status, responseText) {
            if (status === 204) {
                window.location.href = '/signin';
            } else {
                console.log(responseText);
                alert(JSON.parse(responseText)['issueMessage']);
            }
        });
}

function auth(form) {
    request('user/sign_in',
        {
            ['login']: form.login.value,
            ['password']: form.password.value
        },
        function (status, responseText) {
            if (status === 204) {
                window.location.href = '/account';
            } else {
                console.log(responseText);
                alert(JSON.parse(responseText)['issueMessage']);
            }
        });
}

function signOut() {
    request('user/sign_out',
        {},
        function (status, responseText) {
            if (status === 204) {
                deleteCookie('login');
                deleteCookie('token');
                window.location.href = '/';
            } else {
                console.log(responseText);
                alert(JSON.parse(responseText)['issueMessage']);
            }
        });
}

function updateUser(form) {
    request('user/update',
        {
            ['login']: form.login.value,
            ['password']: form.password.value,
            ['first_name']: form.first_name.value,
            ['second_name']: form.second_name.value,
            ['last_name']: form.last_name.value
        },
        function (status, responseText) {
            if (status === 204) {
                window.location.href = '/account';
            } else {
                console.log(responseText);
                alert(JSON.parse(responseText)['issueMessage']);
            }
        });
}

function addBook(form) {
    const authors = [].map.call(form.getElementsByClassName("ui label"), function (e) {
        return Number(e.getAttribute('data-value'))
    });
    request('book/add',
        {
            ['title']: form.title.value,
            ['isbn']: form.isbn.value,
            ['price']: form.price.value,
            ['authors']: authors
        },
        function (status, responseText) {
            if (status === 204) {
                window.location.href = '/admin';
            } else {
                console.log(responseText);
                alert(JSON.parse(responseText)['issueMessage']);
            }
        });
}

function addAuthor(form) {
    request('author/add',
        {
            ['name']: form.name.value
        },
        function (status, responseText) {
            if (status === 204) {
                window.location.href = '/admin';
            } else {
                console.log(responseText);
                alert(JSON.parse(responseText)['issueMessage']);
            }
        });
}

function install(form) {
    request('install/install',
        {
            ['db_host']: form.db_host.value,
            ['db_user']: form.db_user.value,
            ['db_password']: form.db_password.value,
            ['db_schema']: form.db_schema.value,
            ['login']: form.login.value,
            ['password']: form.password.value,
            ['count']: form.count.value
        },
        function (status, responseText) {
            if (status === 204) {
                window.location.href = '/';
            } else if (status === 200) {
                window.location.href = '/';
            } else {
                console.log(responseText);
                alert(JSON.parse(responseText)['issueMessage']);
            }
        });
}
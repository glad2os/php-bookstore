const logins = document.getElementsByName('login');
const firstNames = document.getElementsByName('first_name');
const secondNames = document.getElementsByName('second_name');
const lastNames = document.getElementsByName('last_name');

request('user/get_info', null, function (status, responseText) {
    if (status === 200) {
        const received = JSON.parse(responseText);
        logins.forEach(function (entry) {
            entry.value = received.login;
        });
        firstNames.forEach(function (entry) {
            entry.value = received.first_name;
        });
        secondNames.forEach(function (entry) {
            entry.value = received.second_name;
        });
        lastNames.forEach(function (entry) {
            entry.value = received.last_name;
        });
    } else {
        console.log(responseText);
        alert(JSON.parse(responseText).issueMessage);
    }
});
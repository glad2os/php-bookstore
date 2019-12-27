const authors = document.getElementsByName('authors')[0];

request('author/get_all', null, function (status, responseText) {
    if (status === 200) {
        JSON.parse(responseText).forEach(function (entry) {
            let option = document.createElement('option');
            option.value = entry.id;
            option.innerText = entry.name;
            authors.appendChild(option);
        });
    } else {
        console.log(responseText);
        alert(JSON.parse(responseText)['issueMessage']);
    }
});
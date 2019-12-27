const catalog = document.getElementById('catalog');
const page = document.getElementById('page');
const pageCount = document.getElementById('page_count');

function getBooks(p) {
    request('book/get_page', {
        ['page']: p
    }, function (status, responseText) {
        if (status === 200) {
            const received = JSON.parse(responseText);
            setCookie('page', received.page);
            page.innerText = received.page;
            pageCount.innerText = received.pageCount;
            catalog.innerText = '';
            received.books.forEach(function (entry) {
                let item = document.createElement('div');
                item.className = 'four wide column';
                entry.authors.forEach(function (e) {
                    let author = document.createElement('p');
                    author.innerText = e.name;
                    item.appendChild(author);
                });
                let title = document.createElement('p');
                title.innerText = entry.title;
                item.appendChild(title);
                let price = document.createElement('p');
                price.innerText = entry.price;
                item.appendChild(price);
                catalog.appendChild(item);
                console.log(JSON.parse(responseText));
            });
        } else if (status === 204) {
        } else {
            console.log(responseText);
            alert(JSON.parse(responseText).issueMessage);
        }
    });
}

function prev() {
    getBooks(parseInt(page.innerText) - 1);
}

function next() {
    getBooks(parseInt(page.innerText) + 1);
}

const c = getCookie('page');
getBooks(c === undefined ? 1 : c);
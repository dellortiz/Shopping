
document.addEventListener("DOMContentLoaded", function() {
    var urlParams = new URLSearchParams(window.location.search);
    var productId = urlParams.get('id');
    if (productId) {
        var productElement = document.getElementById('idarticle' + productId);
        if (productElement) {
            productElement.classList.add('highlight');
            productElement.scrollIntoView({ behavior: 'smooth' });
        }
    }
});

document.addEventListener("DOMContentLoaded", function() {
    var searchBar = document.getElementById('header-search-bar');
    var urlParams = new URLSearchParams(window.location.search);
    if (searchBar && urlParams.has('error')) {
        searchBar.placeholder = urlParams.get('error');
        setTimeout(function() {
            searchBar.placeholder = 'Search...';
        }, 3000); // 3000 milisegundos = 3 segundos
    }
});
document.addEventListener("DOMContentLoaded", function() {
    var searchBari = document.getElementById('search-bar');
    var urlParamsi = new URLSearchParams(window.location.search);
    if (searchBari && urlParamsi.has('error')) {
        searchBari.placeholder = urlParamsi.get('error');
        setTimeout(function() {
            searchBari.placeholder = 'Search...';
        }, 3000); // 3000 milisegundos = 3 segundos
    }
});

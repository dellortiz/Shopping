
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


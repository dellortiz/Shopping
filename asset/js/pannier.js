$(document).ready(function() {
    console.log('Document ready'); // Depuración
    updateBasket();
});

function updateBasket() {
    console.log('Calling updateBasket'); // Depuración
    $.ajax({
        url: './common/getbasket.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log('Response from getbasket:', response); // Depuración
            var pannier = $('.bloque-pannier');
            pannier.empty();

            if (response.status === 'success' && response.data.length > 0) {
                pannier.css('display', 'block');
                $.each(response.data, function(index, item) {
                    var totalPrice = item.quantity * item.price;
                    var maxOptions = Math.min(10, item.stock); // Limita las opciones del selector al stock disponible (máximo 10)
                    var newItem = $('<div>').addClass('basket-item').html(`
                        <img class="imgbasket" src="./asset/products/${item.category}/${item.img}" alt="${item.name}">
                        <h4>${item.name}</h4>
                        <p>Quantity: ${item.quantity}</p>
                        <p>Total Price: ${totalPrice.toFixed(2)}€</p>
                        <p class="stock-indicator ${item.stock > 0 ? 'green-text' : 'out-of-stock'}">
                            ${item.stock > 0 ? 'In stock' : 'Out of stock'}
                        </p>
                        <button class="botonpannier" onclick="increaseQuantity(${item.id_products})">+</button>
                        <button class="botonpannier2" onclick="decreaseQuantity(${item.id_products})">-</button>
                        <select id="quantity-selector-${item.id_products}" class="quantity-selector" onchange="updateQuantity(${item.id_products}, this.value)">
                            ${[...Array(maxOptions).keys()].map(i => `<option value="${i+1}" ${i+1 === item.quantity ? 'selected' : ''}>${i+1}</option>`).join('')}
                        </select><br>
                        <button class="botonpannier3" onclick="removeFromBasket(${item.id_products})">Remove</button><hr class="hrpannier">
                    `);
                    pannier.prepend(newItem);
                });
            } else {
                pannier.css('display', 'none');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

function updateQuantity(id_products, quantity) {
    $.ajax({
        url: './common/addtobasket.php', // Usamos el mismo endpoint para actualizar la cantidad
        type: 'POST',
        data: { id_products: id_products, quantity: quantity },
        dataType: 'json',
        success: function(response)  {
            console.log('Response from updateQuantity:', response); // Depuración
            if (response.status === 'error') {
                alert(response.message);
            } else {
                updateBasket(); // Actualiza el carrito
                updateStockInPopup(id_products, response.updated_stock); // Actualiza el stock en el popup
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

function updateStockInPopup(id_products, updated_stock) {
    var stockElement = $('#popup' + id_products + ' .stock-indicator');
    if (updated_stock > 0) {
        stockElement.text('In stock').addClass('green-text').removeClass('out-of-stock');
    } else {
        stockElement.text('Out of stock').removeClass('green-text').addClass('out-of-stock');
    }
}

function addToBasket(id_products) {
    $.ajax({
        url: './common/addtobasket.php',
        type: 'POST',
        data: { id_products: id_products },
        dataType: 'json',
        success: function(response) {
            console.log('Response from addToBasket:', response); // Depuración
            if (response.status === 'error') {
                alert(response.message);
            } else {
                updateBasket(); // Actualiza el carrito
                updateStockInPopup(id_products, response.updated_stock); // Actualiza el stock en el popup
                hidePopup('popup' + id_products); // Cierra el popup automáticamente
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

function increaseQuantity(id_products) {
    var quantity = $('#quantity-selector-' + id_products).val();
    $.ajax({
        url: './common/increasequantity.php',
        type: 'POST',
        data: { id_products: id_products, quantity: quantity },
        dataType: 'json',
        success: function(response) {
            console.log('Response from increaseQuantity:', response); // Depuración
            if (response.status === 'error') {
                alert(response.message);
            } else {
                updateBasket(); // Actualiza el carrito
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

function decreaseQuantity(id_products) {
    var quantity = $('#quantity-selector-' + id_products).val();
    $.ajax({
        url: './common/decreasequantity.php',
        type: 'POST',
        data: { id_products: id_products, quantity: quantity },
        dataType: 'json',
        success: function(response) {
            console.log('Response from decreaseQuantity:', response); // Depuración
            if (response.status === 'error') {
                alert(response.message);
            } else {
                updateBasket(); // Actualiza el carrito
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

function removeFromBasket(id_products) {
    $.ajax({
        url: './common/removefrombasket.php',
        type: 'POST',
        data: { id_products: id_products },
        dataType: 'json',
        success: function(response) {
            console.log('Response from removeFromBasket:', response); // Depuración
            if (response.status === 'error') {
                alert(response.message);
            } else {
                updateBasket(); // Actualiza el carrito
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

function showPopup(popupId) {
    var popup = document.getElementById(popupId);
    popup.style.display = 'flex';
}

function hidePopup(popupId) {
    var popup = document.getElementById(popupId);
    popup.style.display = 'none';
}

window.onclick = function(event) {
    var popups = document.getElementsByClassName('popuparticle');
    for (var i = 0; i < popups.length; i++) {
        if (event.target == popups[i]) {
            popups[i].style.display = 'none';
        }
    }
}

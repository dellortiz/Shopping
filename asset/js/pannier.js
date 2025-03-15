$(document).ready(function() {
    console.log('Document ready'); // Depuración
    updateBasket();

    // Delegar eventos para los botones dentro de .bloque-pannier y .bloque-pannier1
    $('.bloque-pannier').on('click', '.botonpannier', function() {
        console.log('Increase button clicked'); // Depuración
        var id_product = $(this).data('id');
        increaseQuantity(id_product);
    });

    $('.bloque-pannier').on('click', '.botonpannier2', function() {
        console.log('Decrease button clicked'); // Depuración
        var id_product = $(this).data('id');
        decreaseQuantity(id_product);
    });

    $('.bloque-pannier').off('click', '.botonpannier3').on('click', '.botonpannier3', function() {
        console.log('Remove button clicked'); // Depuración
        var id_product = $(this).data('id');
        removeFromBasket(id_product);
    });

    $('.bloque-pannier1').off('click', '.botonpannier3').on('click', '.botonpannier3', function() {
        console.log('Remove button clicked in pannier1'); // Depuración
        var id_product = $(this).data('id');
        removeFromBasket(id_product).then(function() {
            location.reload(); // Recargar la página automáticamente
        }).catch(function(error) {
            console.error('Error:', error);
        });
    });

    $('.bloque-pannier, .bloque-pannier1').on('change', '.quantity-selector', function() {
        console.log('Quantity selector changed'); // Depuración
        var id_product = $(this).data('id');
        var quantity = $(this).val();
        updateQuantity(id_product, quantity);
    });
});

function updateBasket() {
    console.log('Calling updateBasket'); // Depuración
    $.ajax({
        url: './common/getbasket.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log('Response from getbasket:', response); // Depuración
            
            var pannier = $('.bloque-pannier');       // Bloque principal con todos los botones
            var pannier1 = $('.bloque-pannier1');     // Bloque que solo tendrá selector y eliminar

            pannier.empty();
            pannier1.empty();

            var totalItems = 0;      // Contador de artículos
            var grandTotal = 0;      // Suma total de la compra

            if (response.status === 'success' && response.data.length > 0) {
                pannier.css('display', 'block');
                pannier1.css('display', 'block');

                // Recorremos cada ítem y sumamos su precio total al gran total
                $.each(response.data, function(index, item) {
                    var totalPrice = item.quantity * item.price;
                    grandTotal += totalPrice; // Acumula el total de cada ítem

                    var maxOptions = Math.min(10, item.stock); // Limita las opciones del selector al stock disponible (máximo 10)

                    // Generar el HTML para pannier (con todos los botones)
                    var newItem = $('<div>').addClass('basket-item').html(`
                        <img class="imgbasket" src="./asset/products/${item.category}/${item.img}" alt="${item.name}">
                        <h4>${item.name}</h4>
                        <p>Quantity: ${item.quantity}</p>
                        <p>Total Price: ${totalPrice.toFixed(2)}€</p>
                        <p class="stock-indicator ${item.stock > 0 ? 'green-text' : 'out-of-stock'}">
                            ${item.stock > 0 ? 'In stock' : 'Out of stock'}
                        </p>
                        <button class="botonpannier" data-id="${item.id_products}">+</button>
                        <button class="botonpannier2" data-id="${item.id_products}">-</button>
                        <select id="quantity-selector-${item.id_products}" class="quantity-selector" data-id="${item.id_products}">
                            ${[...Array(maxOptions).keys()].map(i => `<option value="${i+1}" ${i+1 === parseInt(item.quantity) ? 'selected' : ''}>${i+1}</option>`).join('')}
                        </select><br>
                        <button class="botonpannier3" data-id="${item.id_products}">Remove</button>
                        <hr class="hrpannier">
                    `);
                    pannier.prepend(newItem);

                    // Generar el HTML para pannier1 (solo selector y eliminar)
                    var newItem1 = $('<div style="margin-bottom: 15px; margin-top: 40px; display: flex; align-items: center; justify-content: space-between;">').addClass('basket-item').html(`
                        <div style="flex: 1; display: flex; justify-content: center; align-items: center;">
                            <img class="imgbasketpannier" src="./asset/products/${item.category}/${item.img}" alt="${item.name}" style="max-width: 190px;">
                        </div>
                        <div style="flex: 1; text-align: center;">
                            <h4 style="font-size: 20px; margin-bottom: 3px;">${item.name}</h4>
                            <p style="font-size: 16px; margin: 1px 0;">Quantity: ${item.quantity}</p>
                            <p style="font-size: 16px; margin: 1px 0;">Price: ${totalPrice.toFixed(2)}€</p>
                            <p class="stock-indicator ${item.stock > 0 ? 'green-text' : 'out-of-stock'}" style="font-size: 14px; margin: 1px 0;">
                                ${item.stock > 0 ? 'In stock' : 'Out of stock'}
                            </p>
                            <select id="quantity-selector-${item.id_products}" class="quantity-selector" data-id="${item.id_products}" style="width: 60px; margin: 3px 0;">
                                ${[...Array(maxOptions).keys()].map(i => `<option value="${i+1}" ${i+1 === parseInt(item.quantity) ? 'selected' : ''}>${i+1}</option>`).join('')}
                            </select><br>
                            <button class="botonpannier3" data-id="${item.id_products}" style="font-size: 12px; padding: 5px 10px;">Remove</button>
                        </div>
                    `);

                    // Añadir media query para dispositivos móviles
                    $('<style>')
                        .text(`
                            @media (max-width: 768px) {
                                .basket-item {
                                    flex-direction: column;
                                    align-items: center;
                                    text-align: center;
                                }
                                .basket-item > div:first-child {
                                    margin-right: 0;
                                    margin-bottom: 5px;
                                }
                                .imgbasketpannier {
                                    max-width: 80px !important;
                                }
                            }
                        `)
                        .appendTo('head');
                    pannier1.prepend(newItem1);

                    totalItems += item.quantity; // Incrementa el contador de artículos
                });

                // Mostrar el total en ambos bloques si lo deseas
                var totalHtml = `
                    <div class="basket-total">
                        <h3>Total: ${grandTotal.toFixed(2)}€</h3>
                        <button class="botonpay" onclick="goToPayment()">Place Order</button>
                    </div>
                `;
                pannier.prepend(totalHtml);

                var totalHtml1 = `
                    <h3 style="text-align: center;">Total: ${grandTotal.toFixed(2)}€</h3>
                    <div style="display: flex; justify-content: center;">
                    <div class="basket-total" style="position: fixed; top: 15; right:50%; z-index: 99; background-color: white;">   
                    </div>
                    </div>
                `;

                // Add CSS to adjust image position
                $('<style>')
                    .text(`
                        @media (min-width: 769px) {
                            .basket-item > div:first-child {
                                margin-right: 10px;
                            }
                        }
                    `)
                    .appendTo('head');
                pannier1.prepend(totalHtml1);

                // Actualizar el contador de artículos y mostrar el icono de la cesta
                $('#item-count').text(totalItems);
                if (totalItems > 0) {
                    $('.basket-icone').css('display', 'flex');
                } else {
                    $('.basket-icone').css('display', 'none');
                }
            } else {
                pannier1.css('display', 'block');

                // Contenido para pannier1
                pannier1.html(`
                    <div class="empty-basket">
                        <p>There is no product selected</p>
                        <img src="./asset/slider/slider6.webp" alt="empty basket" class="empty-cart-image"><br>
                      <div class="form-botton-choose">
                     <button class="botton-form" onclick="window.location.href='./clothes.php'">Continue shopping</button>
                     </div>
                     </div> `);


                $('#item-count').text(0); // Reinicia el contador si no hay artículos
                $('.basket-icone').css('display', 'none'); // Oculta el icono de la cesta

            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}


function goToPayment() {
    // Redirigir a la página de pago
    window.location.href = './shopping.php'; // Ajusta la ruta según tu implementación
}

$(document).ready(function() {
    console.log('Document ready'); // Depuración
    updateBasket();
});

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
    return new Promise(function(resolve, reject) {
        $.ajax({
            url: './common/removefrombasket.php',
            type: 'POST',
            data: { id_products: id_products },
            dataType: 'json',
            success: function(response) {
                console.log('Response from removeFromBasket:', response); // Depuración
                if (response.status === 'error') {
                    alert(response.message);
                    reject(response.message);
                } else {
                    updateBasket(); // Actualiza el carrito
                    resolve(response); // Resuelve la promesa
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                reject(error); // Rechaza la promesa
            }
        });
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

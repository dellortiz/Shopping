
  // Cargamos el objeto productLiked desde localStorage (o lo inicializamos como vacío).
  var productLiked = localStorage.getItem("productLiked") ? JSON.parse(localStorage.getItem("productLiked")) : {};

  function toggleHeart(event, productId) {
      event.stopPropagation();

      // Si no hay estado registrado para este producto, lo inicializamos en false.
      if (productLiked[productId] === undefined) {
          productLiked[productId] = false;
      }

      const heartImg = document.getElementById(`imgHeart${productId}`);

      // Se muestra el corazón rojo inmediatamente.
      heartImg.src = './asset/redheart.png';

      // Si no se había dado like (según nuestro objeto persistido), enviamos like.
      if (!productLiked[productId]) {
          productLiked[productId] = true;
          updateLike(productId, "like");
      } else {
          // Si ya estaba marcado, se envía la acción de quitar el like.
          productLiked[productId] = false;
          updateLike(productId, "unlike");
      }

      // Actualizamos localStorage con el nuevo estado.
      localStorage.setItem("productLiked", JSON.stringify(productLiked));

      // Después de 1 segundo (o 2s según lo que decidas), se vuelve a la imagen normal.
      setTimeout(function() {
          heartImg.src = './asset/heart.png';
      }, 500);
  }

  function updateLike(productId, action) {
      fetch('toggle_like.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id_products: productId, action: action })
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              // Actualiza el contador de likes en el DOM.
              document.getElementById(`likesCount${productId}`).innerHTML = data.likes;
          } else {
              console.error("Error al actualizar el like:", data.message);
          }
      })
      .catch(error => console.error("Error en la solicitud:", error));
  }

   // Cuenta regresiva de 40 segundos
   let countdown = 39;

   const interval = setInterval(() => {
       countdown--;
       if (countdown <= 0) {
           clearInterval(interval);
           // Enviar solicitud al servidor para eliminar usuarios no verificados
           fetch('delete_expired_users.php')
           .then(response => response.json())
           .then(data => {
               if (data.success) {
                   window.location.href = 'signup_verification_email.php?expired=true';
               }
           })
           .catch(error => console.error('Error:', error));
       }
   }, 1000);
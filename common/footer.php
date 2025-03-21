<footer class="footer ">
 <section class="social-media">
    <div>
     <p>Get connected with us on social networks:</p>
    </div>
    <div>
      <ul>
        <li><img src="./asset/facebook.webp" alt="facebook"></li>
        <li><img src="./asset/twitter.png" alt="twitter"></li>
        <li><img src="./asset/instagram.webp" alt="instagram"></li>
        <li><img src="./asset/linkedin.webp" alt="linkedin"></li>
        <li><img src="./asset/whatsapp.webp" alt="whatsapp"></li>
        <li><img src="./asset/youtube.webp" alt="youtube"></li>
      </ul>
    </div>
 </section>
 <section class="site-description">
 <div>
        <p>Shopping :</p>
        <ul>
      <li><span> This online store is a website designed with the objective of selling products or services through electronic commerce tools</span></li>
      </ul>
    </div>
    <div>
      <p>Pages :</p>
    
      <?php if(isset($_SESSION['email'])): ?>
      <li><a href="index.php">Home</a></li>
      <li><a href="clothes.php">Shopping</a></li>
      <li><a href="profile.php">Profile</a></li>
      <li><a href="shopping.php">Basket</a></li>
      <li><a href="about_online_shopping.php">About Online Shopping</a></li>
      
      </div>
      <?php else: ?>
        
      <li><a href="index.php">Home</a></li>
      <li><a href="signup_verification_email.php">Sign up</a></li>
      <li><a href="signin.php">Sign in</a></li>
      <li><a href="clothes.php">Shopping</a></li>
      <li><a href="about_online_shopping.php">About Online Shopping</a></li>
      
    </div>
    <?php endif; ?>
    <div>
      <p>Our conditions :</p>
      <li><a href="data_privacy.php">Data Privacy</a></li>
      
      
    </div>
    <div>
      <p>Contact :</p>
      <li><a href="mailto:jo6024934@gmail.com"><i class="fa-solid fa-envelope fa-lg"></i> shopping@gmail.com</a></li>
      <li><a href=" contact.php"><i class="fa-solid fa-envelope fa-lg"></i> Web Site</a></li>    
    </div>
 </section>
 <div class="copyright">
  © 2025 Copyright :
  <a href="index.php">Shopping.com</a>
  </div>
</footer>

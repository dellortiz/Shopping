<?php include_once("./common/header.php"); ?>

<main class="main-body-index">
<section class="select-menu" id="menu-desktop">
    <ul id="menu">
        <li class="section-menu-li ">Fashion
        <ul class="submenu">
        <li class="section-menu-li"><a href="clothes.php">Clothes</a></li>
        <li class="section-menu-li"><a href="shoes.php">Shoes</a></li>
        <li class="section-menu-li"><a href="hats.php">Hats</a></li>
        </ul></li>
        <li class="section-menu-li">Computers 
        <ul class="submenu">
        <li class="section-menu-li"><summary><a href="computers.php">Desktop computer</a></li>
        <li class="section-menu-li"><a href="laptops.php"> Laptops</a></li>
        </ul></li>
        <li class="section-menu-li ">Phones
        <ul class="submenu">
        <li class="section-menu-li "><a href="iphones.php">Iphones</a></li>
        <li class="section-menu-li"><a href="android.php"> Android</a></li>
        </ul></li>
        <li class="section-menu-li">About Shopping
        <ul class="submenu">
        <li class="section-menu-li"><a href="about_online_shopping.php#shopping-work"> How does online shopping work?</a></li>
        <li class="section-menu-li"><a href="about_online_shopping.php#online-shopping"> What are the advantages or disadvantages of online shopping?</a></li>
        <li class="section-menu-li"><a href="about_online_shopping.php#online-entail"> What does selling online entail?</a></li>
        <li class="section-menu-li "><a href="about_online_shopping.php#virtual-store">What are the elements of a virtual store?</a></li>
        </ul></li>
        <li class="section-menu-li up">Data Privacy
        <ul class="submenu">
        <li class="section-menu-li"><a href="data_privacy.php#processing"> Processing of personal data and transfer to third parties</a></li>
        <li class="section-menu-li"><a href="data_privacy.php#cookies"> Cookies</a></li>
        <li class="section-menu-li"><a href="data_privacy.php#personaldata"> Personal data and retention provisions</a></li>
        <li class="section-menu-li "><a href="data_privacy.php#yourrights">Your rights</a></li>
        </ul></li>
        <li class="section-menu-li ">Contact
        <ul class="submenu">
        <li class="section-menu-li"><a href="contact.php"> Contact us</a></li>
        </ul></li>
        <li class="section-menu-li">Basket
        <ul class="submenu">
        <li class="section-menu-li"><a href="shopping.php"> My purchase</a></li>
        </ul></li>
        <?php if (isset($_SESSION['email'])): ?>
        <li class="section-menu-li">Profile
        <ul class="submenu">
        <li class="section-menu-li"><a href="profile.php"> My profile</a></li>
        </ul></li>
        <?php endif; ?>
        <li class="section-menu-li">Home
        <ul class="submenu">
        <li class="section-menu-li"><a href="index.php">Home page</a></li>
        </ul></li>
        </ul>
</section>
<div class="div-learn">
<h1 class="p-main1">Data Privacy</h1>


<h2 id="processing">Processing of personal data and transfer to third parties</h2>
<p>When you use our website, certain personal data is automatically collected on your device (computer, mobile phone, tablet, etc.). The IP address currently used by your device, the date, time, browser, operating 
 system of your device and the pages retrieved are collected. This is done to ensure data security, to optimise our reach and to improve our website. The processing of this personal data is carried out in accordance with Art. 6, para. 1, sentence 1, letter f
 of the General Data Protection Regulation (GDPR). The protection of our website and the optimisation of our services represent a legitimate interest on our part.</p>
<p>If you contact us (e.g. by means of a request to the contact details we have provided to you), we will only process the personal data you have provided to us that is necessary to process and respond to your request.</p>
<p>In order to carry out the data processing activities described in this Data Protection Statement, e.g. for the hosting and maintenance of our website, we use service providers.</p>

<h2 id="cookies">Cookies</h2>
<p>In order to make our services attractive and to enable the use of certain functions, we use cookies. 
These are small text files that are stored on your device. Some of the cookies we use are deleted as soon as you close
 your browser session (so-called session cookies). Other cookies remain on your device and allow us to recognise your browser on your 
 next visit (persistent cookies). You can set your browser to notify you when you receive a cookie and decide on a case-by-case basis whether to 
 accept it, or to reject it in some cases or in general. For more information, please refer to the help function of your Internet browser. If you 
 refuse cookies, the functionality of our website may be limited. By accepting our "cookie banner", you consent to the processing of your personal data by cookies. Personal data is processed in accordance with Art. 6, para. 1, sentence 1, letter a of the GDPR. Below you will find information about specific cookies.
</p>

<p>We deploy Google Analytics, a web analysis service of Google Inc. ("Google"). Google Analytics also uses cookies.
The information generated by the cookie about your use of this website is usually transferred to a Google server in the USA and stored there.
Before this transfer, however, your IP address will be shortened by Google within the Member States of the European Union or in other 
countries that are signatories to the Agreement on the European Economic Area. The full IP address will only be transmitted to Google's 
server in the USA in exceptional cases and will be shortened there. Google will use this information on behalf of the website operator for 
the purpose of evaluating the use of the website, compiling reports on website activity and providing other services relating to website and 
internet usage. The IP address transmitted by your browser within the framework of Google Analytics will not be merged with other Google data. 
You can prevent the storage of cookies by setting your browser software accordingly. In addition, you can prevent Google from collecting and 
processing the data generated by the cookie during your visit to this website (including your IP address) by downloading and installing the 
add-on module available at: https://tools.google.com/dlpage/gaoptout .
Personal data and retention provisions
</p>

<h2 id="personaldata">Personal data and retention provisions</h2>
<p>Your personal data is provided on a voluntary basis. You are not legally obliged to provide us with your personal data. 
If you do not wish to provide us with your personal data, this has no consequences for you other than that you cannot use our services. 
The personal data you provide to us via our website is only stored for the purpose for which it was provided to us. Different storage periods may also occur due to a legitimate interest of CentralApp AG (e.g. to ensure data security and to prevent abuse). 
Personal data that we have to store due to legal or contractual retention obligations will be blocked.</p>

<h2 id="yourrights">Your rights</h2>
<h3>To exercise your rights under the GDPR, including:</h3>
<ol>
<li>the right to information about the processing of your personal data and the right to obtain a copy of your data (Article 15 GRPD);</li>
<li>the right to correction of erroneous data and the right to complete incomplete data (Article 16 GRPD);</li>
<li>the right to have your personal data deleted and, in the event of disclosure, our duty to inform other responsible parties of the deletion request (Article 17 of the GDPR);</li>
<li>the right to restrict the processing of your personal data (Article 18 GDPR);</li>
<li>the right to data portability, so that your personal data is delivered to you in a structured, established and machine-readable format, as well as the right to transfer your data to another responsible person without our intervention (Article 20 of the GDPR);</li>
<li>the right to revoke an issued consent; the revocation does not affect the lawfulness of the processing carried out on the basis of the consent prior to the revocation (Article 7 GDPR); and
the right to object to the processing of your data (Article 21 GDPR),</li>
</ol>
<h3>You can contact us at any time. You may also lodge a complaint with the competent supervisory body if you consider that the processing of data infringes the provisions of the GDPR (Article 77 GDPR)</h3>

</div>
    
    <div class="message-container">
        <?php if (isset($_SESSION['message'])): ?>
            <span id="message_id" class="span-contact">
                <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                ?>
            </span>
        <?php endif; ?>
    
        <?php if (isset($_SESSION['message-error'])): ?>
            <span id="message_id" class="span-contact-error">
                <?php
                    echo $_SESSION['message-error'];
                    unset($_SESSION['message-error']);
                ?>
            </span>
        <?php endif; ?>
        
    </div>
    <div class="form-group">
        
        </div>

        
        
        
        

        <!-- Span para mostrar mensajes -->

</main>
<script src="./asset/js/message_id.js"></script>
<script src="./asset/js/script.js"></script>
<script src="./asset/js/signin.js"></script>
<script src="./asset/js/responsive_system.js"></script>
<script src="./asset/js/scroll.js"></script>

<?php include_once('./common/footer.php')?>
</body>
</html>
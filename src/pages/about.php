<div class="banner_container">
    <img src = img/Banner-Image-1.png alt = "chocolate">
    <div class="centered">PURE INGREDIENTS MIXED TOGETHER in THOGHTFUL and CREATIVE WAYS</div>
</div>
<div>            
    <?php
    $link = mysqli_connect($hn, $db_user, $db_pw, $db);

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    echo "
    <br> 
	<div class =\"category_container\">
    <div class = \"category_title\">OUR BESTSELLERS</div>
    <div class = \"category\"> <img src = \"https://mahzedahrbakery.com/assets/ecom/product/image/2016/02/25/HeavenInABox-c.jpg\" alt = \"Cookies\"></div>
    <div class = \"category\"> <img src = \"https://mahzedahrbakery.com/assets/product/image/2018/11/06/chocolatesable.jpg\" alt = \"Cookies\"></div>
    <div class = \"category\"> <img src = \"https://mahzedahrbakery.com/assets/ecom/product/image/2015/03/16/product_cookiesubscription-c.jpg\" alt = \"Cookies\"></div>
    <div class = \"category\"> <img src = \"https://mahzedahrbakery.com/assets/product/image/2018/11/08/product_gingersnaps-c.jpg\" alt = \"Cookies\"></div>
    <div class = \"category\"> <img src = \"https://mahzedahrbakery.com/assets/product/image/2018/11/07/product_mzd-bar-c.jpg\" alt = \"Cookies\"></div>
    </div>
    <br>
    <div style=\"text-align: center\" >
        <a href=\"index.php?page=items&category=0\" class=\"button\">SHOP NOW</a>
    </div>
    ";
    mysqli_close($db_connect);
    ?>      
</div>
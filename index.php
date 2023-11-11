<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
?>
<?php include 'include/header.php'; ?>

    <div class="hero-wrap" style="background-image: url('images/bg/1.jpg')">
        <div class="container">
            <div class="row align-items-center gap-y2">
                <div class="col-md-6">
                    <div class="content-title-one">
                        <span>Buy your favourite books</span>
                        <h1>
                            Featured Books of this <b>Month</b>
                        </h1>
                        <p>
                            "Books are the quietest and most constant of friends; they are the most accessible and wisest of counselors, and the most patient of teachers." - <b>Charles William Eliot</b>
                        </p>
                        <a href="#" class="btn btn-one" style="display:none">
                            <i class="ri-shopping-cart-2-line"></i>Buy Now
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="book-box">
                        <a href="product.php">
                            <img src="images/books/800x1105/2.jpg" alt="">
                            <div class="details">
                                <div class="catagory">Biography</div>
                                <h4>Celebration of Freedom</h4>
                                <p>By <span>Ellie Thomson</span></p>
                                <div class="price">$21.00</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="home-about-wrap">
        <div class="container">
            <div class="row gap-y2">
                <div class="col-lg-5 col-md-6">
                    <div class="img-wrap">
                        <img src="images/about/1.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 offset-lg-1">
                    <div class="content">
                        <div class="content-title-one">
                            <span>About Us</span>
                            <h1>
                                We have a big catalog of 12 Million books online
                            </h1>
                            <p>
                                "A great book is a friend that never lets you down. You can return to it again and again and the joy first derived from it will still be there." - <b>Michael Ende</b>
                            </p>
                            <a style="display:none" href="about.php" class="btn btn-one">Discover More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="home-product-wrap">
        <div class="container">
            <div class="row gap-y2">
                <div class="col-12 text-center">
                    <div class="section-title-one">
                        <span>Our Products</span>
                        <h1>Find Your Books</h1>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row gap-y1">
                    <?php
	$product_array = $db_handle->runQuery("SELECT * FROM tblproduct ORDER BY id ASC");
	if (!empty($product_array)) { 
		foreach($product_array as $key=>$value){
	?>
                        <div class="col-md-4">
                            <div class="book-box">
                                <a href="product.php?id=<?php echo $product_array[$key]["id"]; ?>">
                                    <img src="images/books/800x1105/<?php echo $product_array[$key]["image"]; ?>" alt="">
                                    <div class="details">
                                        <div class="catagory" style="display:none">Biography</div>
                                        <h4><?php echo $product_array[$key]["name"]; ?></h4>
                                        <p>By <span><?php echo $product_array[$key]["author"]; ?></span></p>
                                        <div class="price">$<?php echo $product_array[$key]["price"]; ?></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php
		}
	}
	?>                    
  
                    </div>
                </div>
                <div class="col-12 text-center" style="display:none">
                    <a href="#" class="btn btn-one">Find More...</a>
                </div>
            </div>
        </div>
    </div>

<?php include 'include/footer.php'; ?>
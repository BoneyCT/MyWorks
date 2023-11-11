<?php 
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
		if(!empty($_POST["quantity"])) {
			$productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE id='" . $_GET["code"] . "'");
			$itemArray = array($productByCode[0]["code"]=>array('name'=>$productByCode[0]["name"], 'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"], 'image'=>$productByCode[0]["image"]));
			
			if(!empty($_SESSION["cart_item"])) {
				if(in_array($productByCode[0]["code"],array_keys($_SESSION["cart_item"]))) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode[0]["code"] == $k) {
								if(empty($_SESSION["cart_item"][$k]["quantity"])) {
									$_SESSION["cart_item"][$k]["quantity"] = 0;
								}
								$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
							}
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		}
		$succ = "Product added to your cart";

	break;
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["code"] == $k)
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
	break;	
}
}
?>
<?php include 'include/header.php'; ?>


<?php
	$product_array = $db_handle->runQuery("SELECT * FROM tblproduct where id=".$_GET['id']);
	if (!empty($product_array)) { 
		foreach($product_array as $key=>$value){
	?>

    <div class="breadcrumb-wrap" style="background-image: url('images/bg/<?php echo $product_array[$key]["image"]; ?>')">
        <div class="breadcrumb-content">
            <h2>Product</h2>
        </div>
    </div>

    <div class="product-wrap-one">
        <div class="container">
            <div class="row gap-y2">
                <div class="col-lg-4 col-md-5">
                    <div class="img-wrap">
                        <img src="images/books/800x1105/<?php echo $product_array[$key]["image"]; ?>" alt="">
                    </div>
                </div>
                <div class="col-lg-8 col-md-6">
                    <div class="content">
                        <div class="book-info">

                            <h4><?php echo $product_array[$key]["name"]; ?></h4>
                            <p>By <span><?php echo $product_array[$key]["author"]; ?></span></p>
                            <div class="price">$<?php echo $product_array[$key]["price"]; ?></div>
                        </div>
                        <p>
                        <?php echo $product_array[$key]["description"]; ?>
                        </p>
						<?php if(isset($succ)){ ?>
                               <span style="color:green"><?php echo $succ; ?></span>
							<?php } ?>	
                        <div class="btn-sec">

                        <form method="post" action="product.php?id=<?php echo $_GET['id'];?>&action=add&code=<?php echo $product_array[$key]["id"]; ?>">
                           
                            <input type="text" class="product-quantity form-control" name="quantity" value="1" size="2" />
                            <input type="submit" value="Add to Cart" class="btnAddAction btn btn-one" />
                         </form>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
		}
	}
	?>     
<?php include 'include/footer.php'; ?>
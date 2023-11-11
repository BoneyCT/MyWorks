<?php
session_start();
//echo "<pre>";print_r($_SESSION["cart_item"]);
//unset($_SESSION["cart_item"]);
require_once("dbcontroller.php");
$db_handle = new DBController();
if (!empty($_GET["action"])) {
    switch ($_GET["action"]) {
        case "add":
            if (!empty($_POST["quantity"])) {
                $productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
                $itemArray = array($productByCode[0]["code"] => array('name' => $productByCode[0]["name"], 'code' => $productByCode[0]["code"], 'quantity' => $_POST["quantity"], 'price' => $productByCode[0]["price"], 'image' => $productByCode[0]["image"]));

                if (!empty($_SESSION["cart_item"])) {
                    if (in_array($productByCode[0]["code"], array_keys($_SESSION["cart_item"]))) {
                        foreach ($_SESSION["cart_item"] as $k => $v) {
                            if ($productByCode[0]["code"] == $k) {
                                if (empty($_SESSION["cart_item"][$k]["quantity"])) {
                                    $_SESSION["cart_item"][$k]["quantity"] = 0;
                                }
                                $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                            }
                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            }
            break;
        case "remove":

            if (!empty($_SESSION["cart_item"])) {
                foreach ($_SESSION["cart_item"] as $k => $v) {

                    if ($_GET["code"] == $_SESSION["cart_item"][$k]['code']) {
                        //echo 'found';die;
                        unset($_SESSION["cart_item"][$k]);
                    }
                    if (empty($_SESSION["cart_item"]))
                        unset($_SESSION["cart_item"]);
                }
            }
            header("Location: cart.php");
            break;
        case "empty":
            unset($_SESSION["cart_item"]);
            break;
    }
}
?>
<?php include 'include/header.php'; ?>
    <div class="breadcrumb-wrap" style="background-image: url('images/bg/1.jpg')">
        <div class="breadcrumb-content">
            <h2>Shopping Cart</h2>
        </div>
    </div>

    <div class="product-wrap-one">
        <div class="container">
            <div class="row gap-y2">
                <div class="col-12">
                    <?php
                    if (isset($_SESSION["cart_item"])) {
                        $total_quantity = 0;
                        $total_price = 0;
                        ?>
                        <div class="table-responsive">
                            <table class="tbl-cart table table-bordered" cellpadding="10" cellspacing="1">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th style="text-align:right;" width="5%">Quantity</th>
                                        <th style="text-align:right;" width="10%">Unit Price</th>
                                        <th style="text-align:right;" width="10%">Price</th>
                                        <th style="text-align:center;" width="5%">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($_SESSION["cart_item"] as $item) {
                                        $item_price = $item["quantity"] * $item["price"];
                                        ?>
                                        <tr>
                                            <td>
                                                <img src="images/books/800x1105/<?php echo $item["image"]; ?>"
                                                     class="cart-item-image"/><?php echo $item["name"]; ?>
                                            </td>
                                            <td><?php echo $item["code"]; ?></td>
                                            <td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
                                            <td style="text-align:right;"><?php echo "$ " . $item["price"]; ?></td>
                                            <td style="text-align:right;"><?php echo "$ " . number_format($item_price, 2); ?></td>
                                            <td style="text-align:center;">
                                                <a href="cart.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction">
                                                    <i class="fa fa-close"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        $total_quantity += $item["quantity"];
                                        $total_price += ($item["price"] * $item["quantity"]);
                                    }
                                    ?>

                                    <tr>
                                        <td colspan="2" align="right">Total:</td>
                                        <td align="right"><?php echo $total_quantity; ?></td>
                                        <td align="right" colspan="2">
                                            <strong><?php echo "$ " . number_format($total_price, 2); ?></strong></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <a href="checkout.php" class="btn btn-one" style="float:right">
                            <i class="ri-shopping-cart-2-line"></i>Checkout
                        </a>
                        <?php
                    } else {
                        ?>
                        <div class="no-records">Your Cart is Empty</div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    </div>

<?php include 'include/footer.php'; ?>
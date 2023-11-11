<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
?>
<?php include 'include/header.php'; ?>
    <script>
        function save() {

            var err = "";
            var error = 0;
            if (document.getElementById("name").value == "") {
                err = "Name field is mandatory";
                error = 1;
            }

            if (document.getElementById("email").value == "") {
                if (err == '') {
                    err = "Email field is mandatory";
                } else {
                    err += "<br>Email field is mandatory";
                }
                error = 1;
            }

            if (document.getElementById("phone").value == "") {
                if (err == '') {
                    err = "Phone field is mandatory";
                } else {
                    err += "<br>Phone field is mandatory";
                }
                error = 1;
            }

            if (document.getElementById("address").value == "") {
                if (err == '') {
                    err = "Address field is mandatory";
                } else {
                    err += "<br>Address field is mandatory";
                }
                error = 1;
            }

            if (error == 0) {
                window.location.href = 'success.php';
            } else {
                document.getElementById("error").innerHTML = err;
            }


        }
    </script>
    <div class="breadcrumb-wrap" style="background-image: url('images/bg/1.jpg')">
        <div class="breadcrumb-content">
            <h2>Checkout</h2>
        </div>
    </div>

    <div class="product-wrap-one">
        <div class="container">
            <div class="row gap-y2">
                <div class="col-lg-8 col-12 offset-lg-2">
                    <h2>Your Information</h2>
                    <div class="row gap-y1">
                        <div class="col-12">
                            <span style="color:red" id="error"></span>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label htmlFor="username">Name</label>
                                <Input type="text" class="form-control" name="name" id="name" value="" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label htmlFor="username">Email</label>
                                <Input type="text" class="form-control" name="email" id="email" value="" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label htmlFor="username">Phone</label>
                                <Input type="text" class="form-control" name="phone" id="phone" value="" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label htmlFor="username">Address</label>
                                <Input type="text" class="form-control" name="address" id="address" value="" />
                            </div>
                        </div>
                    </div>
                </div>
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
                        <a href="javascript:void(0);" class="btn btn-one" style="float:right" onclick="javascript:save();">
                            <i class="ri-shopping-cart-2-line"></i>Confirm Order
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
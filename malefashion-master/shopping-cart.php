<?php
// include Database
include "config/Database.php";
// include objects
include "objects/ProductImage.php";
include "objects/Product.php";

// instantiate Database Class
$database = new Database();
$db = $database->connect();

// instantiate product class
$product = new Product($db);
$product_image = new ProductImage($db);
?>

    <!-- include Header -->
<?php include "layout/layout_header.php"; ?>

    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Begin -->
<?php include "layout/offcanvas.php"; ?>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
<?php include "layout/navigation.php"; ?>
    <!-- Header Section End -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shopping Cart</h4>
                        <div class="breadcrumb__links">
                            <a href="index.php">Home</a>
                            <a href="shop.php">Shop</a>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="shopping__cart__table">
                        <?php
                        $total = 0;
                        $item_count = 0;

                        if (count($_SESSION['cart']) > 0) {
                        // get product ids
                        $ids = array();

                        foreach ($_SESSION['cart'] as $id => $value) {
                            $ids[] = $id;
                        }

                        $stmt = $product->readByIds($ids);

                        ?>
                        <table>
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($row = $stmt->fetch(PDO::FETCH_OBJ)): ?>
                                <?php
                                $quantity = $_SESSION['cart'][$row->id]['quantity'];
                                $subtotal = $row->price * $quantity;

                                $item_count += $quantity;
                                //  store item count in session to use it in navigation page
                                $_SESSION['item_count'] = $item_count;
                                $total += $subtotal;
                                //  store total in session to display it in navigation page
                                $_SESSION['total'] = $total;

                                // get the first image from database
                                $product_image->product_id = $row->id;
                                $stmt_product_image = $product_image->readFirst();
                                ?>
                                <tr>
                                    <td class="product__cart__item">
                                        <div class="product__cart__item__pic">
                                            <?php while ($image = $stmt_product_image->fetch(PDO::FETCH_OBJ)): ?>
                                                <img src="img/product/<?= $image->name ?>" alt="product image" width="80">
                                            <?php endwhile; ?>
                                        </div>
                                        <div class="product__cart__item__text">
                                            <h6><?= $row->name ?></h6>
                                            <h5>$ <?= number_format($row->price, 2) ?></h5>
                                        </div>
                                    </td>
                                    <td class="quantity__item">
                                        <div class="quantity">
                                            <div class="pro-qty-2">
                                                <input type="text" value="1">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cart__price">$ <?= $subtotal ?></td>
                                    <td class="cart__close"><i class="fa fa-close"></i></td>
                                </tr>
                            <?php endwhile; ?>
                            <?php
                            } else {
                                echo ' there is no product in cart';
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn">
                                <a href="shop.php">Continue Shopping</a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn update__btn">
                                <a href="#"><i class="fa fa-spinner"></i> Update cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart__discount">
                        <h6>Discount codes</h6>
                        <form action="#">
                            <input type="text" placeholder="Coupon code">
                            <button type="submit">Apply</button>
                        </form>
                    </div>
                    <div class="cart__total">
                        <h6>Cart total</h6>
                        <ul>
                            <li>Subtotal <span>$ <?= $total ?></span></li>
                            <li>Total <span>$ <?= $total ?></span></li>
                        </ul>
                        <a href="#" class="primary-btn">Proceed to checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Shopping Cart Section End -->

    <!-- include Footer -->
<?php include "layout/layout_footer.php"; ?>
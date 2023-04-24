<?php

session_start();

require("inc/database.php");

$sql = "SELECT * FROM products WHERE is_active = 1 AND id = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "id" => $_GET["product_id"]
]);
$product = $stmt->fetch();

$sql = "SELECT * FROM products WHERE is_active = 1 AND category_id = :category_id AND id != :id LIMIT 20";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "category_id" => $product["category_id"],
    "id" => $product["id"]
]);
$related = $stmt->fetchAll();

$sql = "SELECT reviews.*, users.name as user FROM reviews INNER JOIN users ON users.id = reviews.user_id WHERE reviews.product_id = :product_id AND reviews.is_approved = 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    "product_id" => $product["id"]
]);
$reviews = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("inc/head.php") ?>
    <title>Product Details</title>
</head>
<body>
    <?php require("inc/navbar.php") ?>

    <div class="container my-4">
        <?php require("inc/show-flash.php") ?>

        <div class="row g-4">
            <div class="col-12 col-md-3 col-lg-4">
                <img class="img-fluid" src="<?= $product["image_url"] ?>">
                <div class="row row-cols-4 g-1 mt-2">
                    <img class="img-fluid" src="<?= $product["image_url"] ?>">
                    <img class="img-fluid" src="<?= $product["image_url"] ?>">
                    <img class="img-fluid" src="<?= $product["image_url"] ?>">
                    <img class="img-fluid" src="<?= $product["image_url"] ?>">
                    <img class="img-fluid" src="<?= $product["image_url"] ?>">
                    <img class="img-fluid" src="<?= $product["image_url"] ?>">
                    <img class="img-fluid" src="<?= $product["image_url"] ?>">
                </div>
            </div>

            <div class="col-12 col-md-9 col-lg-8">
                <h4 class="fw-bold"><?= $product["name"] ?></h4>

                <div class="d-flex gap-3 align-items-center mt-3">
                    <div class="d-flex gap-1 align-items-center" style="font-size:12px">
                        <i class="fa fa-star text-warning"></i>
                        <i class="fa fa-star text-warning"></i>
                        <i class="fa fa-star text-warning"></i>
                        <i class="fa fa-star" style="color:#ccc;"></i>
                        <i class="fa fa-star" style="color:#ccc;"></i>
                    </div>
                    <div class="text-muted">(3,455 customer reviews)</div>
                </div>

                <p class="text-muted mt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio, aliquam?</p>

                <h5 class="fw-bold text-primary mt-3">Rs. <?= $product["price"] ?></h5>

                <div class="mt-3">
                    <label for="" class="form-label">Size</label>
                    <select name="" class="form-control form-select" style="max-width:200px" id="">
                        <option value=""></option>
                        <option value="">S</option>
                        <option value="">M</option>
                        <option value="">L</option>
                    </select>
                </div>

                <div class="mt-3">
                    <label for="" class="form-label">Color</label>
                    <select name="" class="form-control form-select" style="max-width:200px" id="">
                        <option value=""></option>
                        <option value="">S</option>
                        <option value="">M</option>
                        <option value="">L</option>
                    </select>
                </div>

                <div class="d-flex gap-3 mt-3">
                    <form action="/create-cart.php" method="post" class="input-group" style="max-width: 200px">
                        <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
                        <input type="number" name="quantity" value="1" class="form-control">
                        <button type="submit" class="btn btn-primary">Add to cart</button>
                    </form>

                    <form action="/store-wishlist.php" method="post">
                        <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
                        <button type="submit" class="btn btn-secondary">Add to wishlist</button>  
                    </form>
                </div>

                <div class="mt-3"><?= $product["description"] ?></div>
            </div>
        </div>

        <ul class="nav nav-tabs mb-4 mt-5">
            <li class="nav-item">
                <a href="" data-target="#relatedContainer" class="nav-link active">Related Products</a>
            </li>
            <li class="nav-item">
                <a href="" data-target="#reviewContainer" class="nav-link">Reviews (<?= count($reviews) ?>)</a>
            </li>
        </ul>

        <div id="relatedContainer" class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-lg-5 g-4">
            <?php foreach($related as $product): ?>
                <a class="text-dark text-center text-decoration-none" href="/details.php?product_id=<?= $product["id"] ?>">
                    <img class="img-fluid" src="<?= $product["image_url"] ?>" alt="">
                    <p class="fw-semibold mt-2 mb-1"><?= $product["name"] ?></p>
                    <p class="fw-bold text-primary">Rs. <?= $product["price"] ?></p>
                </a>
       
            <?php endforeach; ?>
        </div>

        <div id="reviewContainer">
            <div class="mb-3">
                <label for="review" class="form-label">Review</label>
                <textarea name="review" id="review" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label for="review" class="form-label">Review</label>
                <select name="rating" id="rating" class="form-control">
                    <option value="5">5</option>
                    <option value="4">4</option>
                    <option value="3">3</option>
                    <option value="2">2</option>
                    <option value="1">1</option>
                </select>
            </div>

            <button class="btn btn-secondary">Submit</button>

            <?php foreach($reviews as $review): ?>
                <div>
                    <p class="text-muted mb-0 mt-3 pt-3 border-top"><?= $review["review"] ?></p>
                    <div class="d-flex gap-2 mt-2" style="color:#ccc;font-size:14px">
                        <i class="fa fa-star text-warning"></i>
                        <i class="fa fa-star" style="color:#ccc"></i>
                        <i class="fa fa-star" style="color:#ccc"></i>
                        <i class="fa fa-star" style="color:#ccc"></i>
                        <i class="fa fa-star" style="color:#ccc"></i>
                    </div>
                    <p class="text-muted mt-2">By <?= $review["user"] ?> on <?= $review["created_at"] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php require("inc/remove-flash.php") ?>
</body>

<script>
    $("#reviewContainer").hide()

    $(".nav-tabs .nav-link").click(function(event) {
        event.preventDefault()

        $(".nav-tabs .nav-link").removeClass("active")

        $(this).addClass("active")

        $("#relatedContainer").hide()
        $("#reviewContainer").hide()

        $($(this).attr("data-target")).show()
    })
</script>
</html>
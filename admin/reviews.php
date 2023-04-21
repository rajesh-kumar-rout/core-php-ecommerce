<?php 

require("db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: /admin/login.php");
    die();
}

$sql = "SELECT reviews.*, users.name as customer, products.name as product FROM reviews INNER JOIN users ON users.id = reviews.user_id INNER JOIN products ON products.id = reviews.product_id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("head.php") ?>
    <title>Product Reviews</title>
</head>
<body>
    <?php require("header.php") ?>

    <table>
        <thead>
            <tr>
                <td>Customer</td>
                <td>Product</td>
                <td>Review</td>
                <td>Approved</td>
                <td>Created</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($reviews as $review): ?>
                <tr>
                    <td><?php echo $review["customer"] ?></td>
                    <td><?php echo $review["product"] ?></td>
                    <td><?php echo $review["review"] ?></td>
                    <td><?php echo $review["is_approved"] ? "yes" : "no" ?></td>
                    <td><?php echo $review["created_at"] ?></td>
                    <td>
                        <form action="/admin/approve-review.php" method="post">
                            <input type="hidden" name="review_id" value="<?= $review["id"] ?>">
                            <button type="submit" name="submit">Approve</button>
                        </form>
                    </td>
                    <td>
                        <form action="/admin/delete-review.php" method="post">
                            <input type="hidden" name="review_id" value="<?= $review["id"] ?>">
                            <button type="submit" name="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <?php require("footer.php") ?>
</body>
</html>
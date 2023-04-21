<?php 

require("db.php");

session_start();

if(!isset($_SESSION["email"]))
{
    header("Location: /index.php");
    die();
}

$sql = "SELECT * FROM sliders";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$sliders = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("head.php") ?>
    <title>Sliders</title>
</head>
<body>
    <?php require("header.php") ?>

    <a href="/admin/create-slider.php">Create Slider</a>

    <table>
        <thead>
            <tr>
                <td>Slider</td>
                <td>Image</td>
                <td>Created</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($sliders as $slider): ?>
                <tr>
                    <td>
                        <img src="/<?= $slider["image_url"] ?>" height="60px" width="60px" alt="">
                    </td>
                    <td><?= $slider["created_at"] ?></td>
                    <td>
                        <form action="/admin/delete-slider.php" method="post">
                            <input type="hidden" name="slider_id" value="<?= $slider["id"] ?>">
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
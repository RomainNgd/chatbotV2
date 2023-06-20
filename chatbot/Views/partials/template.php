<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $page_description; ?>">
    <title><?= $page_title ?></title>
    <?php
    if (!empty($_SESSION['chatuser']['login'])): ?>
    <link rel="stylesheet" href="<?= URL ?>assets/css/sidenav.css">
    <script src="https://kit.fontawesome.com/16ccf2aa54.js" crossorigin="anonymous"></script>
    <?php endif;
    if(!empty($page_css)) : ?>
        <?php foreach($page_css as $fichier_css) : ?>
            <link href="<?= URL ?>assets/css/<?= $fichier_css ?>" rel="stylesheet" />
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>

<?php
    if (!empty($_SESSION['chatuser']['login'])){
        require_once "Views/partials/sidenav.php";
    }
?>

<main>
    <?php
    if(!empty($_SESSION['alert'])) {
        foreach($_SESSION['alert'] as $alert){
            echo "<div class='alert ". $alert['type'] ."' role='alert'>
                        ".$alert['message']."
                    </div>";
        }
        unset($_SESSION['alert']);
    }
    ?>
    <?= $page_content; ?>
</main>

<?php require_once("Views/partials/footer.php"); ?>

<?php
if (!empty($_SESSION['userchat']['login'])): ?>
<script src="<?= URL ?>assets/js/sidenav.js"></script>
<?php endif;
if(!empty($page_javascript)) : ?>
    <?php foreach($page_javascript as $fichier_javascript) : ?>
        <script src="<?= URL?>assets/js/<?= $fichier_javascript ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>
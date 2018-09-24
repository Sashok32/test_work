<?php
    require_once "classes.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Категории фото</title>

    <!-- свои css-стили -->
    <link href="style.css" rel="stylesheet">
</head>
<body>
<?php
if (isset($_POST['deleteProject']) && isset($_POST['deletePro'])) {
    $project -> deleteProject($_POST['deleteProject']);
    echo "<p style='color:white; background-color:green; text-align:center'>Вы успешно удалили категорию</p>";
    header('Refresh: 1; url=index.php');
} elseif (isset($_POST['deletePhoto']) && isset($_POST['deletePho'])) {
    $photo -> deletePhoto($_POST['deletePhoto']);
    echo "<p style='color:white; background-color:green; text-align:center'>Фотография успешно удалена</p>";
    header('Refresh: 1;');
} elseif (isset($_FILES['addPhoto']) && !empty($_FILES['addPhoto']) && !empty($_GET['project'])) {
    $photo->addPhoto($_FILES['addPhoto']["name"], $_GET['project'], $_FILES['addPhoto']["tmp_name"]);
    echo "<p style='color:white; background-color:green; text-align:center'>Фотография успешно добавлена</p>";
    header('Refresh: 1;');
} else {
    ?>
    <a class="mainPage" href="index.php">&#8592;Домой</a>


    <div class="container">

        <div class="block1">
            <?php
            if (!empty($_GET['project']) && isset($_GET['project'])) {
                echo "<h1></h1><i><u>ПРОЕКТ</u></i></h1>";
                $project->nameProject($_GET['project']);
                echo "<div class='menuProject'>
                    <form action='' method='post'><input type='hidden' name='deleteProject' value='{$_GET['project']}'>
                    <input type='submit' name='deletePro' value='Удалить Проект'></form>
                    <a href='project.php?project={$_GET['project']}&photo={$_GET['project']}' 
                    >Посмотреть фото проекта</a><br><br>
                     <label for='addPhoto'>Добавить фото:</label>
                    <input type='checkbox' id='addPhoto'>
                    <form action='?project={$_GET['project']}' method='post' enctype='multipart/form-data'>
                        <input type='file' name='addPhoto' required>
                        <input type='submit' value='Добавить'>
                    </form></div>";

            } else {
                $project->showProject();
            }
            ?>

        </div>

        <div class="block2">
            <?php
            if (isset($_GET['project']) && isset($_GET['photo']) && !empty($_GET['photo'])) {
            $photo -> showPhoto($_GET['photo']);
            }
            ?>

        </div>

    </div>
    <?php
}
?>
</body>
</html>
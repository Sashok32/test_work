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
    if (!empty($_POST['newProj']) && isset($_POST['newProj'])) {
        $newProj = $project -> db -> escape($_POST['newProj']);
        $project -> createProject($newProj);
        echo "<p style='color:white; background-color:green; text-align:center'>Вы успешно добавили новую категорию</p>";
        header('Refresh: 2; url=index.php');
    }
?>



<div class="container">

    <div class="block1">
        <label for="projects">Просмотр списка проектов:</label>
        <input type="checkbox" id="projects">
        <?php
            $project -> showProject();
        ?>

    </div>

    <div class="block2">

        <label for="newProject">Создать новый проект:</label>
        <input type="checkbox" id="newProject">
        <form action="" method="post">
            <input type="text" name="newProj" required>
            <input type="submit" value="Создать">
        </form>
    </div>

</div>

</body>
</html>
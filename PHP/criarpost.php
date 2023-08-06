<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/GERAL.css">
    <link rel="stylesheet" href="../CSS/HEADER.css">
    <link rel="stylesheet" href="../CSS/SIDEBAR.css">
    <link rel="stylesheet" href="../CSS/index.css">
    <link rel="stylesheet" href="../CSS/postagem.css">
</head>

<body>
    <?php
    session_start();

    if (!isset($_SESSION['idfconta'])) {
        header("Location: login.php");
        die();
    } else {
        if($_SESSION['idfconta'] === 'u'){
            header("Location: index.php");
            die();

        }else{
            $tipoUsuario = $_SESSION['idfconta'];
    
            if ($tipoUsuario === 'u') {
                require_once '../PGSCOMP/headeru.php';
            }
            if ($tipoUsuario === 'a') {
                require_once '../PGSCOMP/headera.php';
            }
            if ($tipoUsuario === 'm') {
                require_once '../PGSCOMP/headerm.php';
            }
        }

    }

    require_once '../CONFIGS/config.php';
    require_once '../PGSCOMP/sidebar.php';

    $nomePost = $_REQUEST['nomePost'] ?? '';
    $descPost = $_REQUEST['descPost'] ?? '';
    $catPost = $_REQUEST['cat'] ?? '';

    ?>

    <main>
        <h1>CRIAR POSTAGEM</h1>

        <form action="<?= $_SERVER['PHP_SELF'] ?>">
            <input type="text" name="nomePost" id="nomePost" placeholder="Nome da postagem:" maxlength='60' value="<?= $nomePost ?>">
            <textarea name="descPost" id="descPost" maxlength="500" placeholder="Descrição da postagem:"><?= $descPost ?></textarea>

            <select name="cat" id="cat">
                <option value="selecCat">SELECIONE A CATEGORIA</option>
                <?php

                $selectQ = "SELECT * FROM categoria";

                $selectP = $cx->prepare($selectQ);
                $selectP->setFetchMode(PDO::FETCH_ASSOC);
                $selectP->execute();

                while ($dados = $selectP->fetch()) {
                    echo "<option value='{$dados['id_cat']}'>{$dados['nome_cat']}</option>";
                }
                ?>
            </select>

            <input type="submit" value="CRIAR" name="criar">
            <input type="button" value="CANCELAR" onclick="return trocapag(1)">
        </form>

        <?php

        if (isset($_REQUEST['criar'])) {
            if (empty($nomePost) || empty($descPost) || empty($catPost) || $catPost == "selecCat") {
                echo "<p class='erroM'>PREENCHA OS CAMPOS!</p>";
            } else {
                $selectQ2 = "SELECT * FROM postagem WHERE nome_post = '$nomePost' AND desc_post = '$descPost' AND id_cat = '$catPost'";
                $selectP2 = $cx->prepare($selectQ2);
                $selectP2->execute();
                $total = $selectP2->rowCount();

                if ($total >= 1) {
                    echo "<p class='erroM'>ESSA POSTAGEM JA EXISTE</p>";
                } else {
                    $insertQ = "INSERT INTO postagem VALUES(DEFAULT, '$nomePost', '$descPost', '$catPost', 0)";
                    $insertP = $cx->prepare($insertQ);
                    try {
                        $insertP->execute();
                        echo "<p class='acertoM'>POSTAGEM FEITA COM SUCESSO!</p>";
                    } catch (PDOException $e) {
                        $e->getMessage();
                    }
                }
            }
        }

        ?>
    </main>
</body>
<script src="../JS/trocapag.js"></script>
</html>
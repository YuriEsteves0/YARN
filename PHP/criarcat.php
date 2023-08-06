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
        if ($_SESSION['idfconta'] === 'u') {
            header("Location: index.php");
            die();
        } else {
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

    $nomeCat = $_REQUEST['nomeCat'] ?? '';

    ?>

    <main>
        <h1>CRIAR CATEGORIA</h1>

        <form action="<?= $_SERVER['PHP_SELF'] ?>">
            <input type="text" name="nomeCat" id="nomeCat" placeholder="Nome da categoria:" maxlength='100' value="<?= $nomeCat ?>">

            <input type="submit" value="CRIAR" name="criar">
            <input type="button" value="CANCELAR" onclick="return trocapag(1)">
        </form>

        <?php

        if (isset($_REQUEST['criar'])) {
            if (empty($nomeCat)) {
                echo "<p class='erroM'>PREENCHA OS CAMPOS!</p>";
            } else {
                $selectQ2 = "SELECT * FROM categoria WHERE nome_cat = '$nomeCat'";
                $selectP2 = $cx->prepare($selectQ2);
                $selectP2->execute();
                $total = $selectP2->rowCount();

                if ($total >= 1) {
                    echo "<p class='erroM'>ESSA CATEGORIA JA EXISTE</p>";
                } else {

                    $insertQ = "INSERT INTO categoria VALUES(DEFAULT, '$nomeCat', NULL)";
                    $insertP = $cx->prepare($insertQ);
                    $insertP->execute();
                    echo "<p class='acertoM'>CATEGORIA FEITA COM SUCESSO!</p>";
                }
            }
        }

        ?>
    </main>
    <script src="../JS/trocapag.js"></script>


</body>

</html>
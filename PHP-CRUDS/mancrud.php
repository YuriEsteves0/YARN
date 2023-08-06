<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/GERAL.css">
    <link rel="stylesheet" href="../CSS/HEADER.css">
    <link rel="stylesheet" href="../CSS/SIDEBAR.css">
    <link rel="stylesheet" href="../CSS/cruds.css">
    <link rel="stylesheet" href="../CSS/respostas.css">
</head>

<body>

    <?php
    session_start();

    if (!isset($_SESSION['idfconta']) || $_SESSION['idfconta'] !== 'm') {
        header("Location: ../PHP/index.php");
        die();
    }

    require_once '../CONFIGS/config.php';
    require_once '../PGSCOMP/headerm.php';

    ?>

    <div class="sidebar">
        <div class="search-bar-friends">

        </div>

        <form action="<?= $_SERVER['PHP_SELF'] ?>">
            <div class="friends">
                <input type="submit" value="Categorias" name="categorias">
            </div>
        </form>

        <form action="<?= $_SERVER['PHP_SELF'] ?>">
            <div class="friends">
                <input type="submit" value="Postagens" name="postagens">
            </div>
        </form>

    </div>

    <main>
        <?php

        echo "<h1 id='pagid'>USUARIOS</h1>";

        if (isset($_REQUEST['categorias'])) {
            $selectQ = "SELECT * FROM categoria";
            $selectP = $cx->prepare($selectQ);
            $selectP->execute();

            echo "<table>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>NOME</th>";
            echo "<th>AÇÕES</th>";
            echo "</tr>";

            while ($dados = $selectP->fetch()) {
                echo "<tr>";
                echo "<td>{$dados['id_cat']}</td>";
                echo "<td>{$dados['nome_cat']}</td>";
                echo "<td>";
                echo "<a href='../PHP-CRUDS/excluirCat.php?ref={$dados['id_cat']}'>&#x274C;</a>";
                echo "<a href='../PHP-CRUDS/editarCat.php?ref={$dados['id_cat']}'>&#x1F4DD;</a>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            if (isset($_REQUEST['postagens'])) {

                $selectQ = "SELECT postagem.id_post, postagem.nome_post, postagem.desc_post, categoria.nome_cat, postagem.qnt_views FROM postagem JOIN categoria ON postagem.id_cat = categoria.id_cat";

                $selectP = $cx->prepare($selectQ);
                $selectP->execute();

                echo "<table>";
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>NOME</th>";
                echo "<th>DESCRIÇÃO</th>";
                echo "<th>NCATEGORIA</th>";
                echo "<th>VIEWS</th>";
                echo "<th>AÇÕES</th>";
                echo "</tr>";

                while ($dados = $selectP->fetch()) {
                    echo "<tr>";
                    echo "<td>{$dados['id_post']}</td>";

                    if (strlen($dados['nome_post']) > 40) {
                        $nomeN = substr($dados['nome_post'], 0, 39) . '...';
                        echo "<td>$nomeN</td>";
                    } else {
                        echo "<td>{$dados['nome_post']}</td>";
                    }

                    if (strlen($dados['desc_post']) > 40) {
                        $descricao = substr($dados['desc_post'], 0, 39) . '...';
                        echo "<td>$descricao</td>";
                    } else {
                        echo "<td>{$dados['desc_post']}</td>";
                    }
                    echo "<td>{$dados['nome_cat']}</td>";
                    echo "<td>{$dados['qnt_views']}</td>";
                    echo "<td>";
                    echo "<a href='../PHP-CRUDS/excluirPost.php?ref={$dados['id_post']}'>&#x274C;</a>";
                    echo "<a href='../PHP-CRUDS/editarPost.php?ref={$dados['id_post']}'>&#x1F4DD;</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='erroM'>SELECIONE UMA TABELA</p>";
            }
        }



        ?>
    </main>
</body>
</html>
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
</head>

<body>
    <?php
    require_once '../CONFIGS/Csession.php';
    require_once '../CONFIGS/config.php';
    require_once '../PGSCOMP/sidebar.php';
    ?>

    <main>
        <?php

        $selectQ = "SELECT postagem.id_post, postagem.nome_post, postagem.desc_post, categoria.nome_cat, postagem.qnt_views FROM postagem JOIN categoria ON postagem.id_cat = categoria.id_cat";

        $selectP = $cx->prepare($selectQ);
        $selectP->setFetchMode(PDO::FETCH_ASSOC);
        $selectP->execute();

        while ($dados = $selectP->fetch()) {
            echo "<div class='post'>";
            echo "<hr>";
            echo "<div class='txts'>";
            echo "<h1>{$dados['nome_post']}</h1>";
            echo "<h2>{$dados['nome_cat']}</h2>";
            if(strlen($dados['desc_post']) > 100){
                $descricaoN = substr($dados['desc_post'], 0, 99) . "...";
                echo $descricaoN;
            }else{
                echo "<p>{$dados['desc_post']}</p>";
            }
            
            echo "</div>";
            echo "<div class='rightS'>";
            echo "<h3>VIEWS: {$dados['qnt_views']}</h3>";
        ?>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
            <?php
            echo "<a href='../PHP/post.php?id_post={$dados['id_post']}'>VER</a>";
            echo "</div>";
            echo "</div>";
        }

            ?>
            </form>

    </main>

    </div> <!-- .ENCL -->

    <?php

    require_once '../CONFIGS/fBanco.php';

    ?>
</body>

</html>
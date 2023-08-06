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

    $search = $_REQUEST['search'];
    ?>

    <main>
        <?php

        $selectQ = "SELECT postagem.id_post, postagem.nome_post, postagem.desc_post, categoria.nome_cat, postagem.qnt_views FROM postagem JOIN categoria ON postagem.id_cat = categoria.id_cat WHERE postagem.nome_post LIKE '%$search%' OR postagem.desc_post LIKE '%$search%' OR categoria.nome_cat LIKE '%$search%'";

        $selectP = $cx->prepare($selectQ);
        $selectP->setFetchMode(PDO::FETCH_ASSOC);
        $selectP->execute();

        while ($dados = $selectP->fetch()) {
            echo "<div class='post'>";
            echo "<hr>";
            echo "<div class='txts'>";

            $primeiraLN = substr($dados['nome_post'], 0, 1);
            $restoLN = substr($dados['nome_post'], 1, 60);

            echo "<div class='div-nome-post'><h1 class='Frase primeira-l'>$primeiraLN</h1>" . "<h1 class='Frase segunda-l'>$restoLN</h1></div>";

            $primeiraLC = substr($dados['nome_cat'], 0, 1);
            $restoLC = substr($dados['nome_cat'], 1, 100);

            echo "<div class='div-nome-cat'><h2 class='Frase primeira-l'>$primeiraLC</h2>" . "<h2 class='Frase segunda-l'>$restoLC</h2></div>";

            $primeiraLD = substr($dados['desc_post'], 0, 1);
            $restoLD = substr($dados['desc_post'], 1, 99) . "...";

            if(strlen($dados['desc_post']) > 100){;
                
                echo "<div class='div-nome-desc'><h2 class='Frase primeira-l'>$primeiraLC</h2>" . "<h2 class='Frase segunda-l'>$restoLC</h2></div>";
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
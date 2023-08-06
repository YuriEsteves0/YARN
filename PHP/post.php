<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/GERAL.css">
    <link rel="stylesheet" href="../CSS/HEADER.css">
    <link rel="stylesheet" href="../CSS/SIDEBAR.css">
    <link rel="stylesheet" href="../CSS/post.css">


</head>

<body>
    <?php

    require_once '../CONFIGS/Csession.php';
    require_once '../CONFIGS/config.php';
    require_once '../PGSCOMP/sidebar.php';

    $id_post = $_REQUEST['id_post'] ?? '';
    if(!isset($_SESSION['visto_' . $id_post])){
        $updateQ = "UPDATE postagem SET qnt_views = qnt_views + 1 WHERE id_post = '$id_post'";
        $updateP = $cx->prepare($updateQ);
        $updateP->execute();
    
        $_SESSION['visto_' . $id_post] = true;
    }


    ?>

    <main>
        <?php

        $selectQ = "SELECT * FROM postagem JOIN categoria ON postagem.id_cat = categoria.id_cat WHERE id_post = '$id_post'";
        $selectP = $cx->prepare($selectQ);
        $selectP->setFetchMode(PDO::FETCH_ASSOC);
        $selectP->execute();
        $total = $selectP->rowCount();

        if($total != 1){
            echo "<p class='erroM'>NÃO EXISTE ESSA NOTICIA</p>";
        }else{
            while($dados = $selectP->fetch()){
                echo "<div class='infogeral'>";
                echo "<h1>{$dados['nome_post']}</h1>";
                echo "<h2>{$dados['nome_cat']}</h2>";
                echo "</div>";
                echo "<h2>Visualizações: {$dados['qnt_views']}</h2>";
                echo "<h3 class='descpost'>{$dados['desc_post']}</h3>";
            }
        }

        ?>
        <h1></h1>
    </main>
</body>

</html>
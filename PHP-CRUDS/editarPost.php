<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/GERAL.css">
    <link rel="stylesheet" href="../CSS/HEADER.css">
    <link rel="stylesheet" href="../CSS/SIDEBAR.css">
    <link rel="stylesheet" href="../CSS/postagem.css">
</head>

<body>
    <?php

    require_once '../CONFIGS/Csession.php';
    require_once '../CONFIGS/config.php';
    require_once '../PGSCOMP/sidebar.php';

    $ref = $_REQUEST['ref'] ?? '';

    ?>
    <main>
        <div class="descpost">
            <h1>EDITAR</h1>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
                <?php

                if (empty($ref)) {
                    echo "<p class='erroM'>Erro na chamada!</p>";
                } else {
                    $selectQ = "SELECT * FROM postagem JOIN categoria ON postagem.id_cat = categoria.id_cat WHERE id_post = '$ref'";
                    $selectP = $cx->prepare($selectQ);
                    $selectP->setFetchMode(PDO::FETCH_ASSOC);
                    $selectP->execute();

                    while ($dados = $selectP->fetch()) {
                        echo "<input type='hidden' name='ref' value=$ref>";

                        echo "<input type='text' name='Postagem' id='Postagem' placeholder='Nome Da Postagem: ' value='{$dados['nome_post']}' maxlenght='60'>";

                        echo "<textarea name='postagemDesc' id='postagemDesc' cols='30' rows='10' placeholder='Descrição da postagem:' maxlenght='500'>{$dados['desc_post']}</textarea>";

                        echo "<select name='cat' id='cat'>";
                        echo "<option value='{$dados['id_cat']}'>{$dados['nome_cat']}</option>";
                        echo "</select>";
                    }
                }
                ?>
                <input type="submit" value="EDITAR" name="editarbtn">
                <input type="button" value="CANCELAR" onclick="return trocapag(1)">
            </form>

            <?php
            if (isset($_REQUEST['editarbtn'])) {
                $nome = $_REQUEST['Postagem'];
                $descP = $_REQUEST['postagemDesc'];
                $catP = $_REQUEST['cat'];

                $updateQ = "UPDATE postagem SET nome_post = '$nome', desc_post = '$descP', id_cat = '$catP' WHERE id_post = '$ref' LIMIT 1";
                $updateP = $cx->prepare($updateQ);
                try {
                    $cx->beginTransaction();
                    $updateP->execute();
                    $cx->commit();
                    $total = $updateP->rowCount();

                    if ($total <= 0) {
                        echo "<p class='erroM' style='margin-top:140px;'>HOUVE UM ERRO, TENTE NOVAMENTE MAIS TARDE</p>";
                    } else {
                        echo "<p class='acertoM''>Categoria alterada com sucesso!</p>";
                    }
                } catch (PDOException $e) {
                    $cx->rollBack();
                    throw $e;
                }
            }


            ?>
        </div>
    </main>
</body>
<script src="../JS/trocapag.js"></script>
</html>
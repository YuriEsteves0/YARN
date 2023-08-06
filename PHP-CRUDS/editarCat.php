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
                    $selectQ = "SELECT * FROM categoria WHERE id_cat = '$ref'";
                    $selectP = $cx->prepare($selectQ);
                    $selectP->setFetchMode(PDO::FETCH_ASSOC);
                    $selectP->execute();

                    while ($dados = $selectP->fetch()) {
                        echo "<input type='hidden' name='ref' value=$ref>";

                        echo "<input type='text' name='Categorias' id='Categorias' placeholder='Nome Da Categoria: ' value='{$dados['nome_cat']}'>";
                    }
                }
                ?>
                <input type="submit" value="EDITAR" name="editarbtn">
                <input type="button" value="CANCELAR" onclick="return trocapag(1)">
            </form>

            <?php
            if (isset($_REQUEST['editarbtn'])) {
                $nome = $_REQUEST['Categorias'];

                $selectQ2 = "SELECT * FROM categoria WHERE nome_cat = '$nome'";
                $selectP2 = $cx->prepare($selectQ2);
                $selectP2->execute();
                $total = $selectP2->rowCount();

                if ($total == 1) {
                    echo "<p class='erroM'>TROQUE OS VALORES!</p>";
                } else {
                    $updateQ = "UPDATE categoria SET nome_cat = '$nome' WHERE id_cat = '$ref' LIMIT 1";
                    $updateP = $cx->prepare($updateQ);
                    try {
                        $cx->beginTransaction();
                        $updateP->execute();
                        $cx->commit();
                        $total = $updateP->rowCount();

                        if ($total <= 0) {
                            echo "<p class='erroM' style='margin-top:140px;'>HOUVE UM ERRO, TENTE NOVAMENTE MAIS TARDE</p>";
                        } else {
                            echo "<p class='acertoM'>Categoria alterada com sucesso!</p>";
                        }
                    } catch (PDOException $e) {
                        $cx->rollBack();
                        throw $e;
                    }
                }
            }

            ?>
        </div>
    </main>
</body>
<script src="../JS/trocapag.js"></script>
</html>
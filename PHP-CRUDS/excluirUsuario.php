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

        <?php

        if (empty($ref)) {
            echo "<p class='erroM'>ERRO NA CHAMADA.</p>";
        } else {
            $selectQ = "SELECT * FROM usuario WHERE id_user = '$ref'";
            $selectP = $cx->prepare($selectQ);
            $selectP->execute();
            $total = $selectP->rowCount();
            if($total != 1){
                echo "<p class='erroM'>ESSE USUARIO NÃO EXISTE</p>";
            }else{
                $deleteQ = "DELETE FROM usuario WHERE id_user = '$ref'";
                $deleteP = $cx->prepare($deleteQ);
                try{
                    $cx->beginTransaction().
                    $deleteP->execute();
                    $cx->commit();
                    echo "<p class='acertoM'>USUARIO DELETADO COM SUCESSO!</p>";
                }catch(PDOException $e){
                    $e->getMessage();
                    throw $e;
                }
            }
        }

        ?>
    </main>
</body>

</html>
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
            $selectQ = "SELECT * FROM categoria WHERE id_cat = '$ref'";
            $selectP = $cx->prepare($selectQ);
            $selectP->execute();
            $total = $selectP->rowCount();
            if($total != 1){
                echo "<p class='erroM'>ESSA CATEGORIA NÃO EXISTE</p>";
            }else{
                $deleteQ = "DELETE FROM categoria WHERE id_cat = '$ref'";
                $deleteP = $cx->prepare($deleteQ);
                try{
                    $cx->beginTransaction().
                    $deleteP->execute();
                    $cx->commit();
                    echo "<p class='acertoM'>CATEGORIA DELETADA COM SUCESSO!</p>";
                }catch(PDOException $e){
                    if($e->getCode() === '23000' && $e->errorInfo[1] == 1451){
                        echo "<p class='erroM'>Não é possivel excluir a categoria. Alguma postagem ainda a contém!</p>";
                    }else{
                        echo "<p class='erroM'>Erro ao excluir a categoria!</p>";
                    }                    
                }
            }
        }

        ?>
    </main>
</body>

</html>
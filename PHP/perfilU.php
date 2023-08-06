<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/GERAL.css">
    <link rel="stylesheet" href="../CSS/HEADER.css">
    <link rel="stylesheet" href="../CSS/SIDEBAR.css">
    <link rel="stylesheet" href="../CSS/perfil.css">
</head>

<body>
    <?php

    require_once '../CONFIGS/Csession.php';
    require_once '../CONFIGS/config.php';
    require_once '../PGSCOMP/sidebar.php';



    ?>

    <main>

        <?php

        $nome = $_SESSION['idUsuario'];
        $selectQ = "SELECT * FROM usuario WHERE nome_user = '$nome'";
        $selectP = $cx->prepare($selectQ);
        $selectP->setFetchMode(PDO::FETCH_ASSOC);
        $selectP->execute();

        while ($dados = $selectP->fetch()) {
        ?>
            <form action="<?= $_SERVER['PHP_SELF'] ?>">
                <?php
                echo "<div class='foto-nome'>";
                echo "<figure><img src='{$dados['foto_user']}' class='fotoUser'></figure>";
                echo "<h1 class='nomeUser'>{$dados['nome_user']} (#{$dados['id_user']})</h1>";
                echo "</div>";

                echo "<div class='infogeral'>";
                echo "<textarea name='descUser' id='descUser' placeholder='Conte-nos um pouco sobre você (Opcional)'>{$dados['desc_user']}</textarea>";
                echo "<input type='text' name='locUser' id='locUser' placeholder='Diga-nos sua localização (Opcional)' value='{$dados['loc_user']}'>";
                ?>
                <input type="submit" value="Salvar" name="salvar" class='input-salvar'>
            </form>

            <form action="<?= $_SERVER['PHP_SELF'] ?>">
                <input type="submit" value="Sair" name="sair" class='input-sair'>
            </form>
        <?php
            echo "</div>";
        }
        ?>

        <?php

        if (isset($_REQUEST['sair'])) {
            session_destroy();
            header("Location: login.php");
            die();
        }

        if (isset($_REQUEST['salvar'])) {
            $desc = $_REQUEST['descUser'] ?? '';
            $loc = $_REQUEST['locUser'] ?? '';

            if (empty($desc) || empty($loc)) {
                echo "<script>alert('PREENCHA OS CAMPOS');</script>";
            } else {
                $selectQ = "SELECT * FROM usuario WHERE desc_user = '$desc' AND loc_user = '$loc'";
                $selectP = $cx->prepare($selectQ);
                $selectP->execute();
                $total = $selectP->rowCount(); 
                if($total == 0){
                    $updateQ = "UPDATE usuario SET desc_user = '$desc', loc_user = '$loc' WHERE nome_user = '$nome'";
                    $updateP = $cx->prepare($updateQ);
                    try {
                        $cx->beginTransaction();
                        $updateP->execute();
                        $cx->commit();
                        header('Location: ../PHP/perfilU.php');
                    } catch (PDOException $e) {
                        $e->getMessage();
                        throw $e;
                    }
                }else{
                    echo "<script>alert('MUDE OS CAMPOS');</script>";
                }
            }
        }

        ?>
    </main>
</body>

</html>
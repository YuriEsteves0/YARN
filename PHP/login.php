<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/loginCad.css">
    <link rel="stylesheet" href="../CSS/GERAL.css">
</head>

<body>
    <main>
        <?php

        require_once '../CONFIGS/config.php';

        ?>

        <h1>YARN</h1>

        <h2>LOGIN</h2>

        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">

            <input type="text" name="username" id="username" placeholder="Nome:">
            <input type="password" name="password" id="password" placeholder="Senha:">

            <p>Quer fazer cadastro? Clique <a href="cad.php"><strong>AQUI</strong></a></p>

            <input type="submit" value="ENTRAR" name="login">
        </form>

        <?php
        $nomeU = $_REQUEST['username'] ?? "";
        $senhaU = $_REQUEST['password'] ?? "";

        if (isset($_REQUEST['login'])) {
            if (empty($nomeU) || empty($senhaU)) {
                echo "<p class='erroM'>Preencha os campos!</p>";
            } else {
                $selectQ = "SELECT * FROM usuario WHERE nome_user = '$nomeU' AND senha_user = '$senhaU'";
                $selectP = $cx->prepare($selectQ);
                $selectP->execute();
                $total = $selectP->rowCount();

                if ($total == 1) {
                    $lpl = $selectP->fetch(PDO::FETCH_ASSOC);
                    $idf_user = $lpl['idf_user'];

                    switch ($idf_user) {
                        case 'u':
                            session_start();
                            $_SESSION['idfconta'] = 'u';
                            $_SESSION['idUsuario'] = $nomeU;
                            header('Location: index.php');
                            die();
                            break;
                        case 'm':
                            session_start();
                            $_SESSION['idfconta'] = 'm';
                            $_SESSION['idUsuario'] = $nomeU;
                            header('Location: index.php');
                            die();
                            break;
                        case 'a':
                            session_start();
                            $_SESSION['idfconta'] = 'a';
                            $_SESSION['idUsuario'] = $nomeU;
                            header('Location: index.php');
                            die();
                            break;
                        default:
                            echo "ERRO, tente novamente mais tarde!";
                            break;
                    }
                }else{
                    echo "<p class='erroM'>Essa conta não existe, deseja <a href='../PHP/cad.php' class='trocapag'>cria-la?</a></p>";
                }
            }
        }

        ?>

    </main>
    <?php

    require_once '../CONFIGS/fBanco.php';

    ?>
</body>

</html>
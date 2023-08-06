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
        require_once '../PHP-OBJ/Usuario.php';

        ?>
    <main>
        <h1>YARN</h1>

        <h2>CADASTRO</h2>

        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">

            <input type="text" name="username" id="username" placeholder="Nome:">
            <input type="email" name="email" id="email" placeholder="Email:">
            <input type="password" name="password" id="password" placeholder="Senha:">

            <p>Quer fazer login? Clique <a href="login.php"><strong>AQUI</strong></a></p>

            <input type="submit" value="REGISTRAR-SE" name="registrar">
        </form>

        <?php

        $nomeU = $_REQUEST['username'] ?? "";
        $emailU = $_REQUEST['email'] ?? "";
        $senhaU = $_REQUEST['password'] ?? "";

        if (isset($_REQUEST['registrar'])) {
            if (empty($nomeU) || empty($emailU) || empty($senhaU)) {
                echo "<p class='erroM'>PREENCHA OS CAMPOS</p>";
            } else {
                $selectQ = "SELECT * FROM usuario WHERE nome_user = '$nomeU' OR email_user = '$emailU'";
                $selectP = $cx->prepare($selectQ);
                $selectP->execute();
                $total = $selectP->rowCount();
                if ($total == 0) {
                    $novoU = new Usuario($cx);
                    $novoU->criarConta($nomeU, $emailU, $senhaU, 'u');
                    echo "<p class='acertoM'>CADASTRO FEITO COM SUCESSO!</p>";
                } else {
                    echo "<p class='erroM'>A conta <strong>$nomeU</strong> já existe</p>";
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
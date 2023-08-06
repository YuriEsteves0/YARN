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
    $admC = $_REQUEST['us'] ?? '';

    ?>
    <main>
        <div class="descpost">
            <h1>EDITAR</h1>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
                <?php

                if (empty($ref)) {
                    echo "<p class='erroM'>Erro na chamada!</p>";
                } else {
                    $selectQ = "SELECT * FROM usuario WHERE id_user = '$ref'";
                    $selectP = $cx->prepare($selectQ);
                    $selectP->setFetchMode(PDO::FETCH_ASSOC);
                    $selectP->execute();

                    while ($dados = $selectP->fetch()) {
                        echo "<input type='hidden' name='ref' value=$ref>";
                        echo "<input type='hidden' name='admC' value=$admC>";

                        echo "<input type='text' name='username' id='username' placeholder='Nome Do Usuario: ' value='{$dados['nome_user']}' maxlenght='70'>";

                        echo "<input type='email' name='email' id='email' placeholder='Email Do Usuario: ' value='{$dados['email_user']}' maxlenght='100'>";

                        echo "<input type='password' name='password' id='password' placeholder='Senha Do Usuario: ' value='{$dados['senha_user']}' maxlenght='100'>";

                        if ($admC === 'adm') {
                            echo "<select name='idfU' id='idfU'>";
                            echo "<option value='Optdefault'>SELECIONAR...</option>";
                            echo "<option value='u'>Usuario</option>";
                            echo "<option value='m'>Funcionario</option>";
                            echo "<option value='a'>Administrador</option>";
                            echo "</select>";
                        }
                    }
                }
                ?>
                <input type="submit" value="EDITAR" name="editarbtn">
                <input type="button" value="CANCELAR" onclick="return trocapag(1)">
            </form>

            <?php
            $nomeU = $_REQUEST['username'] ?? '';
            $emailU = $_REQUEST['email'] ?? '';
            $senhaU = $_REQUEST['password'] ?? '';
            $idfU = $_REQUEST['idfU'] ?? '';

            if (isset($_REQUEST['editarbtn'])) {
                if (empty($nomeU) || empty($emailU) || empty($senhaU)) {
                    echo "<p class='erroM'>PREENCHA OS CAMPOS!</p>";
                } else {
                    if ($admC = 'adm') {
                        if (empty($idfU) || $idfU == 'Optdefault') {
                            echo "<script>alert('PREENCHA TODOS OS CAMPOS!');</script>";
                            echo "<script>location.href='../PHP-CRUDS/editarUsuario.php?ref=$ref&us=$admC'</script>";
                            // header("Location: ../PHP-CRUDS/editarUsuario.php?ref=$ref&us=$admC");
                        } else {
                            $updateQ = "UPDATE usuario SET nome_user = '$nomeU', email_user = '$emailU', senha_user = '$senhaU', idf_user = '$idfU' WHERE id_user = '$ref' LIMIT 1";
                            $updateP = $cx->prepare($updateQ);
                            try {
                                $cx->beginTransaction();
                                $updateP->execute();
                                $cx->commit();
                                $total = $updateP->rowCount();

                                if ($total <= 0) {
                                    echo "<p class='erroM'>HOUVE UM ERRO, TENTE NOVAMENTE MAIS TARDE</p>";
                                } else {
                                    echo "<p class='acertoM''>Usuario alterado com sucesso!</p>";
                                }
                            } catch (PDOException $e) {
                                $cx->rollBack();
                                throw $e;
                            }
                        }
                    } else {
                        $updateQ = "UPDATE usuario SET nome_user = '$nomeU', email_user = '$emailU', senha_user = '$senhaU' WHERE id_user = '$ref' LIMIT 1";
                        $updateP = $cx->prepare($updateQ);
                        try {
                            $cx->beginTransaction();
                            $updateP->execute();
                            $cx->commit();
                            $total = $updateP->rowCount();

                            if ($total <= 0) {
                                echo "<p class='erroM'>HOUVE UM ERRO, TENTE NOVAMENTE MAIS TARDE</p>";
                            } else {
                                echo "<p class='acertoM''>Usuario alterada com sucesso!</p>";
                            }
                        } catch (PDOException $e) {
                            $cx->rollBack();
                            throw $e;
                        }
                    }
                }
            }

            ?>
        </div>
    </main>
</body>
<script src="../JS/trocapag.js"></script>
</html>
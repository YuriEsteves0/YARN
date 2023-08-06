<?php

echo "<div class='encl'>";
echo "<header>";
echo "<div class='header-encl'>";
echo "<a href='../PHP/index.php' id='logo'>YARN</a>";
?>


<form action="../PHP/pesquisa.php">
    <?php
    echo "<div class='search-bar'>";
    echo "<input type='text' name='search' id='search' placeholder='Buscar pessoas, posts e etc'>";
    echo "<button><img src='../IMG/54481.png' alt=''></button>";
    ?>
</form>

<?php
echo "</div>";
echo "<nav>";
echo "<ul>";
echo "<li><a href='../PHP-CRUDS/admcrud.php'>ADM</a>";
echo "<li><a href='../PHP/criarpost.php'>Criar Post</a></li>";
echo "<li><a href='../PHP/criarcat.php'>Criar Categoria</a></li>";
echo "</ul>";
echo "</nav>";
if (isset($_SESSION['idUsuario'])) {
    $nome = $_SESSION['idUsuario'];
    echo "<a href='../PHP/perfilU.php'><button class='login' name='loginbtn'>olá, $nome</button></a>";
} else {

    echo "<a href='../PHP/login.php'><button class='login' name='loginbtn'>LOGIN</button></a>";
}
echo "</div>";
echo "<hr>";
echo "</header>";
?>
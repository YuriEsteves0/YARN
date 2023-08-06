<?php

require_once '../CONFIGS/config.php';

class Usuario
{
    private $nome;
    private $email;
    private $senha;
    private $idf;
    private $ativo;
    private $cx;

    function __construct($conex)
    {
        $this->cx = $conex;
        $this->nome = "";
        $this->email = "";
        $this->senha = "";
        $this->idf = "u";
        $this->ativo = false;
    }

    function criarConta($nomeU, $emailU, $senhaU, $idfU)
    {

        $this->setativo(true);
        $this->setnome($nomeU);
        $this->setemail($emailU);
        $this->setsenha($senhaU);
        $this->setidf($idfU);

        $insertQ = "INSERT INTO usuario (nome_user, email_user, senha_user) VALUES (:nome, :email, :senha)";
        $insertP = $this->cx->prepare($insertQ);
        $insertP->bindParam(':nome', $nomeU);
        $insertP->bindParam(':email', $emailU);
        $insertP->bindParam(':senha', $senhaU);

        try {
            $this->cx->beginTransaction();
            $insertP->execute();

            $this->cx->commit();
        } catch (PDOException $e) {
            $this->cx->rollback();
            throw $e;
            echo "Algo deu errado, verifique os dados e tente novamente";
        }
    }

    function setnome($nomeInp)
    {
        $this->nome = $nomeInp;
    }

    function setemail($emailInp)
    {
        $this->email = $emailInp;
    }

    function setsenha($senhaInp)
    {
        $this->senha = $senhaInp;
    }

    function setativo($ativoInp)
    {
        $this->ativo = $ativoInp;
    }

    function setidf($idf)
    {
        $this->idf = $idf;
    }

    function getnome()
    {
        return $this->nome;
    }

    function getemail()
    {
        return $this->email;
    }

    function getsenha()
    {
        return $this->senha;
    }

    function getativo()
    {
        return $this->ativo;
    }

    function getidf()
    {
        return $this->idf;
    }
}

// require_once '../CONFIGS/fBanco.php';

<?php 

    include("db/connect.php");

    $erroNome = '';
    $erroEmail = '';
    $erroPass = '';
    $erroGenero = '';
    $erroContact = '';
    $erroData = '';

    if(isset($_POST['submit'])){

        $nome = test_input($_POST['nome']);
        $email = test_input($_POST['email']);
        $pass = test_input(sha1($_POST['pass']));
        $contact = test_input($_POST['tel']);
        $genero = test_input($_POST['genero']);
        $data = test_input($_POST['data']);

        $sql = $conn->prepare("SELECT * FROM `cadastros` WHERE email = ?");
        $sql->execute([$email]);

        if(!preg_match("/^[a-zA-Z-' ]*$/", $nome)){
            $erroNome = 'Apenas aceitamos letras e espacos em branco!';
         }

         if(empty($pass)){
            $erroPass = 'O campo nao pode estar vazio!';
         }

         if(preg_match("/\(?\d{2}\)?\s?\d{5}\-?\d{4}/", $contact)) {
            $erroContact = 'Apenas aceitamos numeros!';
          }
        
          if(empty($genero)){
            $erroGenero = 'Escolha uma opcao!';
          }

          if($sql->rowCount() > 0){
            $erroEmail = 'Email existente!';
          }elseif(empty($data)){
            $erroData = '';
          }else{
            $inserir = $conn->prepare("INSERT INTO `cadastros`(nome, email, password, telefone,sexo, dataNascimento) VALUES(?,?,?,?,?,?)");
            $inserir->execute([$nome, $email, $pass, $contact, $genero, $data]);

            if($inserir){
                $fetch_user = $conn->prepare("SELECT * FROM `cadastros` WHERE email=? AND password=?");
                $fetch_user->execute([$email, $pass]);
                $row = $fetch_user->fetch(PDO::FETCH_ASSOC);

                header('location:login.php');
            }
          }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }



?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Sistema de Cadastro</title>
</head>
<body>
    <div class="box">
        <form action="" method="post">
            <fieldset>
                <legend>Cadastro</legend>
                <div class="inputUser">
                    <input type="text" name="nome" id="nome" class="user" required>
                    <label for="nome" class="inputLabel">Nome completo</label>
                </div>

                <div class="inputUser">
                    <input type="text" name="email" id="email" class="user" required>
                    <label for="email" class="inputLabel">Email</label>
                </div>

                <div class="inputUser">
                    <input type="password" name="pass" id="password" class="user" required>
                    <label for="password" class="inputLabel">Password</label>
                </div>

                <div class="inputUser">
                    <input type="tel" name="tel" id="tel" class="user" required>
                    <label for="tel" class="inputLabel">Telefone</label>
                </div>
                <p class="sexo">Sexo:</p>
                <input type="radio" id="feminino" name="genero" class="radio" value="feminino" required>
                <label for="feminino">Feminino</label>
                    <br>
                <input type="radio" id="masculino" name="genero" class="radio" value="masculino" required>
                <label for="masculino">Masculino</label>
                <br>
                <input type="radio" id="outro" name="genero" class="radio" value="outro" required>
                <label for="outro">Outro</label>
                <br>
                    <label for="data">Data de Nascimento:</label>
                    <input type="date" name="data" id="data"  required>

                <input type="submit" value="Enviar" id="submit" name="submit">

                <p class="pa">Tem uma conta? <a href="login.php">Login</a></p>
            </fieldset>
        </form>
    </div>
</body>
</html>
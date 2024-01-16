<?php 
    include("db/connect.php");


    if(isset($_POST['submit'])){
        $email = test_input($_POST['email']);
        $pass = test_input(sha1($_POST['pass']));

        $sql = $conn->prepare("SELECT * FROM `cadastros` WHERE email=? AND password=?");
        $sql->execute([$email, $pass]);

        $row = $sql->fetch(PDO::FETCH_ASSOC);
        if($sql->rowCount() > 0){
            header('location:home.php');
        }else{
            
            $erroEmail = 'Email ou Password incorretos!';
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
                <legend>Login</legend>

                <div class="inputUser">
                    <input type="text" name="email" id="email" class="user" required>
                    <label for="email" class="inputLabel">Email</label>
                </div>

                <div class="inputUser">
                    <input type="password" name="pass" id="password" class="user" required>
                    <label for="password" class="inputLabel">Password</label>
                </div>

                <input type="submit" value="Enviar" id="submit" name="submit">

                <p class="pa">Nao tem uma conta? <a href="register.php">Registar</a></p>
            </fieldset>
        </form>
    </div>
</body>
</html>
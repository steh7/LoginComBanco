<?php
$hostname = "localhost";
$bancodedados = "clientes"; // Certifique-se de que o banco de dados foi criado
$usuario = "root"; 
$senha = ""; 

try {
    // Conectar ao banco de dados
    $mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);
    
    // Verificar conexão
    if ($mysqli->connect_errno) {
        throw new Exception("Falha ao conectar: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
    }

    // Verificar se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Receber os dados do formulário
        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $_POST['senha'];

        // Consultar usuário no banco de dados
        $sql = "SELECT senha FROM clientes WHERE email='$email'";
        $resultado = $mysqli->query($sql);

        if ($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            // Verificar se a senha está correta
            if (password_verify($senha, $row['senha'])) {
                echo "Login realizado com sucesso!";
                // Aqui você pode redirecionar o usuário para outra página
                // header("Location: homepage.php");
                // exit;
            } else {
                echo "Senha incorreta.";
            }
        } else {
            echo "Email não encontrado.";
        }
    }
} catch (Exception $e) {
    echo "DEU RUIM: " . $e->getMessage();
} finally {
    // Fechar a conexão
    if (isset($mysqli) && $mysqli) {
        $mysqli->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="" method="post">
            <div class="grupo-formulario">
                <label for="email-login">Email:</label>
                <input type="email" id="email-login" name="email" required>
            </div>
            <div class="grupo-formulario">
                <label for="senha-login">Senha:</label>
                <input type="password" id="senha-login" name="senha" required>
            </div>
            <button type="submit" class="shadow__btn">Entrar</button>
        </form>

        <div class="linha-separacao">
            <p>Não tem uma conta? <a href="cadastro.html" class="link-cadastro">Cadastre-se</a></p>
        </div>
    </div>
</body>
</html>

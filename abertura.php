<?php 
    include("conexao.php");
    session_start();
    
    date_default_timezone_set('America/Sao_Paulo');
    // Obter a data de hoje
    $data_hoje = date('Ymd');

    // Verificar se já existe uma linha com a data de hoje
    $sql_verificar = "SELECT * FROM caixa WHERE `data` = '$data_hoje'";
    $query_verificar = $mysqli->query($sql_verificar) or die($mysqli->error);

    if ($query_verificar->num_rows > 0) {
        echo "Já existe uma linha com a data de hoje.";
    } else {
        // Se não existe, insere uma nova linha
        $sql_inserir = "INSERT INTO caixa(`data`) VALUES ('$data_hoje')";
        $query_inserir = $mysqli->query($sql_inserir) or die($mysqli->error);
    }

    if(count($_POST) > 0) {
        $valorAbertura = $mysqli->escape_string($_POST['valorAbertura']);
	$valorAbertura = str_replace(',', '.', $valorAbertura);        

        $sql_updateAbertura = "UPDATE caixa SET abertura = '$valorAbertura' WHERE `data`='$data_hoje'";
        $funcionou_update = $mysqli->query($sql_updateAbertura) or die($mysqli->error);

        header("Location: inicio");
        die();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CaixaZen</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="icon" href="./arquivos/caixaZenLogo.png" />
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="container-navbar">
                <img src="./arquivos/caixaZenLogo.png" class="brand"/>
                <ul class="nav-links">
                <li><a href="./index.php">Início</a></li>
                    <li><a href="./calculadoraTroco.php">Calculadora de Troco</a></li>
                    <li><a href="./abertura.php">Lançar Abertura</a></li>
                    <li><a href="./malote.php">Lançar Malote</a></li>
                    <li><a href="./subirNotas.php">Subir Notas</a></li>
                    <li><a href="./fechamentoCaixa.php">Fechamento de Caixa</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
    <div class="container-conteudo">
            <h1>Lançamento de Abertura</h1>
            <form action="" class="form-calculadora" method="POST">
                <label for="valorAbertura">Digite o Valor da Abertura:</label>
                <input type="text" id="valorAbertura" class="w3-input w3-hover-yellow" name="valorAbertura" placeholder="Digite o Valor da Abertura">
                
                <button type="submit" class="botao">Enviar</button>
            </form>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 CaixaZen - Jaguarão, RS. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>

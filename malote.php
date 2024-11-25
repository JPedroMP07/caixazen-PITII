<?php 
    include("conexao.php");
    session_start();
    
    date_default_timezone_set('America/Sao_Paulo');
    // Obter a data de hoje
    $data_hoje = date('Ymd');

    if(count($_POST) > 0) {
    // Verificar se já existe uma linha com a data de hoje
    $sql_verificar = "SELECT malote, sangria FROM caixa WHERE `data` = '$data_hoje'";
    $query_verificar = $mysqli->query($sql_verificar) or die($mysqli->error);

    if ($query_verificar->num_rows > 0) {
        $dado = $query_verificar->fetch_assoc();
        $maloteExistente = $dado["malote"];
        $sangriaExistente = $dado["sangria"];
        if($maloteExistente > 0 || $sangriaExistente > 0) {
                $valorMalote = $mysqli->escape_string($_POST['valorMalote']);
                $valorMalote = str_replace(',', '.', $valorMalote);
                $valorMalote = $valorMalote + $maloteExistente;

                $valorSangria = $mysqli->escape_string($_POST['valorSangria']);
                $valorSangria = str_replace(',', '.', $valorSangria);
                $valorSangria = $valorSangria + $sangriaExistente;
                
                $sql_updateMalote = "UPDATE caixa SET malote = '$valorMalote', sangria = '$valorSangria' WHERE `data`='$data_hoje'";
                $funcionou_update = $mysqli->query($sql_updateMalote) or die($mysqli->error);

                header("Location: inicio");
                die();
        } else {
                $valorMalote = $mysqli->escape_string($_POST['valorMalote']);
		$valorSangria = $mysqli->escape_string($_POST['valorSangria']);
                
                $sql_updateMalote = "UPDATE caixa SET malote = '$valorMalote', sangria = '$valorSangria' WHERE `data`='$data_hoje'";
                $funcionou_update = $mysqli->query($sql_updateMalote) or die($mysqli->error);

                header("Location: inicio");
                die();
            }
     } 
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bred Caixa</title>
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
            <h1>Lançamento de Malote</h1>
            <form action="" class="form-calculadora" method="POST">
                <label for="valorMalote">Digite o Valor do Malote:</label>
                <input type="text" id="valorMalote" class="w3-input w3-hover-yellow" name="valorMalote" placeholder="Digite o Valor do Malote">

                <label for="valorSangria">Digite o Valor da Sangria:</label>
                <input type="text" id="valorSangria" class="w3-input w3-hover-yellow" name="valorSangria" placeholder="Digite o Valor da Sangria">
                
                <button type="submit" class="botao">Enviar</button>
            </form>

            <?php if(isset($funcionou_update)) { ?>
            <p><?php if($funcionou_update) {
                    echo "Malote salvo com sucesso!";
                } ?></p> <?php } ?>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 CaixaZen - Jaguarão, RS. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>

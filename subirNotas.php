<?php 
    include("conexao.php");
    session_start();
    
    date_default_timezone_set('America/Sao_Paulo');
    // Obter a data de hoje
    $data_hoje = date('Ymd');

            $sql_verificarNotas = "SELECT * FROM notas WHERE dataPagamento = '$data_hoje'";
            $query_verificarNotas = $mysqli->query($sql_verificarNotas) or die($mysqli->error);

            if ($query_verificarNotas->num_rows > 0) {
                $notasExistentes = "";
            }

    if(count($_POST) > 0) {
        $nfc = $mysqli->escape_string($_POST['nfc']);
        $metodoPagamento = $mysqli->escape_string($_POST['metodoPagamento']);
        $valorTotal = $mysqli->escape_string($_POST['valorTotal']);
        $valorTotal = str_replace(',', '.', $valorTotal);

        $sql_notas = "INSERT INTO notas (nfc, metodoPagamento, valorTotal, dataPagamento) 
        VALUES ('$nfc', '$metodoPagamento', '$valorTotal', '$data_hoje')";
        $funcionou = $mysqli->query($sql_notas) or die($mysqli->error);

        if($metodoPagamento == "dinheiro") {
            $sql_verificar = "SELECT dinheiro FROM caixa WHERE `data` = '$data_hoje'";
            $query_verificar = $mysqli->query($sql_verificar) or die($mysqli->error);

            if ($query_verificar->num_rows > 0) {
                $dado = $query_verificar->fetch_assoc();
                $valorExistente = $dado["dinheiro"];

                $valorTotal = $valorTotal + $valorExistente;
            }
            $sql_salvaValor = "UPDATE caixa SET dinheiro = '$valorTotal' WHERE `data`='$data_hoje'";
            $funcionou = $mysqli->query($sql_salvaValor) or die($mysqli->error);

        } else if($metodoPagamento == "credito") {
            $sql_verificar = "SELECT credito FROM caixa WHERE `data` = '$data_hoje'";
            $query_verificar = $mysqli->query($sql_verificar) or die($mysqli->error);

            if ($query_verificar->num_rows > 0) {
                $dado = $query_verificar->fetch_assoc();
                $valorExistente = $dado["credito"];

                $valorTotal = $valorTotal + $valorExistente;
            }
            $sql_salvaValor = "UPDATE caixa SET credito = '$valorTotal' WHERE `data`='$data_hoje'";
            $funcionou = $mysqli->query($sql_salvaValor) or die($mysqli->error);

        } else if($metodoPagamento == "debito") {
            $sql_verificar = "SELECT debito FROM caixa WHERE `data` = '$data_hoje'";
            $query_verificar = $mysqli->query($sql_verificar) or die($mysqli->error);

            if ($query_verificar->num_rows > 0) {
                $dado = $query_verificar->fetch_assoc();
                $valorExistente = $dado["debito"];

                $valorTotal = $valorTotal + $valorExistente;
            }

            $sql_salvaValor = "UPDATE caixa SET debito = '$valorTotal' WHERE `data`='$data_hoje'";
            $funcionou = $mysqli->query($sql_salvaValor) or die($mysqli->error);

        } else if($metodoPagamento == "pix") {
            $sql_verificar = "SELECT pix FROM caixa WHERE `data` = '$data_hoje'";
            $query_verificar = $mysqli->query($sql_verificar) or die($mysqli->error);

            if ($query_verificar->num_rows > 0) {
                $dado = $query_verificar->fetch_assoc();
                $valorExistente = $dado["pix"];

                $valorTotal = $valorTotal + $valorExistente;
            }

            $sql_salvaValor = "UPDATE caixa SET pix = '$valorTotal' WHERE `data`='$data_hoje'";
            $funcionou = $mysqli->query($sql_salvaValor) or die($mysqli->error);
        }

        header("Location: subirNotas");
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
            <h1>Lançamento de Notas</h1>
            <form action="" class="form-calculadora" method="POST">
                <p>Subir uma Nota:</p>
                <br><br>
                <label for="nfc">Digite a NFC-e:</label>
                <input type="text" id="nfc" class="w3-input w3-hover-yellow" name="nfc" placeholder="Digite a NFC-e">

                <p style="color: red; font-size: 12px;">*Caso o pagamento tenha sido feito em duas formas diferentes, lance aqui, separadamente, com o <br>mesmo número de NFC-e, porém com Forma e Valores de pagamento conforme a Forma inserida.</p>

                <label for="metodoPagamento">Digite a Forma de Pagamento:</label>
                <select name="metodoPagamento" id="metodoPagamento" class="w3-input w3-hover-yellow">
                    <option value="">Selecione uma Opção</option>
                    <option value="dinheiro">Dinheiro</option>
                    <option value="credito">Crédito</option>
                    <option value="debito">Débito</option>
                    <option value="pix">Pix</option>
                </select>
                
                <label for="valorTotal">Digite o Valor Total da Venda:</label>
                <input type="text" id="valorTotal" class="w3-input w3-hover-yellow" name="valorTotal" placeholder="Digite o Valor Total">
                <button type="submit" class="botao">Enviar</button>
            </form>
            
                <?php if(isset($notasExistentes)) {
                    
                        $sql_mostrarNotas = "SELECT * FROM notas WHERE dataPagamento = '$data_hoje' ORDER BY nfc ASC";
                        $query_mostrarNotas = $mysqli->query($sql_mostrarNotas) or die($mysqli->error);

                        while($dado = $query_mostrarNotas->fetch_assoc()) {
                            $nfc = $dado["nfc"];
                            $metodoPagamento = $dado["metodoPagamento"];
                            $valorTotal = $dado["valorTotal"];
                ?>
            <div class="container-notas" style="background-color: white; padding: 16px; border-radius: 8px; margin-top: 32px;">
                <p> NFC-e: <?php echo $nfc ?> </p>
                <p style="text-transform:capitalize;"> Método: <?php echo $metodoPagamento ?> </p>
                <p> Valor Total: <?php echo $valorTotal ?> </p>
            </div>
            <?php } } ?>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 CaixaZen - Jaguarão, RS. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>

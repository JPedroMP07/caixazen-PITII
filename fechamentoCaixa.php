<?php 
    include("conexao.php");
    session_start();

    date_default_timezone_set('America/Sao_Paulo');
    // Obter a data de hoje
    $data_hoje = date('Ymd');

        $sql_verificar = "SELECT dinheiro, credito, debito, pix, totalNotas FROM caixa WHERE `data` = '$data_hoje'";
        $query_verificar = $mysqli->query($sql_verificar) or die($mysqli->error);

        if ($query_verificar->num_rows > 0) {
            $dado = $query_verificar->fetch_assoc();
            $dinheiro = $dado["dinheiro"];
            $credito = $dado["credito"];
            $debito = $dado["debito"];
            $pix = $dado["pix"];
            $totalNotas = $dado["totalNotas"];

            $totalNotas = $dinheiro + $credito + $debito + $pix;

            $sql_salvaValor = "UPDATE caixa SET totalNotas = '$totalNotas' WHERE `data`='$data_hoje'";
            $funcionou = $mysqli->query($sql_salvaValor) or die($mysqli->error);
        }
    ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CaixaZen</title>
    <link rel="stylesheet" href="styles.css">
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
        <div class="container">
            <h1>Bem-vindo ao Fechanento de Caixa</h1>
            <p>Aqui estão todos os dados já somados e prontos para serem inseridos no sistema!</p>
        </div>

        <?php      
                    $sql_mostrarDados = "SELECT * FROM caixa WHERE `data` = '$data_hoje'";
                    $query_mostrarDados = $mysqli->query($sql_mostrarDados) or die($mysqli->error);

                    while($dado = $query_mostrarDados->fetch_assoc()) {
                        $dinheiro = $dado["dinheiro"];
                        $credito = $dado["credito"];
                        $debito = $dado["debito"];
                        $pix = $dado["pix"];
                        $malote = $dado["malote"];
                        $sangria = $dado["sangria"];
                        $abertura = $dado["abertura"];
                        $totalNotas = $dado["totalNotas"];
                    }

                    $dinheiroSomado = $dinheiro + $abertura - $malote - $sangria;
                    $data_hoje = date("d/m/Y",strtotime($data_hoje));
            ?>
        <div class="container-notas" style="display: flex; flex-direction: column; align-items: center; background-color: white; padding: 16px; margin-top: 32px;">
            <p style="padding: 8px;">Dados para o Fechamento de Caixa:</p><br>
            <p> Dinheiro + Abertura - Sangria - Malote: <?php echo $dinheiroSomado ?> </p>
	    <p> Dinheiro: <?php echo $dinheiro ?> </p>
            <p style="text-transform:capitalize;"> Crédito: <?php echo $credito ?> </p>
            <p> Débito: <?php echo $debito ?> </p>
            <p> Pix: <?php echo $pix ?> </p>
            <p> Total das Notas: <?php echo $totalNotas ?> </p>
            <p> Malote: <?php echo $malote ?> </p>
            <p> Sangria: <?php echo $sangria ?> </p>
            <p> Abertura de Hoje: <?php echo $abertura ?> </p>
            <p> Fechamento do Dia <?php echo $data_hoje ?> </p>
        </div>
    </div>

    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 CaixaZen - Jaguarão, RS. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>

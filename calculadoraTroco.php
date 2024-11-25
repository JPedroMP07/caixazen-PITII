<?php 
    include("conexao.php");
    session_start();

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
    <main class="main-container">
        <div class="container-conteudo">
            <h1>Calculadora de Troco</h1>
            <p class="titulo">Digite inicialmente o valor pago pelo cliente e por último o valor da venda:</p>
        
            <form action="" class="form-calculadora" method="POST">
                <label for="valorPago">Digite o Valor Pago:</label>
                <input type="text" id="valorPago" class="w3-input w3-hover-yellow" name="valorPago" placeholder="Digite o Valor Pago pelo Cliente">

                <label for="valorVenda">Digite o Valor da Venda:</label>
                <input type="text" id="valorVenda" class="w3-input w3-hover-yellow" name="valorVenda" placeholder="Digite o Valor da Venda">
                
                <button type="submit" class="botao">Calcular Troco</button>
            </form>
        </div>

        <?php 
        if(count($_POST) > 1) {
            $valorPago = $_POST["valorPago"];
            $valorVenda = $_POST["valorVenda"];

            $valorPago = str_replace(',', '.', $valorPago);
            $valorVenda = str_replace(',', '.', $valorVenda);

            $troco = $valorPago - $valorVenda; 
        ?>
        <p class="troco">Troco: <?php $troco = str_replace('.', ',', $troco); echo $troco; ?> </p>
        <?php } ?>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 CaixaZen - Jaguarão, RS. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>
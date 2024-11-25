<?php 
    include("conexao.php");
    session_start();

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
            <h1>Bem-vindo ao CaixaZen</h1>
            <p>Criado para Auxiliar no Fechamento de Caixa</p>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 CaixaZen - Jaguarão, RS. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Moedas</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main>
        <header>
            <h1>Conversor de Moedas</h1>
        </header>
        
        <?php
            // data atual no formato mm/dd/aaaa
            $dataFim = date("m-d-Y");
            
            // calcula a data de 7 dias atrás
            $dataInicio = date("m-d-Y", strtotime("-7 days"));
            
            /**
             * Declara a string com aspas simples, para evitar que o PHP
             * tente interpolar os valores precedidos pelo simbolo $
             * pois não são variáveis
             */
            $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\'' 
            .$dataInicio
            .'\'&@dataFinalCotacao=\''
            .$dataFim
            .'\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

            // traduz os dados retornados em json e recupera o valor do dólar
            $dados = json_decode(file_get_contents($url), true);
            $cotacao = $dados['value'][0]['cotacaoCompra'];

            // recupera o valor informado pelo usuário
            $valor = $_GET['valor'] ?? 0;

            // calcula a conversão
            $dolar = $valor/$cotacao;

            $realFormatado = number_format($valor, 2, ",", ".");
            $dolarFormatado = number_format($dolar, 2, ",", ".");
            
            echo "<p>R\$ {$realFormatado} equivalem à US\$ {$dolarFormatado}.</p>";
        ?>
    </main>

</body>

</html>
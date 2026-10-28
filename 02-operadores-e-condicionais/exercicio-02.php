<?php

declare(strict_types=1);

$valorCompra = 100.00;
$clienteVip = true;
$cupom = "";
$freteGratis = null;

/*
Regras de negócio
Descontos:
- Cliente VIP recebe 15% de desconto.
- Cupom DESC10 concede 10% de desconto.
- Compras a partir de R$ 200 recebem 5% de desconto.
- Os descontos não são cumulativos. Quando mais de uma regra se aplica, deve prevalecer o maior desconto.
Frete:
- Compras com valor original a partir de R$ 300 recebem frete grátis.
- Clientes VIP também recebem frete grátis.
- Caso contrário, o frete custa R$ 20.
- A variável $freteGratis pode receber true, false ou null. Quando não for null, ela tem prioridade 
sobre as demais regras de frete. 
*/

function calculaDesconto(float $valorCompra, bool $clienteVip, string $cupom): float
{
    $desconto = 0.0;

    if(!is_numeric($valorCompra) || $valorCompra <= 0) {
        throw new InvalidArgumentException("O valor da compra deve ser um número maior que zero.");
    }

    if ($clienteVip) {
        $desconto = 0.15;
    } elseif ($cupom === "DESC10") {
        $desconto = 0.10;
    } elseif ($valorCompra >= 200) {
        $desconto = 0.05;
    }

    return $valorCompra * (1 - $desconto);
}

function calculaFrete(float $valorCompra, bool $clientevip, ?bool $freteGratis): float
{
    if(!is_numeric($valorCompra) || $valorCompra <= 0) {
        throw new InvalidArgumentException("O valor da compra deve ser um número maior que zero.");
    }
    if(!is_bool($clientevip)) {
        throw new InvalidArgumentException("O valor de clientevip deve ser um booleano.");
    }

    if ($freteGratis === false) {
        return 20.0;
    }elseif ($valorCompra >= 300 || $clientevip || $freteGratis === true) {
        return 0.0;
    }
    return 20.0;
}

try {
    $totalComDesconto = calculaDesconto($valorCompra, $clienteVip, $cupom);
    $frete = calculaFrete($valorCompra, $clienteVip, $freteGratis);
    $totalFinal = $totalComDesconto + $frete;

    echo "Valor da compra: R$ " . number_format($valorCompra, 2, ',', '.') . PHP_EOL;
    echo "Total com desconto: R$ " . number_format($totalComDesconto, 2, ',', '.') . PHP_EOL;
    echo "Frete: R$ " . number_format($frete, 2, ',', '.') . PHP_EOL;
    echo "Total final: R$ " . number_format($totalFinal, 2, ',', '.') . PHP_EOL;
} catch (InvalidArgumentException $e) {
    echo "Erro: " . $e->getMessage();
}

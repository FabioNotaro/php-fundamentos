<?php

    declare(strict_types=1);

    $preco = "0";
    $quantidade = "abc";

    //Sua missão é desenvolver um código que valide os dados antes de calcular o valor total da compra.

    function calcularTotal(string $preco, string $quantidade): float
    {
        if (!is_numeric($preco) || !ctype_digit($quantidade)) {
            throw new InvalidArgumentException("Preço deve ser valor numérico e quantidade deve ser um número inteiro positivo.");
        }

        $precoFloat = (float) $preco;
        $quantidadeInt = (int) $quantidade;

        if ($precoFloat <= 0 || $quantidadeInt <= 0) {
            throw new InvalidArgumentException("Preço e quantidade devem ser valores maiores que zero.");
        }

        $total = $precoFloat * $quantidadeInt;
        return $total;

    }

    try {
        $total = calcularTotal($preco, $quantidade);
        echo "O valor total da compra é: R$ " . number_format($total, 2, ',', '.');
    } catch (InvalidArgumentException $e) {
        echo "Erro: " . $e->getMessage();
    }
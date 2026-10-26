<?php

declare(strict_types=1);

require_once __DIR__ . '/ProvedorPrecos.php';

final class Epic implements LojaInterface
{
    public function buscarPreco(array $jogo): ?array
    {
        return ProvedorPrecos::buscarLoja($jogo, ['epicgames', 'epicgamesstore']);
    }

    public function nome(): string
    {
        return 'Epic Games';
    }
}

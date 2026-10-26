<?php

declare(strict_types=1);

require_once __DIR__ . '/ProvedorPrecos.php';

final class GOG implements LojaInterface
{
    public function buscarPreco(array $jogo): ?array
    {
        return ProvedorPrecos::buscarLoja($jogo, ['gog']);
    }

    public function nome(): string
    {
        return 'GOG';
    }
}

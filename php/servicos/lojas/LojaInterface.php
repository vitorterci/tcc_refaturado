<?php

declare(strict_types=1);

interface LojaInterface
{
    /**
     * Busca uma oferta real para o jogo informado.
     * Retorna null quando a loja não possui uma oferta compatível ou está indisponível.
     */
    public function buscarPreco(array $jogo): ?array;

    public function nome(): string;
}

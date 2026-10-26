<?php

declare(strict_types=1);

require_once __DIR__ . '/LojaInterface.php';

final class ProvedorPrecos
{
    private const API_BASE = 'https://www.cheapshark.com/api/1.0';
    private const REDIRECT_BASE = 'https://www.cheapshark.com/redirect?dealID=';
    private const TIMEOUT = 12;

    private static array $ofertasPorJogo = [];
    private static ?array $lojas = null;

    public static function buscarTodas(array $jogo): array
    {
        $nome = trim((string)($jogo['nome'] ?? ''));
        if ($nome === '') {
            return [];
        }

        $chave = self::normalizarNome($nome);
        if (array_key_exists($chave, self::$ofertasPorJogo)) {
            return self::$ofertasPorJogo[$chave];
        }

        $candidato = self::encontrarJogo($nome);
        if (!$candidato || empty($candidato['gameID'])) {
            return self::$ofertasPorJogo[$chave] = [];
        }

        $detalhes = self::get('games', ['id' => (string)$candidato['gameID']]);
        if (!$detalhes['ok']) {
            return self::$ofertasPorJogo[$chave] = [];
        }

        $ofertas = is_array($detalhes['dados']['deals'] ?? null)
            ? $detalhes['dados']['deals']
            : [];
        $lojas = self::obterLojas();
        $resultado = [];
        $vistos = [];

        foreach ($ofertas as $oferta) {
            $storeId = (string)($oferta['storeID'] ?? '');
            $dealId = (string)($oferta['dealID'] ?? '');
            $preco = self::numero($oferta['salePrice'] ?? $oferta['price'] ?? null);
            if ($storeId === '' || $dealId === '' || $preco === null || $preco < 0 || !isset($lojas[$storeId])) {
                continue;
            }

            $loja = $lojas[$storeId];
            $chaveOferta = $loja['slug'] . '|PC';
            if (isset($vistos[$chaveOferta])) {
                continue;
            }
            $vistos[$chaveOferta] = true;

            $normal = self::numero($oferta['normalPrice'] ?? $oferta['retailPrice'] ?? null);
            if ($normal !== null && $normal <= $preco) {
                $normal = null;
            }

            $resultado[] = [
                'titulo' => (string)($detalhes['info']['title'] ?? $candidato['external'] ?? $nome),
                'loja' => $loja['nome'],
                'loja_slug' => $loja['slug'],
                'plataforma' => 'PC',
                'preco' => round($preco, 2),
                'preco_antigo' => $normal,
                'moeda' => 'USD',
                'url' => self::REDIRECT_BASE . rawurlencode($dealId),
                'disponibilidade' => 'disponivel',
                'disponivel' => true,
                'desconto' => $normal !== null
                    ? self::desconto($preco, $normal)
                    : round((float)($oferta['savings'] ?? 0), 2),
                'data_atualizacao' => date('Y-m-d H:i:s')
            ];
        }

        usort($resultado, static fn(array $a, array $b): int => $a['preco'] <=> $b['preco']);
        return self::$ofertasPorJogo[$chave] = $resultado;
    }

    public static function buscarLoja(array $jogo, array $slugs): ?array
    {
        foreach (self::buscarTodas($jogo) as $oferta) {
            if (in_array($oferta['loja_slug'], $slugs, true)) {
                return $oferta;
            }
        }
        return null;
    }

    public static function buscarJogo(string $nome): ?array
    {
        return self::encontrarJogo($nome);
    }

    private static function encontrarJogo(string $nome): ?array
    {
        $resposta = self::get('games', ['title' => $nome, 'limit' => 20]);
        if (!$resposta['ok'] || !is_array($resposta['dados'])) {
            return null;
        }

        $alvo = self::normalizarNome($nome);
        $melhor = null;
        $melhorPontuacao = 0.0;
        foreach ($resposta['dados'] as $candidato) {
            $titulo = trim((string)($candidato['external'] ?? $candidato['title'] ?? ''));
            if ($titulo === '') {
                continue;
            }
            $normalizado = self::normalizarNome($titulo);
            if ($normalizado === $alvo) {
                return $candidato;
            }
            similar_text($alvo, $normalizado, $similaridade);
            $tokensAlvo = array_filter(explode(' ', $alvo));
            $tokensTitulo = array_filter(explode(' ', $normalizado));
            $intersecao = count(array_intersect($tokensAlvo, $tokensTitulo));
            $cobertura = count($tokensAlvo) > 0 ? ($intersecao / count($tokensAlvo)) * 100 : 0;
            $pontuacao = min($similaridade, $cobertura);
            if ($pontuacao > $melhorPontuacao) {
                $melhorPontuacao = $pontuacao;
                $melhor = $candidato;
            }
        }
        return $melhorPontuacao >= 80 ? $melhor : null;
    }

    private static function obterLojas(): array
    {
        if (self::$lojas !== null) {
            return self::$lojas;
        }
        $resposta = self::get('stores');
        self::$lojas = [];
        if (!$resposta['ok'] || !is_array($resposta['dados'])) {
            return self::$lojas;
        }
        foreach ($resposta['dados'] as $loja) {
            $id = (string)($loja['storeID'] ?? '');
            $nome = trim((string)($loja['storeName'] ?? ''));
            if ($id === '' || $nome === '') {
                continue;
            }
            $slug = self::normalizarNome($nome);
            $slug = str_replace(' ', '', $slug);
            self::$lojas[$id] = ['nome' => $nome, 'slug' => $slug];
        }
        return self::$lojas;
    }

    private static function get(string $caminho, array $parametros = []): array
    {
        if (!function_exists('curl_init')) {
            return ['ok' => false, 'erro' => 'cURL indisponível'];
        }
        $url = self::API_BASE . '/' . ltrim($caminho, '/');
        if ($parametros !== []) {
            $url .= '?' . http_build_query($parametros);
        }
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => self::TIMEOUT,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'User-Agent: GameSearch/1.0 (price comparison)'
            ]
        ]);
        $corpo = curl_exec($ch);
        $erro = curl_error($ch);
        $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($corpo === false || $erro !== '' || $status < 200 || $status >= 300) {
            return ['ok' => false, 'erro' => $erro !== '' ? $erro : 'HTTP ' . $status];
        }
        $dados = json_decode($corpo, true);
        return is_array($dados) ? ['ok' => true, 'dados' => $dados] : ['ok' => false, 'erro' => 'JSON inválido'];
    }

    private static function normalizarNome(string $nome): string
    {
        $nome = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', trim($nome)) ?: trim($nome);
        $nome = strtolower((string)preg_replace('/[^a-zA-Z0-9]+/', ' ', $nome));
        return trim((string)preg_replace('/\s+/', ' ', $nome));
    }

    private static function numero($valor): ?float
    {
        return is_numeric($valor) ? (float)$valor : null;
    }

    private static function desconto(float $atual, float $antigo): float
    {
        return $antigo > 0 && $atual < $antigo ? round((($antigo - $atual) / $antigo) * 100, 2) : 0.0;
    }
}

<?php
// teste.php — Laboratório isolado da animação de exclusão
// NÃO faz parte da versão final. Não depende de outros arquivos do projeto.
?>
<!DOCTYPE html>
<html lang="pt-BR" class="tema-escuro">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Teste — Botão Excluir (Game Search)</title>

<style>
/* ───────────────────────────────────────────────
   Fallbacks dos tokens do Game Search.
   Em produção, estes valores vêm de global.css.
   ─────────────────────────────────────────────── */
:root {
  /* Tema escuro (padrão do projeto) */
  --cor-fundo: #0b0d1a;
  --cor-lateral: #12142b;
  --cor-card: #161936;
  --cor-tag: #1e224a;
  --cor-hover: #242a5c;
  --cor-borda: rgba(120, 130, 255, 0.22);
  --cor-texto: #f2f4ff;
  --cor-texto-muted: #9aa0c7;
  --cor-texto-destaque: #7aa2ff;
  --cor-texto-sobre-destaque: #ffffff;
  --cor-primaria: #6c5ce7;
  --cor-primaria-hover: #7d6ef0;
  --cor-texto-sobre-destaque-hover: #ffffff;

  /* Perigo (semântico — reforça o que já existe em comentarios.css) */
  --cor-perigo: #ef4444;
  --cor-perigo-hover: #f87171;
  --cor-perigo-texto: #fca5a5;
  --cor-perigo-bg: rgba(239, 68, 68, 0.12);

  /* Sombras */
  --shadow-glow: 0 8px 20px rgba(108, 92, 231, 0.35);
  --shadow-glow-hover: 0 12px 28px rgba(108, 92, 231, 0.5);
  --shadow-perigo: 0 6px 16px rgba(239, 68, 68, 0.28);
  --shadow-perigo-hover: 0 10px 22px rgba(239, 68, 68, 0.42);

  /* Tipografia / medidas */
  --font-titulo: 'Poppins', system-ui, sans-serif;
  --font-corpo: 'Poppins', system-ui, sans-serif;
  --fs-xs: 0.75rem;
  --fs-sm: 0.875rem;
  --fs-md: 1rem;
  --border-radius: 10px;
  --border-radius-sm: 6px;
  --border-radius-xl: 999px;
  --transition-speed: 0.25s;

  --ease-suave: cubic-bezier(0.4, 0, 0.2, 1);
  --ease-bounce: cubic-bezier(0.34, 1.56, 0.64, 1);
}

/* Tema claro — mesmo esquema de nomes usado no projeto */
html.tema-claro {
  --cor-fundo: #eef1fb;
  --cor-lateral: #ffffff;
  --cor-card: #ffffff;
  --cor-tag: #e6e9fa;
  --cor-hover: #dfe4fb;
  --cor-borda: rgba(40, 50, 120, 0.18);
  --cor-texto: #101331;
  --cor-texto-muted: #5a6088;
  --cor-texto-destaque: #4f7cff;
  --cor-texto-sobre-destaque: #ffffff;
  --cor-primaria: #5b4bd6;
  --cor-primaria-hover: #4a3cc0;

  --cor-perigo: #dc2626;
  --cor-perigo-hover: #ef4444;
  --cor-perigo-texto: #b91c1c;
  --cor-perigo-bg: rgba(220, 38, 38, 0.10);

  --shadow-glow: 0 8px 18px rgba(91, 75, 214, 0.28);
  --shadow-glow-hover: 0 12px 26px rgba(91, 75, 214, 0.38);
  --shadow-perigo: 0 6px 14px rgba(220, 38, 38, 0.25);
  --shadow-perigo-hover: 0 10px 20px rgba(220, 38, 38, 0.38);
}

* { box-sizing: border-box; margin: 0; padding: 0; }

body {
  min-height: 100vh;
  display: grid;
  place-items: center;
  background: var(--cor-fundo);
  color: var(--cor-texto);
  font-family: var(--font-corpo);
  transition: background var(--transition-speed) ease,
              color var(--transition-speed) ease;
}

/* Aviso: só de laboratório, não vai para produção */
.lab-note {
  position: fixed;
  top: 16px;
  left: 16px;
  max-width: 260px;
  padding: 10px 14px;
  border: 1px dashed var(--cor-borda);
  border-radius: var(--border-radius-sm);
  background: color-mix(in srgb, var(--cor-card) 85%, transparent);
  color: var(--cor-texto-muted);
  font-size: var(--fs-xs);
  line-height: 1.5;
}

.toggle-tema {
  position: fixed;
  top: 16px;
  right: 16px;
  padding: 8px 16px;
  border: 1px solid var(--cor-borda);
  border-radius: var(--border-radius-xl);
  background: transparent;
  color: var(--cor-texto);
  font: 600 var(--fs-xs) / 1 var(--font-corpo);
  cursor: pointer;
  transition: all var(--transition-speed) ease;
}
.toggle-tema:hover { border-color: var(--cor-primaria); }
.toggle-tema:focus-visible {
  outline: 2px solid var(--cor-primaria);
  outline-offset: 3px;
}

/* Palco de teste */
.stage {
  width: min(92vw, 460px);
  min-height: 240px;
  padding: 32px;
  display: flex;
  flex-direction: column;
  gap: 24px;
  align-items: center;
  justify-content: center;
  border-radius: 18px;
  background: color-mix(in srgb, var(--cor-card) 92%, var(--cor-fundo));
  border: 1px solid var(--cor-borda);
  box-shadow: var(--shadow-glow);
}

.stage h2 {
  font-family: var(--font-titulo);
  font-size: var(--fs-md);
  letter-spacing: 0.04em;
  text-transform: uppercase;
  color: var(--cor-texto);
}

.stage p {
  font-size: var(--fs-sm);
  color: var(--cor-texto-muted);
  text-align: center;
  line-height: 1.5;
}

/* ───────────────────────────────────────────────
   BOTÃO EXCLUIR ANIMADO — adaptado ao Game Search
   Dimensões alinhadas aos .btn-acao do projeto.
   ─────────────────────────────────────────────── */
.btn-excluir-animado {
  --ease: var(--ease-suave);
  position: relative;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 132px;
  height: 38px;
  padding: 0 18px;
  border: 1px solid var(--cor-borda);
  border-radius: var(--border-radius-xl);
  background: var(--cor-tag);
  color: var(--cor-texto-muted);
  font-family: var(--font-corpo);
  font-size: var(--fs-xs);
  font-weight: 600;
  letter-spacing: 0.04em;
  cursor: pointer;
  overflow: hidden;
  -webkit-tap-highlight-color: transparent;
  transition:
    width var(--transition-speed) var(--ease),
    min-width var(--transition-speed) var(--ease),
    padding var(--transition-speed) var(--ease),
    border-color var(--transition-speed) var(--ease),
    background var(--transition-speed) var(--ease),
    color var(--transition-speed) var(--ease),
    box-shadow var(--transition-speed) var(--ease),
    transform var(--transition-speed) var(--ease);
}

.btn-excluir-animado:hover:not(.is-busy) {
  color: var(--cor-perigo-texto);
  border-color: var(--cor-perigo);
  background: var(--cor-perigo-bg);
  box-shadow: var(--shadow-perigo);
  transform: translateY(-1px);
}

.btn-excluir-animado:active:not(.is-busy) {
  transform: translateY(0) scale(0.97);
}

.btn-excluir-animado:focus-visible {
  outline: 2px solid var(--cor-perigo);
  outline-offset: 3px;
}

/* Conteúdo interno */
.btn-excluir-animado .content {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  transition: gap var(--transition-speed) var(--ease);
}

.btn-excluir-animado .label {
  white-space: nowrap;
  max-width: 90px;
  overflow: hidden;
  transition:
    opacity 0.2s ease,
    filter 0.2s ease,
    transform 0.25s var(--ease),
    max-width 0.3s var(--ease);
}

/* Ícone lixeira */
.btn-excluir-animado .trash {
  position: relative;
  width: 16px;
  height: 18px;
  flex: none;
  transition: transform 0.3s var(--ease);
}

.btn-excluir-animado .trash svg {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  overflow: visible;
}

.btn-excluir-animado .trash .lid {
  transform-origin: 2px 5px;
  transition: transform 0.3s var(--ease-bounce);
}

.btn-excluir-animado:hover:not(.is-busy) .lid {
  transform: rotate(-14deg) translateY(-1px);
}

.btn-excluir-animado .trash .body-fill {
  fill: currentColor;
  opacity: 0.15;
}

/* Papel que cai (usa a cor de perigo, não azul do protótipo) */
.btn-excluir-animado .paper {
  position: absolute;
  left: 50%;
  top: 0;
  width: 10px;
  height: 13px;
  margin-left: -5px;
  border-radius: 2px;
  background: linear-gradient(var(--cor-perigo-hover), var(--cor-perigo));
  opacity: 0;
  transform: translateY(-28px);
  z-index: 1;
  box-shadow: 0 0 8px var(--cor-perigo);
  pointer-events: none;
}

.btn-excluir-animado .paper::before,
.btn-excluir-animado .paper::after {
  content: "";
  position: absolute;
  left: 2px;
  right: 2px;
  height: 1.5px;
  border-radius: 1px;
  background: rgba(255, 255, 255, 0.8);
}
.btn-excluir-animado .paper::before { top: 4px; }
.btn-excluir-animado .paper::after  { top: 7px; right: 4px; }

/* Dot / check de status */
.btn-excluir-animado .status {
  position: absolute;
  left: 50%;
  bottom: -22px;
  width: 14px;
  height: 14px;
  margin-left: -7px;
  border-radius: 50%;
  background: var(--cor-perigo);
  transform: scale(0);
  opacity: 0;
  display: grid;
  place-items: center;
  box-shadow: 0 0 10px var(--cor-perigo);
  transition:
    transform 0.3s var(--ease-bounce),
    opacity 0.2s ease;
}

.btn-excluir-animado .status svg {
  width: 9px;
  height: 9px;
  fill: none;
  stroke: #fff;
  stroke-width: 3;
  stroke-linecap: round;
  stroke-linejoin: round;
  stroke-dasharray: 16;
  stroke-dashoffset: 16;
  transition: stroke-dashoffset 0.3s ease 0.05s;
}

/* ─── Fases ─── */
.btn-excluir-animado.is-busy { cursor: default; transform: none; }
.btn-excluir-animado.is-shrink { min-width: 38px; width: 38px; padding: 0; }
.btn-excluir-animado.is-shrink .label {
  opacity: 0;
  filter: blur(3px);
  transform: translateX(6px);
  max-width: 0;
}
.btn-excluir-animado.is-shrink .content { gap: 0; }

.btn-excluir-animado.is-open .lid {
  transform: rotate(-24deg) translate(-2px, -3px);
}

.btn-excluir-animado.is-drop .paper {
  opacity: 1;
  animation: gs-drop 1s cubic-bezier(0.5, 0, 0.75, 0.6) forwards;
}

@keyframes gs-drop {
  0%   { transform: translateY(-28px); opacity: 1; }
  70%  { transform: translateY(-3px);  opacity: 1; }
  100% { transform: translateY(7px) scaleY(0.6); opacity: 0; }
}

.btn-excluir-animado.is-close .lid { transform: none; }
.btn-excluir-animado.is-dot .status { transform: scale(1); opacity: 1; }
.btn-excluir-animado.is-check .status svg { stroke-dashoffset: 0; }
.btn-excluir-animado.is-out .status { transform: scale(0); opacity: 0; }

/* Acessibilidade: modo reduzido — sem coreografia, só estado */
@media (prefers-reduced-motion: reduce) {
  .btn-excluir-animado,
  .btn-excluir-animado * {
    transition-duration: 0.01ms !important;
    animation-duration: 0.01ms !important;
  }
  .btn-excluir-animado.is-drop .paper { animation: none; opacity: 0; }
  .btn-excluir-animado.is-dot .status { transform: scale(1); opacity: 1; }
  .btn-excluir-animado.is-check .status svg { stroke-dashoffset: 0; }
}

/* Empilhamento para o dot de status não ser cortado */
.stage .btn-wrap {
  position: relative;
  display: inline-flex;
  padding-bottom: 28px;
}
</style>
</head>
<body>

<div class="lab-note">
  <strong>LAB — Etapa 1</strong><br>
  Este arquivo não faz parte da versão final. Serve apenas para validar a animação.
</div>

<button class="toggle-tema" id="toggle-tema" type="button" aria-label="Alternar tema claro e escuro">
  Tema
</button>

<div class="stage">
  <h2>Excluir comentário</h2>
  <p>Clique no botão para ver a animação. Use Tab + Enter para testar por teclado.</p>

  <div class="btn-wrap">
    <button class="btn-excluir-animado" id="btn-excluir" type="button"
            aria-label="Excluir comentário"
            aria-live="polite">
      <span class="paper" aria-hidden="true"></span>
      <span class="content">
        <span class="trash" aria-hidden="true">
          <svg viewBox="0 0 20 24" fill="none" stroke="currentColor"
               stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
            <path class="body-fill"
                  d="M3.5 8h13l-1 13.2a1.5 1.5 0 0 1-1.5 1.3H6a1.5 1.5 0 0 1-1.5-1.3z"/>
            <g class="lid">
              <path d="M1.5 5h17M7.5 5V3.2A1.2 1.2 0 0 1 8.7 2h2.6a1.2 1.2 0 0 1 1.2 1.2V5"/>
            </g>
            <path d="M8 11.5v7M12 11.5v7" opacity=".55"/>
          </svg>
        </span>
        <span class="label">Excluir</span>
      </span>
      <span class="status" aria-hidden="true">
        <svg viewBox="0 0 10 10"><path d="M1.8 5.2 4.2 7.6 8.4 2.6"/></svg>
      </span>
    </button>
  </div>
</div>

<script>
(() => {
  'use strict';

  const btn = document.getElementById('btn-excluir');

  /* Timeline enxuta — sem as fases de "fill" e "drain" das listras,
     que foram removidas do HTML/CSS. */
  const timeline = [
    ['is-busy',   0],
    ['is-shrink', 0],
    ['is-open',   300],
    ['is-drop',   420],
    ['is-close',  1500],
    ['is-dot',    1600],
    ['is-check',  2000],
    ['is-out',    3000]
  ];
  const todas = timeline.map(t => t[0]);

  let rodando = false;

  /* Simula o DELETE — em produção será substituído pelo fetch real
     para ../php/api/comentarios.php?id=ID */
  const fakeDelete = () => new Promise((resolve) => setTimeout(resolve, 1800));

  const iniciarAnimacao = () => {
    timeline.forEach(([cls, ms]) => {
      setTimeout(() => {
        if (cls === 'is-close') btn.classList.remove('is-open');
        btn.classList.add(cls);
      }, ms);
    });
  };

  const restaurar = () => {
    todas.forEach(c => btn.classList.remove(c));
    btn.disabled = false;
    btn.setAttribute('aria-label', 'Excluir comentário');
    rodando = false;
  };

  btn.addEventListener('click', async () => {
    if (rodando) return;
    rodando = true;
    btn.disabled = true;
    btn.setAttribute('aria-label', 'Excluindo comentário, aguarde');

    iniciarAnimacao();

    try {
      await fakeDelete();
      // Mantém o check visível por um instante antes de voltar
      setTimeout(restaurar, 400);
    } catch (e) {
      // Em caso de erro: restaura imediatamente e permite nova tentativa
      restaurar();
    }
  });

  /* Toggle de tema — apenas para o laboratório. O projeto já tem seu
     próprio sistema de temas. */
  document.getElementById('toggle-tema').addEventListener('click', () => {
    const html = document.documentElement;
    html.classList.toggle('tema-claro');
    html.classList.toggle('tema-escuro');
  });
})();
</script>
</body>
</html>
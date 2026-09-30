<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="base-path" content="">
  <title>Game Search · Teste da animação de exclusão</title>

  <!-- Identidade visual oficial do projeto -->
  <link rel="stylesheet" href="css/global.css">

  <style>
    /*
     * TESTE ISOLADO — ANIMAÇÃO DE EXCLUSÃO
     * Adaptado ao design system do Game Search.
     * Este arquivo continua sendo apenas uma área de demonstração:
     * não altera comentários, jogos, banco de dados ou exclusões reais.
     */

    :root {
      --teste-danger: #ff5470;
      --teste-danger-soft: rgba(255, 84, 112, .14);
      --teste-success: #3ddbb0;
      --teste-glass: color-mix(in srgb, var(--cor-card) 82%, transparent);
      --teste-line: var(--cor-borda-forte);
      --teste-radius: var(--border-radius-lg);
      --teste-animation: 1;
    }

    html.tema-claro,
    body.tema-claro {
      --teste-glass: rgba(255,255,255,.82);
    }

    body {
      min-height: 100vh;
      background:
        radial-gradient(circle at 50% -10%, color-mix(in srgb, var(--cor-primaria) 18%, transparent), transparent 42%),
        var(--cor-fundo) !important;
      color: var(--cor-texto);
    }

    .teste-stage {
      width: min(860px, 100%);
      min-height: 100vh;
      margin: 0 auto;
      padding: clamp(24px, 5vw, 56px) clamp(14px, 3vw, 28px);
      display: grid;
      align-content: center;
      justify-items: center;
      gap: 22px;
    }

    .teste-head {
      text-align: center;
      max-width: 680px;
    }

    .teste-kicker {
      margin: 0 0 8px;
      font-family: var(--font-corpo);
      font-size: .72rem;
      font-weight: 700;
      letter-spacing: .22em;
      text-transform: uppercase;
      color: var(--cor-texto-destaque);
    }

    .teste-head h1 {
      margin: 0;
      font-family: var(--font-titulo);
      font-size: clamp(1.45rem, 4vw, 2.2rem);
      line-height: 1.1;
      letter-spacing: .03em;
      text-transform: uppercase;
    }

    .teste-head h1 span {
      color: var(--cor-texto-destaque);
      text-shadow: 0 0 18px color-mix(in srgb, var(--cor-primaria) 45%, transparent);
    }

    .teste-subtitulo {
      margin: 10px 0 0;
      color: var(--cor-texto-muted);
      font-size: .9rem;
    }

    .teste-window {
      width: 100%;
      overflow: hidden;
      border: 1px solid var(--cor-borda-forte);
      border-radius: var(--border-radius-lg);
      background: color-mix(in srgb, var(--cor-card) 88%, transparent);
      box-shadow: var(--shadow-card), 0 0 40px color-mix(in srgb, var(--cor-primaria) 12%, transparent);
      backdrop-filter: blur(16px);
    }

    .teste-bar {
      min-height: 48px;
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 10px 16px;
      border-bottom: 1px solid var(--cor-borda);
      background: color-mix(in srgb, var(--cor-fundo) 35%, transparent);
      font-family: var(--font-corpo);
      font-size: .8rem;
    }

    .teste-dot {
      width: 10px;
      height: 10px;
      flex: 0 0 auto;
      border-radius: 50%;
    }

    .teste-dot.red { background: #ff5f57; }
    .teste-dot.yellow { background: #febc2e; }
    .teste-dot.green { background: #28c840; }

    .teste-bar strong {
      margin-left: 6px;
      color: var(--cor-texto);
    }

    .teste-bar em {
      color: var(--cor-texto-destaque);
      font-style: normal;
    }

    .teste-bar small {
      margin-left: auto;
      color: var(--cor-texto-muted);
    }

    .teste-body {
      padding: clamp(16px, 4vw, 42px);
      display: grid;
      place-items: center;
    }

    .delete-demo-card {
      position: relative;
      width: min(100%, 520px);
      padding: clamp(18px, 4vw, 28px);
      padding-bottom: 82px;
      border: 1px solid var(--cor-borda-forte);
      border-radius: var(--teste-radius);
      background:
        linear-gradient(145deg, color-mix(in srgb, var(--cor-texto) 5%, transparent), transparent 60%),
        var(--teste-glass);
      box-shadow: var(--shadow-card), inset 0 1px 0 rgba(255,255,255,.08);
      backdrop-filter: blur(18px);
    }

    .delete-demo-top {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 14px;
    }

    .delete-demo-tag {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      font-family: var(--font-titulo);
      font-size: .7rem;
      font-weight: 700;
      letter-spacing: .16em;
      text-transform: uppercase;
      color: var(--cor-texto-destaque);
    }

    .delete-demo-tag::before {
      content: "";
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--cor-primaria);
      box-shadow: 0 0 10px var(--cor-primaria);
    }

    .delete-demo-top h2 {
      margin: 5px 0 0;
      font-family: var(--font-titulo);
      font-size: clamp(1.25rem, 4vw, 1.7rem);
      text-transform: uppercase;
      letter-spacing: .03em;
    }

    .delete-demo-count {
      flex: 0 0 auto;
      padding: 5px 10px;
      border: 1px solid var(--cor-borda-forte);
      border-radius: var(--radius-full);
      color: var(--cor-texto-muted);
      font-size: .72rem;
      background: color-mix(in srgb, var(--cor-texto) 4%, transparent);
    }

    .delete-demo-count b {
      color: var(--cor-texto);
    }

    .usage {
      margin: 16px 0 7px;
      color: var(--cor-texto-muted);
      font-size: .78rem;
    }

    .usage b {
      color: var(--cor-texto);
    }

    .meter {
      height: 5px;
      overflow: hidden;
      margin-bottom: 16px;
      border-radius: var(--radius-full);
      background: var(--cor-borda);
    }

    .meter-fill {
      width: 100%;
      height: 100%;
      transform-origin: left;
      border-radius: inherit;
      background: linear-gradient(90deg, var(--cor-primaria), var(--cor-texto-destaque));
      transition: transform calc(.7s * var(--teste-animation)) cubic-bezier(.3,1.3,.5,1);
    }

    .file-list {
      display: grid;
      gap: 5px;
      padding: 0;
      margin: 0;
      list-style: none;
    }

    .file-row {
      display: grid;
      grid-template-columns: auto minmax(0, 1fr) auto;
      align-items: center;
      gap: 12px;
      min-height: 68px;
      padding: 8px 10px;
      margin: 0 -10px;
      border: 1px solid transparent;
      border-radius: var(--border-radius);
      transition: background .2s, border-color .2s, transform .2s;
    }

    .file-row:hover,
    .file-row.force-hover {
      background: color-mix(in srgb, var(--teste-danger) 12%, transparent);
      border-color: color-mix(in srgb, var(--teste-danger) 38%, transparent);
      transform: translateX(2px);
    }

    .file-icon {
      width: 42px;
      height: 42px;
      display: grid;
      place-items: center;
      border: 1px solid currentColor;
      border-radius: 11px;
    }

    .file-icon svg,
    .delete-button svg {
      width: 19px;
      height: 19px;
      fill: none;
      stroke: currentColor;
      stroke-width: 1.8;
      stroke-linecap: round;
      stroke-linejoin: round;
    }

    .file-icon.red { color: #ff6b81; background: rgba(255,84,112,.12); }
    .file-icon.teal { color: #3ddbb0; background: rgba(61,219,176,.11); }
    .file-icon.amber { color: #ffb547; background: rgba(255,181,71,.11); }
    .file-icon.blue { color: #7b8cff; background: rgba(123,140,255,.11); }

    .file-name {
      overflow: hidden;
      font-family: var(--font-corpo);
      font-size: .9rem;
      font-weight: 700;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .file-meta {
      margin-top: 2px;
      color: var(--cor-texto-muted);
      font-size: .72rem;
    }

    .delete-button {
      width: 38px;
      height: 38px;
      display: grid;
      place-items: center;
      border: 1px solid color-mix(in srgb, var(--teste-danger) 40%, transparent);
      border-radius: 10px;
      background: var(--teste-danger-soft);
      color: var(--teste-danger);
      cursor: pointer;
      transition: transform .15s, background .2s, color .2s, box-shadow .2s;
    }

    .file-row:hover .delete-button,
    .file-row.force-hover .delete-button {
      background: var(--teste-danger);
      color: #fff;
      box-shadow: 0 0 18px rgba(255,84,112,.42);
    }

    .delete-button:active {
      transform: scale(.88);
    }

    .file-row.crumple {
      pointer-events: none;
      animation: crumple calc(.55s * var(--teste-animation)) cubic-bezier(.6,0,.4,1) forwards;
    }

    @keyframes crumple {
      0% { transform: none; }
      35% { transform: scale(.9,.75) rotate(-2deg) skewX(4deg); filter: brightness(1.2); }
      70% { transform: scale(.3,.6) rotate(8deg); border-radius: 40%; opacity: .9; }
      100% { transform: scale(.05) rotate(30deg); opacity: 0; }
    }

    .file-row.collapse {
      max-height: 0;
      padding-top: 0;
      padding-bottom: 0;
      opacity: 0;
      overflow: hidden;
      transition: max-height calc(.35s * var(--teste-animation)), padding calc(.35s * var(--teste-animation)), opacity .2s;
    }

    .file-row.pop {
      animation: pop calc(.5s * var(--teste-animation)) cubic-bezier(.3,1.5,.5,1);
    }

    @keyframes pop {
      from { transform: scale(.6); opacity: 0; }
    }

    .demo-bin {
      position: absolute;
      right: 24px;
      bottom: 15px;
      width: 52px;
      color: var(--cor-texto-destaque);
      transform-origin: 50% 100%;
    }

    .demo-bin svg {
      width: 100%;
      overflow: visible;
    }

    .demo-bin .tub {
      fill: color-mix(in srgb, var(--cor-texto-destaque) 35%, transparent);
      stroke: currentColor;
      stroke-width: 2;
    }

    .demo-bin .lid rect { fill: color-mix(in srgb, var(--cor-texto-destaque) 75%, var(--cor-primaria)); }
    .demo-bin .rib { stroke: rgba(255,255,255,.25); stroke-width: 2; fill: none; }
    .demo-bin .lid {
      transform-origin: 12px 12px;
      transition: transform calc(.2s * var(--teste-animation));
    }
    .demo-bin.open .lid { transform: rotate(-24deg); }
    .demo-bin.squash { animation: squash calc(.45s * var(--teste-animation)) ease-out; }

    @keyframes squash {
      25% { transform: scale(1.14,.82); }
      55% { transform: scale(.94,1.1); }
      100% { transform: none; }
    }

    .demo-ball {
      position: fixed;
      left: 0;
      top: 0;
      z-index: 1200;
      width: 34px;
      height: 34px;
      pointer-events: none;
      will-change: transform;
      background: radial-gradient(circle at 35% 30%, #fff, #cfd3e8 55%, #8f95b8);
      clip-path: polygon(50% 0,68% 8%,92% 18%,100% 45%,92% 78%,68% 96%,40% 100%,12% 85%,0 52%,10% 22%,30% 6%);
    }

    .puff {
      position: fixed;
      z-index: 1199;
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: color-mix(in srgb, var(--cor-texto-destaque) 45%, transparent);
      pointer-events: none;
      animation: puff calc(.6s * var(--teste-animation)) ease-out forwards;
    }

    @keyframes puff {
      to {
        transform: translate(var(--dx),var(--dy)) scale(2.4);
        opacity: 0;
      }
    }

    .undo-toast {
      position: absolute;
      left: 50%;
      bottom: 18px;
      z-index: 10;
      display: flex;
      align-items: center;
      gap: 10px;
      max-width: calc(100% - 110px);
      padding: 7px 7px 7px 13px;
      border: 1px solid var(--cor-borda-forte);
      border-radius: var(--radius-full);
      background: var(--cor-dropdown);
      color: var(--cor-texto);
      font-size: .75rem;
      transform: translate(-50%, 20px);
      opacity: 0;
      pointer-events: none;
      transition: .25s;
    }

    .undo-toast.show {
      transform: translate(-50%, 0);
      opacity: 1;
      pointer-events: auto;
    }

    .undo-toast span {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .undo-toast button,
    .test-controls button {
      font: inherit;
      cursor: pointer;
    }

    .undo-toast button {
      padding: 5px 12px;
      border: 0;
      border-radius: var(--radius-full);
      background: var(--cor-primaria);
      color: #fff;
      font-weight: 700;
    }

    .test-caption {
      margin: 0;
      font-family: var(--font-titulo);
      font-size: clamp(1rem, 3vw, 1.35rem);
      font-weight: 700;
      letter-spacing: .05em;
      text-transform: uppercase;
      color: var(--cor-texto);
    }

    .test-controls {
      width: 100%;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 8px;
      padding-top: 16px;
      border-top: 1px dashed var(--cor-borda-forte);
    }

    .test-controls button {
      padding: 8px 13px;
      border: 1px solid var(--cor-borda-forte);
      border-radius: var(--radius-full);
      background: var(--cor-card);
      color: var(--cor-texto);
      font-family: var(--font-corpo);
      font-size: .75rem;
      font-weight: 600;
      transition: .2s;
    }

    .test-controls button:hover {
      border-color: var(--cor-primaria);
      box-shadow: 0 0 12px color-mix(in srgb, var(--cor-primaria) 25%, transparent);
    }

    .test-controls button[aria-pressed="true"] {
      background: var(--cor-primaria);
      border-color: var(--cor-primaria);
      color: #fff;
    }

    .reference-video {
      width: min(100%, 420px);
      margin: 0;
    }

    .reference-video video {
      width: 100%;
      border: 1px solid var(--cor-borda-forte);
      border-radius: var(--border-radius);
    }

    .reference-video figcaption {
      margin-top: 6px;
      color: var(--cor-texto-muted);
      text-align: center;
      font-size: .7rem;
    }

    .a11y-focus:focus-visible,
    .delete-button:focus-visible,
    .undo-toast button:focus-visible,
    .test-controls button:focus-visible {
      outline: 2px solid var(--cor-primaria);
      outline-offset: 3px;
    }

    @media (max-width: 520px) {
      .teste-stage { padding-top: 72px; }
      .teste-bar small { display: none; }
      .delete-demo-card { padding-bottom: 78px; }
      .file-row { grid-template-columns: auto minmax(0,1fr) auto; gap: 9px; }
      .file-icon { width: 38px; height: 38px; }
      .delete-button { width: 36px; height: 36px; }
    }

    @media (prefers-reduced-motion: reduce) {
      :root { --teste-animation: .2; }
    }
  </style>
</head>

<body>
  <main class="teste-stage">
    <header class="teste-head">
      <p class="teste-kicker">Game Search · Área de teste</p>
      <h1>A exclusão mais <span>satisfatória</span></h1>
      <p class="teste-subtitulo">
        Protótipo visual da animação de lixeira, adaptado à paleta, tipografia e temas do projeto.
      </p>
    </header>

    <section class="teste-window" aria-label="Demonstração da animação de exclusão">
      <div class="teste-bar">
        <i class="teste-dot red" aria-hidden="true"></i>
        <i class="teste-dot yellow" aria-hidden="true"></i>
        <i class="teste-dot green" aria-hidden="true"></i>
        <strong>Excluir → <em>amassar &amp; jogar</em></strong>
        <small>Game Search / teste.php</small>
      </div>

      <div class="teste-body">
        <article class="delete-demo-card" id="card">
          <div class="delete-demo-top">
            <div>
              <span class="delete-demo-tag">Demonstração</span>
              <h2>Itens recentes</h2>
            </div>
            <span class="delete-demo-count"><b id="count">4</b> itens</span>
          </div>

          <p class="usage">Uso demonstrativo: <b id="used">25.5 MB</b></p>
          <div class="meter" aria-hidden="true">
            <div class="meter-fill" id="fill"></div>
          </div>

          <ul class="file-list" id="list" aria-label="Itens de demonstração"></ul>

          <div class="demo-bin" id="bin" aria-hidden="true">
            <svg viewBox="0 0 64 72">
              <g class="lid">
                <rect x="8" y="10" width="48" height="7" rx="3"></rect>
                <rect x="24" y="4" width="16" height="6" rx="3"></rect>
              </g>
              <path class="tub" d="M11 20h42l-4 46a5 5 0 0 1-5 4H20a5 5 0 0 1-5-4L11 20Z"></path>
              <path class="rib" d="M24 28v34M32 28v34M40 28v34"></path>
            </svg>
          </div>

          <div class="undo-toast" id="toast" role="status" aria-live="polite">
            <span id="toastTxt"></span>
            <button type="button" id="undo">Desfazer</button>
          </div>
        </article>
      </div>
    </section>

    <p class="test-caption">Excluir não precisa ser sem graça</p>

    <section class="test-controls" aria-label="Controles da demonstração">
      <button type="button" data-act="reset">Restaurar tudo</button>
      <button type="button" data-act="slow" aria-pressed="false">Câmera lenta</button>
      <button type="button" data-act="theme">Tema claro / escuro</button>
      <button type="button" data-act="force-hover">Forçar hover</button>
      <button type="button" data-act="delete-next">Excluir próximo</button>
    </section>

    <figure class="reference-video" id="ref" hidden>
      <video autoplay muted loop playsinline>
        <source src="assets/videos/referencia.mp4" type="video/mp4">
      </video>
      <figcaption>Referência visual em vídeo</figcaption>
    </figure>
  </main>

  <!-- Mantém o teste conectado ao sistema visual/preferências real do Game Search. -->
  <script src="js/global.js"></script>

  <script>
    (() => {
      const $ = (selector) => document.querySelector(selector);
      const TOTAL = 32 * 1024 * 1024;
      const MB = 1024 * 1024;

      const svg = (path) => `<svg viewBox="0 0 24 24">${path}</svg>`;

      const ICONS = {
        pdf: svg('<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8l-5-5Z"/><path d="M14 3v5h5"/>'),
        img: svg('<rect x="3" y="4" width="18" height="16" rx="3"/><circle cx="9" cy="10" r="1.6"/><path d="m4 18 5-5 4 4 3-3 4 4"/>'),
        zip: svg('<rect x="4" y="3" width="16" height="18" rx="3"/><path d="M12 3v6m-2 3h4m-4 3h4"/>'),
        txt: svg('<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8l-5-5Z"/><path d="M14 3v5h5M9 13h6M9 17h6"/>'),
        bin: svg('<path d="M4 7h16M9 7V4h6v3M6 7l1 13h10l1-13M10 11v6M14 11v6"/>')
      };

      const SEED = [
        { id: 1, name: 'Quarterly-report.pdf', meta: 'PDF · 2.4 MB', bytes: 2.4 * MB, ic: 'pdf', c: 'red' },
        { id: 2, name: 'team-photo.jpg', meta: 'Imagem · 5.1 MB', bytes: 5.1 * MB, ic: 'img', c: 'teal' },
        { id: 3, name: 'brand-assets.zip', meta: 'Arquivo · 18 MB', bytes: 18 * MB, ic: 'zip', c: 'amber' },
        { id: 4, name: 'meeting-notes.txt', meta: 'Documento · 12 KB', bytes: 12 * 1024, ic: 'txt', c: 'blue' }
      ];

      let files = [...SEED];
      let last = null;
      let timer;

      const list = $('#list');
      const bin = $('#bin');
      const toast = $('#toast');

      const fmt = (bytes) =>
        bytes >= MB
          ? (bytes / MB).toFixed(1).replace(/\.0$/, '') + ' MB'
          : Math.round(bytes / 1024) + ' KB';

      const T = () =>
        parseFloat(
          getComputedStyle(document.documentElement)
            .getPropertyValue('--teste-animation')
        ) || 1;

      const rowHTML = (file) => `
        <li class="file-row" data-id="${file.id}">
          <span class="file-icon ${file.c}">${ICONS[file.ic]}</span>
          <div>
            <div class="file-name">${file.name}</div>
            <div class="file-meta">${file.meta}</div>
          </div>
          <button class="delete-button" type="button" aria-label="Excluir ${file.name}">
            ${ICONS.bin}
          </button>
        </li>
      `;

      function meter() {
        const used = files.reduce((sum, file) => sum + file.bytes, 0);
        $('#fill').style.transform = `scaleX(${Math.max(used / TOTAL, .02)})`;
        $('#used').textContent = fmt(used);
        $('#count').textContent = files.length;
      }

      function render() {
        list.innerHTML = files.map(rowHTML).join('');
        meter();
      }

      const lerp = (a, b, t) => a + (b - a) * t;
      const ease = (t) =>
        t < .5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2;

      function puffs(x, y) {
        for (let i = 0; i < 9; i++) {
          const puff = document.createElement('i');
          const angle = Math.PI * (1 + Math.random());

          puff.className = 'puff';
          puff.style.cssText =
            `left:${x}px;top:${y}px;--dx:${Math.cos(angle) * 40}px;--dy:${Math.sin(angle) * 34 - 6}px`;

          document.body.appendChild(puff);
          setTimeout(() => puff.remove(), 700 * T());
        }
      }

      function toss(from, done) {
        const ball = document.createElement('div');
        ball.className = 'demo-ball';
        document.body.appendChild(ball);

        const target = bin.getBoundingClientRect();
        const to = {
          x: target.left + target.width / 2 - 17,
          y: target.top + 6
        };

        const duration = 750 * T();
        const arc = 90 + Math.abs(to.y - from.y) * .25;
        const spin = 540;

        bin.classList.add('open');

        const start = performance.now();

        function step(now) {
          const progress = Math.min((now - start) / duration, 1);
          const eased = ease(progress);

          const x = lerp(from.x, to.x, eased);
          const y =
            lerp(from.y, to.y, eased) -
            arc * Math.sin(Math.PI * progress);

          ball.style.transform =
            `translate(${x}px,${y}px) rotate(${spin * progress}deg) scale(${1 - .35 * progress})`;

          if (progress < 1) {
            requestAnimationFrame(step);
            return;
          }

          ball.remove();
          bin.classList.remove('open', 'squash');
          void bin.offsetWidth;
          bin.classList.add('squash');

          puffs(to.x + 17, to.y);
          done();
        }

        requestAnimationFrame(step);
      }

      function removeRow(row) {
        const index = files.findIndex((file) => file.id == row.dataset.id);
        if (index < 0) return;

        const file = files[index];
        const iconRect = row.querySelector('.file-icon').getBoundingClientRect();

        row.classList.add('crumple');

        setTimeout(() => {
          row.classList.add('collapse');

          toss(
            { x: iconRect.left, y: iconRect.top },
            () => {
              files.splice(index, 1);
              last = { file, index };
              meter();
              showToast(file.name);
              row.remove();
            }
          );
        }, 380 * T());
      }

      function showToast(name) {
        $('#toastTxt').textContent = `Excluído: ${name}`;
        toast.classList.add('show');

        clearTimeout(timer);
        timer = setTimeout(() => toast.classList.remove('show'), 5000);
      }

      $('#undo').addEventListener('click', () => {
        if (!last) return;

        files.splice(last.index, 0, last.file);

        const temp = document.createElement('div');
        temp.innerHTML = rowHTML(last.file);

        const row = temp.firstElementChild;
        row.classList.add('pop');

        list.insertBefore(row, list.children[last.index] || null);

        last = null;
        meter();
        toast.classList.remove('show');
      });

      list.addEventListener('click', (event) => {
        const button = event.target.closest('.delete-button');
        if (button) removeRow(button.closest('.file-row'));
      });

      $('.test-controls').addEventListener('click', (event) => {
        const button = event.target.closest('button');
        if (!button) return;

        const action = button.dataset.act;
        const root = document.documentElement;

        if (action === 'reset') {
          files = [...SEED];
          last = null;
          toast.classList.remove('show');
          render();
        }

        if (action === 'slow') {
          const enabled = button.getAttribute('aria-pressed') !== 'true';
          root.style.setProperty('--teste-animation', enabled ? 3 : 1);
          button.setAttribute('aria-pressed', enabled);
        }

        if (action === 'theme') {
          const atual =
            document.documentElement.classList.contains('tema-escuro')
              ? 'escuro'
              : 'claro';

          const proximo = atual === 'escuro' ? 'claro' : 'escuro';

          if (
            window.Preferencias &&
            typeof window.Preferencias.aplicarTema === 'function'
          ) {
            window.Preferencias.aplicarTema(proximo);
          } else {
            document.documentElement.classList.toggle('tema-claro', proximo === 'claro');
            document.documentElement.classList.toggle('tema-escuro', proximo === 'escuro');
            document.body.classList.toggle('tema-claro', proximo === 'claro');
            document.body.classList.toggle('tema-escuro', proximo === 'escuro');
          }
        }

        if (action === 'force-hover') {
          list.children[2]?.classList.toggle('force-hover');
        }

        if (action === 'delete-next') {
          const row = list.querySelector('.file-row:not(.crumple)');
          if (row) removeRow(row);
        }
      });

      const video = $('#ref video');
      video.addEventListener('loadeddata', () => {
        $('#ref').hidden = false;
      });

      render();
    })();
  </script>
</body>
</html>

<!DOCTYPE html>
<html lang="pt-BR" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teste · Delete crumple &amp; toss</title>
    <link rel="stylesheet" href="css/teste.css">
</head>
<style>
    :root {
        --bg: #05060d;
        --bg2: #141433;
        --glass: rgba(255, 255, 255, .07);
        --line: rgba(255, 255, 255, .12);
        --tx: #f4f5fb;
        --mut: #8b90a8;
        --acc: #8b7bff;
        --danger: #ff5470;
        --dangerbg: rgba(255, 84, 112, .14);
        --t: 1;
        --r: clamp(14px, 3vw, 22px);
        font-family: "Inter", system-ui, -apple-system, "Segoe UI", sans-serif;
    }

    [data-theme=light] {
        --bg: #eceefa;
        --bg2: #fff;
        --glass: rgba(255, 255, 255, .7);
        --line: rgba(20, 20, 60, .12);
        --tx: #15162b;
        --mut: #666b85;
        --dangerbg: rgba(255, 84, 112, .12)
    }

    * {
        box-sizing: border-box;
        margin: 0
    }

    body {
        min-height: 100dvh;
        color: var(--tx);
        background: radial-gradient(90% 60% at 50% 0, var(--bg2), var(--bg));
        -webkit-font-smoothing: antialiased
    }

    .stage {
        width: min(760px, 100%);
        margin: 0 auto;
        padding: clamp(20px, 5vw, 48px) clamp(12px, 3vw, 24px);
        display: grid;
        gap: clamp(16px, 3vw, 28px);
        justify-items: center
    }

    .head {
        text-align: center
    }

    .kicker {
        font-size: .72rem;
        letter-spacing: .28em;
        text-transform: uppercase;
        color: var(--mut);
        margin-bottom: 8px
    }

    h1 {
        font-size: clamp(1.3rem, 3.6vw, 1.9rem);
        font-weight: 700;
        letter-spacing: -.02em
    }

    h1 span {
        color: var(--acc)
    }

    .window {
        width: 100%;
        border: 1px solid var(--line);
        border-radius: 16px;
        background: rgba(10, 10, 25, .55);
        overflow: hidden;
        box-shadow: 0 30px 80px -30px #000
    }

    [data-theme=light] .window {
        background: rgba(255, 255, 255, .5)
    }

    .bar {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 16px;
        border-bottom: 1px solid var(--line);
        font-size: .85rem
    }

    .dot {
        width: 12px;
        height: 12px;
        border-radius: 50%
    }

    .r {
        background: #ff5f57
    }

    .y {
        background: #febc2e
    }

    .g {
        background: #28c840
    }

    .bar b {
        margin-left: 8px
    }

    .bar em {
        font-style: normal;
        color: var(--acc)
    }

    .bar small {
        margin-left: auto;
        color: var(--mut);
        font-size: .72rem
    }

    .body {
        padding: clamp(14px, 4vw, 40px);
        display: grid;
        place-items: center
    }

    .card {
        position: relative;
        width: min(100%, 440px);
        padding: clamp(16px, 4vw, 26px);
        border-radius: var(--r);
        border: 1px solid var(--line);
        background: linear-gradient(160deg, var(--glass), rgba(255, 255, 255, .02));
        backdrop-filter: blur(18px);
        box-shadow: 0 20px 60px -20px rgba(0, 0, 0, .6), inset 0 1px 0 rgba(255, 255, 255, .12);
        padding-bottom: 70px
    }

    .top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start
    }

    .tag {
        font-size: .68rem;
        letter-spacing: .22em;
        text-transform: uppercase;
        color: var(--acc);
        display: flex;
        align-items: center;
        gap: 8px
    }

    .tag::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--acc);
        box-shadow: 0 0 8px var(--acc)
    }

    h2 {
        font-size: clamp(1.4rem, 4.5vw, 1.7rem);
        margin-top: 6px;
        letter-spacing: -.02em
    }

    .count {
        font-size: .75rem;
        color: var(--mut);
        padding: 5px 12px;
        border: 1px solid var(--line);
        border-radius: 99px;
        background: var(--glass)
    }

    .count b {
        color: var(--tx)
    }

    .using {
        margin-top: 14px;
        font-size: .8rem;
        color: var(--mut)
    }

    .using b {
        color: var(--tx)
    }

    .meter {
        height: 6px;
        border-radius: 9px;
        background: var(--line);
        margin: 8px 0 18px;
        overflow: hidden
    }

    .fill {
        height: 100%;
        width: 100%;
        transform-origin: left;
        border-radius: 9px;
        background: linear-gradient(90deg, #6c5cff, #a99bff);
        transition: transform calc(.7s*var(--t)) cubic-bezier(.3, 1.3, .5, 1)
    }

    .sound {
        position: absolute;
        top: -14px;
        right: -14px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 1px solid var(--line);
        background: var(--glass);
        backdrop-filter: blur(10px);
        color: var(--mut);
        cursor: pointer;
        display: grid;
        place-items: center
    }

    .sound svg {
        width: 18px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round
    }

    .sound[aria-pressed=true] .x {
        display: none
    }

    .list {
        list-style: none;
        padding: 0;
        display: grid
    }

    .row {
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 14px;
        align-items: center;
        padding: 10px 12px;
        margin: 0 -12px;
        border-radius: 14px;
        border: 1px solid transparent;
        transition: background .25s, border-color .25s, transform .25s;
        max-height: 80px;
        overflow: hidden
    }

    .row:hover,
    .row.hov {
        background: linear-gradient(90deg, rgba(255, 84, 112, .16), rgba(255, 84, 112, .05));
        border-color: rgba(255, 84, 112, .35);
        transform: translateX(2px)
    }

    .ico {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        border: 1px solid
    }

    .ico svg,
    .del svg {
        width: 20px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round
    }

    .c-red {
        color: #ff6b81;
        background: rgba(255, 84, 112, .15);
        border-color: rgba(255, 84, 112, .4)
    }

    .c-teal {
        color: #3ddbb0;
        background: rgba(61, 219, 176, .13);
        border-color: rgba(61, 219, 176, .4)
    }

    .c-amber {
        color: #ffb547;
        background: rgba(255, 181, 71, .13);
        border-color: rgba(255, 181, 71, .4)
    }

    .c-blue {
        color: #7b8cff;
        background: rgba(123, 140, 255, .13);
        border-color: rgba(123, 140, 255, .4)
    }

    .name {
        font-weight: 600;
        font-size: .98rem
    }

    .meta {
        font-size: .75rem;
        color: var(--mut);
        margin-top: 3px
    }

    .del {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        border: 1px solid rgba(255, 84, 112, .35);
        background: var(--dangerbg);
        color: var(--danger);
        cursor: pointer;
        display: grid;
        place-items: center;
        transition: transform .15s, background .2s, color .2s
    }

    .row:hover .del,
    .row.hov .del {
        background: var(--danger);
        color: #fff;
        box-shadow: 0 0 18px rgba(255, 84, 112, .6)
    }

    .del:active {
        transform: scale(.88)
    }

    .del:focus-visible,
    .lab button:focus-visible,
    .toast button:focus-visible {
        outline: 2px solid var(--acc);
        outline-offset: 2px
    }

    .row.crumple {
        animation: crumple calc(.55s*var(--t)) cubic-bezier(.6, 0, .4, 1) forwards;
        pointer-events: none
    }

    @keyframes crumple {
        0% {
            transform: none
        }

        35% {
            transform: scale(.9, .75) rotate(-2deg) skewX(4deg);
            filter: brightness(1.2)
        }

        70% {
            transform: scale(.3, .6) rotate(8deg);
            border-radius: 40%;
            opacity: .9
        }

        100% {
            transform: scale(.05) rotate(30deg);
            opacity: 0
        }
    }

    .row.collapse {
        max-height: 0;
        padding-top: 0;
        padding-bottom: 0;
        opacity: 0;
        transition: max-height calc(.35s*var(--t)), padding calc(.35s*var(--t)), opacity .2s
    }

    .row.pop {
        animation: pop calc(.5s*var(--t)) cubic-bezier(.3, 1.5, .5, 1)
    }

    @keyframes pop {
        from {
            transform: scale(.6);
            opacity: 0
        }
    }

    .ball {
        position: fixed;
        left: 0;
        top: 0;
        width: 34px;
        height: 34px;
        z-index: 50;
        pointer-events: none;
        will-change: transform;
        background: radial-gradient(circle at 35% 30%, #fff, #cfd3e8 55%, #8f95b8);
        clip-path: polygon(50% 0, 68% 8%, 92% 18%, 100% 45%, 92% 78%, 68% 96%, 40% 100%, 12% 85%, 0 52%, 10% 22%, 30% 6%)
    }

    .bin {
        position: absolute;
        right: 22px;
        bottom: 14px;
        width: 52px;
        color: #5d6b9c;
        transform-origin: 50% 100%
    }

    .bin svg {
        width: 100%;
        overflow: visible
    }

    .bin .tub {
        fill: rgba(93, 107, 156, .45);
        stroke: currentColor;
        stroke-width: 2
    }

    .bin .lid rect {
        fill: #6f7fb4
    }

    .bin .rib {
        stroke: rgba(255, 255, 255, .25);
        stroke-width: 2;
        fill: none
    }

    .bin .lid {
        transform-origin: 12px 12px;
        transition: transform calc(.2s*var(--t))
    }

    .bin.open .lid {
        transform: rotate(-24deg)
    }

    .bin.squash {
        animation: squash calc(.45s*var(--t)) ease-out
    }

    @keyframes squash {
        25% {
            transform: scale(1.14, .82)
        }

        55% {
            transform: scale(.94, 1.1)
        }

        100% {
            transform: none
        }
    }

    .puff {
        position: fixed;
        z-index: 49;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(200, 205, 235, .55);
        pointer-events: none;
        animation: puff calc(.6s*var(--t)) ease-out forwards
    }

    @keyframes puff {
        to {
            transform: translate(var(--dx), var(--dy)) scale(2.4);
            opacity: 0
        }
    }

    .toast {
        position: absolute;
        left: 50%;
        bottom: 16px;
        transform: translate(-50%, 20px);
        opacity: 0;
        pointer-events: none;
        display: flex;
        gap: 12px;
        align-items: center;
        padding: 8px 8px 8px 14px;
        font-size: .78rem;
        border-radius: 99px;
        background: rgba(20, 20, 45, .92);
        border: 1px solid var(--line);
        color: #fff;
        transition: .3s;
        max-width: calc(100% - 100px)
    }

    .toast.show {
        opacity: 1;
        transform: translate(-50%, 0);
        pointer-events: auto
    }

    .toast button {
        border: 0;
        border-radius: 99px;
        background: var(--acc);
        color: #fff;
        font-weight: 600;
        padding: 5px 12px;
        cursor: pointer
    }

    #toastTxt {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap
    }

    .caption {
        font-size: clamp(1.3rem, 4vw, 1.7rem);
        font-weight: 600;
        letter-spacing: -.02em
    }

    .lab {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: center;
        padding-top: 16px;
        border-top: 1px dashed var(--line)
    }

    .lab button {
        font: inherit;
        font-size: .78rem;
        padding: 8px 14px;
        border-radius: 99px;
        border: 1px solid var(--line);
        background: var(--glass);
        color: var(--tx);
        cursor: pointer
    }

    .lab button[aria-pressed=true] {
        background: var(--acc);
        border-color: var(--acc);
        color: #fff
    }

    .ref {
        width: min(100%, 320px)
    }

    .ref video {
        width: 100%;
        border-radius: 12px
    }

    .ref figcaption {
        font-size: .72rem;
        color: var(--mut);
        text-align: center;
        margin-top: 6px
    }

    @media (max-width:480px) {
        .bar small {
            display: none
        }

        .sound {
            top: -10px;
            right: -6px
        }
    }

    @media (prefers-reduced-motion:reduce) {
        :root {
            --t: .2
        }
    }
</style>

<body>
    <main class="stage">
        <header class="head">
            <p class="kicker">Wait for the undo</p>
            <h1>The most <span>satisfying</span> delete</h1>
        </header>

        <section class="window" aria-label="Demonstração">
            <div class="bar">
                <i class="dot r"></i><i class="dot y"></i><i class="dot g"></i>
                <b>Delete → <em>crumple &amp; toss</em></b>
                <small>localhost / storage</small>
            </div>
            <div class="body">
                <article class="card" id="card">
                    <button class="sound" id="sound" aria-pressed="false" aria-label="Som">
                        <svg viewBox="0 0 24 24">
                            <path d="M11 5 6 9H3v6h3l5 4V5Z" />
                            <path class="x" d="m16 9 5 6m0-6-5 6" />
                        </svg>
                    </button>
                    <div class="top">
                        <div><span class="tag">Storage</span>
                            <h2>Recent files</h2>
                        </div>
                        <span class="count"><b id="count">4</b> items</span>
                    </div>
                    <p class="using">Using <b id="used">25.5 MB</b></p>
                    <div class="meter">
                        <div class="fill" id="fill"></div>
                    </div>
                    <ul class="list" id="list"></ul>
                    <div class="bin" id="bin" aria-hidden="true">
                        <svg viewBox="0 0 64 72">
                            <g class="lid">
                                <rect x="8" y="10" width="48" height="7" rx="3" />
                                <rect x="24" y="4" width="16" height="6" rx="3" />
                            </g>
                            <path class="tub" d="M11 20h42l-4 46a5 5 0 0 1-5 4H20a5 5 0 0 1-5-4L11 20Z" />
                            <path class="rib" d="M24 28v34M32 28v34M40 28v34" />
                        </svg>
                    </div>
                    <div class="toast" id="toast" role="status"><span id="toastTxt"></span><button id="undo">Undo</button></div>
                </article>
            </div>
        </section>
        <p class="caption">Delete won't boring anymore</p>

        <!-- Área de teste -->
        <section class="lab" aria-label="Área de teste">
            <button data-act="reset">Restaurar tudo</button>
            <button data-act="slow" aria-pressed="false">Câmera lenta</button>
            <button data-act="theme">Tema claro / escuro</button>
            <button data-act="force-hover">Forçar hover</button>
            <button data-act="delete-next">Excluir próximo</button>
            <!-- Slot para a gravação original: coloque o arquivo em assets/videos/referencia.mp4 -->
            <figure class="ref" id="ref" hidden>
                <video autoplay muted loop playsinline>
                    <source src="assets/videos/referencia.mp4" type="video/mp4">
                </video>
                <figcaption>Referência (vídeo)</figcaption>
            </figure>
        </section>
    </main>
    <script>(() => {
  const $ = s => document.querySelector(s);
  const TOTAL = 32 * 1024 * 1024, MB = 1024 * 1024;
  const svg = p => `<svg viewBox="0 0 24 24">${p}</svg>`;
  const ICONS = {
    pdf: svg('<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8l-5-5Z"/><path d="M14 3v5h5"/>'),
    img: svg('<rect x="3" y="4" width="18" height="16" rx="3"/><circle cx="9" cy="10" r="1.6"/><path d="m4 18 5-5 4 4 3-3 4 4"/>'),
    zip: svg('<rect x="4" y="3" width="16" height="18" rx="3"/><path d="M12 3v6m-2 3h4m-4 3h4"/>'),
    txt: svg('<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8l-5-5Z"/><path d="M14 3v5h5M9 13h6M9 17h6"/>'),
    bin: svg('<path d="M4 7h16M9 7V4h6v3M6 7l1 13h10l1-13M10 11v6M14 11v6"/>')
  };
  const SEED = [
    { id: 1, name: 'Quarterly-report.pdf', meta: 'PDF', bytes: 2.4 * MB, ic: 'pdf', c: 'red' },
    { id: 2, name: 'team-photo.jpg', meta: 'Image', bytes: 5.1 * MB, ic: 'img', c: 'teal' },
    { id: 3, name: 'brand-assets.zip', meta: 'Archive', bytes: 18 * MB, ic: 'zip', c: 'amber' },
    { id: 4, name: 'meeting-notes.txt', meta: 'Document', bytes: 12 * 1024, ic: 'txt', c: 'blue' }
  ];
  let files = [...SEED], last = null, timer;
  const list = $('#list'), bin = $('#bin'), toast = $('#toast');

  const fmt = b => b >= MB ? (b / MB).toFixed(1).replace(/\.0$/, '') + ' MB' : Math.round(b / 1024) + ' KB';
  const T = () => parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--t')) || 1;

  const rowHTML = f => `<li class="row" data-id="${f.id}">
      <span class="ico c-${f.c}">${ICONS[f.ic]}</span>
      <div class="txt"><div class="name">${f.name}</div><div class="meta">${f.meta} · ${fmt(f.bytes)}</div></div>
      <button class="del" aria-label="Excluir ${f.name}">${ICONS.bin}</button></li>`;

  // medidor ao vivo: só transform (GPU)
  function meter() {
    const used = files.reduce((s, f) => s + f.bytes, 0);
    $('#fill').style.transform = `scaleX(${Math.max(used / TOTAL, .02)})`;
    $('#used').textContent = fmt(used);
    $('#count').textContent = files.length;
  }
  const render = () => { list.innerHTML = files.map(rowHTML).join(''); meter(); };

  const lerp = (a, b, t) => a + (b - a) * t;
  const ease = t => t < .5 ? 2 * t * t : 1 - Math.pow(-2 * t + 2, 2) / 2;

  function puffs(x, y) {
    for (let i = 0; i < 9; i++) {
      const p = document.createElement('i'), a = Math.PI * (1 + Math.random());
      p.className = 'puff';
      p.style.cssText = `left:${x}px;top:${y}px;--dx:${Math.cos(a) * 40}px;--dy:${Math.sin(a) * 34 - 6}px`;
      document.body.appendChild(p);
      setTimeout(() => p.remove(), 700 * T());
    }
  }

  // bola amassada em arco até a lixeira
  function toss(from, done) {
    const ball = document.createElement('div');
    ball.className = 'ball';
    document.body.appendChild(ball);
    const b = bin.getBoundingClientRect();
    const to = { x: b.left + b.width / 2 - 17, y: b.top + 6 };
    const DUR = 750 * T(), arc = 90 + Math.abs(to.y - from.y) * .25, spin = 540;
    bin.classList.add('open');
    const t0 = performance.now();
    (function step(now) {
      const t = Math.min((now - t0) / DUR, 1), p = ease(t);
      const x = lerp(from.x, to.x, p), y = lerp(from.y, to.y, p) - arc * Math.sin(Math.PI * p);
      ball.style.transform = `translate(${x}px,${y}px) rotate(${spin * p}deg) scale(${1 - .35 * p})`;
      if (t < 1) return requestAnimationFrame(step);
      ball.remove(); bin.classList.remove('open', 'squash');
      void bin.offsetWidth; bin.classList.add('squash');
      puffs(to.x + 17, to.y); done();
    })(t0);
  }

  function remove(li) {
    const idx = files.findIndex(f => f.id == li.dataset.id);
    if (idx < 0) return;
    const f = files[idx], r = li.querySelector('.ico').getBoundingClientRect();
    li.classList.add('crumple');
    setTimeout(() => {
      li.classList.add('collapse');
      toss({ x: r.left, y: r.top }, () => {
        files.splice(idx, 1); last = { f, idx }; meter(); showToast(f.name); li.remove();
      });
    }, 380 * T());
  }

  function showToast(n) {
    $('#toastTxt').textContent = `Deleted ${n}`;
    toast.classList.add('show'); clearTimeout(timer);
    timer = setTimeout(() => toast.classList.remove('show'), 5000);
  }
  $('#undo').onclick = () => {
    if (!last) return;
    files.splice(last.idx, 0, last.f);
    const tmp = document.createElement('div'); tmp.innerHTML = rowHTML(last.f);
    const li = tmp.firstElementChild; li.classList.add('pop');
    list.insertBefore(li, list.children[last.idx] || null);
    last = null; meter(); toast.classList.remove('show');
  };

  list.addEventListener('click', e => { const b = e.target.closest('.del'); if (b) remove(b.closest('.row')); });
  $('#sound').onclick = e => { const s = e.currentTarget; s.setAttribute('aria-pressed', s.getAttribute('aria-pressed') !== 'true'); };

  // área de teste
  $('.lab').addEventListener('click', e => {
    const b = e.target.closest('button'); if (!b) return;
    const a = b.dataset.act, root = document.documentElement;
    if (a === 'reset') { files = [...SEED]; last = null; toast.classList.remove('show'); render(); }
    if (a === 'slow') { const on = b.getAttribute('aria-pressed') !== 'true'; root.style.setProperty('--t', on ? 3 : 1); b.setAttribute('aria-pressed', on); }
    if (a === 'theme') root.dataset.theme = root.dataset.theme === 'dark' ? 'light' : 'dark';
    if (a === 'force-hover') list.children[2]?.classList.toggle('hov');
    if (a === 'delete-next') { const li = list.querySelector('.row:not(.crumple)'); if (li) remove(li); }
  });

  // slot de vídeo: só aparece se assets/videos/referencia.mp4 existir
  const v = $('#ref video');
  v.addEventListener('loadeddata', () => $('#ref').hidden = false);
  render();
})();</script>
</body>

</html>
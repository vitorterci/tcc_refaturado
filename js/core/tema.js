/* ─── PREFERÊNCIAS: TEMA ─────────────────────────────────────────────────── */

window.Preferencias = window.Preferencias || {};

window.Preferencias.aplicarTema = function (tema) {
    localStorage.setItem('pref_tema', tema);
    const html = document.documentElement;
    // <html> é a única fonte de verdade do tema.
    // Evita que componentes especiais sejam afetados por seletores duplicados em body.
    html.classList.remove('tema-claro', 'tema-escuro');

    if (tema === 'claro') {
        html.classList.add('tema-claro');
    } else if (tema === 'escuro') {
        html.classList.add('tema-escuro');
    } else {
        // Sistema
        const prefDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        html.classList.add(prefDark ? 'tema-escuro' : 'tema-claro');
    }
    window.AtalhoTema?.sincronizar();
};

(() => {
    if (window.__temaSistemaInicializado) return;
    window.__temaSistemaInicializado = true;
    const mediaTemaSistema = window.matchMedia('(prefers-color-scheme: dark)');
    const atualizarTemaDoSistema = () => {
        if (localStorage.getItem('pref_tema') === 'sistema') {
            window.Preferencias.aplicarTema('sistema');
        }
    };
    if (typeof mediaTemaSistema.addEventListener === 'function') {
        mediaTemaSistema.addEventListener('change', atualizarTemaDoSistema);
    } else if (typeof mediaTemaSistema.addListener === 'function') {
        mediaTemaSistema.addListener(atualizarTemaDoSistema);
    }
})();

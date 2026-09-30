/* Game Search — animação de exclusão para ações do usuário. */
(() => {
  'use strict';

  const REDUZIDO = window.matchMedia?.('(prefers-reduced-motion: reduce)').matches ?? false;
  const FASES = [
    ['is-busy', 0], ['is-shrink', 0], ['is-open', 300], ['is-drop', 420],
    ['is-close', 1500], ['is-dot', 1600], ['is-check', 2000], ['is-out', 3000]
  ];
  const classes = FASES.map(([nome]) => nome);

  function montarEstrutura(btn) {
    if (btn.querySelector('.anim-excluir-content')) return;
    const label = (btn.textContent || 'Excluir').trim();
    btn.classList.add('btn-excluir-animado');
    btn.innerHTML = `
      <span class="paper" aria-hidden="true"></span>
      <span class="content anim-excluir-content">
        <span class="trash" aria-hidden="true">
          <svg viewBox="0 0 20 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
            <path class="body-fill" d="M3.5 8h13l-1 13.2a1.5 1.5 0 0 1-1.5 1.3H6a1.5 1.5 0 0 1-1.5-1.3z"/>
            <g class="lid"><path d="M1.5 5h17M7.5 5V3.2A1.2 1.2 0 0 1 8.7 2h2.6a1.2 1.2 0 0 1 1.2 1.2V5"/></g>
            <path d="M8 11.5v7M12 11.5v7" opacity=".55"/>
          </svg>
        </span>
        <span class="label">${label.replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c]))}</span>
      </span>
      <span class="status" aria-hidden="true"><svg viewBox="0 0 10 10"><path d="M1.8 5.2 4.2 7.6 8.4 2.6"/></svg></span>`;
    btn.setAttribute('aria-label', 'Excluir comentário');
    btn.setAttribute('aria-live', 'polite');
  }

  function limpar(btn) {
    classes.forEach(c => btn.classList.remove(c));
  }

  async function executar(btn, { onDelete, onSuccess, onError } = {}) {
    if (!btn || btn.dataset.animRunning === '1') return false;
    if (typeof onDelete !== 'function') throw new Error('AnimacaoExclusao: onDelete é obrigatório.');

    montarEstrutura(btn);
    btn.dataset.animRunning = '1';
    btn.disabled = true;
    btn.setAttribute('aria-label', 'Excluindo comentário, aguarde');

    const timers = [];
    const agendar = (fn, ms) => { const t = setTimeout(fn, ms); timers.push(t); return t; };
    const restaurar = () => {
      timers.forEach(clearTimeout);
      limpar(btn);
      btn.disabled = false;
      btn.dataset.animRunning = '0';
      btn.setAttribute('aria-label', 'Excluir comentário');
    };

    if (!REDUZIDO) {
      FASES.forEach(([cls, ms]) => agendar(() => {
        if (cls === 'is-close') btn.classList.remove('is-open');
        btn.classList.add(cls);
      }, ms));
    } else {
      btn.classList.add('is-busy', 'is-shrink', 'is-dot');
    }

    try {
      await onDelete();
      btn.classList.add('is-check');
      await new Promise(resolve => agendar(resolve, REDUZIDO ? 100 : 400));
      restaurar();
      onSuccess?.();
      return true;
    } catch (erro) {
      restaurar();
      onError?.(erro);
      return false;
    }
  }

  window.AnimacaoExclusao = { executar, montarEstrutura, limpar };
})();
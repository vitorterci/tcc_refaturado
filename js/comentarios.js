(() => {
  'use strict';

  const api = '../php/api/comentarios.php';
  const MAX = 1000;

  // Mesma fonte de identificação usada por detalhes-jogo.js:
  // lê "id" ou "slug" diretamente da query string.
  const qs = new URLSearchParams(window.location.search);
  const idUrl = qs.get('id') || '';
  const slugUrl = qs.get('slug') || '';

  const escapar = (v) =>
    String(v ?? '').replace(/[&<>'"]/g, (c) => ({
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      "'": '&#039;',
      '"': '&quot;',
    }[c]));

  const formatarData = (iso) => {
    if (!iso) return '';
    const d = new Date(iso.replace(' ', 'T'));
    if (isNaN(d)) return iso;
    return d.toLocaleString('pt-BR', { dateStyle: 'short', timeStyle: 'short' });
  };

  const obterFoto = (caminho) => {
    if (!caminho) return '../img/naoencontrada.png';
    if (/^https?:\/\//i.test(caminho)) return caminho;
    return '../' + caminho.replace(/^\/+/, '');
  };

  let jogoIdResolvido = null;

  const resolverJogoId = async () => {
    if (jogoIdResolvido) return jogoIdResolvido;

    if (idUrl && /^\d+$/.test(idUrl)) {
      jogoIdResolvido = Number(idUrl);
      return jogoIdResolvido;
    }

    if (!slugUrl) return null;

    try {
      const r = await fetch(
        `../php/api/jogo.php?acao=buscar&slug=${encodeURIComponent(slugUrl)}`
      );
      const d = await r.json();
      if (d && d.success && d.jogo) {
        jogoIdResolvido = Number(d.jogo.id);
        return jogoIdResolvido;
      }
    } catch (e) {
      console.warn('Falha ao resolver slug → id', e);
    }

    return null;
  };

  const el = {
    lista:    () => document.querySelector('#comentarios-lista'),
    total:    () => document.querySelector('#comentarios-total'),
    form:     () => document.querySelector('#comentario-form'),
    textarea: () => document.querySelector('#comentario-texto'),
    aviso:    () => document.querySelector('#comentarios-aviso'),
    erro:     () => document.querySelector('#comentarios-erro'),
  };

  const mostrarErro = (msg) => {
    const e = el.erro();
    if (!e) return;
    e.textContent = msg || '';
    e.hidden = !msg;
  };

  const renderizar = (comentarios) => {
    const lista = el.lista();
    const total = el.total();
    if (!lista) return;

    if (total) {
      total.textContent = `${comentarios.length} ${
        comentarios.length === 1 ? 'comentário' : 'comentários'
      }`;
    }

    if (!comentarios.length) {
      lista.innerHTML = `<div class="comentarios-vazio">
        <i class="far fa-comment-dots" aria-hidden="true"></i>
        <p>Nenhum comentário ainda. Seja o primeiro a comentar!</p>
      </div>`;
      return;
    }

    lista.innerHTML = comentarios
      .map((c) => {
        const foto = escapar(obterFoto(c.usuario_foto));
        const nome = escapar(c.usuario_nome || 'Usuário');
        const texto = escapar(c.comentario).replace(/\n/g, '<br>');
        const data = escapar(formatarData(c.data_criacao));
        const editado =
          c.data_atualizacao &&
          c.data_criacao &&
          c.data_atualizacao !== c.data_criacao;

        const acoes =
          c.pode_editar || c.pode_excluir
            ? `
        <div class="comentario-acoes">
          ${
            c.pode_editar
              ? `<button type="button" class="btn-acao" data-acao="editar" data-id="${c.id}"><i class="fas fa-pen"></i> Editar</button>`
              : ''
          }
          ${
            c.pode_excluir
              ? `<button type="button" class="btn-acao btn-acao-perigo" data-acao="excluir" data-id="${c.id}"><i class="fas fa-trash"></i> Excluir</button>`
              : ''
          }
        </div>`
            : '';

        return `<article class="comentario" data-id="${c.id}">
        <header class="comentario-cabecalho">
          <img class="comentario-avatar" src="${foto}" alt="Foto de ${nome}" loading="lazy"
               onerror="this.src='../img/naoencontrada.png'">
          <div class="comentario-meta">
            <strong class="comentario-autor">${nome}</strong>
            <span class="comentario-data">${data}${editado ? ' · editado' : ''}</span>
          </div>
        </header>
        <p class="comentario-texto">${texto}</p>
        ${acoes}
      </article>`;
      })
      .join('');
  };

  const carregar = async () => {
    const jogoId = await resolverJogoId();
    if (!jogoId) {
      mostrarErro('Não foi possível identificar o jogo para carregar comentários.');
      return;
    }

    try {
      const r = await fetch(`${api}?jogo_id=${jogoId}`, {
        credentials: 'include',
        cache: 'no-store',
      });
      const d = await r.json();
      if (!r.ok || !d.success) {
        throw new Error(d.message || 'Erro ao carregar comentários.');
      }

      renderizar(d.comentarios || []);

      const aviso = el.aviso();
      const form = el.form();
      if (aviso && form) {
        if (d.autenticado) {
          aviso.hidden = true;
          form.hidden = false;
        } else {
          aviso.hidden = false;
          form.hidden = true;
          const redirect = encodeURIComponent(
            window.location.pathname + window.location.search
          );
          aviso.innerHTML = `Faça <a href="login.html?redirect=${redirect}">login</a> para comentar.`;
        }
      }
    } catch (e) {
      mostrarErro(e.message || 'Erro ao carregar comentários.');
    }
  };

  const publicar = async (ev) => {
    ev.preventDefault();
    const ta = el.textarea();
    if (!ta) return;

    const texto = ta.value.trim();
    if (!texto) return;

    const jogoId = await resolverJogoId();
    if (!jogoId) return;

    ta.disabled = true;
    try {
      const r = await fetch(api, {
        method: 'POST',
        credentials: 'include',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ jogo_id: jogoId, comentario: texto }),
      });
      const d = await r.json();

      if (r.status === 401) {
        const redirect = encodeURIComponent(
          window.location.pathname + window.location.search
        );
        window.location.href = `login.html?redirect=${redirect}`;
        return;
      }

      if (!r.ok || !d.success) {
        throw new Error(d.message || 'Erro ao publicar.');
      }

      ta.value = '';
      await carregar();
    } catch (e) {
      mostrarErro(e.message || 'Erro ao publicar comentário.');
    } finally {
      ta.disabled = false;
    }
  };

  const editar = async (id, artigo) => {
    const p = artigo.querySelector('.comentario-texto');
    if (!p) return;

    const original = p.textContent;
    const novo = window.prompt('Editar comentário:', original);
    if (novo === null) return;

    const texto = novo.trim();
    if (!texto || texto === original) return;

    try {
      const r = await fetch(`${api}?id=${id}`, {
        method: 'PUT',
        credentials: 'include',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ comentario: texto }),
      });
      const d = await r.json();
      if (!r.ok || !d.success) {
        throw new Error(d.message || 'Erro ao editar.');
      }
      await carregar();
    } catch (e) {
      mostrarErro(e.message || 'Erro ao editar comentário.');
    }
  };

  const excluir = async (id) => {
    if (!window.confirm('Excluir este comentário?')) return;

    try {
      const r = await fetch(`${api}?id=${id}`, {
        method: 'DELETE',
        credentials: 'include',
      });
      const d = await r.json();
      if (!r.ok || !d.success) {
        throw new Error(d.message || 'Erro ao excluir.');
      }
      await carregar();
    } catch (e) {
      mostrarErro(e.message || 'Erro ao excluir comentário.');
    }
  };

  document.addEventListener('DOMContentLoaded', () => {
    el.form()?.addEventListener('submit', publicar);

    el.lista()?.addEventListener('click', (ev) => {
      const btn = ev.target.closest('button[data-acao]');
      if (!btn) return;

      const id = Number(btn.dataset.id);
      const artigo = btn.closest('.comentario');

      if (btn.dataset.acao === 'editar') editar(id, artigo);
      if (btn.dataset.acao === 'excluir') excluir(id);
    });

    const ta = el.textarea();
    if (ta) {
      ta.addEventListener('input', () => {
        if (ta.value.length > MAX) {
          ta.value = ta.value.slice(0, MAX);
        }
      });
    }

    carregar();
  });
})();
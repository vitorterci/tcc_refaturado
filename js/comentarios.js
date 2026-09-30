  /**
   * Exclusão com animação integrada.
   * - Se `AnimacaoExclusao` estiver disponível: usa a coreografia.
   * - Senão: cai no fallback com `window.confirm` (comportamento original).
   * - Respeita `LixeiraDestrutiva` se ambos existirem (prioridade: AnimacaoExclusao).
   */
  const excluir = async (id, artigo, botao) => {
    const mensagemConfirmacao = 'Excluir este comentário?';

    // 1) Confirmação (inalterada)
    if (!window.confirm(mensagemConfirmacao)) return;

    // 2) Executor real do DELETE — reaproveitado por ambos os caminhos
    const executarDelete = async () => {
      const r = await fetch(`${api}?id=${id}`, {
        method: 'DELETE',
        credentials: 'include',
      });
      const d = await r.json();
      if (!r.ok || !d.success) {
        throw new Error(d.message || 'Erro ao excluir.');
      }
    };

    // 3) Caminho novo: AnimacaoExclusao
    if (window.AnimacaoExclusao && botao) {
      await window.AnimacaoExclusao.executar(botao, {
        onDelete: executarDelete,
        onSuccess: () => {
          atualizarTotal(-1);
          carregar();
        },
        onError: (erro) => {
          mostrarErro(erro.message || 'Erro ao excluir comentário.');
          carregar();
        },
      });
      return;
    }

    // 4) Fallback: LixeiraDestrutiva (comportamento anterior)
    if (window.LixeiraDestrutiva && botao) {
      const lixeira = new window.LixeiraDestrutiva(botao, {
        target: artigo,
        confirmMessage: mensagemConfirmacao,
        inline: true,
        text: 'Excluir',
        onDelete: executarDelete,
        onError: (erro) => {
          mostrarErro(erro.message || 'Erro ao excluir comentário.');
          carregar();
        },
        onSuccess: () => atualizarTotal(-1),
      });
      await lixeira.executar();
      return;
    }

    // 5) Fallback final: sem componente visual
    try {
      await executarDelete();
      await carregar();
    } catch (e) {
      mostrarErro(e.message || 'Erro ao excluir comentário.');
    }
  };
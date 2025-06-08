document.addEventListener('DOMContentLoaded', () => {
  const filtros = {
    cliente: document.getElementById('pagamento-filter'),       
    pagamento: document.getElementById('categoria-filter'),     
    produto: document.getElementById('formadepagamento-filter'),  
    quantidade: document.getElementById('vencimento-filter'),     
    valorUnit: document.getElementById('valor-unit-filter'),   
  };

  const tabela = document.querySelector('.tabela-receitas tbody');

  function filtrarTabela() {
    const filtroCliente = filtros.cliente.value;
    const filtroPagamento = filtros.pagamento.value;
    const filtroProduto = filtros.produto.value;
    const filtroQuantidade = filtros.quantidade.value;
    const filtroValorUnit = filtros.valorUnit.value;

    Array.from(tabela.rows).forEach(row => {
      const dataPagamento = row.cells[0].textContent.trim();
      const categoria = row.cells[1].textContent.trim();
      const formaPagamento = row.cells[2].textContent.trim();
      const dataVencimento = row.cells[3].textContent.trim();
      const valor = row.cells[4].textContent.trim();

      const matchCliente = filtroCliente === '' || dataPagamento === formatDate(filtroCliente);
      const matchPagamento = filtroPagamento === '' || categoria === filtroPagamento;
      const matchProduto = filtroProduto === '' || formaPagamento === filtroProduto;
      const matchQuantidade = filtroQuantidade === '' || dataVencimento === formatDate(filtroQuantidade);
      const matchValorUnit = filtroValorUnit === '' || valor === formatValor(filtroValorUnit);

      if (matchCliente && matchPagamento && matchProduto && matchQuantidade && matchValorUnit) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  }

  function formatDate(dateStr) {
    if (!dateStr) return '';
    const d = new Date(dateStr);
    return d.toLocaleDateString('pt-BR');
  }

  function formatValor(valorStr) {
    if (!valorStr) return '';
    return 'R$ ' + Number(valorStr).toFixed(2).replace('.', ',');
  }

  Object.values(filtros).forEach(select => {
    select.addEventListener('change', filtrarTabela);
  });
});

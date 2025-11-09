document.addEventListener('DOMContentLoaded', () => {

  const cartModal = new bootstrap.Modal(document.getElementById('cartModal'));

  let carrinho = [];

  const botoesAdicionar = document.querySelectorAll('.btn-adicionar');

  const cartItemsContainer = document.getElementById('cart-items');
  const cartCountBadge = document.getElementById('cart-count');
  const cartSubtotalEl = document.getElementById('cart-subtotal');
  const cartTaxEl = document.getElementById('cart-tax');
  const cartTotalEl = document.getElementById('cart-total');
  const clearCartButton = document.getElementById('clear-cart');

  botoesAdicionar.forEach(botao => {
    botao.addEventListener('click', () => {
      const nome = botao.dataset.nome;
      const preco = parseFloat(botao.dataset.preco); 

      adicionarAoCarrinho(nome, preco);

    });
  });

  clearCartButton.addEventListener('click', () => {
    carrinho = []; 
    atualizarModalCarrinho(); 
  });

  function adicionarAoCarrinho(nome, preco) {
    const itemExistente = carrinho.find(item => item.nome === nome);
    if (itemExistente) {
      itemExistente.quantidade++;
    } else {

      carrinho.push({
        nome: nome,
        preco: preco,
        quantidade: 1
      });
    }

    atualizarModalCarrinho();

    cartModal.show();
  }

  function atualizarModalCarrinho() {
    cartItemsContainer.innerHTML = '';
    
    let subtotal = 0;
    let totalItens = 0;

    if (carrinho.length === 0) {
      cartItemsContainer.innerHTML = '<p>Seu carrinho está vazio.</p>';
    } else {
      carrinho.forEach(item => {
        const totalItem = item.preco * item.quantidade;
        subtotal += totalItem;
        totalItens += item.quantidade;

        const itemElement = document.createElement('div');
        itemElement.classList.add('d-flex', 'justify-content-between', 'mb-2');
        itemElement.innerHTML = `
          <div>
            <span class="fw-bold">${item.nome}</span>
            <br>
            <small class="text-muted">Qtd: ${item.quantidade}</small>
          </div>
          <span>R$ ${totalItem.toFixed(2).replace('.', ',')}</span>
        `;
        cartItemsContainer.appendChild(itemElement);
      });
    }

    const taxaServico = subtotal * 0.10; 
    const totalGeral = subtotal + taxaServico;

    cartCountBadge.innerText = totalItens; 
    cartSubtotalEl.innerText = `R$ ${subtotal.toFixed(2).replace('.', ',')}`;
    cartTaxEl.innerText = `R$ ${taxaServico.toFixed(2).replace('.', ',')}`;
    cartTotalEl.innerText = `R$ ${totalGeral.toFixed(2).replace('.', ',')}`;
  }

  const checkoutButton = document.getElementById('checkout-button');

  checkoutButton.addEventListener('click', () => {
    const pedido = {
      carrinho: carrinho, 
      subtotal: document.getElementById('cart-subtotal').innerText,
      taxa: document.getElementById('cart-tax').innerText,
      total: document.getElementById('cart-total').innerText
    };

    fetch('finalizar_pedido.php', {
      method: 'POST', 
      headers: {
        'Content-Type': 'application/json', 
      },
      body: JSON.stringify(pedido) 
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('Pedido realizado com sucesso!'); 
        carrinho = []; 
        atualizarModalCarrinho();
        cartModal.hide(); 
      } else {
        alert('Erro ao finalizar o pedido: ' + data.message);
      }
    })
    .catch(error => {
      console.error('Erro na requisição:', error);
      alert('Ocorreu um erro de conexão. Tente novamente.');
    });
  });

}); 
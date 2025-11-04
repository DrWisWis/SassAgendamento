    async function carregarClientes() {
      const lista = document.getElementById('lista-clientes');
      lista.innerHTML = `<p style="text-align:center;color:#777;">Carregando...</p>`;
      try {
        const resp = await fetch('../../pages/admin/listarUsuario.php');
        const data = await resp.json();

        if (data.success && data.clientes.length > 0) {
          lista.innerHTML = '';
          data.clientes.forEach(c => {
            const div = document.createElement('div');
            div.className = 'cliente-card';
            div.innerHTML = `
                <div class="client-info">
                  <p class="cliente-nome">${c.nome}</p>
                  <p class="cliente-status">(${c.status})</p>
                </div>
                <img src="../../src/assets/more-vert.png" alt="Editar">
            `;
            lista.appendChild(div);
          });
        } else {
          lista.innerHTML = `<p style="text-align:center;color:#777;">${data.msg}</p>`;
        }
      } catch (err) {
        console.error(err);
        lista.innerHTML = `<p style="text-align:center;color:#777;">Erro ao carregar clientes.</p>`;
      }
    }

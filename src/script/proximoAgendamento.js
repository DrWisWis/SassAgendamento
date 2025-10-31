async function carregarProximoAgendamento() {
      try {
        const response = await fetch('../../pages/admin/proximo_agendamento.php');
        const data = await response.json();

        const infoDiv = document.getElementById('agendamento-info');
        infoDiv.innerHTML = ''; // limpa antes de mostrar

        if (data.success && data.proximo) {
          const ag = data.proximo;

          infoDiv.innerHTML = `
          <div class="agendamento">
            <div class="dados">
                <div class="info">
                    <img src="../../src/assets/category.png" alt="">
                    <p>${ag.cliente_nome}</p>
                </div>
                <div class="info">
                    <img src="../../src/assets/category.png" alt="">
                    <p>${ag.data}</p>
                </div>
                <div class="info">
                    <img src="../../src/assets/category.png" alt="">
                    <p>${ag.horario}</p>
                </div>
            </div>

            <div class="line"></div>
            
            <p class="info">${ag.observacao || 'Nenhuma'}</p>
          </div>  
          `;
        } else {
          infoDiv.innerHTML = `<p class="no-agendamento">${data.msg}</p>`;
        }

      } catch (error) {
        document.getElementById('agendamento-info').innerHTML =
          `<p class="no-agendamento">Erro ao carregar dados.</p>`;
        console.error('Erro:', error);
      }
    }

    carregarProximoAgendamento();
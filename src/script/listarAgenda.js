async function carregarAgenda() {
    try {
        const response = await fetch('listarAgendamento.php');
        const data = await response.json();
        const list = document.getElementById('agenda-list');
        list.innerHTML = '';

        if (data.success && data.agendamentos.length > 0) {
            let horaAtual = '';
            data.agendamentos.forEach(item => {
                const hora = item.horario.substring(0, 2) + "H";
                if (hora !== horaAtual) {
                    horaAtual = hora;
                    const label = document.createElement('div');
                    label.className = 'time-label';
                    label.textContent = hora;
                    list.appendChild(label);
                }

                const div = document.createElement('div');
                div.className = 'appointment';
                div.innerHTML = `
                    <h4>${item.cliente_nome}</h4>
                    <p>${item.observacao || 'Sem observação'}</p>
                    <p class="appointment-time">${item.data} • ${item.horario}</p>
                `;
                list.appendChild(div);
            });
        } else {
            list.innerHTML = `<p style="text-align:center;color:#777;">${data.msg}</p>`;
        }

    } catch (error) {
        console.error(error);
        document.getElementById('agenda-list').innerHTML =
            `<p style="text-align:center;color:#777;">Erro ao carregar agendamentos.</p>`;
    }
}

carregarAgenda();
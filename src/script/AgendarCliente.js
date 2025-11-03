(function(){
  const daysGrid = document.getElementById('daysGrid');
  const monthYear = document.getElementById('monthYear');
  const selectedInfo = document.getElementById('selectedInfo');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const modal = document.getElementById('modalHorarios');
  const listaHorarios = document.getElementById('listaHorarios');
  const fecharModal = document.getElementById('fecharModal');
  const confirmarBtn = document.getElementById('confirmarAgendamento');
  const observacaoInput = document.getElementById('observacao');

  let viewDate = new Date(); 
  viewDate.setDate(1);
  let selectedDate = null;
  let selectedHorarioId = null;

  const monthNames = new Intl.DateTimeFormat('pt-BR', { month: 'long' });
  const fullFmt = new Intl.DateTimeFormat('pt-BR', { weekday:'long', year:'numeric', month:'long', day:'2-digit' });

  function renderCalendar(){
    daysGrid.innerHTML = '';
    const year = viewDate.getFullYear();
    const month = viewDate.getMonth();
    const firstDayIndex = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month+1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();

    monthYear.textContent = capitalize(monthNames.format(viewDate)) + ' ' + year;

    // Dias do mês anterior
    for(let i=firstDayIndex-1;i>=0;i--){
      const d = daysInPrevMonth-i;
      daysGrid.appendChild(createDayElement(d,true,new Date(year,month-1,d)));
    }

    // Dias do mês atual
    for(let d=1; d<=daysInMonth; d++){
      const dateObj = new Date(year, month, d);
      daysGrid.appendChild(createDayElement(d,false,dateObj));
    }

    // Dias do próximo mês para completar a grade
    const totalRendered = firstDayIndex + daysInMonth;
    const nextDays = (7-(totalRendered%7))%7;
    for(let i=1;i<=nextDays;i++){
      daysGrid.appendChild(createDayElement(i,true,new Date(year, month+1, i)));
    }
  }

  function createDayElement(dayNumber, inactive, dateObj){
    const el = document.createElement('button');
    el.className = 'day' + (inactive?' inactive':'');
    el.type='button';
    el.textContent = dayNumber;

    const iso = dateObj.toISOString().slice(0,10);

    // Se a data não estiver disponível, cinza e desabilitado
    if (!diasDisponiveis.includes(iso)) {
      el.classList.add('inactive');
      el.disabled = true;
    }

    if(selectedDate && isSameDate(dateObj, selectedDate)) el.classList.add('selected');

    el.addEventListener('click',()=>{
      if(el.disabled) return;

      selectedDate = new Date(dateObj.getFullYear(), dateObj.getMonth(), dateObj.getDate());
      renderCalendar();
      selectedInfo.textContent = 'Selecionado: '+capitalize(fullFmt.format(selectedDate));

      // limpar seleção anterior
      listaHorarios.innerHTML = '';
      observacaoInput.value = '';
      selectedHorarioId = null;

      // preencher horários
      if(horariosDisponiveis[iso] && horariosDisponiveis[iso].length>0){
        horariosDisponiveis[iso].forEach(h=>{
          const btn = document.createElement('button');
          btn.textContent = h.horario;
          btn.style.marginRight = '5px';
          btn.disabled = h.ocupado;
          if(h.ocupado) btn.style.backgroundColor = '#ccc';

btn.addEventListener('click', ()=>{
  selectedHorarioId = h.id;
  listaHorarios.querySelectorAll('button').forEach(b => b.classList.remove('selected'));
  btn.classList.add('selected');

  // mostra o horário selecionado
  const horarioSelecionadoEl = document.getElementById('horarioSelecionado');
  horarioSelecionadoEl.textContent = `Horário selecionado: ${h.horario}`;
});

          listaHorarios.appendChild(btn);
        });
      } else {
        listaHorarios.textContent = 'Nenhum horário disponível';
      }

      modal.style.display = 'flex';
    });

    return el;
  }

  // Confirmar agendamento
  confirmarBtn.addEventListener('click', ()=>{
    const observacao = observacaoInput.value;

    if(!selectedHorarioId){
      alert('Escolha um horário antes de confirmar!');
      return;
    }

    fetch('agendar.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        disponibilidade_id: selectedHorarioId,
        observacao: observacao
      })
    })
    .then(res => res.json())
    .then(data => {
      if(data.success){
        alert('Agendamento realizado com sucesso!');
        modal.style.display='none';
        // atualizar status do horário para ocupado
        const diaIso = selectedDate.toISOString().slice(0,10);
        horariosDisponiveis[diaIso].find(h => h.id === selectedHorarioId).ocupado = true;
        renderCalendar();
        selectedHorarioId = null;
      } else {
        alert('Erro: '+data.message);
      }
    })
    .catch(err => alert('Erro ao enviar agendamento: '+err));
  });

  prevBtn.addEventListener('click',()=>{viewDate=new Date(viewDate.getFullYear(),viewDate.getMonth()-1,1); renderCalendar();});
  nextBtn.addEventListener('click',()=>{viewDate=new Date(viewDate.getFullYear(),viewDate.getMonth()+1,1); renderCalendar();});
  fecharModal.addEventListener('click',()=>{modal.style.display='none';});

  function isSameDate(a,b){
    return a.getFullYear()===b.getFullYear() && a.getMonth()===b.getMonth() && a.getDate()===b.getDate();
  }
  function capitalize(str){return str.charAt(0).toUpperCase()+str.slice(1);}

  renderCalendar();
})();
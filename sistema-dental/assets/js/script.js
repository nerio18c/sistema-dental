// assets/js/script.js
document.querySelectorAll('.tooth').forEach(btn => {
  btn.addEventListener('click', () => {
    // Ciclo de estados: normal → caries → tratado → absent
    const estados = ['#FFF','#F00','#0F0','#CCC'];
    let idx = btn.style.backgroundColor
      ? estados.indexOf(btn.style.backgroundColor)
      : 0;
    btn.style.backgroundColor = estados[(idx+1)%estados.length];
    // Aquí podrías enviar AJAX para guardar estado en BD
  });
});

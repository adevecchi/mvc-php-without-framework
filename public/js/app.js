var grauTemp = '°F';

const loader = new Loader(document.getElementById('temp-convert'));

document.getElementById('grau').addEventListener('change', evt => {
  let value = evt.target.value,
      tempMsg = document.getElementById('tempMsg');

  if (value == 'celsius') {
    tempMsg.textContent = 'para Fahrenheit (°F)';
  }
  else {
    tempMsg.textContent = 'para Celsius (°C)';
  }

  grauTemp = tempMsg.textContent.substr(-3, 2);
});

document.getElementById('btn-converter').addEventListener('click', evt => {
  const grau = document.getElementById('grau').value;
  const elTemperatura = document.getElementById('temperatura');

  if (elTemperatura.value.length === 0) elTemperatura.value = '0';

  const temperatura = elTemperatura.value.replace(',', '.');

  const options = {
    method: 'POST',
    body: JSON.stringify({ grau: grau, temperatura: temperatura })
  };

  loader.show();
  
  fetch('home/converter', options)
    .then(response => {
      return response.json();
    })
    .then(data => {
      loader.hide();

      if (!data.error) {
          document.getElementById('resultado').textContent = data.content.toLocaleString() + ' ' + grauTemp;
      }
      else {
        bootbox.alert({
          title: 'Conversor de Temperatura',
          message: data.content
        });
      }
    });
});

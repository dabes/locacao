function mascara(t, mask) {
  var i = t.value.length;
  var saida = mask.substring(1, 0);
  var texto = mask.substring(i);
  if (texto.substring(0, 1) != saida) {
    t.value += texto.substring(0, 1);
  }
}

async function consulta_cep(cep) {
  cep = cep.replace("-", "");
  var url = "http://localhost/imoveis/consulta_cep.php?cep=" + cep;
  await $.get(url, (res) => {
    if (res == "") alert("CEP Inválido");
    else {
      var json = JSON.parse(res);
      if (json.erro !== false) {
        alert("CEP não econtrado!");
      } else {
        if (json.total == 0) alert("CEP não econtrado!");
        else {
          $("#endereco").val(json.dados[0].logradouroDNEC.split(" -")[0]);
          $("#bairro").val(json.dados[0].bairro);
          $("#cidade").val(json.dados[0].localidade);
          $("#estado").val(json.dados[0].uf);
          $("#numero").val("");
          $("#complemento").val("");
        }
      }
    }
  });
}

async function mostrarImagens(input) {
  $("[id^='img-']").remove();
  var arquivos = input.files;
  for (var index = 0; index < arquivos.length; index++) {
    var imagem = $(
      "<img id='img-" + index + "' src='' height='200' class='mr-1 mb-1'/>"
    );
    if (arquivos[index]) {
      const contents = await lerArquivo(arquivos[index]);
      imagem.attr("src", contents);
    } else {
      imagem.attr("src", "");
    }
    $(".editimagens").append(imagem);
  }
}

function lerArquivo(arquivo) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();

    reader.onload = (res) => {
      resolve(res.target.result);
    };
    reader.onerror = (err) => reject(err);

    reader.readAsDataURL(arquivo);
  });
}

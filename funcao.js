function validarCampos(formAgenda){   
    if (document.formAgenda.nome_servidor.value == "" && document.formAgenda.telefone.value == "" && 
        document.formAgenda.tipo.value == "" && document.formAgenda.data_agendamento.value &&
        document.formAgenda.horario.value == ""          ){
            alert("Existe campos Obrigatorios não Preenchidos.");

    }
 /*
    var email = formAgenda.email.value;
    var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!regex.test(email)) {
        alert("Por favor, insira um endereço de e-mail válido.");
        formAgenda.email.value = "";
    }
*/
} 
//Mascara para o numero de telefone 
 $(document).ready(function(){
          $('#telefone').mask('(00) 0000-0000');
});
 
/* desconsiderar por enquanto */
function modoEscuro() {
  let x = document.body;
  x.classList.toggle("w3-black");
}
 /*
function mascaraEmail(input){
    var email = input.value;
    var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!regex.test(email)) {
        alert("Por favor, insira um endereço de e-mail válido.");
        input.value = "";
    }
}*/

function atualizarPagina() {
         fetch('visualizaAgendamentos.php')
             .then(response => response.json())
             .then(dados => {
                 // Lógica para atualizar a página com os dados recebidos
                 // Por exemplo:
                 let elemento = document.getElementById('id');
                 elemento.innerHTML = ''; // Limpa o conteúdo atual
                 dados.forEach(item => {
                     let novoItem = document.createElement('div');
                     novoItem.textContent = item.nome + ': ' + item.valor;
                     elemento.appendChild(novoItem);
                 });
             })
             .catch(error => console.error('Erro:', error));
     }
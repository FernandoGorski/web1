$(document).ready(function() {
  $(function(){
      // Verificar formulário de alteração de nome
      $("#form-alterar-nome").on("submit",function(){
          var nome_input = $("input[name='novo-nome']");
          var senha_input = $("input[name='senha-nome']");
    
          if(nome_input.val() == "" || nome_input.val() == null) {
              alert("O nome é obrigatório.");
              return false;
          }
          else if(senha_input.val() == "" || senha_input.val() == null) {
              alert("A senha é obrigatória.");
              return false;
          }
    
          return true;
      });
    
      // Verificar formulário de alteração de senha
      $("#form-alterar-senha").on("submit",function(){
          var senha_atual_input = $("input[name='senha']");
          var nova_senha_input = $("input[name='nova-senha']");
          var confirmacao_input = $("input[name='confirmacao']");
    
          if(senha_atual_input.val() == "" || senha_atual_input.val() == null) {
              alert("A senha atual é obrigatória.");
              return false;
          }
          else if(nova_senha_input.val() == "" || nova_senha_input.val() == null) {
              alert("A nova senha é obrigatória.");
              return false;
          }
          else if(confirmacao_input.val() == "" || confirmacao_input.val() == null) {
              alert("A confirmação da nova senha é obrigatória.");
              return false;
          }
          else if(nova_senha_input.val() != confirmacao_input.val()) {
              alert("A nova senha e a confirmação devem ser iguais.");
              return false;
          }
    
          return true;
      });
  });
});
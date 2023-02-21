$(document).ready(function() {
    $("#form-register").on("submit", function() {
      var name_input = $("input[name='name']");
      var email_input = $("input[name='email']");
      var password_input = $("input[name='password']");
      var confirm_password_input = $("input[name='confirm_password']");

      if (name_input.val() == "" || name_input.val() == null) {
        alert("Por favor, insira seu nome.");
        return false;
      } else if (email_input.val() == "" || email_input.val() == null) {
        alert("Por favor, insira seu email.");
        return false;
      } else if (password_input.val() == "" || password_input.val() == null) {
        alert("Por favor, insira uma senha.");
        return false;
      } else if (confirm_password_input.val() == "" || confirm_password_input.val() == null) {
        alert("Por favor, confirme sua senha.");
        return false;
      } else if (password_input.val() != confirm_password_input.val()) {
        alert("As senhas não conferem.");
        return false;
      }
      return true;
    });
  });
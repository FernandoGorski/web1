$(document).ready(function() {
    $(function(){
        // Verificar formulário login
        $("#form-login").on("submit",function(){
            var email_input = $("input[name='email']");
            var password_input = $("input[name='password']");
      
            if(email_input.val() == "" || email_input.val() == null) {
                alert("Por favor, insira seu email.");
                return false;
            }
            else if(password_input.val() == "" || password_input.val() == null) {
                alert("Por favor, insira sua senha.");
                return false;
            }
            return true;
        });
    });
});
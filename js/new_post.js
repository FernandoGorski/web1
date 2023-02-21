$(document).ready(function() {
    $(function(){
      // Verificar formulário de envio de post
      $("#form-post").on("submit",function(){
        var title_input = $("input[name='form-title']");
        var content_input = $("textarea[name='form-content']");
      
        if(title_input.val() == "" || title_input.val() == null) {
          alert("Por favor, insira um título.");
          return false;
        }
        else if(content_input.val() == "" || content_input.val() == null) {
          alert("Por favor, insira um conteúdo.");
          return false;
        }
        return true;
      });
    });
  });
  
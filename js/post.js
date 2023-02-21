$(document).ready(function() {
    $(function() {
      // Verificar formulário de comentário
      $("#form-comment").on("submit", function() {
        var comment_input = $("textarea[name='form_comment']");
        
        if (comment_input.val() == "" || comment_input.val() == null) {
          alert("O comentário é obrigatório.");
          return false;
        }
        
        return true;
      });
    });
  });
  
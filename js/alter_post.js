$(document).ready(function() {
    $(function(){
        // Verificar formulário de alteração de post
        $("#form-alterar-post").on("submit",function(){
            var titulo_input = $("input[name='form-title']");
            var conteudo_input = $("textarea[name='form-content']");
      
            if(titulo_input.val() == "" || titulo_input.val() == null) {
                alert("O titulo é obrigatório.");
                return false;
            }
            else if(conteudo_input.val() == "" || conteudo_input.val() == null) {
                alert("O conteudo é obrigatório.");
                return false;
            }
            return true;
        });
      
        // Verificar formulário de alteração de comentario
        $("#form-alterar-comentario").on("submit",function(){
            var novo_comentario_input = $("textarea[name='new_comment']");
      
            if(novo_comentario_input.val() == "" || novo_comentario_input.val() == null) {
                alert("Por favor preencha o campo comentario.");
                return false;
            }      
            return true;
        });
    });
});
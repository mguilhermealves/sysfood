
quiz_template_resposta = '<tr id="question_row#ID#">';
quiz_template_resposta += '    <td style="text-align:center"><span id="questions_check_#ID_KEY#_#ID#">#CHECKED#</span></td>';
quiz_template_resposta += '    <td style="text-align:center"><textarea name="questions[data][#ID_KEY#][resposta][#ID#][text]" style="display:none">#TEXT#</textarea>#TEXT#</td>';
quiz_template_resposta += '    <td style="text-align:center"><button id="question_button_remove#ID#" type="button" class="btn button round alert" style="margin-bottom: 0px; padding: 7px;" title="Excluir Alternativa"><i class="fontello-trash"></i></button></td>';
quiz_template_resposta += '</tr>';
 
quiz_template_pergunta = '<div class="accordion-item" id="accordion-item#ID#">' ;
quiz_template_pergunta += '  <div style="display:flex;flex-direction: row;justify-content: space-between;align-items: center;padding: 7px;">' ;
quiz_template_pergunta += '     <div>' ;
quiz_template_pergunta += '       Pergunta <span class="quiz_num_pergunta">#NUM#</span>' ;
quiz_template_pergunta += '     </div>' ;
quiz_template_pergunta += '     <div>' ;
quiz_template_pergunta += '       <button id="buttonflush-#ID#" type="button" data-bs-toggle="collapse" data-bs-target="#flush-#ID#" aria-expanded="false" aria-controls="flush-#ID#" class="btn button round info" style="margin-bottom: 0px; padding: 7px;" title="Excluir Questão"><i class="fontello-edit"></i> Editar</button>' ;
quiz_template_pergunta += '       <button id="removeflush-#ID#" type="button" class="btn button round alert" style="margin-bottom: 0px; padding: 7px;" title="Excluir Questão"><i class="fontello-trash"></i> Excluir</button>' ;
quiz_template_pergunta += '     </div>' ;
quiz_template_pergunta += '  </div>' ;
quiz_template_pergunta += '  <div id="flush-#ID#" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" style="display:none">' ;
quiz_template_pergunta += '      <div class="accordion-body">' ;
quiz_template_pergunta += '          <input type="hidden" id="questions_correct_#ID#" name="questions[data][#ID#][correct]" value="#CORRECT#">' ;
quiz_template_pergunta += '          <table class="table" id="quiz_table_#ID#">' ;
quiz_template_pergunta += '              <thead>' ;
quiz_template_pergunta += '                  <tr>' ;
quiz_template_pergunta += '                      <th colspan="3">' ;
quiz_template_pergunta += '                         <label>' ;
quiz_template_pergunta += '                             Texto da Pergunta' ;
quiz_template_pergunta += '                             <input type="text"  name="questions[data][#ID#][pergunta]" value="#pergunta#">' ;
quiz_template_pergunta += '                         </label>' ;
quiz_template_pergunta += '                      </th>' ;
quiz_template_pergunta += '                  </tr>' ;
quiz_template_pergunta += '                  <tr>' ;
quiz_template_pergunta += '                      <th>Correta</th>' ;
quiz_template_pergunta += '                      <th>Respostas</th>' ;
quiz_template_pergunta += '                      <th style="width:100px">Ação</th>' ;
quiz_template_pergunta += '                  </tr>' ;
quiz_template_pergunta += '              </thead>' ;
quiz_template_pergunta += '              <tfoot>' ;
quiz_template_pergunta += '                  <tr>' ;
quiz_template_pergunta += '                      <th>' ;
quiz_template_pergunta += '                          <select id="questions_select#ID#">' ;
quiz_template_pergunta += '                              <option value="yes">Sim</option>' ;
quiz_template_pergunta += '                              <option value="no" selected>Não</option>' ;
quiz_template_pergunta += '                          </select>' ;
quiz_template_pergunta += '                      </th>' ;
quiz_template_pergunta += '                      <th><input type="text" id="question_text#ID#"></th>' ;
quiz_template_pergunta += '                      <th style="vertical-align: top;text-align:center"><button type="button" class="btn button round success" style="margin-bottom: 0px; padding: 7px;" title="Adicionar Alternativa" id="question_button#ID#"><i class="fontello-plus"></i></button></th>' ;
quiz_template_pergunta += '                  </tr>' ;
quiz_template_pergunta += '              </tfoot>' ;
quiz_template_pergunta += '              <tbody> ' ;
quiz_template_pergunta += '              </tbody>' ;
quiz_template_pergunta += '          </table>' ;
quiz_template_pergunta += '      </div>' ;
quiz_template_pergunta += '  </div>' ;
quiz_template_pergunta += '</div>' ;


quiz = {
  add_question: function ( data ){
    $.each( $(".quiz_num_pergunta") , function(i,o){
      $(o).html( i + 1);
    })
    var c = quiz_template_pergunta;
    c = String( c ).replace(/#NUM#/gim, data.num );
    c = String( c ).replace(/#ID#/gim, data.id_key );
    c = String( c ).replace(/#pergunta#/gim, data.pergunta );
    c = String( c ).replace(/#CORRECT#/gim, data.CORRECT );
    data.target.append( c ) ;
    $("button[id='removeflush-" + data.id_key + "']").bind("click", function(){
      if( confirm('Deseja realmente excluir essa questão ? Essa ação é irreversivel') ){
        quiz.remove_question( $("#accordion-item" + data.id_key  ) );
      }
      else{
        return false;
      }
      
    })
    $("button[id='buttonflush-" + data.id_key  + "']").bind("click", function(){
      quiz.show_question( $("button[id='buttonflush-" + data.id_key  + "']") );
    })
    $("button[id='question_button" + data.id_key  + "']").bind("click", function(){
      if( $("#question_text" + data.id_key).val() != "" ){
        quiz.add_resposta({ 
          "id_key" : data.id_key 
          , "checked": $("option:selected" , "#questions_select" + data.id_key).val() == "yes" ? " x " : ""
          , "text": $("#question_text" + data.id_key).val()
          , "peso": $("#question_peso" + data.id_key).val()
          , "correct": $("#questions_correct_"+data.id_key).val()
        });
      }
      else{
        alert("Necessário informar o texto da resposta")
        return false;
      }
    })
    quiz.show_question( $("button[id='buttonflush-" + data.id_key  + "']") );
  }
  , show_question: function( obj ){
    var id = obj.attr("data-bs-target");
    $('div[id^="flush-"]').hide()
    $(id).toggle('slow')
  }
  , remove_question: function ( id ){
    id.remove()
  }
  , add_resposta: function( data ){
    var c = quiz_template_resposta;
    var id = data.id == undefined ? Math.floor(Math.random() * 1000000) : data.id;
    if( $("option:selected" , "#questions_select" + data.id_key).val() == "yes" ){
        $("#questions_correct_"+data.id_key).val( id );
        $.each( $("span[id^='questions_check_" + data.id_key + "']") , function(i,o){
          $(o).html('')  
        })
    }
    c = String( c ).replace(/#CHECKED#/gim, data.checked );
    c = String( c ).replace(/#ID#/gim, id );
    c = String( c ).replace(/#ID_KEY#/gim, data.id_key );
    c = String( c ).replace(/#TEXT#/gim, data.text );
    $("#quiz_table_" + data.id_key +" tbody").append( c ) ;
    $("#question_button_remove"+id).bind("click",function(){
      if( confirm('Deseja realmente excluir essa alternativa ? Essa ação é irreversivel') ){
        $("#question_row"+id).remove();
        if( data.correct == id ){
            $.each( $("span[id^='questions_check_"+data.id_key+"']") , function(i,o){
              $(o).html('')  
            })
            $("#questions_correct_"+data.id_key).val(id)
        }
      }
      else{
        return false;
      }
    })
    $("#question_text" + data.id_key).val('');
    $("#questions_select" + data.id_key).val('no');
  }
}
$("#btn_add_pergunta").bind("click", function(){
  var data = {
    id_key : Math.floor(Math.random() * 1000000)
    , num: Number( Number( $(".quiz_num_pergunta").length ) + 1 )
    , CORRECT: ""
    , pergunta: ""
    , target: $("#accordionFlushExample")
  }
  quiz.add_question( data );
});

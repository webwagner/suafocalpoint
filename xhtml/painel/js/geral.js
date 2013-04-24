$(document).ready(function(){
        //perfil
        $('#editar-perfil').click(function() {
          $('#aparece-perfil').show();
        });

        $('#aparece-perfil').click(function() {
          $('#aparece-perfil').hide();
        });
        $('.nome').click(function() {
          $('#aparece-perfil').toggle();
        });
		//trocar foto
        $('').mouseover(function() {
          $('').show();
        });

        $('').mouseout(function() {
                $("").hide();
        }); 

        $('#editar-perfil').click(function() {

        });
		
		//abas
        $('#lista-abas li a').each(function(x){
                $(this).click(function(){                       
                        $('#lista-abas li a.clicado').removeClass("clicado");
                        $('#lista-abas li a.clicado2').removeClass("clicado2").addClass("link-imoveis-da-minha-rede");

                        if(x != 2)
                            $(this).addClass("clicado");
                        else
                            $(this).removeClass("link-imoveis-da-minha-rede").addClass("clicado2");

                        $('.abas-imoveis').each(function(y){
                                if(x == y) {
                                        $(this).show();
                                }
                                else{
                                        $(this).hide();
                                }
                        });
                });
        });
		
		//adicoinar campos
		var x = 1;
		
		$('#add-campo').click(function()
		{   
			x++
			$('#repetir').append('<input type="text" name="nome'+x+'"  class="input"/> <input type="text" name="email'+x+'" class="input" />' );
			$('#quantidade-campos').val(x);
				 
		});
		
	   $("#b-avancada").toggle(function(){
		  $(this).next().slideToggle('fast');
	   }, function () {
		  $(this).next().slideToggle('fast');
	   }); 
	   
		$(".plano").click(function(){
			$("#plano1").removeClass("plano-h");
			$("#plano2").removeClass("plano-h");
			$("#plano3").removeClass("plano-h");
			$("#plano4").removeClass("plano-h");
			$(this).addClass("plano-h");
		});
		
		fileInputs = function() {
		  var $this = $(this),
			  $val = $this.val(),
			  valArray = $val.split('\\'),
			  newVal = valArray[valArray.length-1],
			  $button = $this.siblings('.button'),
			  $fakeFile = $this.siblings('.file-holder');
		  if(newVal !== '') {
			$button.text('Photo Chosen');
			if($fakeFile.length === 0) {
			  $button.after('' + newVal + '');
			} else {
			  $fakeFile.text(newVal);
			}
		  }
		};
		
		$(".fotos h2").toggle(function(){
		  $(this).addClass("hover"); 
			if ($("h2#first").hasClass("hover")) {
			  $("h2#first").removeClass("hover"); 
			}
		  $(this).next().slideToggle('fast');
		}, function () {
		  $(this).removeClass("hover");
		  $(this).next().slideToggle('fast');
		}); 
	
 });

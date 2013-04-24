//jquery alert
(function($) {
	
	$.alerts = {
				
		verticalOffset: -75,                // vertical offset of the dialog from center screen, in pixels
		horizontalOffset: 0,                // horizontal offset of the dialog from center screen, in pixels/
		repositionOnResize: true,           // re-centers the dialog on window resize
		overlayOpacity: .01,                // transparency level of overlay
		overlayColor: '#FFF',               // base color of overlay
		draggable: true,                    // make the dialogs draggable (requires UI Draggables plugin)
		okButton: '&nbsp;OK&nbsp;',         // text for the OK button
		cancelButton: '&nbsp;Cancel&nbsp;', // text for the Cancel button
		dialogClass: null,                  // if specified, this class will be applied to all dialogs
		
		// Public methods
		
		alert: function(message, title, callback) {
			if( title == null ) title = 'Alert';
			$.alerts._show(title, message, null, 'alert', function(result) {
				if( callback ) callback(result);
			});
		},
		
		confirm: function(message, title, callback) {
			if( title == null ) title = 'Confirm';
			$.alerts._show(title, message, null, 'confirm', function(result) {
				if( callback ) callback(result);
			});
		},
			
		prompt: function(message, value, title, callback) {
			if( title == null ) title = 'Prompt';
			$.alerts._show(title, message, value, 'prompt', function(result) {
				if( callback ) callback(result);
			});
		},
		
		// Private methods
		
		_show: function(title, msg, value, type, callback) {
			
			$.alerts._hide();
			$.alerts._overlay('show');
			
			$("BODY").append(
			  '<div id="popup_container">' +
			    '<h1 id="popup_title"></h1>' +
			    '<div id="popup_content">' +
			      '<div id="popup_message"></div>' +
				'</div>' +
			  '</div>');
			
			if( $.alerts.dialogClass ) $("#popup_container").addClass($.alerts.dialogClass);
			
			// IE6 Fix
			var pos = ($.browser.msie && parseInt($.browser.version) <= 6 ) ? 'absolute' : 'fixed'; 
			
			$("#popup_container").css({
				position: pos,
				zIndex: 99999,
				padding: 0,
				margin: 0
			});
			
			$("#popup_title").text(title);
			$("#popup_content").addClass(type);
			$("#popup_message").text(msg);
			$("#popup_message").html( $("#popup_message").text().replace(/\n/g, '<br />') );
			
			$("#popup_container").css({
				minWidth: $("#popup_container").outerWidth(),
				maxWidth: $("#popup_container").outerWidth()
			});
			
			$.alerts._reposition();
			$.alerts._maintainPosition(true);
			
			switch( type ) {
				case 'alert':
					$("#popup_message").after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /></div>');
					$("#popup_ok").click( function() {
						$.alerts._hide();
						callback(true);
					});
					$("#popup_ok").focus().keypress( function(e) {
						if( e.keyCode == 13 || e.keyCode == 27 ) $("#popup_ok").trigger('click');
					});
				break;
				case 'confirm':
					$("#popup_message").after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /> <input type="button" value="' + $.alerts.cancelButton + '" id="popup_cancel" /></div>');
					$("#popup_ok").click( function() {
						$.alerts._hide();
						if( callback ) callback(true);
					});
					$("#popup_cancel").click( function() {
						$.alerts._hide();
						if( callback ) callback(false);
					});
					$("#popup_ok").focus();
					$("#popup_ok, #popup_cancel").keypress( function(e) {
						if( e.keyCode == 13 ) $("#popup_ok").trigger('click');
						if( e.keyCode == 27 ) $("#popup_cancel").trigger('click');
					});
				break;
				case 'prompt':
					$("#popup_message").append('<br /><input type="text" size="30" id="popup_prompt" />').after('<div id="popup_panel"><input type="button" value="' + $.alerts.okButton + '" id="popup_ok" /> <input type="button" value="' + $.alerts.cancelButton + '" id="popup_cancel" /></div>');
					$("#popup_prompt").width( $("#popup_message").width() );
					$("#popup_ok").click( function() {
						var val = $("#popup_prompt").val();
						$.alerts._hide();
						if( callback ) callback( val );
					});
					$("#popup_cancel").click( function() {
						$.alerts._hide();
						if( callback ) callback( null );
					});
					$("#popup_prompt, #popup_ok, #popup_cancel").keypress( function(e) {
						if( e.keyCode == 13 ) $("#popup_ok").trigger('click');
						if( e.keyCode == 27 ) $("#popup_cancel").trigger('click');
					});
					if( value ) $("#popup_prompt").val(value);
					$("#popup_prompt").focus().select();
				break;
			}
			
			// Make draggable
			if( $.alerts.draggable ) {
				try {
					$("#popup_container").draggable({ handle: $("#popup_title") });
					$("#popup_title").css({ cursor: 'move' });
				} catch(e) { /* requires jQuery UI draggables */ }
			}
		},
		
		_hide: function() {
			$("#popup_container").remove();
			$.alerts._overlay('hide');
			$.alerts._maintainPosition(false);
		},
		
		_overlay: function(status) {
			switch( status ) {
				case 'show':
					$.alerts._overlay('hide');
					$("BODY").append('<div id="popup_overlay"></div>');
					$("#popup_overlay").css({
						position: 'absolute',
						zIndex: 99998,
						top: '0px',
						left: '0px',
						width: '100%',
						height: $(document).height(),
						background: $.alerts.overlayColor,
						opacity: $.alerts.overlayOpacity
					});
				break;
				case 'hide':
					$("#popup_overlay").remove();
				break;
			}
		},
		
		_reposition: function() {
			var top = (($(window).height() / 2) - ($("#popup_container").outerHeight() / 2)) + $.alerts.verticalOffset;
			var left = (($(window).width() / 2) - ($("#popup_container").outerWidth() / 2)) + $.alerts.horizontalOffset;
			if( top < 0 ) top = 0;
			if( left < 0 ) left = 0;
			
			// IE6 fix
			if( $.browser.msie && parseInt($.browser.version) <= 6 ) top = top + $(window).scrollTop();
			
			$("#popup_container").css({
				top: top + 'px',
				left: left + 'px'
			});
			$("#popup_overlay").height( $(document).height() );
		},
		
		_maintainPosition: function(status) {
			if( $.alerts.repositionOnResize ) {
				switch(status) {
					case true:
						$(window).bind('resize', $.alerts._reposition);
					break;
					case false:
						$(window).unbind('resize', $.alerts._reposition);
					break;
				}
			}
		}
		
	}
	
	// Shortuct functions
	jAlert = function(message, title, callback) {
		$.alerts.alert(message, title, callback);
	}
	
	jConfirm = function(message, title, callback) {
		$.alerts.confirm(message, title, callback);
	};
		
	jPrompt = function(message, value, title, callback) {
		$.alerts.prompt(message, value, title, callback);
	};
	
})(jQuery);

$(document).ready(function(){
    
    var q = 1;
    
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
    
    $(".email_convidar").focusout(function() {
        if($(this).val() != ''){
           var email = $(this).val();
           $.getJSON('verifica-corretor.php',{campo : 'email', valor : email} ,function(txt){
                if(txt.valor == 'YES'){
                    $("#campo_existe2").show();
                    $(".email_convidar").val('');
                    $(".email_convidar").focus();
                }
                else{
                    $("#campo_existe2").hide();
                }
           })
       }
    })
            
    $('#add-campo').click(function(e){   
        q++;        
        $('#repetir').append('<input type="text" name="nome_convidar[]" class="input nome_convidar"/> <input type="text" id="mail'+q+'" name="email_convidar[]" class="input email_convidar" />' );       
        $(".email_convidar").each(function(i){
            $("#mail"+(i+1)).focusout(function() {
                if($(this).val() != ''){
                   var email = $(this).val();
                   $.getJSON('verifica-corretor.php',{campo : 'email', valor : email} ,function(txt){
                        if(txt.valor == 'YES'){
                            $("#campo_existe2").show();
                            $("#mail"+(i+1)).val('');
                            $("#mail"+(i+1)).focus();
                        }
                        else{
                            $("#campo_existe2").hide();
                        }
                   })
               }
            })
        })
    
    });
    
    $(".plano").click(function(){
        $(".plano").removeClass("plano-h");
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
    
    $("#bt-close-vencimento").click(function(){
        $("#box-vencimento").hide();
    })
	
});

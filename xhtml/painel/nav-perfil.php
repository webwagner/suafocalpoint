<?php
	switch ($page) {
		case 'meu-perfil-publico':
			$display  = "none";
			break;
		case 'meu-perfil-geral':
			$display  = "block";
			break;
		case 'meu-perfil-privado':
			$display  = "block";
			break;
	}
?>
<div id="foto" style="background:none">
    <div id="bt-foto">
        <a href="#" title="Trocar Foto">Trocar Foto</a>
    </div>
    <img src="imagens/foto-perfil.jpg" width="167" height="159" alt="Foto Perfil"  />
</div>

<div style="display:<?php echo $display;?>">

    <ul id="menu-nav">
        <li id="bt-contatos"><a href="#" class="nav-perfil"><img src="imagens/icon-contato_18.jpg" alt="Adicionar Contato" /><span>Adicionar Contato</span></a></li>
        <li id="bt-mensagens"><a href="#" class="nav-perfil"><img src="imagens/icon-mensagens_14.jpg" alt="Enviar Mensagem" /><span>Enviar Mensagem</span></a></li>    
    </ul>
    
    <ul id="menu-nav-2">
        <li><a href="#" id="bt-meus-contatos"><span>Contatos</span></a><span class="num">20</span></li>
    </ul>

</div>
<?php
	switch ($page) {
		case 'dados-perfil':
			$classPerfil  = "hover";
			$classContato = "";
			$classImagem  = "";
			$classPlano   = "";
			break;
		case 'dados-contato':
			$classPerfil  = "";
			$classContato = "hover";
			$classImagem  = "";
			$classPlano   = "";
			break;
		case 'dados-imagem':
			$classPerfil  = "";
			$classContato = "";
			$classImagem  = "hover";
			$classPlano   = "";
			break;
		case 'dados-plano':
			$classPerfil  = "";
			$classContato = "";
			$classImagem  = "";
			$classPlano   = "hover";
			break;
	}
?>
<div id="foto" style="background:none">
    <div id="bt-foto">
    <a href="#" title="Trocar Foto">Trocar Foto</a>
    </div>
    <img src="imagens/foto-perfil.jpg" width="167" height="159" alt="Foto Perfil"  />
    
    <ul class="menu-dados">
    
        <li class="<?php echo $classPerfil;?>"><a href="?page=dados-perfil">Dados Gerais</a></li>
    
        <li class="<?php echo $classContato;?>"><a href="?page=dados-contato">Dados de Contato</a></li>
    
        <li class="<?php echo $classImagem;?>"><a href="?page=dados-imagem">Imagem de Exibi&ccedil;&atilde;o</a></li>
    
        <li class="<?php echo $classPlano;?>"><a href="?page=dados-plano">Alterar Plano</a></li>
    
    </ul>
    
</div>

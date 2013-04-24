<?php
	switch ($page) {
		case 'imovel-dados':
			$classPerfil  = "hover";
			$classContato = "";
			$classImagem  = "";
			break;
		case 'imovel-fotos':
			$classPerfil  = "";
			$classContato = "hover";
			$classImagem  = "";
			break;
		case 'imovel-obs':
			$classPerfil  = "";
			$classContato = "";
			$classImagem  = "hover";
			break;
	}
?>
<div id="foto" style="background:none;width:250px;">
    
    <p class="other">Fa&ccedil;a o cadastro do seu im&oacute;vel em 3 passos simples</p>
    
    <ul class="imovel">
    
    <li class="<?php echo $classPerfil;?>"><a href="?page=imovel-dados">Dados do Im&oacute;vel</a></li>
    
        <li class="<?php echo $classContato;?>"><a href="?page=imovel-fotos">Fotos do Im&oacute;vel</a></li>
    
        <li class="<?php echo $classImagem;?>"><a href="?page=imovel-obs">Dados restritos e observa&ccedil;&otilde;es</a></li>
    
    </ul>
    
</div>

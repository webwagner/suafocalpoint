<?php
$residencial_aluguel = listaImoveis('residencial_aluguel');
$residencial_venda   = listaImoveis('residencial_compra');
$comercial_aluguel   = listaImoveis('comercial_aluguel');
$comercial_venda     = listaImoveis('comercial_compra');
?>

<div id="content">
	
    <div style="padding-bottom: 0;" class="page">
	
        <div class="breadcumbs">
            <span><?php echo $_SESSION['usuario_visitado']->nome;?></span>
            <span class="creci">
            <?php echo ($_SESSION['usuario_visitado']->empresa != "") ? $_SESSION['usuario_visitado']->empresa : '';?>
            <?php echo ($_SESSION['usuario_visitado']->empresa != "" && $_SESSION['usuario_visitado']->creci != "") ? ' | ' : '';?>
            <?php echo ($_SESSION['usuario_visitado']->creci != "") ? 'CRECI '.$_SESSION['usuario_visitado']->creci : '';?>
            </span>
        </div>
        
        <br clear="all" /><br clear="all" /><br clear="all" />
        
        <div class="contatos-perfil">
        
            <div class="box-contatos-perfil">
                <h4>Parceiros</h4>
                <p>
                   <?php echo ($_SESSION['usuario_visitado']->rua != "" ? 'Endereço: '.$_SESSION['usuario_visitado']->rua.', ' : '');?> 
                   <?php echo ($_SESSION['usuario_visitado']->rua != "" ? 'número: '.$_SESSION['usuario_visitado']->numero.', ' : '');?> 
                   <?php echo ($_SESSION['usuario_visitado']->complemento != "") ? ' '.$_SESSION['usuario_visitado']->complemento.' - ' : '';?>
                   <?php echo ($_SESSION['usuario_visitado']->bairro != "") ? ' '.$_SESSION['usuario_visitado']->bairro.' - ' : '';?>
                   <?php echo ($_SESSION['usuario_visitado']->cidade != "") ? ' '.$_SESSION['usuario_visitado']->cidade.' - ' : '';?>
                    <?php echo ($_SESSION['usuario_visitado']->uf != "") ? ' '.$_SESSION['usuario_visitado']->uf : '';?>
                </p>
                <p>Email: <?php echo $_SESSION['usuario_visitado']->email;?></p>
                
                <?php if($_SESSION['usuario_visitado']->website != "") :?>
                <p>Website: <?php echo $_SESSION['usuario_visitado']->website;?></p>
                <?php endif;?>
                
                <p>Tel: <?php echo $_SESSION['usuario_visitado']->telefone;?></p>
            </div>
        
            <div class="line">&nbsp;</div>
        	
             <div class="box-contatos-perfil">
                    
                <h4>Especialidades</h4>
                
                <?php if($residencial_aluguel != "<p>O Corretor não possui imóveis residenciais para aluguel.</p>" && $residencial_venda != "<p>O Corretor não possui imóveis residenciais para venda.</p>") { ?>
                <p>Residencial<br /><font>Aluguel e Venda</font></p>
                <?php } else if($residencial_aluguel != "<p>O Corretor não possui imóveis residenciais para aluguel.</p>"){ ?>
                <p>Residencial<br /><font>Aluguel</font></p>
                <?php } else if($residencial_venda != "<p>O Corretor não possui imóveis residenciais para venda.</p>"){ ?>
                <p>Residencial<br /><font>Venda</font></p>
                <?php }?>
                
                <?php if($comercial_aluguel != "<p>O Corretor não possui imóveis comerciais para aluguel.</p>" && $comercial_venda != "<p>O Corretor não possui imóveis comerciais para venda.</p>") { ?>
                <p>Comercial<br /><font>Aluguel e Venda</font></p>
                <?php } else if($comercial_aluguel != "<p>O Corretor não possui imóveis comerciais para aluguel.</p>"){ ?>
                <p>Comercial<br /><font>Aluguel</font></p>
                <?php } else if($comercial_venda != "<p>O Corretor não possui imóveis comerciais para venda.</p>"){ ?>
                <p>Comercial<br /><font>Venda</font></p>
                <?php }?>
                
            </div>
        
            <div class="box-contatos-perfil box-contatos-perfil-last">
                <h4>Áreas de Cobertura</h4>
                <?php echo areasCobertura();?>
            </div>
            
        
        </div>
        
    </div>
    
<!--    <div id="box-imoveis" class="box-imoveis-perfil">
    
        <ul id="lista-abas">
            <li><a class="link-imoveis-da-minha-rede-perfil clicado" href="javascript:void(0)"><span class="perfil-alone">IMÓVEIS RECENTES</span></a></li>
            <li><a class="link-imoveis-da-minha-rede-perfil" href="javascript:void(0)"><span class="perfil-alone">IMÓVEIS ATIVOS</span></a></li>
        </ul>
        
        <div style="display:block;" id="meus-imoveis" class="abas-imoveis">
            <ul>
                <li class="box-imv-rede box-imv-rede-perfil">
                    <a href="javascript:void(0)" class="title">Residencial > Aluguel</a>                   
                    <?php 
                        //echo $residencial_aluguel;                   
                        //echo totalImovelContato('residencial_aluguel');
                        //if($residencial_aluguel != '')
                        //    echo '<a href="'.url().'/imoveis-contato/residencial-aluguel" class="ver-todos">ver todos</a>';
                    ?>                  
                </li>
                <li class="box-imv-rede box-imv-rede-perfil">
                    <a href="javascript:void(0)" class="title">Residencial > Compra</a>                   
                    <?php 
                        //echo $residencial_venda;            
                        //echo totalImovelContato('residencial_venda');
                        //if($residencial_venda != '')
                        //    echo '<a href="'.url().'/imoveis-contato/residencial-venda" class="ver-todos">ver todos</a>';
                    ?>                    
                </li>
                <li class="box-imv-rede box-imv-rede-perfil box-imv-rede-perfil-green">
                    <a href="javascript:void(0)" class="title">Comercial > Aluguel</a>
                    <?php
                        //echo $comercial_aluguel;
                        //echo totalImovelContato('comercial_aluguel');
                        //if($comercial_aluguel != '')
                        //    echo '<a href="'.url().'/imoveis-contato/comercial-aluguel" class="ver-todos">ver todos</a>';
                    ?>
                </li>
                <li class="box-imv-rede box-imv-rede-perfil box-imv-rede-perfil-last box-imv-rede-perfil-green">
                    <a href="javascript:void(0)" class="title">Comercial > Compra</a>
                    <?php 
                        //echo $comercial_venda;
                        //echo totalImovelContato('comercial_venda');
                        //if($comercial_venda != '')
                        //    echo '<a href="'.url().'/imoveis-contato/comercial-venda" class="ver-todos">ver todos</a>';
                    ?>
                </li>
           </ul>
        </div>
        
        <div style="display:none;" id="meus-imoveis-ativos" class="abas-imoveis">
            <ul>
                <li class="box-imv-rede box-imv-rede-perfil">
                    <a href="javascript:void(0)" class="title">Residencial > Aluguel</a>                   
                    <?php 
                        //echo $residencial_aluguel_ativo;                 
                        //echo totalImovelContato('residencial_aluguel_ativo');
                        //if($residencial_aluguel_ativo != '')
                            //echo '<a href="'.url().'/imoveis-contato/residencial-aluguel-ativo" class="ver-todos">ver todos</a>';
                    ?>                  
                </li>
                <li class="box-imv-rede box-imv-rede-perfil">
                    <a href="javascript:void(0)" class="title">Residencial > Compra</a>                   
                    <?php 
                        //echo $residencial_venda_ativo;             
                        //echo totalImovelContato('residencial_venda_ativo');
                        //if($residencial_venda_ativo != '')
                         //   echo '<a href="'.url().'/imoveis-contato/residencial-venda-ativo" class="ver-todos">ver todos</a>';
                    ?>                    
                </li>
                <li class="box-imv-rede box-imv-rede-perfil box-imv-rede-perfil-green">
                    <a href="javascript:void(0)" class="title">Comercial > Aluguel</a>
                    <?php 
                        //echo $comercial_aluguel_ativo;
                        //echo totalImovelContato('comercial_aluguel_ativo');
                        //if($comercial_aluguel_ativo != '')
                        //    echo '<a href="'.url().'/imoveis-contato/comercial-aluguel-ativo" class="ver-todos">ver todos</a>';
                    ?>
                </li>
                <li class="box-imv-rede box-imv-rede-perfil box-imv-rede-perfil-last box-imv-rede-perfil-green">
                    <a href="javascript:void(0)" class="title">Comercial > Compra</a>
                    <?php 
                        //echo $comercial_venda_ativo;
                        //echo totalImovelContato('comercial_venda_ativo');
                        //if($comercial_venda_ativo != '')
                        //    echo '<a href="'.url().'/imoveis-contato/comercial-venda-ativo" class="ver-todos">ver todos</a>';
                    ?>
                </li>
           </ul>
        </div>

    </div>-->

    <div id="box-imoveis">
    
        <ul id="lista-abas">
            <li><a class="clicado" href="javascript:void(0)"><span>Imóveis Recentes</span></a></li>
            <li><a href="javascript:void(0)"><span>Todos os Imóveis</span></a></li>
        </ul>
        
        <div style="display:block;" id="meus-imoveis" class="abas-imoveis">
            <?php echo listaImoveis('imoveis_visitado_recentes');?>
            <a href="<?php echo url();?>/imoveis-contato/imoveis-recentes" id="imv-rede2"><span>Ver todos os Imóveis</span></a>           
         </div>
        
        <div id="imoveis-a-vencer" class="abas-imoveis">
            <?php echo listaImoveis('imoveis_visitado_todos');?>
            <a href="<?php echo url();?>/imoveis-contato/imoveis-todos" id="imv-rede2"><span>Ver todos os Imóveis</span></a>
        </div>
        
    </div>
    
</div>

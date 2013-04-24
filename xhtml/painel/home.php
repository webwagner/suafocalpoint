<div id="nav">

    <?php include 'nav.php';?>
    
</div>

<div id="content">

    <div id="box-imoveis">
    
        <ul id="lista-abas">
            <li><a class="clicado" href="#"><span>Meus Im�veis</span></a></li>
            <li><a href="#"><span>Im�veis a Vencer</span></a></li>
            <li><a href="#" class="link-imoveis-da-minha-rede"><span>Im�veis da Minha Rede</span></a></li>
        </ul>
        
        <div style="display:block;" id="meus-imoveis" class="abas-imoveis">
            <ul>
                <li class="box-imv-rede">
                    <a href="#">Barra �nico</a>
                    <a href="#" >
                        <img src="imagens/foto-imv-rede-1.jpg" width="169" height="127" alt="Barra �nico" />
                        <span>Rio de Janeiro / RJ</span>
                    </a>
                </li>
                 <li class="box-imv-rede">
                    <a href="#">Barra �nico</a>
                    <a href="#">
                        <img src="imagens/foto-imv-rede-1.jpg" width="169" height="127" alt="Barra �nico" />
                        <span>Rio de Janeiro / RJ</span>
                    </a>
                </li>
                <li class="box-imv-rede">
                    <a href="#" >Barra �nico</a>
                    <a href="#">
                        <img src="imagens/foto-imv-rede-1.jpg" width="169" height="127" alt="Barra �nico" />
                        <span>Rio de Janeiro / RJ</span>
                    </a>
                </li>
                <li class="box-imv-rede">
                    <a href="#" class="tit-imv">Barra �nico</a>
                    <a href="#">
                        <img src="imagens/foto-imv-rede-1.jpg" width="169" height="127" alt="Barra �nico" />
                        <span>Rio de Janeiro / RJ</span>
                    </a>
                </li>
           </ul>
           <a href="#" id="imv-rede"><span>Ver todos os Meus Im�veis</span></a>
        </div>
        
        <div id="imoveis-a-vencer" class="abas-imoveis">
            <ul>
                <li class="box-imv-rede">
                    <a href="#">Barra �nico</a>
                    <a href="#" >
                        <img src="imagens/foto-imv-rede-1.jpg" width="169" height="127" alt="Barra �nico" />
                        <span>Rio de Janeiro / RJ</span>
                    </a>
                </li>
                 <li class="box-imv-rede">
                    <a href="#">Barra �nico</a>
                    <a href="#">
                        <img src="imagens/foto-imv-rede-1.jpg" width="169" height="127" alt="Barra �nico" />
                        <span>Rio de Janeiro / RJ</span>
                    </a>
                </li>
                <li class="box-imv-rede">
                    <a href="#" >Barra �nico</a>
                    <a href="#">
                        <img src="imagens/foto-imv-rede-1.jpg" width="169" height="127" alt="Barra �nico" />
                        <span>Rio de Janeiro / RJ</span>
                    </a>
                </li>
                <li class="box-imv-rede">
                    <a href="#" class="tit-imv">Barra �nico</a>
                    <a href="#">
                        <img src="imagens/foto-imv-rede-1.jpg" width="169" height="127" alt="Barra �nico" />
                        <span>Rio de Janeiro / RJ</span>
                    </a>
                </li>
           </ul>
           <a href="#" id="imv-rede"><span>Ver todos os Im�veis � Vencer</span></a>
        </div>
        
        <div id="imoveis-da-minha-rede" class="abas-imoveis">
        
            <ul>
                <li class="box-imv-rede">
                    <a href="#">Barra �nico</a>
                    <a href="#" >
                        <img src="imagens/foto-imv-rede-1.jpg" width="169" height="127" alt="Barra �nico" />
                        <span>Rio de Janeiro / RJ</span>
                    </a>
                </li>
                 <li class="box-imv-rede">
                    <a href="#">Barra �nico</a>
                    <a href="#">
                        <img src="imagens/foto-imv-rede-1.jpg" width="169" height="127" alt="Barra �nico" />
                        <span>Rio de Janeiro / RJ</span>
                    </a>
                </li>
                <li class="box-imv-rede">
                    <a href="#" >Barra �nico</a>
                    <a href="#">
                        <img src="imagens/foto-imv-rede-1.jpg" width="169" height="127" alt="Barra �nico" />
                        <span>Rio de Janeiro / RJ</span>
                    </a>
                </li>
                <li class="box-imv-rede">
                    <a href="#" class="tit-imv">Barra �nico</a>
                    <a href="#">
                        <img src="imagens/foto-imv-rede-1.jpg" width="169" height="127" alt="Barra �nico" />
                        <span>Rio de Janeiro / RJ</span>
                    </a>
                </li>
           </ul>
           <a href="#" id="imv-rede"><span>Ver todos os Im�veis da Minha Rede</span></a>
           
        </div>
        
    </div>
    
    <div id="busca-imoveis">
        
        <h2>Busca de Im�veis</h2>
        
        <form>
        
            <label class="radio">
                <input type="radio" />
                <span>Por C�digo</span>
            </label>
        
            <label class="radio">
                <input type="radio" checked="checked" />
                <span>Por Caracter�sticas</span>
            </label>
        
            <br clear="all" />
            
            <label class="select">
                <span>Filtrar por UF</span>
                <select id="uf">
                    <option>UF</option>
                    <option>UF</option>
                    <option>UF</option>
                    <option>UF</option>
                    <option>UF</option>
                    <option>UF</option>
                </select>
            </label>
            
            <label class="select">
                <select id="cidade">
                    <option>Cidade</option>
                    <option>Cidade</option>
                    <option>Cidade</option>
                    <option>Cidade</option>
                    <option>Cidade</option>
                    <option>Cidade</option>
                </select>
            </label>

            <label class="select">
                <select id="bairro">
                    <option>Bairro</option>
                    <option>Bairro</option>
                    <option>Bairro</option>
                    <option>Bairro</option>
                    <option>Bairro</option>
                    <option>Bairro</option>
                    <option>Bairro</option>
                </select>
            </label>
        
            <br clear="all" />
            
            <label class="select tipo">
                <span>Tipo</span>
                <select id="tipo">
                    <option>Selecione</option>
                    <option>Selecione</option>
                    <option>Selecione</option>
                    <option>Selecione</option>
                    <option>Selecione</option>
                    <option>Selecione</option>
                    <option>Selecione</option>
                </select>
            </label>
            
            <div class="check">
                <p>Residencial</p>
                
                <label>
                    <input type="checkbox" />
                    <span>Aluguel</span>
                </label>
                
                <label>
                    <input type="checkbox" />
                    <span>Compra</span>
                </label>
            </div>
            
            <div class="check">
                <p>Comercial</p>
                
                <label>
                    <input type="checkbox" />
                    <span>Aluguel</span>
                </label>
                
                <label>
                    <input type="checkbox" />
                    <span>Compra</span>
                </label>
            </div>
            
            <input type="submit" value="Buscar"/>
        
            <div class="busca-avancada">

                <h3>BUSCA AVAN�ADA</h3>

                <div id="b-avancada">&nbsp;</div>
                
                <div id="busca-avancada-display">
                        
                    <label>
                        <span>Valor do Aluguel ou Venda at� R$</span>
                        <input type="text" />
                    </label>
                        
                    <label>
                        <span>N�mero Atual de Quartos</span>
                        <input type="text" />
                    </label>
                        
                    <label>
                        <span>Nome do Condom�nio</span>
                        <input type="text" />
                    </label>
                        
                    <label>
                        <span>�rea constru�da <br /><font>(n�o incluindo varandas)</font></span>
                        <input type="text" />
                    </label>
                    
                                                
                    <label class="av-check av-check-f">
                        <input type="checkbox" />
                        <span>Mobiliado</span>
                    </label>
                    
                    <label class="av-check">
                        <input type="checkbox" />
                        <span>Portaria 24h</span>
                    </label>
                    
                    <label class="av-check">
                        <input type="checkbox" />
                        <span>Varanda</span>
                    </label>
                    
                    <label class="av-check">
                        <input type="checkbox" />
                        <span>Piscina</span>
                    </label>
                    
                    <br clear="all" />
    
                    <input type="submit" value="Buscar" class="b-av"/>                     	                        
                
                </div>
            
            </div>
        
        </form>

    </div>
    
    <div id="box-rede-contatos">
    
        <p>Amplie sua rede de parceiros</p>
        <form name="rede_contatos" action="#" method="post" >
        <span>*Nome</span><span>Email</span>
        <div id="repetir">
        <input type="text" name="nome1"  class="input"/>
        <input type="text" name="email1" class="input" />
        <input type="hidden" id="quantidade-campos" value="" name="quantidade" class="input"  />
        </div>
        <a href="#box-rede-contatos" id="add-campo">+ Clique aqui para convidar mais amigos</a>
        <input type="submit" value="" class="bt" />
        </form>
        
    </div>
    
    <div id="banner-imoveis"><a href="#"></a></div>
    
    </div>
    
</div>
<script type="text/javascript">
	$("#cidade").selectbox().bind('change', function(){
		$('<div>Value of #cidade changed to: '+$(this).val()+'</div>').appendTo('#demo-default-usage .demoTarget').fadeOut(5000, function(){
			$(this).remove();
		});
	});
	$("#bairro").selectbox().bind('change', function(){
		$('<div>Value of #bairro changed to: '+$(this).val()+'</div>').appendTo('#demo-default-ciuda .demoTarget').fadeOut(5000, function(){
			$(this).remove();
		});
	});
	$("#tipo").selectbox().bind('change', function(){
		$('<div>Value of #tipo changed to: '+$(this).val()+'</div>').appendTo('#demo-default-ciuda .demoTarget').fadeOut(5000, function(){
			$(this).remove();
		});
	});
	$("#uf").selectboxB().bind('change', function(){
		$('<div>Value of #uf changed to: '+$(this).val()+'</div>').appendTo('#demo-default-ciuda .demoTarget').fadeOut(5000, function(){
			$(this).remove();
		});
	});
</script>


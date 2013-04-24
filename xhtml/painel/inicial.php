<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/geral.js"></script>
    
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    
    <title>Focal Point</title>
</head>

<body>

    <div id="header">
    
        <div class="meio">
        
            <div id="logo">
                <a href="#" title="Sua Focal Point - Rede de Ferramentas Para Corretores">
                	<img src="imagens/logo_02.gif" alt="Sua Focal Point - Rede de Ferramentas Para Corretores" border="0" />
                </a>
            </div>
            <div id="login">
                <p>
                    <span>Olá,</span>
                    <span class="nome"><strong>Leandra Soares</strong></span>
                </p>
                <a href="#" id="editar-perfil"></a>
                <img src="imagens/foto-login_03.jpg" width="43" height="37" alt="Leandra Soares" />
                <ul id="aparece-perfil">
                    <li><a href="#"><span>Editar Perfil</span></a></li>
                    <li><a href="#"><span>Alterar Senha</span></a></li>
                    <li><a href="#"><span>Sair</span></a></li>
                 </ul>
            </div>
            <ul id="menu">
                <li>
                	<a href="#" id="bg-menu-1" class="clicado1" >
                    <img src="imagens/add-imoveis.png" alt="Adicionar Imóveis" />
                        <span>ADICIONAR IMÓVEIS<br />
                        Cadastre seus imóveis
                        </span> 
                    </a>
                </li>
                <li >
                	<a href="#" id="bg-menu-2" class="clicado1">
                    <img src="imagens/imoveis.png" alt="Imóveis" />
                        <span>IMÓVEIS<br />
                        Seus imóveis e imóveis da rede
                        </span>
                    </a>
                </li>
                <li>
                	<a href="#" id="bg-menu-3" class="clicado2">
                    <img src="imagens/contatos.png" alt="Contatos" />
                        <span>PARCEIROS<br />
                        Conheça a rede
                        </span>
                    </a>
                </li>
                <li >
                	<a href="#" id="bg-menu-4">
                    <img src="imagens/fale-conosco.png" alt="Fale Conosco" />
                        <span>FALE CONOSCO<br />
                        Tire suas dúvidas
                        </span>
                    </a>
                </li>
            </ul>
            
        </div>
        
    </div>
    
    <div id="main">
    
        <div class="meio">
        
            <div id="nav">
            
            	<div id="foto">
                    <div id="bt-foto">
                    <a href="#" title="Trocar Foto">Trocar Foto</a>
                    </div>
                    <img src="imagens/foto-perfil.jpg" width="167" height="159" alt="Foto Perfil"  />
                    <p><span>Leandra Soares</span>
                        Patrimóvel
                    </p>
                </div>
                
                <div id="num-creci"><p>CRECI Nº 2233</p></div>
                                
                <ul id="menu-nav">
                   
                    <li id="bt-minha-pagina"> <p>Minha Página</p></li>
                    
                    <li id="bt-notificacoes">
                    
                        <div id="notificacoes">
                        
                            <h3>Notificações</h3>
                            
                            <div class="notificacao">
                                <span>10</span>
                                <p><a href="#">Solicitações de Contato</a></p>
                            </div>
                            
                            <div class="notificacao">
                                <span>2</span>
                                <p><a href="#">Novas Mensagens</a></p>
                            </div>
                            
                            <p class="traco">&nbsp;</p>
                        
                        </div>

                    </li>
                    
                    <li id="bt-mensagens"><a href="#"><img src="imagens/icon-mensagens_14.jpg" alt="Mensagens" /><span>Mensagens</span></a></li>
   
                    <li id="bt-contatos"><a href="#"><img src="imagens/icon-contato_18.jpg" alt="Contatos" /><span>Contatos</span></a></li>
                </ul>
                
                <a href="#" id="bt-add-imoveis"><span>Adicionar Imóveis</span></a>
                
                <ul id="menu-nav-2">
                    <li><a href="#" id="bt-meus-imv"><span>Meus Imóveis</span></a><span class="num">0</span></li>
                    <li><a href="#" id="bt-imv-a-vencer"><span>LEMBRETE DE IMÓVEIS</span></a><span class="num">0</span></li>
                    <li><a href="#" id="bt-meus-contatos"><span>Meus Contatos</span></a><span class="num">0</span></li>
                </ul>
                
                <a href="#" id="ver-todos"></a>
                
                <a href="#" id="convidar"></a>
                
            </div>
            
            <div id="content">
            
                <div id="box-imoveis">
                
                    <ul id="lista-abas">
                        <li><a class="clicado" href="#"><span>Meus Imóveis</span></a></li>
                        <li><a href="#"><span>Imóveis a Vencer</span></a></li>
                        <li><a href="#" class="link-imoveis-da-minha-rede"><span>Imóveis da Minha Rede</span></a></li>
                    </ul>
                    
                    <div style="display:block;" id="meus-imoveis" class="abas-imoveis">
                        <p>Você ainda não possui imóveis cadastrados</p>
                        <a href="#">Cadastre seu prmeiro imóvel agora</a>
                    </div>
                    
                    <div id="imoveis-a-vencer" class="abas-imoveis">
                        <p>Você ainda não possui imóveis a vencer</p>
                    </div>
                    
                    <div id="imoveis-da-minha-rede" class="abas-imoveis">
                    
                        <ul>
                            <li class="box-imv-rede">
                                <a href="#">Barra Único</a>
                                <a href="#" >
                                    <img src="imagens/foto-imv-rede-1.jpg" width="169" height="127" alt="Barra Único" />
                                    <span>Rio de Janeiro / RJ</span>
                                </a>
                            </li>
                             <li class="box-imv-rede">
                                <a href="#">Barra Único</a>
                                <a href="#">
                                    <img src="imagens/foto-imv-rede-1.jpg" width="169" height="127" alt="Barra Único" />
                                    <span>Rio de Janeiro / RJ</span>
                                </a>
                            </li>
                            <li class="box-imv-rede">
                                <a href="#" >Barra Único</a>
                                <a href="#">
                                    <img src="imagens/foto-imv-rede-1.jpg" width="169" height="127" alt="Barra Único" />
                                    <span>Rio de Janeiro / RJ</span>
                                </a>
                            </li>
                            <li class="box-imv-rede">
                                <a href="#" class="tit-imv">Barra Único</a>
                                <a href="#">
                                    <img src="imagens/foto-imv-rede-1.jpg" width="169" height="127" alt="Barra Único" />
                                    <span>Rio de Janeiro / RJ</span>
                                </a>
                            </li>
                       </ul>
                       <a href="#" id="imv-rede"><span>Ver todos os Imóveis da Minha Rede</span></a>
                       
                    </div>
                    
                </div>
                
                <div id="busca-imoveis">
                    
                    <h2>Busca de Imóveis</h2>
                    
                    <form>
                    
                    	<label class="radio">
                        	<input type="radio" />
                            <span>Por Código</span>
                        </label>
                    
                    	<label class="radio">
                        	<input type="radio" checked="checked" />
                            <span>Por Características</span>
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
                        
                            <h3>BUSCA AVANÇADA</h3>
                                
                            <label>
                                <span>Valor do Aluguel ou Venda até R$</span>
                                <input type="text" />
                            </label>
                                
                            <label>
                                <span>Número Atual de Quartos</span>
                                <input type="text" />
                            </label>
                                
                            <label>
                                <span>Nome do Condomínio</span>
                                <input type="text" />
                            </label>
                                
                            <label>
                                <span>Área construída <br /><font>(não incluindo varandas)</font></span>
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
                    
                    </form>

                </div>
                
                <div id="box-rede-contatos">
                
                    <p>Amplie sua rede de contatos</p>
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
            
    </div>
    
    <div id="footer">
    
    	<div class="meio">
        
            <ul id="links-footer">
                <li><a href="#">Home  |</a></li>
                <li><a href="#">Sua Focal Point  |</a></li>
                <li><a href="#">Inscreva-se |</a></li>
                <li><a href="#">Convide seu Corretor |</a></li>
                <li><a href="#">Fale Conosco </a></li>
            </ul>
            
            <div id="linha"></div>
            
            <div id="img-footer"></div>
            
            <p id="copyright">© 2011 SUA Focal Point. Todos os direitos reservados.</p>
            
            <div id="creditos-click">
                <a href="#" rel="partner" title="Desenvolvido pela Click Designer">
                    <img src="imagens/creditos-click.png" alt="Créditos Click designer" border="0"/>
                </a>
            </div>
            
        </div>
        
    </div>
    
</body>
</html>

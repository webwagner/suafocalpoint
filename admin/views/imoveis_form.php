<div class="tit">
    <img src="static/images/ico-usuarios.jpg" width="40" height="40" alt="imóveis" title="imóveis" />
    <span>Imóveis</span>
</div>
<div class="form-c">
    <form action="" method="post" id="formulario" enctype="multipart/form-data"> 
        <label class="five">
            <span class="span-c">Corretor</span>
            <input type="text" value="<?php echo $corretor;?>" />
        </label> 
        <label class="five">
            <span class="span-c">Código</span>
            <input type="text" value="<?php echo (isset($row->codigo_imovel)) ? $row->codigo_imovel : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Tipo</span>
            <input type="text" value="<?php echo $tipo;?>" />
        </label>
        <label class="five">
            <span class="span-c">Vencimento do Contrato</span>
            <input type="text" value="<?php echo (isset($row->vencimento_contrato)) ? $row->vencimento_contrato : ""; ?>" />
        </label>     
        <?php 
        if(isset($row->residencial)){
            if($row->residencial == "SIM"){ ?>
                <label class="five">
                    <span class="span-c"><?php echo "Residencial";?></span>
                    <input type="text" value="<?php echo (isset($row->aluguel)) ? 'Aluguel - '.$row->aluguel.'    ' : ""; echo (isset($row->compra)) ? 'Venda - '.$row->compra : "";?>" />
                </label>
        <?php       
            }
         }
        ?>
        <?php 
        if(isset($row->comercial)){
            if($row->comercial == "SIM"){ ?>
                <label class="five">
                    <span class="span-c"><?php echo "Comercial";?></span>
                    <input type="text" value="<?php echo (isset($row->aluguel)) ? 'Aluguel - '.$row->aluguel.'    ' : ""; echo (isset($row->compra)) ? 'Venda - '.$row->compra : "";?>" />                    
                </label>
        <?php       
            }
         }
        ?>
        <label class="five">
            <span class="span-c">Valor para Aluguel</span>
            <input type="text" value="<?php echo (isset($row->valor_aluguel)) ? 'R$ '.number_format($row->valor_aluguel,2,',','.') : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Valor para Venda</span>
            <input type="text" value="<?php echo (isset($row->valor_venda)) ? 'R$ '.number_format($row->valor_venda,2,',','.') : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Título</span>
            <input type="text" value="<?php echo (isset($row->titulo)) ? $row->titulo : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Informações Adicionais</span>
            <input type="text" value="<?php echo (isset($row->informacoes_adicionais)) ? $row->informacoes_adicionais : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Nº de Quartos Atual</span>
            <input type="text" value="<?php echo (isset($row->quartos_atual)) ? $row->quartos_atual : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Nº de Quartos Original</span>
            <input type="text" value="<?php echo (isset($row->quartos_original)) ? $row->quartos_original : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Área Construida</span>
            <input type="text" value="<?php echo (isset($row->area_construida)) ? $row->area_construida.' m²' : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Área Externa</span>
            <input type="text" value="<?php echo (isset($row->area_externa)) ? $row->area_externa.' m²' : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Terreno</span>
            <input type="text" value="<?php echo (isset($row->terreno)) ? $row->terreno.' m²' : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Portaria 24 Horas</span>
            <input type="text" value="<?php echo (isset($row->portaria_24h)) ? $row->portaria_24h : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Varanda</span>
            <input type="text" value="<?php echo (isset($row->varanda)) ? $row->varanda : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Mobiliado</span>
            <input type="text" value="<?php echo (isset($row->mobiliado)) ? $row->mobiliado : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Piscina</span>
            <input type="text" value="<?php echo (isset($row->piscina)) ? $row->piscina : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Nome do Condominio</span>
            <input type="text" value="<?php echo (isset($row->nome_condominio)) ? $row->nome_condominio : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Valor do IPTU</span>
            <input type="text" value="<?php echo (isset($row->valor_iptu)) ? 'R$ '.number_format($row->valor_iptu,2,',','.') : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Valor do Condominio</span>
            <input type="text" value="<?php echo (isset($row->valor_condominio)) ? 'R$ '.number_format($row->valor_condominio,2,',','.') : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Bairro</span>
            <input type="text" value="<?php echo $bairro; ?>" />
        </label>
        <label class="five">
            <span class="span-c">UF</span>
            <input type="text" value="<?php echo $uf ?>" />
        </label>
        <label class="five">
            <span class="span-c">Cidade</span>
            <input type="text" value="<?php echo $cidade; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Endereço</span>
            <input type="text" value="<?php echo (isset($row->endereco)) ? $row->endereco : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">CEP</span>
            <input type="text" value="<?php echo (isset($row->cep)) ? $row->cep : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Nome Proprietário</span>
            <input type="text" value="<?php echo (isset($row->nome_proprietario)) ? $row->nome_proprietario : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Telefone Proprietário</span>
            <input type="text" value="<?php echo (isset($row->telefone_proprietario)) ? $row->telefone_proprietario : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Email Proprietário</span>
            <input type="text" value="<?php echo (isset($row->email_proprietario)) ? $row->email_proprietario : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Endereço Proprietário</span>
            <input type="text" value="<?php echo (isset($row->endereco_proprietario)) ? $row->endereco_proprietario : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Bairro Proprietário</span>
            <input type="text" value="<?php echo (isset($row->bairro_proprietario)) ? $row->bairro_proprietario : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Cidade Proprietário</span>
            <input type="text" value="<?php echo (isset($row->cidade_proprietario)) ? $row->cidade_proprietario : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">CEP Proprietário</span>
            <input type="text" value="<?php echo (isset($row->cep_proprietario)) ? $row->cep_proprietario : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Observações</span>
            <input type="text" value="<?php echo (isset($row->observacoes)) ? $row->observacoes : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Data de Cadastro</span>
            <input type="text" value="<?php echo (isset($row->data_cadastro)) ? converteData(substr($row->data_cadastro,0,-9)) : ""; ?>" />
        </label>
    </form>
</div>
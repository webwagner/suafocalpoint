<div class="tit">
    <img src="static/images/ico-usuarios.jpg" width="40" height="40" alt="corretores" title="corretores" />
    <span>Corretores</span>
</div>
<div class="form-c">
    <form action="" method="post" id="formulario" enctype="multipart/form-data"> 
        <?php if($row->foto_perfil != "") :?>
        <label class="five">
            <span class="span-c">Foto</span>
            <?php 
                $img = URL_ABSOLUTE.'static/uploads/fotos/'.$row->login.'/'.$row->foto_perfil;    
                echo ImgRender($img, 100, 100, $row->nome);
            ?>
        </label> 
        <?php endif;?>
        <label class="five">
            <span class="span-c">Nome</span>
            <input type="text" value="<?php echo (isset($row->nome)) ? $row->nome : ""; ?>" />
        </label> 
        <label class="five">
            <span class="span-c">Login</span>
            <input type="text" value="<?php echo (isset($row->login)) ? $row->login : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">CPF</span>
            <input type="text" value="<?php echo (isset($row->cpf)) ? $row->cpf : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Email</span>
            <input type="text" value="<?php echo (isset($row->email)) ? $row->email : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Creci</span>
            <input type="text" value="<?php echo (isset($row->creci)) ? $row->creci : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Data de Nascimento</span>
            <input type="text" value="<?php echo (isset($row->data_nascimento)) ? $row->data_nascimento : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Sexo</span>
            <input type="text" value="<?php echo (isset($row->sexo)) ? $row->sexo : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Autonomo</span>
            <input type="text" value="<?php echo (isset($row->autonomo)) ? $row->autonomo : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Empresa</span>
            <input type="text" value="<?php echo (isset($row->empresa)) ? $row->empresa : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Rua</span>
            <input type="text" value="<?php echo (isset($row->rua)) ? $row->rua : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Número</span>
            <input type="text" value="<?php echo (isset($row->numero)) ? $row->numero : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Complemento</span>
            <input type="text" value="<?php echo (isset($row->complemento)) ? $row->complemento : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Bairro</span>
            <input type="text" value="<?php echo (isset($row->bairro)) ? $row->bairro : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">UF</span>
            <input type="text" value="<?php echo (isset($row->uf)) ? $row->uf : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Cidade</span>
            <input type="text" value="<?php echo (isset($row->cidade)) ? $row->cidade : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Telefone</span>
            <input type="text" value="<?php echo (isset($row->telefone)) ? $row->telefone : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Celular</span>
            <input type="text" value="<?php echo (isset($row->celular)) ? $row->celular : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Como Conheceu</span>
            <input type="text" value="<?php echo (isset($row->como_conheceu)) ? $row->como_conheceu : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Sigla</span>
            <input type="text" value="<?php echo (isset($row->sigla)) ? $row->sigla : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Dados Listados</span>
            <input type="text" value="<?php echo (isset($row->dados_listados)) ? $row->dados_listados : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Ativado</span>
            <input type="text" value="<?php echo (isset($row->ativado)) ? $row->ativado : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Data de Cadastro</span>
            <input type="text" value="<?php echo (isset($row->data_cadastro)) ? $row->data_cadastro : ""; ?>" />
        </label>
        <label class="five">
            <span class="span-c">Plano</span>
            <input type="text" value="<?php echo $plano;?>" />
        </label>
    </form>
</div>
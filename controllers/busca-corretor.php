<?php

if(!$_POST)
    echo '<script>location.href = "home"</script>';

/**
* Faz um select com todos os bairros de imoveis
*/
$mapper = new Mapper();
$mapper->setDbTable(new Imovel);
$rows = $mapper->getSql('SELECT bairro_imovel FROM imovel GROUP BY bairro_imovel');
$mapper_bairro = new Mapper();
$mapper_bairro->setDbTable(new ImovelBairro());

$select_bairro = '<select name="bairro" class="required"><option value="">Selecione</option>';

foreach($rows as $row){

    $mapper_bairro->setWhere('id = '.$row->bairro_imovel);
    $bairro = $mapper_bairro->getRow();
    $select_bairro .= '<option value="'.$bairro->id.'">'.$bairro->bairro.'</option>';

}

$select_bairro .= '</select>';

/**
* Pega o nome do bairro
*/
$mapper_bairro->setWhere('id = '.$_POST['bairro']);
$nome_bairro = $mapper_bairro->getRow();

/**
* Pega os corretores do bairro
*/
$rows = $mapper->getSql('SELECT id_corretor, count(id_corretor) FROM imovel where bairro_imovel = '.$_POST['bairro'].' GROUP BY id_corretor');
$mapper_corretor = new Mapper();
$mapper_corretor->setDbTable(new Corretor());

$lista_corretor = '';

foreach ($rows as $row){

    $mapper_imovel = new Mapper();
    $mapper_imovel->setDbTable(new Imovel);
    $mapper_imovel->setWhere('id_corretor = '.$row->id_corretor);
    $total = $mapper_imovel->getTotal();
    $mapper_corretor->setWhere('id = "'.$row->id_corretor.'" and dados_listados = "SIM"');
    
    if($mapper_corretor->getRow()){
        $corretor = $mapper_corretor->getRow();

        if($corretor->foto_perfil != '')
            $img = URL_ABSOLUTE.'static/uploads/fotos/'.$corretor->login.'/'.$corretor->foto_perfil;
        else
            $img = URL_ABSOLUTE.'static/img/perfil-focalpoint.jpg';

        $lista_corretor .= '<div class="corretor">
                    '.ImgRender($img, 96, 91, $corretor->nome).'
                    <p>'.$corretor->nome.' - '.$total.' imóveis</p>
                    <p>'.$corretor->rua.' '.$corretor->numero.' - '.$corretor->bairro.' - '.$corretor->cidade.' - '.$corretor->uf.'</p>
                    <p>Email: '.$corretor->email.'</p>
                    <p>Tel: '.$corretor->telefone.'</p>
                </div>';
    }

}

include('views/busca-corretor.php');
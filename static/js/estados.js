function openAjax()
{
	try
	{
		var ajax = new XMLHttpRequest();
	}
	catch(e)
	{
		try
		{
			var ajax = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(ee)
		{
			try
			{
				var ajax = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(eee)
			{
			    var ajax = false;
			}
		}
	}
	
	return ajax;
}

function buscaEstados(id)
{
	var uf = document.getElementById(id);
	
	var op = document.createElement('option');
        op.setAttribute('value', '');
        op.appendChild(document.createTextNode("Carregando..."));
        uf.appendChild(op);
	
	var ajax = openAjax();
	
	ajax.open('GET', 'estados.php?acao=buscaEstados', true);
	
	ajax.onreadystatechange = function()
	{
		if (ajax.readyState == 4)
		{
			if (ajax.status == 200)
			{
				uf.innerHTML = '';
				
				var opcao = document.createElement('option');
				opcao.setAttribute('value', '');
				opcao.appendChild(document.createTextNode('UF'));
				uf.appendChild(opcao);
				
				var xml = ajax.responseXML;
				var estado = xml.getElementsByTagName('estado');
				
				for (var i = 0; i < estado.length; i++)
				{
					var idEstado = estado[i].getElementsByTagName('id')[0].firstChild.nodeValue;
					var siglaEstado = estado[i].getElementsByTagName('sigla')[0].firstChild.nodeValue;
					
					var opcao = document.createElement('option');
					opcao.setAttribute('value', idEstado);
					opcao.appendChild(document.createTextNode(siglaEstado));
					uf.appendChild(opcao);
					
				}
				
			}
		}
	}
    ajax.send(null);
    
}




function buscaCidades(uf,id)
{
	var cidades = document.getElementById(id);
	cidades.innerHTML = '';
	var op = document.createElement('option');
        op.setAttribute('value', '');
        op.appendChild(document.createTextNode("Carregando..."));
        cidades.appendChild(op);
	var url = 'estados.php?acao=buscaCidades&uf=' + uf;
	var ajax = openAjax();
	
	ajax.open('GET', url, true);
	ajax.onreadystatechange = function()
	{
		if (ajax.readyState == 4)
		{
			if (ajax.status == 200)
			{
				cidades.innerHTML = '';
				
				var xml = ajax.responseXML;
				var cidade = xml.getElementsByTagName('cidade');
				
				for (var i = 0; i < cidade.length; i++)
				{
					var idCidade = cidade[i].getElementsByTagName('id')[0].firstChild.nodeValue;
					var nomeCidade = cidade[i].getElementsByTagName('nome')[0].firstChild.nodeValue;
					
					var opcao = document.createElement('option');
					opcao.setAttribute('value', idCidade);
					opcao.appendChild(document.createTextNode(nomeCidade));
					cidades.appendChild(opcao);
				}
			}
		}
	}
	ajax.send(null);
}
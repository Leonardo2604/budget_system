modal = document.getElementById('modal');
section = document.getElementById('content');

function close_modal()
{
	modal.style.pointerEvents = 'none';
	modal.style.opacity = '0';
	modal.style.transform = 'translateY(-10px)';
}

function page(_page)
{
	init_http_request_product(section, "/budget_system/controller/product/product_controller.php?action=init_table&page="+_page);
}

function delete_product(id)
{
	var d = confirm('Você tem certeza que quer apagar o produto');

	if(d)
	{
		action_product('delete', id);
	}
	else
	{
		return;
	}
}

function update_product()
{
	id = document.getElementsByName('id')[0].value;
	name = document.getElementsByName('name')[0].value;
	description = document.getElementsByName('description')[0].value;
	price = document.getElementsByName('price')[0].value;
	cash_discount = document.getElementsByName('cash_discount')[0].value;
	labor = document.getElementsByName('labor')[0].value;
	
	if(name != "" && description != "" && price != "" && cash_discount != "" && id != "" && labor != "")
	{
		init_http_request_product_post(section, "/budget_system/controller/product/product_controller.php", id, name, description, price, cash_discount, labor);
		close_modal();
	}else
	{
		modal.innerHTML += "<p>Estão faltando dados no registro</p>";
		return;
	}
}

function create_product()
{
	id = document.getElementsByName('id')[0].value;
	name = document.getElementsByName('name')[0].value;
	description = document.getElementsByName('description')[0].value;
	price = document.getElementsByName('price')[0].value;
	cash_discount = document.getElementsByName('cash_discount')[0].value;
	labor = document.getElementsByName('labor')[0].value;
	
	if(name != "" && description != "" && price != "" && cash_discount != "" && id != "" && labor != "")
	{
		init_http_request_product_post(section, "/budget_system/controller/product/product_controller.php", id, name, description, price, cash_discount, labor, true);
		close_modal();
	}else
	{
		section.innerHTML += "<div class='alert alert-danger alert-dismissible fade show' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Falhou!</strong> Estão faltando dados no registro.</div>";
		return;
	}
}


function action_product(action, id)
{
	switch (action)
	{
		case "show":
			if(modal.style.opacity != '1')
			{
				modal.style.pointerEvents = 'auto';
				modal.style.opacity = '1';
				modal.style.transform = 'translateY(10px)';
				init_http_request_product(modal, "/budget_system/controller/product/product_controller.php?action=show&id="+id);
			}
			else
			{
				modal.style.pointerEvents = 'none';
				modal.style.opacity = '0';
				modal.style.transform = 'translateY(-10px)';
			}
			break;
		case "update":
			if(modal.style.opacity != '1')
			{
				modal.style.pointerEvents = 'auto';
				modal.style.opacity = '1';
				modal.style.transform = 'translateY(10px)';
				init_http_request_product(modal, "/budget_system/controller/product/product_controller.php?action=update&id="+id);
			}
			else
			{
				modal.style.pointerEvents = 'none';
				modal.style.opacity = '0';
				modal.style.transform = 'translateY(-10px)';
			}
			break;
		case "delete":
			init_http_request_product(section, "/budget_system/controller/product/product_controller.php?action=delete&id="+id);
			break;
	}
}


function init_http_request_product(content, url)
{
	if(window.XMLHttpRequest)
	{
		var http_request = new XMLHttpRequest();
	}else
	{
		var http_request = new ActiveXObject("Microsoft.XMLHTTP");
	}

	if(!http_request)
	{
		alert("Seu navegador não suporta o ajax por favor use navegadores como Chrome, FireFox");
		return;
	}

	http_request.onreadystatechange = function()
	{
		try{
			if(http_request.readyState === XMLHttpRequest.DONE)
			{
				if(http_request.status === 200)
				{
					content.innerHTML = http_request.responseText;
				}else
				{
					alert('ouveram problemas ao fazer a requisição');
				}
			}
		}catch( e )
		{
			alert('exeção '+e.description);
		}
	}

	http_request.open('GET', url, true);
	http_request.send();
}

function init_http_request_product_post(content, url, id, name, description, price, cash_discount, labor, increment = false)
{
	if(window.XMLHttpRequest)
	{
		var http_request = new XMLHttpRequest();
	}else
	{
		var http_request = new ActiveXObject("Microsoft.XMLHTTP");
	}

	if(!http_request)
	{
		alert("Seu navegador não suporta o ajax por favor use navegadores como Chrome, FireFox");
		return;
	}

	http_request.onreadystatechange = function()
	{
		try{
			if(http_request.readyState === XMLHttpRequest.DONE)
			{
				if(http_request.status === 200)
				{
					if(!increment)
						content.innerHTML = http_request.responseText;
					else
						content.innerHTML += http_request.responseText;
				}else
				{
					alert('ouveram problemas ao fazer a requisição');
				}
			}
		}catch( e )
		{
			alert('exeção '+e.description);
		}
	}

	http_request.open('POST', url, true);
	http_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	http_request.send("id="+encodeURIComponent(id)+
					  "&description="+encodeURIComponent(description)+
					  "&name="+encodeURIComponent(name)+
					  "&price="+encodeURIComponent(price)+
					  "&cash_discount="+encodeURIComponent(cash_discount)+
					  "&labor="+encodeURIComponent(labor)+
					  "&btn_cadaster");
}

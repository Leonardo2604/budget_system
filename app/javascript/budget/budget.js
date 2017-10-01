content_list_products = document.getElementById('products');
content_budget = document.getElementById('products_list');

//=========================================== EVENTS =========================================
document.getElementsByName('text_search')[0].onkeyup = function(){ search(); } 
//========================================= FUNCTIONS ========================================
window.onload = function()
{
	init_http_request(content_list_products, '/budget_system/controller/budget/budget_controller.php?action=init_products');
	init_http_request(content_budget, '/budget_system/controller/budget/budget_controller.php?action=init_budget');
}

function clear_budget()
{
	init_http_request(content_budget, '/budget_system/controller/budget/budget_controller.php?action=clear_budget');
}

function search()
{
	text = document.getElementsByName('text_search')[0].value;
	init_http_request(content_list_products, '/budget_system/controller/budget/budget_controller.php?action=search_products&search='+text);
}

function add_to_budget(url)
{
	init_http_request(content_budget, url);
}

function remove_to_budget(url)
{
	init_http_request(content_budget, url);
}

function update_value_to_budget(indice)
{
	amount = document.getElementsByName('amount'+indice)[0].value;
	url = '/budget_system/controller/budget/budget_controller.php?qtd='+amount+'&indice='+indice;
	init_http_request(content_budget, url);
}

function init_http_request(content_list_products, url)
{
	if (window.XMLHttpRequest)
	{
   		var httpRequest = new XMLHttpRequest(); 
  	}else
    {
    	var httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
  	}

	if(!httpRequest)
	{
		alert('Seu navegador não suporta o ajax por favor use navegadores como Chrome, FireFox');
		return;
	}

	httpRequest.onreadystatechange = function()
	{
		try
		{
			if(httpRequest.readyState === XMLHttpRequest.DONE)
			{
				if(httpRequest.status === 200) 
				{
					content_list_products.innerHTML = httpRequest.responseText;
				}else
				{
					alert('ouveram problemas ao fazer a requisição');
				}
			}
		}catch ( e )
		{
			alert('exeção '+e.description);
		}
	}

	httpRequest.open('GET', url, true);
	httpRequest.send();
}
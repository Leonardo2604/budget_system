//============================ USER ===================================
document.getElementsByName('show-users')[0].onclick    = function(){ init_http_request("/budget_system/controller/user/user_controller.php?action=init_table"); }
document.getElementsByName('new-user')[0].onclick      = function(){ init_http_request("/budget_system/controller/user/user_controller.php?action=new_user&id=-1"); }
//============================ PRODUCT ===================================
document.getElementsByName('show-products')[0].onclick = function(){ init_http_request("/budget_system/controller/product/product_controller.php?action=init_table&page=1"); }
document.getElementsByName('new-product')[0].onclick   = function(){ init_http_request("/budget_system/controller/product/product_controller.php?action=new_product&id=-1"); }

section = document.getElementById('content');

function init_http_request(url)
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
		alert('Seu navegador não suporta o ajax por favor use navegadores como Chrome, FireFox');
		return;
	}

	http_request.onreadystatechange = function()
	{
		try
		{	
			if(http_request.readyState === XMLHttpRequest.DONE)
			{
				if(http_request.status === 200) 
				{
					section.innerHTML = http_request.responseText;	
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
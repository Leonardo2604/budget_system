modal = document.getElementById('modal');
section = document.getElementById('content');

function close_modal()
{
	modal.style.pointerEvents = 'none';
	modal.style.opacity = '0';
	modal.style.transform = 'translateY(-10px)';
}

function delete_user(id)
{
	var d = confirm('Você tem certeza que quer apagar o(a) usuario(a)');

	if(d)
	{
		action_user('delete', id);
	}
	else
	{
		return;
	}
}

function update_user()
{
	id = document.getElementsByName('id')[0].value;
	permission = document.getElementsByName('permission')[0].value
	token = document.getElementsByName('token')[0].value;
	name = document.getElementsByName('name')[0].value;
	email = document.getElementsByName('email')[0].value;
	password = document.getElementsByName('password')[0].value;
	confirm_password = document.getElementsByName('confirm_password')[0].value;
	
	if(name != "" && email != "" && password != "" && confirm_password != "" && id != "" && token != "" && password == confirm_password)
	{
		init_http_request_user_post(section, "/budget_system/controller/user/user_controller.php", name, email, password, confirm_password, id, permission, token);
		close_modal();
	}else
	{
		modal.innerHTML += "<p>Estão faltando dados no registro</p>";
		return;
	}
}
 
function create_user ()
{
	id = document.getElementsByName('id')[0].value;
	permission = document.getElementsByName('permission')[0].value
	token = document.getElementsByName('token')[0].value;
	name = document.getElementsByName('name')[0].value;
	email = document.getElementsByName('email')[0].value;
	password = document.getElementsByName('password')[0].value;
	confirm_password = document.getElementsByName('confirm_password')[0].value;
	
	if(name != "" && email != "" && password != "" && confirm_password != "" && id != "" && token != "" && password == confirm_password)
	{
		init_http_request_user_post(section, "/budget_system/controller/user/user_controller.php", name, email, password, confirm_password, id, permission, token, true);
		close_modal();
	}else
	{
		modal.innerHTML += "<p>Estão faltando dados no registro</p>";
		return;
	}
}

function action_user(action, id)
{
	switch (action)
	{
		case "show":
			if(modal.style.opacity != '1')
			{
				modal.style.pointerEvents = 'auto';
				modal.style.opacity = '1';
				modal.style.transform = 'translateY(10px)';
				init_http_request_user(modal, "/budget_system/controller/user/user_controller.php?action=show&id="+id);
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
				init_http_request_user(modal, "/budget_system/controller/user/user_controller.php?action=update&id="+id);
			}
			else
			{
				modal.style.pointerEvents = 'none';
				modal.style.opacity = '0';
				modal.style.transform = 'translateY(-10px)';
			}
			break;
		case "delete":
			init_http_request_user(section, "/budget_system/controller/user/user_controller.php?action=delete&id="+id);
			break;
	}
}

function init_http_request_user(content, url)
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

function init_http_request_user_post(content, url, name, email, password, confirm_password, id, permission, token, increment = false)
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
					  "&permission="+encodeURIComponent(permission)+
					  "&token="+encodeURIComponent(token)+
					  "&name="+encodeURIComponent(name)+
					  "&email="+encodeURIComponent(email)+
					  "&password="+encodeURIComponent(password)+
					  "&confirm_password="+encodeURIComponent(confirm_password)+
					  "&btn_register");
}

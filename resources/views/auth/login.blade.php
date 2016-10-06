<html>
	<head>
		<meta charset = "utf-8">
<meta name="_token" content="{!! csrf_token() !!}"/>
		<title>Система электронного голосования</title>
		<style>
			body {
				background-color: #ffffff;
			}
			
			#header {
				margin-top: 100px;
				width: 100%;
				text-align: center;	
				margin-bottom: 100px;
			}
			.floater {
				display: table;
				width: 100%;
				height: 100%;
				text-align: center;
			}
			.forms {
				display: table-cell;
			}
			mark {
				background: #ffec82
			}
			#results {
				position: absolute;
				width: 100%;
				text-align: center;
			}
		</style>
		<script type = "text/javascript" src ="{{ asset('jquery.js') }}" ></script>
		<script type = "text/javascript" src = "{{ asset('md5.js') }}"></script>
		<script type="text/javascript" language="javascript">
			//вызов скрипта для проверки введенных данных
			function call() {
				// определение анализируемых данных
				var password = $('#password').val();
				// шифруем пароль
				password = hex_md5 ( hex_md5 ( password ) );
				var msg = $('#email').serialize() + '&password=' + password;
				$.ajax ({
					type: 'POST',
					url: '/laraveltest/public/auth/login',
					data: msg,
					success: function (data) {
						// если данные неверные
						if (data == 0)
							$('#results').html('<mark>Неверный логин/пароль</mark>');
						else // проверка корректности куки
							if(data == 1)
								location.reload();
							else
								location.href='/laraveltest/public/meetings';
					},
					error: function (data) {
						alert('Ошибка при обращении к серверу');
					}
				});
			}
		</script>
	</head>
	<body>
		<h1 id = "header"><font face="Georgia" size="+3" color="Black">Авторизация</font></h1>
		<div class = "floater">
			<div class = "forms">
				
				<!-- используется ajax для передачи шифрованного пароля -->
				<form class = "enter" method = "post" action = "javascript:void(NULL);" onsubmit = "call()">
					<p>E-mail <input id = "email" required type = "text" name = "email" size = 25 placeholder = "Введите логин"/></p>
					<p>Пароль <input id = "password" required type = "password" name = "password" size = 25 placeholder = "Введите пароль"/></p>
					<p><label><input type = "checkbox" id = "anCompCheck" name = "anCompCheck" /> Чужой компьютер </label> </p> 
					<p><input class = "button" type = "submit" name = "enter" value = "Войти"/></p>
				</form>
				<form class = "register" method = "post" action = "http://onlinemkd.ru/register.php">
					<input class = "button" type = "submit" name = "register" value = "Зарегистрироваться"/>
				</form>
				<!--<form class = "unregblank" method = "get" action = "{{ url('unregblank') }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input class = "button" type = "submit" name = "unregblank" value = "Мне просто нужен бланк"/>
				</form> -->
				<a href = "{{ url('unregblank') }}">Мне просто нужен бланк</a>
				<p id = "results"></p>
			</div>
		</div>
		<script type="text/javascript">
			$.ajaxSetup({
				headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
			});
		</script>
	</body>
<html>
	<head>
		<meta charset = "utf-8">
		<meta name="_token" content="{!! csrf_token() !!}"/>
		<title>Выбор собрания</title>
		<style>
			body {
				background-color: #ffffff;
			}
			#exit {
				position: absolute;
				height: 400px;
				top: 25px;
				right: 5px;
				line-height: 35px;
			}
			#title {
				font-family: 'Times New Roman', Times, serif;
				font-size: 250%;
				position: absolute;
				width: 100%;
				text-align: center;
				top: 60px;
				margin-bottom: 60px;
			}
			.list {
				position: absolute;
				top: 200px;
				width: 100%;
				text-align: center;
			}
			table {
    			width: 99%; /* Ширина таблицы */
    			background: white; /* Цвет фона таблицы */
   				color: black; /* Цвет текста */
    			border-spacing: 1px; /* Расстояние между ячейками */
				align: center;
   			}
			#userinfo {
				font-family: 'Times New Roman', Times, serif;
				position: absolute;
				top: 0px;
				right: 5px;
			}
		</style>
	</head>
	<body>
		<p><div id = "title">Список собраний</div></p>
	<div id = "userinfo">
	<?php echo ''.
	Auth::user()->login . ' ' .
	Auth::user()->surname .' ' .
	Auth::user()->name . ' ' .
	Auth::user()->patronymic . ' ' .
	Auth::user()->phone .  ' '	.
	Auth::user()->email; ?>
	</div>
		<!--выход юзера из приложения-->
		<form id = "exit" action="{{ url('/auth/logout') }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<button type="submit">Выход</button>
		</form>

		</form>
		<div class = "list">
			<form method="GET" action="{{ url('getblank') }}">
				<!--<input type="hidden" name="_token" value="{{ csrf_token() }}">-->
				<select name="id_met">
					<option disabled>Выберите собрание</option>
					@foreach($meetings as $meet)
						@if (( $meet->date_end > date('Y-m-d H:i:s')) && ($meet->date_start <= date('Y-m-d H:i:s')))
							<option value={{$meet->id_meeting}}>{{$meet->date_start}}</option>
						@endif
					@endforeach
				</select>
				<input type='submit' value='Получить бланк'/>
			</form>
			
		</div>
	</body>
</html>

<html>
<head>
	<meta charset = "utf-8">
	<meta name="_token" content="{!! csrf_token() !!}"/>
	<script type="text/javascript" src="jquery.js"></script>
	<title>Выбор собрания</title>
	<style>
		body {
			background-color: #ffffff;
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
<p><div id = "title">Выберите адрес</div></p>
<div id = "userinfo">
</div>
<div class = "list">
	<form id="myForm">
		<select id="id_build" name="id_build">
			@foreach($building as $build)
				<option value={{$build->id_building}}>{{$build->address}}</option>
			@endforeach
		</select>
		<input type='submit' value='Подтвердить адрес'/>
	</form>
	<br>
	<br>
<div id="meets"></div>
<script>
	$(document).ready(function(){
		$('#myForm').submit(function(){
			$.ajax({
				type: "POST",
				url: "datmet",
				data: { id_build: $('#id_build option:selected').val() },
				success: function(html){
					$("#meets").html(html);
				}
			});
			return false;
		});
	});
	$.ajaxSetup({
		headers: {'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
	});
</script>
</div>
</body>
</html>

<?php
	require_once("dompdf/autoload.inc.php"); // Подключение библиотеки dompdf
	use Dompdf\Dompdf;
	
	include("phpqrcode/qrlib.php");

	$html = <<<HTML
	<html>
      <head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			<script type="text/php">
			if (isset($pdf) )
			{
				echo $PAGE_COUNT;
			}
			</script>
			<style type="text/css">
				*{
					margin:0; /* Отступ от края элемента */
					padding:0; /* Поля вокруг текста */
				 }
	
				 .layer1 
				{
					position: fixed; /* Абсолютное позиционирование */
					top: 10px;
					left: 10px; 
				}
				
				.layer2 
				{
					position: fixed; /* Абсолютное позиционирование */
					top: 10px;
					left: 760px;
				}
				
				.layer3 
				{
					position: fixed; /* Абсолютное позиционирование */
					top: 1090px;
					left: 10px; 
				}
				
				#header
				{	
					/* Отступы */
					margin-top: 50px;
					margin-right: 50px;
					margin-left: 50px;
					margin-bottom: 0;
					font-size: 90%;
					font-family: firefly, DejaVu Sans, sans-serif;
				}
				
				#container
				{	
					/* Отступы */
					margin-top: 0px;
					margin-right: 50px;
					margin-left: 50px;
					margin-bottom: 0;
					font-size: 90%;
					font-family: firefly, DejaVu Sans, sans-serif;
				}
								
				.avoid 
				{
					page-break-inside: auto;
				}
			</style>
      </head>
      <body>
HTML;

  
	// Подключение к бд
	$dbname = "mpolyakru_mkd";   
	$dblocation = "localhost";   
	$dbuser = "mpolyakru_mkd";   
	$dbpasswd = "test1234";

	// Создание запроса
	$dbcnx = new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
	$dbcnx->query("SET NAMES utf8");
	$dbcnx->query("SET CHARACTER SET utf8");
	$dbcnx->query("SET SESSION collation_connection = utf8");

	$Meeting = $_GET['id_meeting']; // id - собрания 
	$Id = $_GET['id_user']; // id - юзера
	$ThisPage = 0;// текущая страница
	$NumberQuestion = 1;// номер написанного вопроса

	if($dbcnx->connect_errno)
	{
		$html .= "Не могу соедениться";
	}
	
	// Подключение стилей
	$CssQuery = $dbcnx->query("select css_style from Markup_style, Meeting where Meeting.id_meeting = ".$Meeting.
							  "and Meeting.id_markup_style = Markup_style.id_markup_style");	
							  
    while($row = mysqli_fetch_array($CssQuery))
	{
		$Somegr[0] = "<style>";
		$Somegr[1] = "</style>";
		$SomeRes = $row['css_style'];
		$html .= preg_replace($Somegr, "", $SomeRes);
	}
		
		// Запрос для вывода шапки таблицы
		$joinQuery = $dbcnx->query("select *, ROUND((area_rosreestr*((share_numerator + 0.0)/share_denominator)), 2) as Data_Flat
									from Meeting join Building on Meeting.id_building = Building.id_building
									join Premise on Premise.id_building = Building.id_building
									join Property_rights on Premise.id_premise = Property_rights.id_premise
									join Owner on Property_rights.id_owner = Owner.id_owner  
									left join Users on Owner.id_owner = Users.id_owner
									where id = ".$Id." and id_meeting = ".$Meeting);//соединения с основными таблицами
		
		//	Запррс для выводоа вопросов для голосования	
		$Result1 = $dbcnx->query ("select id_question, sequence_no, question from Question 
								   where Question.id_meeting = ".$Meeting." order by sequence_no ASC");
									  
		
		// Расставляем 3 черных квадрата по углам
		$html .= '<div class="layer1">';
			$html .= '<img src = "black.jpg" width=25px height=20px>';
		$html .= '</div>';
		
		$html .= '<div class="layer2">';
			$html .= '<img src = "black.jpg" width=25px height=20px>';
		$html .= '</div>';
		
		$html .= '<div class="layer3">';
			$html .= '<img src = "black.jpg" width=25px height=20px>';
		$html .= '</div>';
		
		// ШАПКА
		$html .= '<div id="header">';
			$html .= '<table id ="t1" width="750px">';
				// Ячейка с данными
				$html .= '<tr><td>';
				$QRDATA = "V";
					while($row31 = mysqli_fetch_array($joinQuery))
					{
						$Max_symb = 10;
						$Max_Quest = 3;
						$id_owner = 0;
						$SomeMeeting = 0;
						$id_building = 0;
						$SomeQuest = 0;
						
						for($i = $Max_symb; $i > strlen(strval($Meeting))+1; $i--){// id-собрания
							$SomeMeeting .= 0; 
						}
						$SomeMeeting .= $Meeting;
						
						for($i = $Max_symb; $i > strlen(strval($row31['id_building']))+1; $i--){// id-постройки
							$id_building .= 0; 
						}
						$id_building .= $row31['id_building'];
						
						if($row31['id_owner'] != NULL )
						{
							for($i = $Max_symb; $i > strlen(strval($row31['id_owner']))+1; $i--){// id-пользователя
								$id_owner .= 0; 
							}
							$id_owner .= $row31['id_owner'];
						
							$QRDATA .= "1.0|".$id_owner."|";
							$html .= "<p>Адрес здания: ".$row31['address']."</p>";
							$html .= "<p>Ф.И.О. собственника: ".$row31['surname']." ".$row31['name']." ".$row31['patronymic']."</p>";
							$html .= "<p>Номер помещения (квартиры): ".$row31['number']."</p>";
							$html .= "<p>Площадь помещения (кв.м.): ".str_replace(".", ",", $row31['area_rosreestr'])."</p>";
							$html .= "<p>Количество голосов: ".str_replace(".", ",", $row31['Data_Flat'])."</p>";
							$html .= "<p>Номер свидетельства о праве собственности: ".$row31['regnumber']."</p>";
							$html .= "<p>Дата регистрации права собственности: ".$row31['regdate']."</p>";
							$html .='<p>Телефон: </p>';
							
						}
						else 
						{
							$QRDATA .= "1.1|0000000000|";
							$html .= "<p>Адреc здания: ___________________";
							$html .= "<br>Ф.И.О. собственника: ___________________ ";
							$html .= "<br>Номер помещения (квартиры):___________________";
							$html .= "<br>Площадь помещения (кв.м): ___________________";
							$html .= "<br>Количество голосов: ___________________";
							$html .= "<br>Номер свидетельства о праве собственности: ___________________";
							$html .= "<br>Дата регистрации права собственности: ___________________</p>";
							$html .='<p>Телефон: </p>';
						}
						$QRDATA .= $SomeMeeting."|".$id_building."|000|";
					}
					QRcode::png($QRDATA, 'ImageQR/TopQRPage.png', 'Q', 4,4);
					$html .='</td></tr>';
				$html .='</table>';
				$html .='<img src = "ImageQR/TopQRPage.png" class="big_qr" style="position:absolute;left:620px;right:10px;top:44px;width=195px height=195px">';
		$html .='</div>';
				
		// РАБОЧАЯ ОБЛАСТЬ 
		$html .='<div id="container">'; 
		

			$html .='<h1 align="center">Вопросы, поставленные на голосование:</h1><br>';

			$IndexResult = 1;// индекс текушего вопроса
			
			$html .= '<table id ="t2" width="725px">';
				while($rowResOne = mysqli_fetch_array($Result1))// вставка вопроса
				{				
				$joinQuery = $dbcnx->query("select *, ROUND((area_rosreestr*((share_numerator + 0.0)/share_denominator)), 2) as Data_Flat
									from Meeting join Building on Meeting.id_building = Building.id_building
									join Premise on Premise.id_building = Building.id_building
									join Property_rights on Premise.id_premise = Property_rights.id_premise
									join Owner on Property_rights.id_owner = Owner.id_owner  
									left join Users on Owner.id_owner = Users.id_owner
									where id = ".$Id." and id_meeting = ".$Meeting);//соединения с основными таблицами
					// формирование qr-кода по принципу: версия|id_owner|id_meeting|id_building|Номер вопроса|
					while($row31 = mysqli_fetch_array($joinQuery))
					{	
						$Max_symb = 10;
						$Max_Quest = 3;
						$id_owner = 0;
						$SomeMeeting = 0;
						$id_building = 0;
						$SomeQuest = 0;
						
						for($i = $Max_symb; $i > strlen(strval($Meeting))+1; $i--){// id-собрания
							$SomeMeeting .= 0; 
						}
						$SomeMeeting .= $Meeting;
						
						for($i = $Max_symb; $i > strlen(strval($row31['id_building']))+1; $i--){// id-постройки
							$id_building .= 0; 
						}
						$id_building .= $row31['id_building'];
						
						for($i = $Max_Quest; $i > strlen(strval($NumberQuestion))+1; $i--){// номера вопросов(максимум - 999)
							$SomeQuest .= 0; 
						}
						$SomeQuest .= $NumberQuestion;

						if($row31['id_owner'] != NULL )
						{
							for($i = $Max_symb; $i > strlen(strval($row31['id_owner']))+1; $i--){// id-пользователя
								$id_owner .= 0; 
							}
							$id_owner .= $row31['id_owner'];
						
							$QRDATA1 = "1.0|".$id_owner."|";
						}	
						else {
							$QRDATA1 = "1.1|0000000000|";
						}
						$QRDATA1 .= $SomeMeeting."|".$id_building."|".$SomeQuest."|";
					}
					QRcode::png($QRDATA1, 'ImageQR/QuestionQRNum'.$NumberQuestion.'.png', 'Q', 4,4);
					
					$html .='<tr>';
						$html .='<td>';
						
					$html .='<table class="avoid"  width="680px">';
					$html .='<tr>';
						$html .='<td colspan=5>';
						$html .='<strong>Вопрос  '.$NumberQuestion.':</strong> '.$rowResOne['question'].'</td>';					
					$html .='</tr>';
					
					$html .='<tr>';
						$html .='<td align=left>';
							$html .='<p>За</p>';
						$html .='</td>';												
						$html .='<td width=50px></td>';
						
						$html .='<td align=left>';
							$html .='<p style="position:absolute;left:250px">Против</p>';
						$html .='</td>';
						$html .='<td width=50px></td>';
						
						$html .='<td align=left>';
							$html .='<p style="position:absolute;left:450px">Воздерж.</p>';
						$html .='</td>';
						
						$html .='<td>';
							$html .='<img src = ImageQR/QuestionQRNum'.$NumberQuestion.'.png  width=95px height=95px style="position:absolute;left:630px;">';	
							$html .='<br>';
						$html .='</td>';	
					$html .='</tr>';
					
					$html .='<tr>';
						$html .='<td align=left>';
							$html .='<img src = form.png width=50px height=40px>';
						$html .='</td>';
						$html .='<td width=50px></td>';
						
						$html .='<td align=left>';
							$html .='<img src = form.png width=50px height=40px style="position:absolute;left:250px">';
						$html .='</td>';
						$html .='<td width=50px></td>';
						
						$html .='<td align=left>';
							$html .='<img src = form.png width=50px height=40px style="position:absolute;left:450px">';
						$html .='</td>';
						//$html .='<td width=50px></td>';
					$html .='</tr>';
					$html .='<br><br>';
					
					$html .='</table>';
					$html .='</td>';
					$html .='</tr>';
							
					$NumberQuestion++;
				}
				mysqli_free_result($joinQuery);
				mysqli_free_result($Result1);
			$html .='</table></div>';	
		mysqli_close($dbcnx);

	$html .='</body></html>';


	$dompdf = new Dompdf();
	$dompdf->load_html($html); 
	$dompdf->setPaper('A4', 'portrait');
	$dompdf->render();
	
	$canvas = $dompdf->get_canvas();
	$canvas->page_text(50, 820, "Страница {PAGE_NUM} из {PAGE_COUNT}",$font, 10, array(0,0,0));
	$canvas->page_text(190, 820, "Дата___________Подпись___________",$font, 10, array(0,0,0));
	
	$dompdf->stream("blank.pdf", array("Attachment" => 0));
?>
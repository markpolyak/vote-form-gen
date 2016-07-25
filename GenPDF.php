<?php
	require_once("dompdf/autoload.inc.php"); // Подключение библиотеки dompdf
	use Dompdf\Dompdf;
	
	include("phpqrcode/qrlib.php");
	
	$html = <<<HTML
	<html>
      <head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<style type="text/css">
				*{
					margin:0; /* Отступ от края элемента */
					padding:0; /* Поля вокруг текста */
				 }
HTML;

	$dbname = "mpolyakru_mkd";   
	$dblocation = "localhost";   
	$dbuser = "mpolyakru_mkd";   
	$dbpasswd = "test1234"; 

	$dbcnx = new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
	$dbcnx->query("SET NAMES utf8");
	$dbcnx->query("SET CHARACTER SET utf8");
	$dbcnx->query("SET SESSION collation_connection = utf8");
	
	$Meeting = 2; // id - собрания 
	$Id = 2; // id - юзера
	$ThisPage = 1;// текущая страница
	
	if($dbcnx->connect_errno)
	{
		$html .= "Не могу соедениться";
	}
	
	$CssQuery = $dbcnx->query("select css_style from Markup_style, Meeting where Meeting.id_meeting = ".$Meeting.
				" and Meeting.id_markup_style = Markup_style.id_markup_style");	
				
    while($row = mysqli_fetch_array($CssQuery)){
		$SomeRes = $row['css_style'];
		$Somegr[0] = "<style>";
		$Somegr[1] = "</style>";
		$html .= preg_replace($Somegr, "", $SomeRes);
	}
	$html .= <<< HTML
				@font-face 
				{
				  font-family: 'Open Sans';
				  font-style: normal;
				  font-weight: normal;
				  src: url(http://themes.googleusercontent.com/static/fonts/opensans/v8/cJZKeOuBrn4kERxqtaUH3aCWcynf_cDxXwCLxiixG1c.ttf) format('truetype');
				}	
				
				#header
				{	
					/* Отступы */
					margin-top: 50px;
					margin-right: 50px;
					margin-bottom: 0;
					margin-left: 50px;
					font-family: firefly, DejaVu Sans, sans-serif;
				}	
				
				#container
				{	
					/* Отступы */
					margin-top: 0px;
					margin-right: 50px;
					margin-bottom: 0;
					margin-left: 50px;
					font-family: firefly, DejaVu Sans, sans-serif;
				}	

				#footer
				{	
					/* Отступы */
					margin-right: 50px;
					margin-bottom: 0;
					margin-left: 50px;
					position: fixed;
					text-align: center;
					font-family: firefly, DejaVu Sans, sans-serif;	
				}
			
				#footer table 
				{
					text-align: center;
				}
				
				.layer1 
				{
					position: absolute; /* Абсолютное позиционирование */
					top: 2px;
					left: 5px; 
					
				}
				
				.layer2 
				{
					position: absolute; /* Абсолютное позиционирование */
					top: 2px;
					right: 5px; 
				}
				
				.layer3 
				{
					position: absolute; /* Абсолютное позиционирование */
					bottom: 2px;
					left: 5px; 
				}
				
				#t2
				{
					font-size: 90%;
				}
            </style>
      </head>
      <body>
HTML;

	$html .= '<div class="layer1">';
	$html .= '<img src = "black.jpg" width=25px height=20px>';
	$html .= '</div>';
	$html .= '<div class="layer2">';
	$html .= '<img src = "black.jpg" width=25px height=20px>';
	$html .= '</div>';
	$html .= '<div class="layer3">';
	$html .= '<img src = "black.jpg" width=25px height=20px>';
	$html .= '</div>';
	
	$html .= '<div id="header">';
    $html .= '<table id ="t1" width="755px">';
	$html .= '<tr><td>';
	
	$joinQuery = $dbcnx->query("select *, ROUND((area_rosreestr*((share_numerator + 0.0)/share_denominator)), 2) as Data_Flat
		from Meeting join Building on Meeting.id_building = Building.id_building
		join Premise on Premise.id_building = Building.id_building
		join Property_rights on Premise.id_premise = Property_rights.id_premise
		join Owner on Property_rights.id_owner = Owner.id_owner  
		left join Users on Owner.id_owner = Users.id_owner
		where id = ".$Id." and id_meeting = ".$Meeting);//соединения с основными таблицами
	$QRDATA = "V";
	while($row31 = mysqli_fetch_array($joinQuery))
	{									
		if($row31['id_owner'] != NULL )
		{
			$QRDATA .= "1.0|".$row31.['id_owner']."|";
			if($ThisPage == 1){
				$html .= "<p>Адрес здания: ".$row31['address'];
				$html .= "<br>Ф.И.О. собственника: ".$row31['surname']." ".$row31['name']." ".$row31['patronymic']." ";
				$html .= "<br>Номер помещения (квартиры): ".$row31['number'];
				$html .= "<br>Площадь помещения (кв.м.): ".str_replace(".", ",", $row31['area_rosreestr']);
				$html .= "<br>Количество голосов: ".str_replace(".", ",", $row31['Data_Flat']);
				$html .= "<br>Номер свидетельства о праве собственности: ".$row31['regnumber'];
				$html .= "<br>Дата регистрации права собственности: ".$row31['regdate']."</p>";	
			}
		}
		else {
			$QRDATA .= "1.1|0|";
			if($ThisPage == 1){
				$html .= "<p>Адреc здания: ___________________";
				$html .= "<br>Ф.И.О. собственника: ___________________ ";
				$html .= "<br>Номер помещения (квартиры):___________________";
				$html .= "<br>Площадь помещения (кв.м): ___________________";
				$html .= "<br>Количество голосов: ___________________";
				$html .= "<br>Номер свидетельства о праве собственности: ___________________";
				$html .= "<br>Дата регистрации права собственности: ___________________</p>";
			}
		}
		$QRDATA .= $Meeting."|".$row31['id_building']."|".$ThisPage."|";
	}
	mysqli_free_result($result1);
	mysqli_free_result($result2);
	mysqli_free_result($joinQuery);		
	QRcode::png($QRDATA, 'ImageQR/test.png', 'L', 4,4);// Записать версию алгоритма(первые 5 символов(v1.0)), id-owner, id-meeting, id-building, колличество страниц пример: v1.0 | 1234567 | 1234789 | 875938759				
			
	
	$html .='<p>Телефон: </p>';	
	$html .='</td>';
	$html .='<td align="center"><img src = "test.png"></td>';
	$html .='</tr></table></div>';
	
	$html .='<div id="container">'; 
	$html .='<h1 align="center">Вопросы, поставленные на голосование:</h1><br>';
	$html .='<table id ="t2" width="745px">';
			         
	$NumberQuestion = 1;
	$Result1 = $dbcnx->query("select id_question, sequence_no, question from Question 
	where Question.id_meeting = ".$Meeting." order by sequence_no ASC");
						
	while($rowResOne = mysqli_fetch_array($Result1))
	{
		$QRDATA = $rowResOne['id_question'];
		QRcode::png($QRDATA, 'test'.$NumberQuestion.'.png', 'L', 2.5,2.5);
		$html .='<tr>';
		$html .='<td colspan=6>';
		$html .='<strong>Вопрос  '.$NumberQuestion.':</strong> '.$rowResOne['question'].'</td>';					
		$html .='</tr>';
		
		$html .='<tr>';
		$html .='<td align=center>';
		$html .='<p>За</p>';
		$html .='</td><td width=50px>';
		$html .='</td>';
		$html .='<td align=center>';
		$html .='<p>Против</p>';
		$html .='</td><td width=50px></td>';
		$html .='<td align=center>';
		$html .='<p>Воздерж.</p>';
		$html .='</td><td width=50px></td>';
		$html .='</tr>';
		$html .='<tr>';
		$html .='<td align=center>';
		$html .='<img src = form.png width=50px height=40px>';
		$html .='<td width=50px></td>';
		$html .='<td align=center>';
		$html .='<img src = form.png width=50px height=40px>';
		$html .='<td width=50px></td>';
		$html .='<td align=center>';
		$html .='<img src = form.png width=50px height=40px>';
		$html .='<td width=50px></td>';
		$html .='<td>';
		$html .='<img src = ImageQR/test'.$NumberQuestion.'.png>';		
		$html .='</td>';									
		$html .='</tr>';

		$NumberQuestion++;
	}
	mysqli_free_result($Result1);
	mysqli_close($dbcnx);	
				
	$html .='</table></div>';
	
	$html .='<div id="footer">'; 
	$html .='<table cellpadding="0" cellspacing="0" width="100%" border="0">';
	$html .='<tr><td width="50%">';
	$html .='';
	$html .='</td>';
	$html .='<td width="50%">';
	//$html .='Дата___________Подпись___________';
	$html .='</td>';
	$html .='</tr></table>';
	$html .='</div>';
	$html .='</body></html>';
											
	$dompdf = new Dompdf();
	$dompdf->load_html($html); 
	$dompdf->setPaper('A4', 'portrait');
	$dompdf->render();
	
	$canvas = $dompdf->get_canvas();
	$canvas->page_text(50, 820, "Страница {PAGE_NUM} из {PAGE_COUNT}",$font, 10, array(0,0,0));
	$dompdf->stream("blank.pdf", array("Attachment" => 0));
?>



		
			
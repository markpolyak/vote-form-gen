<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<title>Бланк</title>
		<style>
		*{
			font-family: Thimes New Roman; /* Рубленый шрифт заголовка */
		    margin:0; /* Отступ от края элемента */
			padding:0; /* Поля вокруг текста */
		 }
		 
		#header
		{	
			/* Отступы */
			margin-top: 50px;
			margin-right: 50px;
			margin-bottom: 0;
			margin-left: 50px;
		}	
		
		#container
		{	
			/* Отступы */
			margin-top: 0px;
			margin-right: 50px;
			margin-bottom: 0;
			margin-left: 50px;
		}	
		
		#footer
		{	
			/* Отступы */
			margin-top: 505px;
			margin-right: 50px;
			margin-bottom: 10;
			margin-left: 50px;
		}	
		p
		{
			font-size: 120%;
		}
		</style>
	</head>
	
	<body>
		<!--Шапка-->
		<div id="header">
			<table id ="t1" width="700px">
				<tr>
					<td>
						<?php
							header('Content-Type: text/html; charset=utf8');
							include("phpqrcode/qrlib.php");
							$dbname = "mpolyakru_mkd";   
							$dblocation = "localhost";   
							$dbuser = "mpolyakru_mkd";   
							$dbpasswd = "test1234";   
			
							$dbcnx = new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
							$dbcnx->query("SET NAMES utf8");
							$dbcnx->query("SET CHARACTER SET utf8");
							$dbcnx->query("SET SESSION collation_connection = utf8");
							
							if($dbcnx->connect_errno){
								echo "Не могу соедениться";
							}	
							//варианты генерации бланков:
							// 1 - собственники не привязаны к сайту (id-user = 0 или пустой) - генерируется пустой бланк(адресс дома уже заполнен)
							// 2 - id-user не равен 0 или не пустой, смотрим записи: premise и owner. Если id-owner не задан, пункт первый
							// Иначе - берется фио из owners и находим все помещения, которыми он владеет(дом опред по собранию), расчитывается площадь и т.п.
							$Meeting = 2;
							$ThisPage = 1;
							$Id = 2; //создать одинбольшой join со всеми таблицами
							$resultVariable1 = $dbcnx->query("select id from Building, Meeting, Users, Premise 
									where Meeting.id_meeting = ".$Meeting." and Meeting.id_building = Building.id_building
									and Users.id = ".$Id." and Premise.id_building = Building.id_building");
							$resultVariable2 = $dbcnx->query("select id_meeting from Building, Meeting, Users, Premise 
									where Meeting.id_meeting = ".$Meeting." and Meeting.id_building = Building.id_building
									and Users.id = ".$Id." and Premise.id_building = Building.id_building");
							$resultVariable3 = $dbcnx->query("select id_owner from Users, Owner 
									where Users.id = ".$Id." and Users.id_owner = Owner.id_owner");
							$result1 = $dbcnx->query("select Building.Address from Building, Meeting, Users, Premise 
									where Meeting.id_meeting = ".$Meeting." and Meeting.id_building = Building.id_building
									and Users.id = ".$Id." and Users.id_premise = Premise.id_premise and Premise.id_building = Building.id_building"); 		
							$result2 = $dbcnx->query("select Owner.name, Owner.patronymic, Owner.surname, Owner.SNILS from Owner, Users, Premise, Building, Meeting
									where Users.id = ".$Id." and Owner.id_owner = Users.id_owner and Premise.id_premise = Users.id_premise and Building.id_building = Premise.id_building
									and Meeting.id_building = Building.id_building and Meeting.id_meeting = ".$Meeting);// приведение к float
							$result31 = $dbcnx->query("select distinct Building.id_building, Premise.number, Premise.area_rosreestr, ROUND((area_rosreestr*((share_numerator + 0.0)/share_denominator)), 2) as Data_Flat, Property_rights.regnumber, Property_rights.regdate 
									from Building, Meeting, Users, Premise, Property_rights, Owner 
									where Meeting.id_meeting = ".$Meeting." and Meeting.id_building = Building.id_building
									and Premise.id_building = Building.id_building and Users.id = ".$Id." and Users.id_premise = Premise.id_premise
									and Premise.id_premise = Property_rights.id_premise and Users.id_owner = Owner.id_owner and Property_rights.id_owner = Owner.id_owner");/*from Meeting inner join Building on Meeting.id_building = Building.id_building inner join Premise on Building.id_building = Premise.id_building
									inner join User on Premise.id_premise = User.id_premise inner join Owner on Owner.id_owner = User.id_owner as LinkData, Property_rights
									*/
							$rowVar1 = $resultVariable1->num_rows;
							$rowVar2 = $resultVariable2->num_rows;
							$rowVar3 = $resultVariable3->num_rows;
							$QRDATA = "V";
							while($row1 = mysqli_fetch_array($result1))
							{
								if(($rowVar1 == 0 and $rowVar2 != 0) or $rowVar3 == 0){
									$QRDATA .= "1.0";																				
									echo "<p>Адрес здания: ".$row1['Address']."</p>";	
								}
								else {
									$QRDATA .= "1.1";
									echo "<p>Адрес здания: ____________</p>";	
								}
							}
							while($row2 = mysqli_fetch_array($result2))
							{
								echo "<p>Ф.И.О. собственника: ";
								if(($rowVar1 == 0 and $rowVar2 != 0) or $rowVar3 == 0)
									echo $row2['surname']." ".$row2['name']." ".$row2['patronymic'];
								else 
									echo "___________________";
								echo "</p>";
							}
							while($row31 = mysqli_fetch_array($result31))
							{									
								if(($rowVar1 == 0 and $rowVar2 != 0) or $rowVar3 == 0)
								{
									$QRDATA .= "|".$row31.['id_owner']."|";
									echo "<p>Номер помещения(квартиры): ".$row31['number'];
									echo "<br>Площадь помещения(кв.м): ".$row31['area_rosreestr'];
									echo "<br>Количество голосов: ".$row31['Data_Flat'];
									echo "<br>Номер свидетельства о праве собственности: ".$row31['regnumber'];
									echo "<br>Дата регистрации права собственности: ".$row31['regdate']."</p>";		
								}
								else {
									$QRDATA .= "|0|";
									echo "<p>Номер помещения(квартиры):___________________";
									echo "<br>Площадь помещения(кв.м): ___________________";
									echo "<br>Количество голосов: ___________________";
									echo "<br>Номер свидетельства о праве собственности: ___________________</p>";
									echo "<br>Дата регистрации права собственности: ___________________</p>";
								}
								$QRDATA .= $Meeting."|".$row31['id_building'];
								$QRDATA .= "|".$ThisPage."|";
								
							}
							mysqli_free_result($result1);
							mysqli_free_result($result2);
							mysqli_free_result($result31);		
							QRcode::png($QRDATA, 'test.png', 'L', 4,4);// Записать версию алгоритма(первые 5 символов(v1.0)), id-owner, id-meeting, id-building, колличество страниц пример: v1.0 | 1234567 | 1234789 | 875938759				
				
						?>
					<p>Телефон______________________ </p>

					</td>
					<td align="center"><img src = "test.png"></td>
				</tr>
			</table>
		</div>
		
		<!--Рабочая область-->
		<!--Рабочая область-->
		<div id="container"> 
			<h1 align="center">Вопросы, поставленные на голосование:</h1><br>
			<table id ="t2" width="700px">
				<?php
				        //Таблица Markup_style - описание стилей, использующихся в размете html- запросов. Содержимое вставить в шапку. Соединена с Meeting по 
						$Meeting = 2;
						$NumberQuestion = 1;
						$Result1 = $dbcnx->query("select id_question, sequence_no, question from Question 
						where Question.id_meeting = ".$Meeting." order by sequence_no ASC");//
						
						while($rowResOne = mysqli_fetch_array($Result1)){
							$QRDATA = $rowResOne['id_question'];
							QRcode::png($QRDATA, 'test'.$NumberQuestion.'.png', 'L', 2.5,2.5);
							echo "<tr>
									<td colspan='6'><strong>Вопрос  ".$NumberQuestion.": </strong>".$rowResOne['question']."</td>					
							     </tr>";
							echo "<tr>
									<td align='center'><p>За</p></td><td width='50px'></td>
									<td align='center'><p>Против</p></td><td width='50px'></td>
									<td align='center'><p>Воздерж.</p></td><td width='50px'></td>
								</tr>";
							echo "<tr>
									<td align='center'><img src = 'form.png' width='50px' height='40px'><td width='50px'></td>
									<td align='center'><img src = 'form.png' width='50px' height='40px'><td width='50px'></td>
									<td align='center'><img src = 'form.png' width='50px' height='40px'><td width='50px'></td>
									<td> <img src = 'test".$NumberQuestion.".png'> </td>									
								</tr>";

							$NumberQuestion++;
						}
						mysqli_free_result($Result1);
						mysqli_close($dbcnx);	
				?>
			</table>		
		</div>
		
		
		<!--Подвал--> 
		<div id="footer"> 
			<p align="center">Дата___________Подпись___________</p>
		</div>
	</body>
</html>
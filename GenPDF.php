<?php
require_once("dompdf/dompdf_config.inc.php"); // Подключение библиотеки dompdf
include("phpqrcode/qrlib.php");

function pdf_create($html,$filename,$paper,$orientation,$stream=true)
{
	$dompdf = new DOMPDF(); // Создаем обьект
	$dompdf->load_html($html); // Загружаем в него наш html код
	$dompdf->render(); // Создаем из HTML PDF
	
    $canvas = $dompdf->get_canvas();
    $font = Font_Metrics::get_font("Helvetica");

    $canvas->page_text(50, 768, "Page {PAGE_NUM}",
                   $font, 8, array(0,0,0));
	$dompdf->stream($filename.".pdf"); // Выводим результат (скачивание)
	
}
$filename='Blank'; // Имя создаваемого файла
$dompdf = new DOMPDF();
$html=file_get_contents('blank_html.php'); // Считываем содержимое html-кода из файла в переменную
pdf_create($html,$filename,'A4','portrait'); 

?>

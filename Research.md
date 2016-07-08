# ������ ���������� �������

## ���������� ��� ��������� pdf-������ � ������� PHP

### ���������� FPDF 
http://www.fpdf.org/

����� ��������� ������ ������� ���� �� PHP 5.1. ����� �������� ��������� UTF-8.

#### �����������:

- Choice of measure unit, page format and margins
- Page header and footer management
- Automatic page break
- Automatic line break and text justification
- Image support (JPEG, PNG and GIF)
- Colors
- Links
- TrueType, Type1 and encoding support
- Page compression
	
#### ����������:

- ��� ������ � ���� ������� ��������� ��������� � �������������� �������, ��� ��� FPDF ��� ���������� ������������ ��������������.
	
#### ����������� ����������:
```
  require('fpdf.php');
```

#### ������ ������������� ���������� ��� ��������� pdf.

�� �������� ����� ������ FPDF:

```
$pdf= new FPDF();
```

����������� FPDF ��������� ��������� ���������:

- ���������� �������� (P or L) ������� ��� ���������
- ����������� (pt,mm,cm ��� in)
- ������ ��������� (A3, A4, A5, Letter and Legal)

����� �� ��������� ��������� �������� ���������:

```
$pdf->SetAuthor('Irina Panova');
$pdf->SetTitle('FPDF tutorial');
```

����� ��� ����� ���������, �� ������������� ��� �� �������� ��������:

```
$pdf->SetFont('Helvetica','B',20); // SetFont 3 ���������: �������� ������,�����,������
$pdf->SetTextColor(50,60,100); // ������������� ���� ������ ��� ����� ���-��
```

����� ������������ ����� ������ �����, ��������� ������� `AddFont()`.
���� ����� ���� ����������� � RGB ��� grey scale.

������ ����� ������� �������, ��������� � �������� �������:

```
	$pdf->AddPage('P');
	$pdf->SetDisplayMode('real','default');
```

� ������� `AddPage()` ����� �������� ��������� �P� ��� �L� ��� �������� ���������� ��������. ������� SetDisplayMode ���������� ��� ����� ���������� ��������. ����� ���������� ��������� ���������� � ��������. 

����� ����������, ��������� ������� `Output()`:

```
$pdf->Output('example1.pdf','I');
```

����� ������� ��� ����� � ��������� ������, � ������ ������ `'I'`. `'I'`-�������� ������� ��������� � �������.

����� ��������� FPDF ����� ������� header � footer ���������:

```
require('fpdf.php');
class PDF extends FPDF
{
	function Header()
  		{
    			$this->Image('logo.png',10,8,33);
    			$this->SetFont('Helvetica','B',15);
    			$this->SetXY(50, 10);
    			$this->Cell(0,10,'This is a header',1,0,'C');
  		}

  		function Footer()
  		{
  		  	$this->SetXY(100,-15);
    			$this->SetFont('Helvetica','I',10);
    			$this->Write (5, 'This is a footer');
  		}
	}

	$pdf=new PDF();
	$pdf->AddPage();
	$pdf->Output('example2.pdf','D');
```


### ���������� DOMPDF
���������� DOMPDF - ��� ����������, ��������� ������������ PDF �� HTML-�������� � CSS-������ (� ����������� ������� ��� �����, ����������� � CSS 2.1 � ���������� ��������� ������� CSS3). 

  ����������  Git ��� ��������� Dompdf.
  ���������� ������� PHP >= 5.0 � ��������������� ������������ mbstring � DOM. 
  ����� ��� ������� ��������� �������, ������� ������ �������� �� ����������� �����������.

#### �����������:

- Handles most CSS 2.1 and a few CSS3 properties, including @import, @media & @page rules
- Supports most presentational HTML 4.0 attributes
- Supports external stylesheets, either local or through http/ftp (via fopen-wrappers)
- Supports complex tables, including row & column spans, separate & collapsed border models, individual cell styling
- Image support (gif, png (8, 24 and 32 bit with alpha channel), bmp & jpeg)
- No dependencies on external PDF libraries, thanks to the R&OS PDF class
- Inline PHP support
- Basic SVG support

#### �������� ������, ������� ����������� ������� PDF ��������:
```
<?php
    set_include_path(get_include_path() . PATH_SEPARATOR . "/path/to/dompdf");
    require_once "dompdf_config.inc.php";

    $dompdf = new DOMPDF();

    $html = <<<'ENDHTML'

    <html>
        <body>
            <h1>Hello Dompdf</h1>
        </body>
    </html>

    ENDHTML;

    $dompdf->load_html($html);
    $dompdf->render();

    $dompdf->stream("hello.pdf");
?>
```

#### ������: 
 �������� �� ��, ��� Dompdf �������� ����������, ��� �� �������� ��������� ������������� �������� ��� ��������� PDF ����������; 
 ��� ��� �� ����� ������������ ����������� � ��������. Dompdf �� ����� ������� ��������� � ����� ������������ HTML 
 � ������� ������� ����� ����� �������� � ������������ ������. ��������� ������� ������� CSS, ����� ��� float �� ��������� ��������������.
 � ������, ��������� CSS 3 ����� ����������. ���� ��� ���������� �������, ������� �� �������������� � Dompdf, ��� ����� ������ � ������� wkhtmltopdf. 

### ���������� TCPDF 
http://www.tcpdf.org/

#### �����������:
- no external libraries are required for the basic functions;
- all standard page formats, custom page formats, custom margins and units of measure;
- UTF-8 Unicode and Right-To-Left languages;
- TrueTypeUnicode, OpenTypeUnicode, TrueType, OpenType, Type1 and CID-0 fonts;
- font subsetting;
- methods to publish some XHTML -  CSS code, Javascript and Forms;
- images, graphic (geometric figures) and transformation methods;
- supports JPEG, PNG and SVG images natively, all images supported by GD (GD, GD2, GD2PART, GIF, JPEG, PNG, BMP, XBM, XPM) and all images 		supported via - ImagMagick (http: www.imagemagick.org/www/formats.html)
- 1D and 2D barcodes: CODE 39, ANSI MH10.8M-1983, USD-3, 3 of 9, CODE 93, USS-93, Standard 2 of 5, Interleaved 2 of 5, CODE 128 A/B/C, 2 and 5 		Digits UPC-Based Extention, EAN 8, EAN 13, UPC-A, UPC-E, MSI, POSTNET, PLANET, RMS4CC (Royal Mail 4-state Customer Code), CBC (Customer Bar 		Code), KIX (Klant index - Customer index), Intelligent Mail Barcode, Onecode, USPS-B-3200, CODABAR, CODE 11, PHARMACODE, PHARMACODE TWO-TRACKS, 	Datamatrix ECC200, QR-Code, PDF417;
- ICC Color Profiles, Grayscale, RGB, CMYK, Spot Colors and Transparencies;
- automatic page header and footer management;
- document encryption up to 256 bit and digital signature certifications;
- transactions to UNDO commands;
- PDF annotations, including links, text and file attachments;
- text rendering modes (fill, stroke and clipping);
- multiple columns mode;
- no-write page regions;
- bookmarks and table of content;
- text hyphenation;
- text stretching and spacing (tracking/kerning);
- automatic page break, line break and text alignments including justification;
- automatic page numbering and page groups;
- move and delete pages;
- page compression (requires php-zlib extension);
- XOBject templates;
- PDF/A-1b (ISO 19005-1:2005) support.

#### ���������� ����������:
```
  require_once('tcpdf/tcpdf.php');
```
#### ������� ��������� ������ TCPDF:
```
	// ������� ������ TCPDF - �������� � ��������� ������� A4
	// ���������� - �������
	// ������� ��������� - ����������
	// ��������� - UTF-8
	$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
	// ������� �� ������ ������ ����� � ����� ���������
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	$pdf->SetMargins(20, 25, 25); // ������������� ������� (20 �� - �����, 25 �� - 	������, 25 �� - ������)
	$pdf->AddPage(); // ������� ������ ��������, �� ������� ����� ����������
```


## ���������� ��� ��������� QR-�����
### ���������� PHP QrCode
���������� PHP QrCode - ����������, ���������� � PHP ��� ������������� QR-�����, ������� ��� �������� ����������� �� ��������� ������, ������   	                   ������������ ������������ ���������� GD2.

�����������:
- Supports QR Code versions (size) 1-40
- Numeric, Alphanumeric, 8-bit and Kanji encoding. 
- Implemented purely in PHP, no external dependencies except GD2
- Exports to PNG, JPEG images, also exports as bit-table
- TCPDF 2-D barcode API integration
- Easy to configure
- Data cache for calculation speed-up
- Provided merge tool helps deploy library as a one big dependency-less file, simple to "include and do not wory"
- Debug data dump, error logging, time benchmarking
- API documentation
- Detailed examples
- 100% Open Source, LGPL Licensed

#### ������� ������:
```
<?php
include "phpqrcode/qrlib.php";
$param = $_GET['url'];  
QRcode::png($param); // ���������� qr-��� � ������� �������� ��� png-�����
?>
```

#### �������� ������� ��������� QR-����:  
```
	static png ($text,
   		    $outfile=false,
		    $level=QR_ECLEVEL_L,
  		    $size=3,
 		    $margin=4,
  		    $saveandprint=false
   		   )
```
`$text` - ������ ��� �����������, \
`$outfile` - ��� ����� ��� ���������� png-����������� (���� `false`, �� ����� � ������� � ������������ �����������), \
`$level` - ������� ��������� ������ (`QR_ECLEVEL_L`, `QR_ECLEVEL_M`, `QR_ECLEVEL_Q` ��� `QR_ECLEVEL_H`), \
`$size` - ������ ������� (��������� ��� ������� ������������ �������, ������� ���������, ���� ����������� ���������� ��������), \
`$margin` - ������ ����� �������, \
`$saveandprint` - ���� `true`, �� ���������� � ����� � �������, � ���������� � ����, ����� ������ ���������� � ���� (������� ������ ��� ������������� � ���� � `$outfile`).


## Links
### General
- Wikipedia: [Optical scan voting system](https://en.wikipedia.org/wiki/Optical_scan_voting_system)
- Google search: [ballot image recognition](https://www.google.ru/?gws_rd=ssl#newwindow=1&q=ballot+image+recognition)
### Publications on voting form recognition
- [Document Analysis Techniques for Automatic Electoral Document Processing: A Survey](http://www.cvc.uab.es/~afornes/publi/chap_lncs/2015_LNCS_JIToledo.pdf)
- [Efficient User-Guided Ballot Image Verification](https://cseweb.ucsd.edu/~kmowery/papers/ballot-image-verification.pdf)
- [Style-Based Ballot Mark Recognition](http://www.cse.lehigh.edu/~lopresti/Publications/2009/icdar09b.pdf)

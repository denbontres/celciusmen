<?php
include_once APPPATH . '/third_party/fpdf/fpdf.php';
class PDF extends FPDF{
    function Header()
	{
		$this->SetDisplayMode(100,'default');
        $this->Image(base_url('resource/logo.png'),15,10,20,20);
        $this->SetFont('Arial','B',16);
        $this->Cell(190,7,'CELCIUS',0,1,'C');
        $this->SetFont('Arial','B',12);
        $this->Cell(190,7,'Jl. TAPOS No 10 Palingam',0,1,'C');
        $this->SetFont('Arial','i',9);
        $this->Cell(190,7,'Telpon : 089525761176, FAX : 898989, Email : admin@admin.com',0,1,'C');
        $this->SetLineWidth(1);
        $this->Line(10,36,195,36);
        $this->SetLineWidth(0);
        $this->Line(10,37,195,37);

        $this->Cell(10,7,'',0,1);
        $this->Cell(10,7,'',0,1);
	}
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Halaman '.$this->PageNo().'',0,0,'R');
    }
}
?>
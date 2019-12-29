<?php
require('fpdf182/fpdf.php');

class PDF extends FPDF{
    public function Header()
    {
        // Logo
        $this->Image('cropped-Logo-RLG-2014-Ecriture-noire.jpg', 15, 15, 75);
        $this->SetLeftMargin(15);
        $this->SetXY(15, 50);
// Police Arial gras 15
        $this->SetFont('Arial', '', 8);
// Décalage à droite

        $w = $this->GetStringWidth('PRESIDENT : ');
        $this->Cell($w, 5, 'PRESIDENT : ', 0, 0);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(45, 5, 'Dr Jean Marc CHAPPLAIN', 0, 1);

        $this->SetFont('Arial', '', 8);
        $w = $this->GetStringWidth('DIRECTEUR : ');
        $this->Cell($w, 5, 'DIRECTEUR : ', 0, 0);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(45, 5, 'Patrice PRETER', 0, 1);

        $this->SetFont('Arial', '', 8);
        $w = $this->GetStringWidth('COORDINATEUR MEDICAL : ');
        $this->Cell($w, 5, 'COORDINATEUR MEDICAL : ', 0, 0);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(45, 5, 'Dr Didier MICHEL', 0, 1);

        $this->SetFont('Arial', '', 8);
        $w = $this->GetStringWidth('Tél: : 02 99 32.47 36/ Fax : 02.99.50.51.20');
        $this->Cell($w, 5, iconv("UTF-8", "CP1252",'Tél: : 02 99 32.47 36/ Fax : 02.99.50.51.20'), 0, 1);
    }

    public function Footer()
    {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Arial italique 8
        $this->SetFont('Arial','',8);
        // Numéro de page
        $this->Cell(0,10,'Réseau Louis Guilloux - Association loi 1901 – 12ter avenue de Pologne 35200 RENNES',0,0,'C');
    }

    public function addTH($header)
    {
        // Largeurs des colonnes
        $w = array(80, 35, 35, 35);
        for($i=0, $iMax = count($header); $i< $iMax; $i++)
            $this->Cell($w[$i],7,iconv("UTF-8", "CP1252",$header[$i]),1,0,$this->getalign($i));
        $this->Ln();
    }
    public function addRow($row)
    {
        // Largeurs des colonnes
        $w = array(80, 35, 35, 35);
        foreach ($row as $key=>$ligne){
            for($i=0, $iMax = count($ligne); $i< $iMax; $i++) {
                if($key==count($row)-1){
                    $this->Cell($w[$i], 7, iconv("UTF-8", "CP1252",$ligne[$i]), 'LRB', 0, $this->getalign($i), false);
                } else{
                    $this->Cell($w[$i], 7, iconv("UTF-8", "CP1252",$ligne[$i]), 'LR', 0, $this->getalign($i), false);
                }

            }
            $this->Ln();
        }
    }
    public function addTH2($header)
    {
        // Largeurs des colonnes
        $w = array(80, 30);
        for($i=0, $iMax = count($header); $i< $iMax; $i++)
            if($i==0){
                $this->Cell($w[$i],7,iconv("UTF-8", "CP1252",$header[$i]),'LBT',0,$this->getalign($i));
            } else{
                $this->Cell($w[$i],7,iconv("UTF-8", "CP1252",$header[$i]),'RBT',0,$this->getalign($i));
            }
        $this->Ln();
    }

    function getalign($i){
        if ($i==0){
            return 'L';
        } else{
            return 'C';
        }
    }

    public function addRow2($row)
    {
        // Largeurs des colonnes
        $w = array(80, 30);
        foreach ($row as $key=>$ligne){
            for($i=0, $iMax = count($ligne); $i< $iMax; $i++) {
                if($key==count($row)-1){
                    $this->Cell($w[$i], 7, iconv("UTF-8", "CP1252",$ligne[$i]), 'LRB', 0, $this->getalign($i), false);
                } else{
                    $this->Cell($w[$i], 7, iconv("UTF-8", "CP1252",$ligne[$i]), 'LR', 0, $this->getalign($i), false);
                }

            }
            $this->Ln();
        }
    }
}
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252", 'A l’attention de Christine PIVIN'), 0, 1, 'R');
$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252",'Maison du Département de Lannion'), 0, 1, 'R');
$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252",'13 Boulevard Louis GUILLOUX'), 0, 1, 'R');
$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252",'22300 LANNION'), 0, 1, 'R');

$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252",'e-mail :interpretariat@rlg35.org'), 0, 1);
$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252",'Nos réf. : 19-041'), 0, 1);
$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252",'Objet : intervention interprète'), 0, 1);
$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252",'N° : de Siret : 402 810 295 000 53'), 0, 1);


$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252",'A Rennes, le 5/09/2019'), 0, 1, 'R');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252",'DEVIS N17/2019'), 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 11);
$pdf->addTH(['Service', 'Nombre', 'Prix par unité', 'Total']);
$pdf->addRow([['Interprétariat téléphonique', '', '', ''],
    ['- en mongol 4 séances d’une heure', '4h','38€','152,00€'],
    ['- en turc 4 séances d’une heure', '4h','38€','152,00€']
]);

$pdf->SetFont('Arial', 'B', 11);
$pdf->addRow([['Total', '', 'Net à payer :', '304,00€']]);

$pdf->SetFont('Arial', '', 11);
$pdf->Ln(10);

$pdf->addTH2(['Mode de règlement', '']);

$pdf->addRow2([['Par Chèque bancaire ou virement à réception', '']]);

$pdf->Ln(5);

$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252", 'TVA non applicable, article 293 B du code général des impôts'), 0, 1, 'L');

$pdf->Ln(5);

$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252", 'Mme Oksana VATS'), 0, 1, 'R');
$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252", 'Responsable du pôle interprétariat'), 0, 1, 'R');


$pdf->Output();

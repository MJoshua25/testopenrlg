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
        $this->SetFont('Arial', '', 10);
// Décalage à droite

        $w = $this->GetStringWidth('PRESIDENT : ');
        $this->Cell($w, 5, 'PRESIDENT : ', 0, 0);
        $w = $this->GetStringWidth('Dr Jean Marc CHAPPLAIN');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell($w, 5, 'Dr Jean Marc CHAPPLAIN', 0, 0);

        $this->SetFont('Arial', 'B', 10);
        $this->SetX(150);
        $this->Cell(15, 5, 'Essor', 0, 1);

        $this->SetFont('Arial', '', 10);
        $w = $this->GetStringWidth('DIRECTEUR : ');
        $this->Cell($w, 5, 'DIRECTEUR : ', 0, 0);
        $w = $this->GetStringWidth('Patrice PRETER');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell($w, 5, 'Patrice PRETER', 0, 0);

        $this->SetFont('Arial', 'B', 10);
        $this->SetX(150);
        $this->Cell(15, 5, iconv("UTF-8", "CP1252",'Service Brocéliande'), 0, 1);

        $this->SetX(150);
        $this->Cell(15, 5, '12 rue Marie de France', 0, 1);

        $this->SetX(150);
        $this->Cell(15, 5, '35000 Rennes', 0, 1);

        $this->Cell(0, 5,  iconv("UTF-8", "CP1252",'N° : de Siret : 402 1010 295 000 53'), 0, 1);
    }

    public function Footer()
    {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-25);
        // Arial italique 10
        $this->SetFont('Arial','B',10);
        // Numéro de page
        $this->Cell(0,5,iconv("UTF-8", "CP1252",'Réseau Louis Guilloux - Association loi 1901 – 12ter avenue de Pologne 35200 RENNES'),0,1,'C');
        $this->Cell(0,5,iconv("UTF-8", "CP1252",'Tél 02 99 32 47 36  Fax: 02 99 50 51 20'),0,1,'C');
        $this->Cell(0,5,iconv("UTF-8", "CP1252",'email : f.forveille@rlg.org'),0,1,'C');
    }

    public function addTH($header)
    {
        // Largeurs des colonnes
        $w = array(25, 25, 40, 25, 25, 40);
        for($i=0, $iMax = count($header); $i< $iMax; $i++)
            $this->Cell($w[$i],7,iconv("UTF-8", "CP1252",$header[$i]),1,0,$this->getalign($i));
        $this->Ln();
    }
    public function addRow($row)
    {
        // Largeurs des colonnes
        $w = array(25, 25, 40, 25, 25, 40);
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
            $this->SetFont('Arial', 'B', 10);
            $this->SetX(150);
            $this->Cell(25,14,iconv("UTF-8", "CP1252", 'Montant total'),1,0, 'L');
            $this->Cell(20,14,iconv("UTF-8", "CP1252", '48,00 €'),1,0, 'L');

            $this->Ln();
        }
    }
}
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);


$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252",'Rennes, le 31 juillet 2019'), 0, 1, 'R');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252",'FACTURE N° 19-409'), 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$w = $pdf->GetStringWidth('Objet : ');
$pdf->Cell($w, 5, 'Objet : ', 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell($w, 5, iconv("UTF-8", "CP1252",'Interprétariat mois de juillet 2019'), 0, 1);

$pdf->SetFont('Arial', '', 11);
$pdf->addTH(['Langue', 'Date', 'Lieu/Famille', 'Temps en Heures', 'Prix de l\'heure', 'Total']);
$pdf->addRow([['Albanais', '03/07/2019', 'Elmasllari', '1', '38', '38,00'],
]);
$pdf->addRow([['', '','','', '', ''],
]);

$pdf->SetFont('Arial', 'B', 11);
$pdf->addRow([['Total', '', '', '1', '', '48']]);

$pdf->SetFont('Arial', '', 11);
$pdf->Ln(10);

$pdf->addTH2(['Mode de règlement et date de règlement', '']);

$pdf->addRow2([['Virement à réception', '48,00 €']]);

$pdf->Ln(5);

$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252", 'TVA non applicable, article 293 B du code général des impôts'), 0, 1, 'L');

$pdf->Ln(5);

$pdf->SetFont('Arial', 'U', 11);
$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252", 'Coordonnées bancaires du Réseaux Louis Guilloux'), 'LRT', 1, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252", 'Crédit mutuel de Bretagne - Domiciliation : CCM RENNES SAINTE ANNE-S'), 'LR', 1, 'L');
$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252", 'RIB: Code Banque : 15589 - Code Guichet : 35109 - N° de compte : 00194982243 - Clé RIB : 79'), 'LR', 1, 'L');
$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252", 'IBAN : FR76 1558 9351 0900 1949 8224 379 - BIC : CMBRFR2BARK'), 'LRB', 1, 'L');


$pdf->Output();

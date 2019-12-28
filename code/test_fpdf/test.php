<?php
require('fpdf182/fpdf.php');

// Exemple basic
// $pdf = new FPDF();
// $pdf->AddPage();
// $pdf->SetFont('Arial','B',16);
// $pdf->Cell(60, 10, 'Hello World !', 0, 0, 'C');
// $pdf->Output();

// En-tête, pied de page, saut de page et image
//class PDF extends FPDF{
//    // En-tête
//    function Header()
//    {
//        // Logo
//        $this->Image('https://nan.ci/ressources/images/logo-nan.png', 50, 6, 30);
//        // Police Arial gras 15
//        $this->SetFont('Arial', 'B', 15);
//        // Décalage à droite
//        $this->Cell(0, 10, 'Titre', 1, 0, 'C');
//        // Saut de ligne
//        $this->Ln(20);
//    }
//    // Pied de page
//    function Footer()
//    {
//        // Positionnement à 1,5 cm du bas
//        $this->SetY(-15);
//        // Police Arial italique 8
//        $this->SetFont('Arial', 'I', 8);
//        // Numéro de page
//        $this->Cell(0, 10, 'Page '.$this->PageNo().'/{nb}', 0, 0, 'C');
//    }
//}
//
//// Instanciation de la classe dérivée
//$pdf = new PDF();
//$pdf->AliasNbPages();
//$pdf->AddPage();
//$pdf->SetFont('Times', '', 10);
//for ($i=1; $i <= 40; $i++) {
//    $pdf->Cell(0, 10, 'Impression de la ligne numéro '.$i, 0, 1);
//}
//$pdf->Output();

//Retour du texte à la ligne et couleurs
//class PDF extends FPDF
//{
//    public function Header()
//    {
//        global $titre;
//
//        // Arial gras 15
//        $this->SetFont('Arial','B',15);
//        // Calcul de la largeur du titre et positionnement
//        $w = $this->GetStringWidth($titre)+6;
//        $this->SetX((210-$w)/2);
//        // Couleurs du cadre, du fond et du texte
//        $this->SetDrawColor(0,80,180);
//        $this->SetFillColor(230,230,0);
//        $this->SetTextColor(220,50,50);
//        // Epaisseur du cadre (1 mm)
//        $this->SetLineWidth(1);
//        // Titre
//        $this->Cell($w,9,$titre,1,1,'C',true);
//        // Saut de ligne
//        $this->Ln(10);
//    }
//
//    public function Footer()
//    {
//        // Positionnement à 1,5 cm du bas
//        $this->SetY(-15);
//        // Arial italique 8
//        $this->SetFont('Arial','I',8);
//        // Couleur du texte en gris
//        $this->SetTextColor(108);
//        // Numéro de page
//        $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
//    }
//
//    public function TitreChapitre($num, $libelle)
//    {
//        // Arial 10
//        $this->SetFont('Arial','',10);
//        // Couleur de fond
//        $this->SetFillColor(200,220,255);
//        // Titre
//        $this->Cell(0,6,"Chapitre $num : $libelle",0,1,'L',true);
//        // Saut de ligne
//        $this->Ln(4);
//    }
//
//    public function CorpsChapitre($fichier)
//    {
//        // Lecture du fichier texte
//        $txt = file_get_contents($fichier);
//        // Times 10
//        $this->SetFont('Times','',10);
//        // Sortie du texte justifié
//        $this->MultiCell(0,5,$txt);
//        // Saut de ligne
//        $this->Ln();
//        // Mention en italique
//        $this->SetFont('','I');
//        $this->Cell(0,5,"(fin de l'extrait)");
//    }
//
//    public function AjouterChapitre($num, $titre, $fichier)
//    {
//        $this->AddPage();
//        $this->TitreChapitre($num,$titre);
//        $this->CorpsChapitre($fichier);
//    }
//}
//
//$pdf = new PDF();
//$titre = 'Vingt mille lieues sous les mers';
//$pdf->SetTitle($titre);
//$pdf->SetAuthor('Jules Verne');
//$pdf->AjouterChapitre(1,'UN ÉCUEIL FUYANT','20k_c1.txt');
//$pdf->AjouterChapitre(2,'LE POUR ET LE CONTRE','20k_c2.txt');
//$pdf->Output();

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

    public function addTH($header)
    {
        // Largeurs des colonnes
        $w = array(80, 35, 35, 35);
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,iconv("UTF-8", "CP1252",$header[$i]),1,0,'C');
        $this->Ln();
    }
    public function addRow($row)
    {
        // Largeurs des colonnes
        $w = array(80, 35, 35, 35);
        foreach ($row as $ligne){
            for($i=0, $iMax = count($ligne); $i< $iMax; $i++) {
                $this->Cell($w[$i], 7, iconv("UTF-8", "CP1252",$ligne[$i]), 'LR', 0, 'C', false);
            }
            $this->Ln();
        }
        $this->Cell(array_sum($w),0,'','T');
    }
}
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252", 'A l’attention de M Guelfucci'), 0, 1, 'R');
$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252",'IME La Clarté'), 0, 1, 'R');
$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252",'28bis, rue Saint Michel'), 0, 1, 'R');
$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252",'35600 Redon'), 0, 1, 'R');

$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252",'e-mail :interpretariat@rlg35.org'), 0, 1);
$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252",'Nos réf. : 19-041'), 0, 1);
$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252",'Objet : intervention interprète'), 0, 1);
$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252",'N° : de Siret : 402 810 295 000 53'), 0, 1);


$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252",'A Rennes, le 4 mars 2019'), 0, 1, 'R');

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 5,  iconv("UTF-8", "CP1252",'DEVIS 06/2019'), 0, 4, 'C');

$pdf->SetFont('Arial', '', 11);
$pdf->addTH(['Service', 'Nombre', 'Prix par unité', 'Total']);
$pdf->addRow([['Interprétariat en turc le 19/03/2019', '1 heure', '38€', '38€'],
    ['Temps de déplacement aller-retour', '2 heures','38€','76€'],
    ['Frais de déplacement (réf. Mappy)','66*2=54km','0,54€','71,28€'],
    ]);
$pdf->addRow([['Interprétariat en turc le 04/06/2019', '1 heure', '38€', '38€'],
    ['Temps de déplacement aller-retour', '2 heures','38€','76€'],
    ['Frais de déplacement (réf. Mappy)','66*2=54km','0,54€','71,28€'],
]);

$pdf->SetFont('Arial', 'B', 11);

$pdf->Output();
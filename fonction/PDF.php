
<?php
include "../bdd/bdd.php";
$select=$bdd->SELECTALL("employe");

require('../lib/fpdf185/fpdf.php');


class PDF extends FPDF {
	// En-tête
	function Header() {
		$connect = new PDO('mysql:host=localhost;dbname=ruvalor_employé','root',''); 

	    $_SESSION['EMP_ID'] = $_GET['numId'];

	    $req=$connect->prepare('select * from employe where EMP_ID = ?');
	    $req->execute(array($_SESSION['EMP_ID']));

	    $select=$req->fetch();

		$prenom = $select["EMP_PRENOM"];
		$nom = $select["EMP_NOM"];
		$identite = $prenom." ".$nom;
	    // Logo
	    //$this->Image('logo.png',10,6,30);
	    // Police Arial gras 15
	    $this->SetFont('Arial','B',15);
	    // Décalage à droite
	    //$this->Cell(80);
	    // Titre
	    $this->Cell(190,10,"Informations sur $identite",1,0,'C');
	    // Saut de ligne
	    $this->Ln(20);
	}


	function Body() {
		$connect = new PDO('mysql:host=localhost;dbname=ruvalor_employé','root',''); 

	    $_SESSION['EMP_ID'] = $_GET['numId'];

	    $req=$connect->prepare('select * from employe where EMP_ID = ?');
	    $req->execute(array($_SESSION['EMP_ID']));

	    $select=$req->fetch();

		$prenom = $select["EMP_PRENOM"];
		$nom = $select["EMP_NOM"];
		$identite = $prenom." ".$nom;

		$photo = "../img/photo/$id.jpg";
	    // Photo
	    if (realpath($photo)) {
	    	$this->Image($photo,10,6,30);
	    }
	    // Police Arial gras 15
	    $this->SetFont('Arial','B',15);
	    // Décalage à droite
	    //$this->Cell(80);
	    // Titre
	    $this->Cell(190,10,"Informations sur $identite",1,0,'C');
	    // Saut de ligne
	    $this->Ln(20);
	}

	// Pied de page
	function Footer() {
	    // Positionnement à 1,5 cm du bas
	    $this->SetY(-15);
	    // Police Arial italique 8
	    $this->SetFont('Arial','I',8);
	    // Numéro de page
	    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

	$connect = new PDO('mysql:host=localhost;dbname=ruvalor_employé','root',''); 

	$_SESSION['EMP_ID'] = $_GET['numId'];

	$req=$connect->prepare('select * from employe where EMP_ID = ?');
	$req->execute(array($_SESSION['EMP_ID']));

	$select=$req->fetch();

	$prenom = $select["EMP_PRENOM"];
	$nom = $select["EMP_NOM"];
	$identite = $prenom." ".$nom;

	//$html = "$prenom <br><br><br><br> $nom";
	//$pdf->WriteHTML($html);
	$pdf->Cell(40,20,"$prenom \n $nom",1,1);

   					
                          

for($i=1;$i<=40;$i++)
    $pdf->Cell(0,10,'Impression de la ligne num&eacute;ro '.$i,0,1);

$pdf->Output();
?>

?>
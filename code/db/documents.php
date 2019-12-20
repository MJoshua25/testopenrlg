<?php
	function getDocumentsByCode($code)
	{
		global $conn;
		$queryDocsInterpByCode = "SELECT documents.id as id, documents.libelle as libelle,";		
		$queryDocsInterpByCode .= " documents.typedocument as typedocument, ";
		$queryDocsInterpByCode .= " documents.document as document,";
		$queryDocsInterpByCode .= " documents.personnefk as personnefk FROM documents,";		
		$queryDocsInterpByCode .= " personne where documents.personnefk = personne.id and ";
		$queryDocsInterpByCode .= " documents.personnefk = ".$code."";		
		$resultByCode = mysqli_query($conn, $queryDocsInterpByCode);
		
		$data = array();		
		while($row = mysqli_fetch_array($resultByCode))
		{			
			$document = new Document();
			$document->id = $row["id"];
			$document->libelle = $row["libelle"];
			$document->typedocument = utf8_encode($row["typedocument"]);
			$document->document = utf8_encode($row["document"]);			
			$document->personnefk = $row["personnefk"];
			$data[] = $document;				
		}

		return $data;
	}
?>
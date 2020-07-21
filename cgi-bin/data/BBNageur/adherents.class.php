<?php
	namespace data\BBnageur;

	class adherents extends data\Data
	{
		// Function récupération de toute les infos de tous les adhérents.
		public static function getAllAdherents()
		{
			$statement=$this->db->prepare(
				'SELECT * 
				FROM adherents'
				);
			$statement->execute();
			return $statement->fetchAll(\PDO::FETCH_ASSOC);
		}

		// Function d'ajout d'adhérents dans la table
		public static function addAdherents($nom, $prenom ,$date_naissance, $adresse, $tel, $cotisation, $dateFin, $ville, $zipcode)
		{
			$statement=$this->db->prepare(
				'INSERT INTO adherents(Nom, Prenom, Age, Adresse, Telephone, Cotisation, dateFin, Ville, CP)
				VALUES(:nom, :prenom, :date_naissance, :adresse, :tel, :cotisation, :dateFin, :ville, :zipcode)');
				$statement->bindParam(':nom', $nom, \PDO::PARAM_STR);
				$statement->bindParam(':prenom', $prenom, \PDO::PARAM_STR);
				$statement->bindParam(':date_naissance', $date_naissance, \PDO::PARAM_INT);
				$statement->bindParam(':adresse', $adresse, \PDO::PARAM_STR);
				$statement->bindParam(':tel', $tel, \PDO::PARAM_INT);
				$statement->bindParam(':cotisation', $cotisation, \PDO::PARAM_STR);
				$statement->bindParam(':dateFin', $dateFin, \PDO::PARAM_INT);
				$statement->bindParam(':ville', $ville, \PDO::PARAM_STR);
				$statement->bindParam(':zipcode', $zipcode, \PDO::PARAM_INT);
				$statement->execute();
		}

		// Function de  modification des adhérents
		public static function modifyAdherents($id, $nom, $prenom ,$date_naissance, $adresse, $tel, $cotisation, $dateFin, $ville, $zipcode)
		{
			$statement=$this->db->prepare(
				'UPDATE adherents
				SET Id = :id,
					Nom = nom,
					Prenom = :prenom,
					Age = :date_naissance,
					Adresse = :adresse,
					Telephone = :tel,
					Cotisation = :cotisation,
					dateFin = :dateFin,
					Ville = :ville,
					CP = :zipcode
				WHERE Id = :id');
			$statement->bindParam(':nom', $nom, \PDO::PARAM_STR);
			$statement->bindParam(':prenom', $prenom, \PDO::PARAM_STR);
			$statement->bindParam(':date_naissance', $date_naissance, \PDO::PARAM_INT);
			$statement->bindParam(':adresse', $adresse, \PDO::PARAM_STR);
			$statement->bindParam(':tel', $tel, \PDO::PARAM_INT);
			$statement->bindParam(':cotisation', $cotisation, \PDO::PARAM_STR);
			$statement->bindParam(':dateFin', $dateFin, \PDO::PARAM_INT);
			$statement->bindParam(':ville', $ville, \PDO::PARAM_STR);
			$statement->bindParam(':zipcode', $zipcode, \PDO::PARAM_INT);
			$statement->execute();
		}

		public static function deleteAdherents($id)
		{
			$statement=$this->db->prepare(
				'DELETE
				FROM adherents
				WHERE Id = :id');
			$statement->bindParam(':id', $id, \PDO::PARAM_INT);
			$statement->execute();
		}

		public function getExistByNP($nom, $prenom){ 
            $statement = $this->db->prepare(
                'SELECT COUNT(*)
                 FROM adherents
                 WHERE Nom =  :nom
             	 AND Prenom = :prenom');
            $statement->bindParam(':nom', $nom, \PDO::PARAM_STR);
            $statement->bindParam(':prenom', $prenom, \PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetch(\PDO::FETCH_COLUMN);
        }

		public static function getAdherentsbyId($id)
		{
			$statement=$this->db->prepare(
				'SELECT *
				FROM adherents
				WHERE Id = :id');
			$statement->bindParam(':id', $id, \PDO::PARAM_INT);
			$statement->execute();
			return $statement->fetch(\PDO::FETCH_ASSOC);
		}
	}
?>
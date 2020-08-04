<?php

	namespace data\BBNageur;

	class reservations extends \data\Data
	{
		public function getReservationsbyId($id)
		{
			$statement=$this->db->prepare(
				'SELECT * FROM emprunts_livres
				WHERE Id_emprunt = :id_emprunt');
			$statement->bindParam(':id_emprunt', $id_emprunt, \PDO::PARAM_INT);
			$statement->execute();
			return $statement->fetchAll(\PDO::FETCH_ASSOC);
		}

		public function addReservation($date_d , $date_f , $id_livre , $id_adh)
		{
			$statement=$this->db->prepare(
				'INSERT INTO emprunts_livres (Date_debut , Date_fin , Livres_fk , Adherents_fk)
				VALUES (:date_d , :date_f , :id_livre , :id_adh)');
			$statement->bindParam(':date_d', $date_d, \PDO::PARAM_STR);
			$statement->bindParam(':date_f', $date_f, \PDO::PARAM_STR);
			$statement->bindParam(':id_livre', $id_livre, \PDO::PARAM_INT);
			$statement->bindParam(':id_adh', $id_adh, \PDO::PARAM_INT);
			$statement->execute();
		}

		public function getReservations()
		{
			$statement=$this->db->prepare(
				'SELECT
					Id_emprunt ,
					DATE_FORMAT(Date_debut , "%d/%m/%Y"),
					DATE_FORMAT(Date_fin , "%d/%m/%Y"),
					Reference ,
					Titre ,
					Nom ,
					Prenom ,
					DATE_FORMAT(Date_rendu , "%d/%m/%Y"),
					etat_actuel 
				FROM emprunts_livres
				INNER JOIN livres
					ON emprunts_livres.Livres_fk = Livres.reference
				INNER JOIN adherents
					ON emprunts_livres.Adherents_fk = adherents.Id
	 			WHERE Date_rendu IS NULL
	 			ORDER BY Date_debut');
			$statement->execute();
			return $statement->fetchAll(\PDO::FETCH_ASSOC);
		}

		public function getReservationsRetard()
		{
			$statement=$this->db->prepare(
				"SELECT 
					Id_emprunt ,
					Date_debut ,
					Date_fin ,
					Reference ,
					Titre ,
					Prenom ,
					Nom 
				FROM emprunts_livres
					INNER JOIN livres
						ON emprunts_livres.Livres_fk = Livres.Reference
					INNER JOIN adherents
						ON emprunts_livres.Adherents_fk = Adherents.Id
				WHERE Date_fin < NOW() AND date_rendu IS NULL");
			$statement->execute();
			return $statement->fetchAll(\PDO::FETCH_ASSOC);
		}

		public function getHistorique()
		{
			$statement=$this->db->prepare(
				'SELECT
					Id_emprunt ,
					Date_debut,
					Date_fin,
					Titre ,
					Nom , 
					Prenom ,
					Date_rendu ,
					Etat_actuel
				FROM emprunts_livres
				INNER JOIN livres
					ON emprunts_livres.Livres_fk = Livres.Reference
				INNER JOIN adherents
					ON emprunts_livres.Adherents_fk = Adherents.Id
				WHERE Date_rendu IS NOT NULL
				ORDER BY Date_rendu DESC');
			$statement->execute();
			return $statement->fetchAll(\PDO::FETCH_ASSOC);
		}

		public function modifyReservations($date_r , $etat , $id_emprunt)
		{
			$statement=$this->db->prepare(
				'UPDATE emprunts_livres
				INNER JOIN livres
					ON emprunts_livres.Livres_fk = Livres.Reference
				SET Date_rendu = DATE_FORMAT(:date_rendu, "%Y/%m/%d"),
					Etat_actuel = :etat
				WHERE Id_emprunt = :id_emprunt');
			$statement->bindParam(':date_rendu', $date_r, \PDO::PARAM_INT);
			$statement->bindParam(':etat', $etat, \PDO::PARAM_STR);
			$statement->bindParam(':id_emprunt', $id_emprunt, \PDO::PARAM_INT);
			$statement->execute();
		}

		public function getExistByRefDate($id_livre, $date_f){ 
            $statement=$this->db->prepare(
                'SELECT COUNT(*)
                 FROM emprunts_livres
                 WHERE Livres_fk = :id_livre
                 AND Date_fin IS NULL');
            $statement->bindParam(':id_livre', $id_livre, \PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(\PDO::FETCH_COLUMN);
        }
	}
 ?>
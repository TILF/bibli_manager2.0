<?php

    namespace data\BBNageur;

    class livres extends \data\Data
    {

        public function getAllLivres()
        {
            $statement = $this->db->prepare(
                    'SELECT *
                   FROM livres
                   WHERE dateFin IS NULL
                   ');
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function addBook($reference, $titre, $auteur, $emplacement , $etat, $apparenance ,$annee){
            $statement = $this->db->prepare(
                'INSERT INTO livres (Reference, Titre, Auteur, Annee_parution, Emplacement, Etat_actuel, Exemplaires, Bibli_media, dateFin) 
                VALUES (:reference, :titre, :auteur, :annee, :emplacement, :etat, 1, :appartenance, null)');
            $statement->bindParam(':titre', $titre, \PDO::PARAM_STR);
            $statement->bindParam(':auteur', $auteur, \PDO::PARAM_STR);
            $statement->bindParam(':emplacement', $emplacement, \PDO::PARAM_STR);
            $statement->bindParam(':etat', $etat, \PDO::PARAM_STR);
            $statement->bindParam(':appartenance', $apparenance, \PDO::PARAM_STR);
            $statement->bindParam(':annee', $annee, \PDO::PARAM_INT);
            $statement->bindParam(':reference', $reference, \PDO::PARAM_INT);
            $statement->execute();
        }
        
        public function ModifyBook($reference, $titre, $auteur, $emplacement , $etat, $apparenance ,$annee){
                $statement = $this->db->prepare(
                    'UPDATE livres 
                    SET Titre = :titre, 
                        Auteur = :auteur, 
                        Annee_parution = :annee, 
                        Emplacement = :emplacement, 
                        Etat_actuel = :etat, 
                        Bibli_media = :appartenance
                    WHERE Reference = :reference');
                $statement->bindParam(':titre', $titre, \PDO::PARAM_STR);
                $statement->bindParam(':auteur', $auteur, \PDO::PARAM_STR);
                $statement->bindParam(':emplacement', $emplacement, \PDO::PARAM_STR);
                $statement->bindParam(':etat', $etat, \PDO::PARAM_STR);
                $statement->bindParam(':appartenance', $apparenance, \PDO::PARAM_STR);
                $statement->bindParam(':annee', $annee, \PDO::PARAM_INT);
                $statement->bindParam(':reference', $reference, \PDO::PARAM_INT);
                $statement->execute();
            }

        public function deleteBook($reference, $date){
            $statement = $this->db->prepare(
                'UPDATE livres
                 SET dateFin = :date
                 WHERE Reference =  :reference');
            $statement->bindParam(':reference', $reference, \PDO::PARAM_INT);
            $statement->bindParam(':date', $date, \PDO::PARAM_STR);
            $statement->execute();
        }

        public function getExistByRef($reference){ 
            $statement = $this->db->prepare(
                'SELECT COUNT(*)
                 FROM livres
                 WHERE Reference =  :reference
                 AND dateFin IS NULL');
            $statement->bindParam(':reference', $reference, \PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(\PDO::FETCH_COLUMN);
        }

        public function getBookInfoByRef($reference){           
            $statement = $this->db->prepare(
                'SELECT * 
                 FROM livres
                 WHERE Reference =  :reference');
            $statement->bindParam(':reference', $reference, \PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(\PDO::FETCH_ASSOC);
        }


    }

?>



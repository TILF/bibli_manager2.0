<?php

    namespace apps\frontend\livre;

    class MainAction
    {
        public static function execute()
        {
            \Form::retrieveErrorsAndParams();
            \Page::set('title', 'Gestion des Livres');

            $allLivres = \Application::getDb(\config\Configuration::get('bbnageur_dsn', 'databases'))
                    ->data('BBNageur\\livres')->getAllLivres();
            
            \Page::set('allLivres', $allLivres);            
            \Page::display();
        }
        
        /* ##################################################################################
         *                              FONCTIONS DE MANIPULATION
         #################################################################################### */
        
        
        public static function addNewBook(){
            
            self::getBookDatas(1);
            
            if(\Form::isValid()){               
                //ajout en base de donnée de la nouvelle entrée
                \Application::getDb(\config\Configuration::get('bbnageur_dsn', 'databases'))
                    ->data('BBNageur\\livres')->addBook(\Form::param('reference'), \Db::encode(\Form::param('titre')), \Db::encode(\Form::param('auteur')), \Form::param('emplacement'), \Form::param('etat'), \Db::encode(\Form::param('AppartenanceRadio')), \Form::param('annee'));
                
                \Form::addConfirmation('Ajout réalisé avec succès');
                \Form::displayResult(\Application::getRoute('livre', 'index'));
            }else{
                \Form::displayErrors(\Application::getRoute('livre', 'index'));
            }
            
        }
        
        public static function modifyBook($reference){
            
            self::getBookDatas();
            
            if(\Form::isValid()){               
                //ajout en base de donnée de la nouvelle entrée
                \Application::getDb(\config\Configuration::get('bbnageur_dsn', 'databases'))
                    ->data('BBNageur\\livres')->ModifyBook(\Form::param('reference'), \Db::encode(\Form::param('titre')), \Db::encode(\Form::param('auteur')), \Form::param('emplacement'), \Form::param('etat'), \Db::encode(\Form::param('AppartenanceRadio')), \Form::param('annee'));
                
                \Form::addConfirmation('Modification réalisée avec succès');
                \Form::displayResult(\Application::getRoute('livre', 'index'));
            }else{
                \Form::displayErrors(\Application::getRoute('livre', 'index'));
            }
            
        }
        
        public static function deleteBook($reference){
            \Form::addParams('reference', $reference,  \Form::TYPE_INT, 0, \Form::SIGNED_INT_32_MAX);
            if(\Form::param('reference') !== \Form::EMPTY_STRING){
                 \Application::getDb(\config\Configuration::get('bbnageur_dsn', 'databases'))
                    ->data('BBnageur\\livres')->deleteBook(\Form::param('reference'), date('Ymd'));               
                \Form::addConfirmation('Suppression réalisé avec succès');
                \Form::displayResult(\Application::getRoute('livre', 'index'));
            }else{
                \Form::addError('Erreur Critique', 'Problème critique lors de la suppression. Contactez un administrateur');
                \Form::displayErrors(\Application::getRoute('livre', 'index'));
            }
        }
        
        /* ##################################################################################
         *                FONCTIONS DE RECUPERATION ET MANIPULATION DES DONNEES
         #################################################################################### */
        
        private static function getBookDatas($type = null){
            \Form::addParams('titre', $_POST, \Form::TYPE_STRING, 1, 255);
            \Form::addParams('auteur', $_POST, \Form::TYPE_STRING, 1, 255);
            \Form::addParams('emplacement', $_POST, \Form::TYPE_STRING, 1, 255);
            \Form::addParams('AppartenanceRadio', $_POST, \Form::TYPE_STRING, 1, 255);
            \Form::addParams('etat', $_POST, \Form::TYPE_STRING, 1, 255);
            \Form::addParams('annee', $_POST, \Form::TYPE_INT, 0, \Form::SIGNED_INT_32_MAX);
            \Form::addParams('reference', $_POST, \Form::TYPE_INT, 0, \Form::SIGNED_INT_32_MAX);
            
            if( trim(\Form::param('titre')) === \Form::EMPTY_STRING || 
                trim(\Form::param('reference')) === \Form::EMPTY_STRING || 
                trim(\Form::param('auteur')) === \Form::EMPTY_STRING ||
                trim(\Form::param('emplacement')) === \Form::EMPTY_STRING || 
                trim(\Form::param('etat')) === \Form::EMPTY_STRING || 
                trim(\Form::param('AppartenanceRadio')) === \Form::EMPTY_STRING ||
                trim(\Form::param('annee')) === \Form::EMPTY_STRING) {
                \Form::addError('Erreur Critique', 'Une erreur critique est survenue, merci de contacter votre administrateur');
            }
            
            $exist = \Application::getDb(\config\Configuration::get('bbnageur_dsn', 'databases'))
                    ->data('BBNageur\\livres')->getExistByRef(\Form::param('reference'));               
            if(intval($exist) !== 0 && $type){
                \Form::addError('Erreur Reference', 'Cette référence existe déjà !');
            }
        }
        
        public static function getBookInfosByRef(){    
            \Form::addParams('reference', $_POST,  \Form::TYPE_INT, 0, \Form::SIGNED_INT_32_MAX);
            if(trim(\Form::param('reference')) !== \Form::EMPTY_STRING){
                $datas = \Application::getDb(\config\Configuration::get('bbnageur_dsn', 'databases'))
                    ->data('BBnageur\\livres')->getBookInfoByRef(\Form::param('reference'));       
                $final=array();
                $final['Reference'] = \Db::decode($datas['Reference']);
                $final['Titre'] =  \Db::decode($datas['Titre']);
                $final['Auteur'] =  \Db::decode($datas['Auteur']);
                $final['Annee_parution'] =  \Db::decode($datas['Annee_parution']);
                $final['Emplacement'] =  \Db::decode($datas['Emplacement']);
                $final['Etat_actuel'] =  \Db::decode($datas['Etat_actuel']);
                $final['Bibli_media'] =  \Db::decode($datas['Bibli_media']);
              die(\json_encode($final, true));
            }else{
                die('Erreur lié au traitement');
            }       
        }
        
    }

?>

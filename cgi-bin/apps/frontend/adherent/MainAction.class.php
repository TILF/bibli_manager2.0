<?php

    namespace apps\frontend\adherent;

    class MainAction
    {
        public static function execute()
        {
            \Form::retrieveErrorsAndParams();
            \Page::set('title', 'Gestion des Adhérents');  

            $allAdherents = \Application::getDb(\config\Configuration::get('bbnageur_dsn', 'databases'))
                    ->data('BBNageur\\adherents')->getAllAdherents();
            
            \Page::set('allAdherents', $allAdherents);
            \Page::display();
        }

            /* ##################################################################################
         *                              FONCTIONS DE MANIPULATION
         #################################################################################### */

        public static function addAdherents(){

            self::getAdherentsDatas();

            if (\Form::isValid()) {

                \Application::getDb(\config\Configuration::get('bbnageur_dsn', 'databases'))
                    ->data('BBNageur\\adherents')->addAdherents(
                        \Db::encode(\Form::Param('nom')),
                        \Db::encode(\Form::Param('prenom')),
                        \Form::Param('age'),
                        \Db::encode(\Form::Param('adresse')),
                        \Form::Param('tel'),
                        \Db::encode(\Form::Param('cotisation')),
                        \Db::encode(\Form::Param('ville')),
                        \Form::Param('zipcode'));
                \Form::addConfirmation('Ajout réalisé avec succès!');
                \Form::displayResult(\Application::getRoute('adherent', 'index'));
            }else{
                \Form::displayErrors(\Application::getRoute('adherent', 'index'));
            }
        }

        public static function modifyAdherents($id){

            self::getAdherentsDatas();

            if (\Form::isValid()) {

               \Application::getDb(\config\Configuration::get('bbnageur_dsn' , 'databases'))
                ->data('BBNageur\\adherents')->modifyAdherents($id,
                        \Db::encode(\Form::Param('nom')),
                        \Db::encode(\Form::Param('prenom')),
                        \Form::Param('age'),
                        \Db::encode(\Form::Param('adresse')),
                        \Form::Param('tel'),
                        \Db::encode(\Form::Param('cotisation')),
                        \Db::encode(\Form::Param('ville')),
                        \Form::Param('zipcode'));
                \Form::addConfirmation('Modification réalisée avec succès!');
                \Form::displayResult(\Application::getRoute('adherent' , 'index'));
            }else{
                \Form::displayErrors(\Application::getRoute('adherent' , 'index'));
            }
        }

        public static function deleteAdherents($id){

            \Form::addParams('id', $id, \Form::TYPE_INT, 0, \Form::SIGNED_INT_32_MAX);
            if (\Form::param('id') !== \Form::EMPTY_STRING) {
                \Application::getDb(\config\Configuration::get('bbnageur_dsn', 'databases'))
                    ->data('BBNageur\\adherents')->deleteAdherents(\Form::param('id'));
                \Form::addConfirmation('Suppression réalisée avec succès!');
                \Form::displayResult(\Application::getRoute('adherent', 'index'));
            }else{
                \Form::addError('Erreur Critique', 'Problème critique lors de la suppression. Contactez un administrateur');
                \Form::displayErrors(\Application::getRoute('adherent', 'index'));
            }
        }

                /* ##################################################################################
         *                FONCTIONS DE RECUPERATION ET MANIPULATION DES DONNEES
         #################################################################################### */

        private static function getAdherentsDatas($type = null){

            \Form::addParams('nom', $_POST, \Form::TYPE_STRING, 1, 255);
            \Form::addParams('prenom', $_POST, \Form::TYPE_STRING, 1, 255);
            \Form::addParams('age', $_POST, \Form::TYPE_INT, 0, \Form::SIGNED_INT_32_MAX);
            \Form::addParams('adresse', $_POST, \Form::TYPE_STRING, 1, 255);
            \Form::addParams('tel', $_POST, \Form::TYPE_STRING, 1, 255);
            \Form::addParams('cotisation', $_POST, \Form::TYPE_STRING, 1, 255);
            \Form::addParams('ville', $_POST, \Form::TYPE_STRING, 1, 255);
            \Form::addParams('zipcode', $_POST, \Form::TYPE_INT, 0 , \Form::SIGNED_INT_32_MAX);
            
            if( trim(\Form::param('nom')) === \Form::EMPTY_STRING || 
                trim(\Form::param('prenom')) === \Form::EMPTY_STRING || 
                trim(\Form::param('age')) === \Form::EMPTY_STRING ||
                trim(\Form::param('adresse')) === \Form::EMPTY_STRING || 
                trim(\Form::param('tel')) === \Form::EMPTY_STRING || 
                trim(\Form::param('cotisation')) === \Form::EMPTY_STRING ||
                trim(\Form::param('ville')) === \Form::EMPTY_STRING ||
                trim(\Form::param('zipcode')) === \Form::EMPTY_STRING) {
                \Form::addError('Erreur Critique', 'Une erreur critique est survenue, merci de contacter votre administrateur');
            }
            
            $exist = \Application::getDb(\config\Configuration::get('bbnageur_dsn', 'databases'))
                    ->data('BBNageur\\adherents')->getExistByNP(\Form::param('nom'), (\Form::param('prenom')));               
            if(intval($exist) !== 0 && $type){
                \Form::addError('Erreur Adhérent', 'Cet adhérent existe déjà !');
            }
        }

        public static function getAdherentsbyId(){

            \Form::addParams('id', $_POST, \Form::TYPE_INT, 0, \Form::SIGNED_INT_32_MAX);
                if (trim(\Form::param('id')) !== \Form::EMPTY_STRING) {
                    $datas= \Application::getDb(\config\Configuration::get('bbnageur_dsn', 'databases'))
                        ->data('BBNageur\\adherents')->getAdherentsbyId(\Form::param('id'));
                    $final= array();
                    $final['Id'] = \Db::decode($datas['Id']);
                    $final['Nom'] =  \Db::decode($datas['Nom']);
                    $final['Prenom'] =  \Db::decode($datas['Prenom']);
                    $final['Age'] =  \Db::decode($datas['Age']);
                    $final['Adresse'] =  \Db::decode($datas['Adresse']);
                    $final['Telephone'] =  \Db::decode($datas['Telephone']);
                    $final['Cotisation'] =  \Db::decode($datas['Cotisation']);
                    $final['Ville'] =  \Db::decode($datas['Ville']);
                    $final['CP'] =  \Db::decode($datas['CP']);
                die(\json_encode($final, true));
            }else{
                die('Erreur lié au traitement');
                }
        }
    }

?>

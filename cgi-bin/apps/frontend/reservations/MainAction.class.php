<?php

    namespace apps\frontend\reservations;

    class MainAction
    {
        public static function execute()
        {
            \Form::retrieveErrorsAndParams();
            \Page::set('title', 'Gestion des réservations');

            $allReservations = \Application::getDb(\config\Configuration::get('bbnageur_dsn', 'databases'))
                            ->data('BBNageur\\reservations')->getReservations();

            $allHistorique = \Application::getDb(\config\Configuration::get('bbnageur_dsn', 'databases'))
                            ->data('BBNageur\\reservations')->getHistorique();

            \Page::set('allReservations', $allReservations);
            \Page::set('allHistorique', $allHistorique);
            \Page::display();
        }

        /* ##################################################################################
         *                              FONCTIONS DE MANIPULATION
         #################################################################################### */

        public static function addReservation(){
            self::getReservationsDatas();
            if (\Form::isValid()) {
                \Application::getDb(\config\Configuration::get('bbnageur_dsn', 'databases'))
                        ->data('BBNageur\\reservations')->addReservation(
                            \Form::Param('date_d'),
                            \Form::Param('date_f'),
                            \Form::Param('id_adh'),
                            \Form::Param('id_livre'));
                            
                \Form::addConfirmation('Réservation réalisée avec succès!');
                \Form::displayResult(\Application::getRoute('reservations', 'index'));
            }else{
                \Form::displayErrors(\Application::getRoute('reservations', 'index'));
            }
        }

        public static function modifyReservations($id_emprunt){

            if (Form::isValid()) {
                \Application::getDb(\config\Configuration::get('bbnageur_dsn', 'databases'))
                        ->data('BBNageur\\reservations')->modifyReservations($id_emprunt,
                            \Form::Param('date_r'),
                            \Form::Param('etat'),
                            \Form::Param('id_emprunt'));

                \Form::addConfirmation('La réservation a été mise à jour !');
                \Form::displayResult(\Application::getRoute('reservations' , 'index'));
            }else{
                \Form::displayErrors(\Application::getRoute('reservations' , 'index'));
            }
        }
        
        public static function getReservationsById(){
            //TODO
        }


        /* ##################################################################################
         *                FONCTIONS DE RECUPERATION ET MANIPULATION DES DONNEES
         #################################################################################### */
         private static function getReservationsDatas($type = null){
            \Form::addParams('date_d', $_POST, \Form::TYPE_STRING, 1, 255);
            \Form::addParams('date_f', $_POST, \Form::TYPE_STRING, 1, 255);
            \Form::addParams('id_adh', $_POST, \Form::TYPE_INT, 0, \Form::SIGNED_INT_32_MAX);
            \Form::addParams('id_livre', $_POST, \Form::TYPE_INT, 0, \Form::SIGNED_INT_32_MAX);
            
            if(
                trim(\Form::param('date_d')) === \Form::EMPTY_STRING || 
                trim(\Form::param('date_f')) === \Form::EMPTY_STRING || 
                trim(\Form::param('id_adh')) === \Form::EMPTY_STRING ||
                trim(\Form::param('id_livre')) === \Form::EMPTY_STRING) {
                \Form::addError('Erreur Critique', 'Une erreur critique est survenue, merci de contacter votre administrateur');
            }
            
            $exist = \Application::getDb(\config\Configuration::get('bbnageur_dsn', 'databases'))
                    ->data('BBNageur\\reservations')->getExistByRefDate(
                        \Form::param('id_livre'),
                        \Form::param('date_f'));        
            if(intval($exist) !== 0 && $type){
                \Form::addError('Erreur', 'Ce livre est déjà réservé !');
            }
        }
    }
?>

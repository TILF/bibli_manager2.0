<?php

    namespace apps\frontend\index;

    class MainAction
    {
        public static function execute()
        {
            \Form::retrieveErrorsAndParams();
            \Page::set('title', 'Index');

            $allReservationsCourantes = \Application::getDb(\config\Configuration::get('bbnageur_dsn', 'databases'))
                            ->data('BBNageur\\reservations')->getReservations();

            $allReservationsRetard = \Application::getDb(\config\Configuration::get('bbnageur_dsn', 'databases'))
                            ->data('BBNageur\\reservations')->getReservationsRetard();

            \Page::set('allReservationsCourantes', $allReservationsCourantes);
            \Page::set('allReservationsRetard', $allReservationsRetard);

            \Page::display();
        }
    }

?>

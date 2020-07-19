<?php

    namespace apps\frontend\reservations;

    class MainAction
    {
        public static function execute()
        {
            \Form::retrieveErrorsAndParams();
            \Page::set('title', 'Gestion des réservations');


            \Page::display();
        }
    }

?>

<?php

    namespace apps\frontend\adherent;

    class MainAction
    {
        public static function execute()
        {
            \Form::retrieveErrorsAndParams();
            \Page::set('title', 'Gestion des Adhérents');


            \Page::display();
        }
    }

?>

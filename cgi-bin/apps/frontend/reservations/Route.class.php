<?php

	namespace apps\frontend\reservations;

	class Route extends \Route
	{
            protected static $routes = array(
                'index' => array(
                        'pattern' => '',
                        'controller' => 'MainAction::execute'
                ),

                'addReservation' => array(
                        'pattern' => 'addReservation',
                        'controller' => 'MainAction::addReservation'
                ),

                'getReservationsbyId' => array(
                        'pattern' => 'getReservationsbyId',
                        'controller' => 'MainAction::getReservationsbyId'
                ),

                'getReservations' => array(
                        'pattern' => 'getReservations',
                        'controller' => 'MainAction::getReservations'
                ),

                'getHistorique' => array(
                        'pattern' => 'getHistorique',
                        'controller' => 'MainAction::getHistorique'
                ),

                'modifyReservation' => array(
                        'pattern' => 'modifyReservations{id_emprunt}',
                        'controller' => 'MainAction::modifyReservation'
                ),
            );
	}

?>

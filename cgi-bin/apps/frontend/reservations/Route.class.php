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

                'getReservationsById' => array(
                        'pattern' => 'getReservationsById',
                        'controller' => 'MainAction::getReservationsById'
                ),

                'getReservations' => array(
                        'pattern' => 'getReservations',
                        'controller' => 'MainAction::getReservations'
                ),

                'getHistorique' => array(
                        'pattern' => 'getHistorique',
                        'controller' => 'MainAction::getHistorique'
                ),

                        'pattern' => 'modifyReservations-{id_emprunt}',
                ),
            );
	}
    
?>

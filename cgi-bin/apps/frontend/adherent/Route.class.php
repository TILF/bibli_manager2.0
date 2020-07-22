<?php

	namespace apps\frontend\adherent;

	class Route extends \Route
	{
            protected static $routes = array(
                'index' => array(
                        'pattern' => '',
                        'controller' => 'MainAction::execute'
                ),
                'addAdherents' => array(
                        'pattern' => 'addAdherents',
                        'controller' => 'MainAction::addAdherents'
                ),
                'modifyAdherents' => array(
                        'pattern' => 'modifyAdherents-{id}',
                        'controller' => 'MainAction::modifyAdherents'
                ),
                'deleteAdherents' => array(
                        'pattern' => 'deleteAdherents-{id}',
                        'controller' => 'MainAction::deleteAdherents'
                ),
                'getAdherentsbyId' => array(
                        'pattern' => 'getAdherentsbyId',
                        'controller' => 'MainAction::getAdherentsbyId'
                ),      
            );
	}

?>

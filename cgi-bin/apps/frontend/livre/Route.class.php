<?php

	namespace apps\frontend\livre;

	class Route extends \Route
	{
            protected static $routes = array(
                'index' => array(
                        'pattern' => '',
                        'controller' => 'MainAction::execute'
                ),
                'addNewBook' => array(
                        'pattern' => 'addNewBook',
                        'controller' => 'MainAction::addNewBook'
                ),
                'deleteBook' => array(
                        'pattern' => 'deleteBook-{reference}',
                        'controller' => 'MainAction::deleteBook'
                ),
                'modifyBook' => array(
                        'pattern' => 'modifyBook-{reference}',
                        'controller' => 'MainAction::modifyBook'
                ),
                'getBookInfosByRef' => array(
                        'pattern' => 'getBookInfosByRef',
                        'controller' => 'MainAction::getBookInfosByRef'
                ),
            );
	}

?>

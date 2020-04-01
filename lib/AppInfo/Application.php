<?php

namespace OCA\NotesTutorial\AppInfo;

use \OCP\AppFramework\App;

use OCA\NotesTutorial\Controller\NoteController;


class Application extends App {

    public function __construct(array $urlParams=array()){
        parent::__construct('NotesTutorial', $urlParams);

        $container = $this->getContainer();

        $container->registerService('folder', function($c) {
            return $c->query('ServerContainer')->getUserFolder();
        });

        $container->registerAlias('NoteController', NoteController::class);
    }
}



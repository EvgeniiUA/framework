<?php

namespace site\controllers;

/**
 * Default controller
 * 
 * @author Sinevid Evgenii (sinevid-evgenii@mail.ru)
 */
class index extends \framework\Controller {
    
    /**
     * default action
     */
    public function actionIndex() {
        $this->render('index');
    }

}

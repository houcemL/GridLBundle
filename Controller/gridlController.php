<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Lamari\GridLBundle\Controller;

/**
 * Description of gridlController
 *
 * @author houceml
 */
use Symfony\Component\DependencyInjection\ContainerAware;

class GridlController extends ContainerAware {
    /**
     * default load.
     */
    public function loadAction($class) {
        return $this->container->get("grid.entity_wrapper")->_load($class);
    }
}

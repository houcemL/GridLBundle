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
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class GridlController extends ContainerAwareTrait {
    /**
     * default load.
     */
    public function loadAction($class) {
        return $this->container->get("grid.entity_wrapper")->load($class);
    }
}

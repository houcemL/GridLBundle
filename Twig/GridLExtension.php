<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Lamari\GridLBundle\Twig;
/**
 * Description of GridLTwigExtension
 * 
 * @author houceml
 */
class GridLExtension extends \Twig_Extension {
    const DEFAULT_TEMPLATE = 'GridLbundle::gridL.js.twig';
    protected $container;
    public function __construct($container) {
        $this->container= $container;
    }
    public function getFunctions() {
        return array(
            "jqgridL" => new \Twig_Function_Method($this, "gridL", array('is_safe' => array('html')))
        );
    }
    public function gridL(\Lamari\GridLBundle\Model\jqGridConfig $gridConf) {
        
        $response = $this->container->get("templating")->renderResponse("GridLBundle:gridjs:grid.js.twig",
                array("grid" => $gridConf,
                    "id" => "id",
                "saveId" => "saveId",
                "restoreId" => "restoreId",
                "editId" => "editId"
                    ));
        return $response->getContent();
    }
    public function getName() {
        return "grid";
    }
}

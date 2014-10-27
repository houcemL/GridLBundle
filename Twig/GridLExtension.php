<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Lamari\GridLBundle\Twig;
/**
 * Description of GridLTwigExtension
 * This extension add new twig function to generate needed jquery script for the grid.
 * @author houceml
 */
class GridLExtension extends \Twig_Extension {
    const DEFAULT_TEMPLATE = 'GridLbundle::gridL.js.twig';
    protected $templating;
    public function __construct($templating) {
        $this->templating= $templating;
    }
    public function getFunctions() {
        return array(
            "jqgridL" => new \Twig_Function_Method($this, "gridL", array('is_safe' => array('html')))
        );
    }
    public function gridL(\Lamari\GridLBundle\Model\jqGridConfig $gridConf, $pager = "pager", $events = null) {
        $id = "gridL_" . md5(rand(1882, 1991));
        $conf = array(
            "grid" => $gridConf,
            "id" => $id,
            "events" => $events,
            "paginator" => $pager,
        );
        $response = $this->templating->renderResponse("GridLBundle:gridjs:grid.js.twig",$conf);
        return $response->getContent();
    }
    public function getName() {
        return "grid";
    }
}

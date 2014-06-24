<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace L\GridLBundle\Model;

/**
 * Description of jqGridConfig
 *
 * @author houceml
 */
class jqGridConfig {

    public $datatype;
    public $url;
    public $colNames;
    public $colModel;
    public $method;
    public $onEvents;
//    public $rowNum;
//    public $rowList;
//    public $pager;
//    public $sortname;
//    public $viewrecords;
//    public $sortorder;
    public $caption;
    public $editurl;
    public $subGrid;
    public function __construct($conf = array()) {
        $this->caption = empty($conf["caption"]) ? "caption" : $conf["caption"];
        $this->subGrid = empty($conf["subGrid"]) ? false : $conf["subGrid"];
        $this->method = empty($conf["method"]) ? "get" : $conf["method"];
        $this->url = empty($conf["url"]) ? "load" : $conf["url"];
        $this->datatype = empty($conf["datatype"]) ? "json" : $conf["datatype"];
        $this->onEvents = "";
    }

    /**
     * Define and update the columns names.
     */
    public function setColNames($names = array()) {
        if (is_array($names)) {
            $this->colNames = $names;
        }
    }

    /**
     * get the columns names.
     */
    public function getColNames() {
        return $this->colNames;
    }

    /**
     * Define the columns config.
     */
    public function setColModel($models) {
        if (is_array($models)) {
            foreach ($models as $model) {
                if (!is_a($model, "jqCol")) {
                    throw new Exception("jqGrid column model's not configured !");
                }
            }
            $this->colModel = $models;
        }
        return false;
    }
    
    /**
     * get the column's names.
     */
    public function getColModel() {
        return $this->colModels;
    }

    //put your code here
}
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Lamari\GridLBundle\Tools;

/**
 * Description of GridLEntity
 *
 * @author houceml
 */
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Lamari\GridLBundle\Model\jqdata;
use Lamari\GridLBundle\Model\jqGridConfig;

class GridEntity {

    protected $entityClass;
    protected $alias;
    protected $fields;
    protected $em;
    protected $router;
    protected $request;
    protected $qb;
    protected $search;

    public function __construct($em, $router, $request, $templating) {
        $this->em = $em;
        $this->qb = $this->em->createQueryBuilder();
        $this->router = $router;
        $this->request = $request;
        $this->template = $templating;
        $this->search = $this->request->get("_search");
    }

    public function setEntityClass($class) {
        $this->entityClass = $class;
    }

    public function setAlias($alias) {
        $this->alias = $alias;
    }

    public function entityfields($class) {
        $meta = $this->em->getClassMetadata($class);
        return $meta->fieldMappings;
    }
    public function getfieldNames($class){
        $meta = $this->em->getClassMetadata($class);
        return $meta->fieldNames;
    }
    public function entitiesConf() {
        return $this->em->getConfiguration();
    }

    /**
     * 
     * @return type
     */
    public function getQb() {
        return $this->qb;
    }

    /**
     * 
     * @param type $sidx
     * @return type
     */
    public function getTotalRecords($sidx, $class) {
        $queryb = new QueryBuilder($this->em);
        $queryb->add('select', 'obj')
                ->add('from', $class . ' obj');
        $queryb->resetDQLPart("orderBy");
        $queryb->select(" count(obj.{$sidx}) ");
        if ($this->search === "true") {
            $afd = $this->getSearchedField($class);
            $field = $afd["field"];
            $value = $afd["val"];
            $queryb->andWhere(" obj.$field like '%{$value}%' ");
        }
        $res = $queryb->getQuery()->getSingleScalarResult();
        return $res;
    }

    /**
     * 
     * @param type $class
     * @param type $rows
     * @param type $page
     * @param type $sidx
     * @param type $sord
     * @return type
     */
    public function getPage($class) {
        $rows = $this->request->get("rows");
        $page = $this->request->get("page");
        $sidx = $this->request->get("sidx");
        $sord = $this->request->get("sord");
        $begin = $rows * ($page - 1);
        $qb = $this->qb;
        $qb->add('select', 'obj')
                ->add('from', $class . ' obj')
                ->orderBy("obj.$sidx",$sord);
        if ($this->search === "true") {
            $afd = $this->getSearchedField($class);
            $field = $afd["field"];
            $value = $afd["val"];
            $qb->andWhere(" obj.$field like '%{$value}%' ");
        }
        $qb->setFirstResult($begin)
                ->setMaxResults($rows);
        $query = $qb->getQuery();
        $entities = $query->getResult();
        return $entities;
    }
    /**
     * 
     * @param type $class
     * @return boolean
     */
    public function getSearchedField($class) {
        $fields = $this->entityfields($class);
        foreach ($fields as $key => $field) {
            $keyf = $this->request->get($key);
            if(!empty($keyf)) {
                return array("field" => $key,"val" => $keyf);
            }
        }
        return false;
    }
    /**
     * 
     * @param type $class
     * @return \Lamari\GridLBundle\Model\jqdata
     */
    public function fetchEntities($class, $entities = null) {
        $maxrows = $this->request->get("rows");
        $page = $this->request->get("page");
        $id = $this->request->get("sidx");
        $data = new jqdata();
        if (empty($entities)&& ($this->search === 'false')) {
            $entities = $this->em->getRepository($class)->findAll();
        }
        $getId = $this->getter($id);
        foreach ($entities as $entity) {
            $row = new \stdClass;
            $row->id = $entity->$getId();
            $cell = $this->mappedToArray($class, $entity);
            $row->cell = $cell;
            $data->rows[] = $row;
            $data->records++;
        }
        $data->page = $page;
        $allrecords = $this->getTotalRecords($id, $class);
        if ($allrecords == $maxrows) {
            $data->total = 1;
        } else {
            $data->total = $allrecords / $maxrows + 1;
        }
        return $data;
    }
    
    /**
     * 
     * @param type $class
     * @param type $entity
     * @param type $fieldsMap
     * @return type
     */
    public function mappedToArray($class, $entity, $fieldsMap = array()) {
        if (empty($fieldsMap)) {
            $fieldsMap = $this->entityFields($class);
        }
        $cells = array();
        foreach ($fieldsMap as $key => $field) {
            $getter = $this->getter($key);
            $keyvalue = $entity->$getter();
            $cells[] = $keyvalue;
        }
        return $cells;
    }

    /**
     * 
     * @param type $class : format of the class "NamebundleBundle:className"
     * @param \Lamari\GridLBundle\Model\jqGridConfig $grid
     * @param Boolean $load : if true it generate an absolute url to load data
     *  automatically
     * @return \Lamari\GridLBundle\Model\jqGridConfig
     */
    public function gridByDoctrineEntity($class, jqGridConfig $grid = null, $load = true) {
        if (empty($grid)) {
            $grid = new jqGridConfig();
        }
        if ($load) {
            $grid->url = $this->router->generate("gridL_load", array("class" => $class), true);
        }
        $fieldsMap = $this->entityFields($class);
        $fields = $this->getfieldNames($class);
        $grid->setColNames($fields);
        $i = 0;
        foreach ($fieldsMap as $key => $field) {
            $names[$i] = $key;
            $col[$i] = new \stdClass();
            $col[$i]->index = $key;
            $col[$i]->name = $key;
            $col[$i]->width = 200;
            $i++;
        }
        $grid->colModel = $col;
        $grid->colNames = $names;
        return $grid;
    }

    /**
     * 
     */
    public function _load($class) {
        $entities = $this->getPage($class);
        $data = $this->fetchEntities($class, $entities);
        return $this->template->renderResponse("GridLBundle:gridjs:grid.json.twig", array("data" => $data));
    }

    /**
     * 
     */
    public function _defaultGrid($class, $view, $url = true) {
        $grid = $this->gridByDoctrineEntity($class, null, $url);
        return $this->template->renderResponse($view, array("grid" => $grid));
    }

    /**
     * 
     * @param type $property
     * @return type
     */
    protected function getter($property) {
        $first = strtoupper(substr($property, 0, 1));
        $rest = substr($property, 1);
        return "get" . $first . $rest;
    }

}


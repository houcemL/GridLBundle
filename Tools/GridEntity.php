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
use L\GridLBundle\Model\jqCol;
use L\GridLBundle\Model\jqNames;
use L\GridLBundle\Model\jqGridConfig;

class GridEntity {

    protected $entityClass;
    protected $alias;
    protected $fields;
    protected $em;
    protected $router;
    public function __construct(ContainerInterface $container) {
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->router = $container->get('router');
    }

    public function setEntityClass($class) {
        $this->entityClass = $class;
    }

    public function setAlias($alias) {
        $this->alias = $alias;
    }

    public function Entityfields($class) {
        return $this->em->getClassMetadata($class);
    }

    public function EntitiesConf() {
        return $this->em->getConfiguration();
    }
    /**
     * 
     * @param type $class
     * @return \Sf\GridLBundle\Model\jqdata
     */
    public function EntitiesFetchData($class) {
        $data = new jqdata();
        $entities = $this->em->getRepository($class)->findAll();
        foreach ($entities as $entity) {
            $row = new \stdClass;
            $row->id = $entity->getId();
            $cell = $this->mappedToArray($class, $entity);
            $row->cell = $cell;
            $data->rows[] = $row;
        }
        return $data;
    }
    /**
     * 
     * @param type $class
     * @param type $entity
     * @return type
     */
    public function mappedToArray($class, $entity) {
        $meta = $this->EntityFields($class);
        $fieldsMap = $meta->fieldMappings;
        $cells = array();
        foreach ($fieldsMap as $key => $field) {
            $first = strtoupper(substr($key, 0, 1));
            $rest = substr($key, 1);
            $getter = "get" . $first . $rest;
            $keyvalue = $entity->$getter();
            $cells[] = $keyvalue;
        }
        return $cells;
    }
    /**
     * 
     * @param type $class : format of the class "NamebundleBundle:className"
     * @param \Sf\GridLBundle\Model\jqGridConfig $grid
     * @param Boolean $load : if true it generate an absolute url to load data
     *  automatically
     * @return \Sf\GridLBundle\Model\jqGridConfig
     */
    public function gridByDoctrineEntity($class, jqGridConfig $grid, $load) {
        if ($load) {
            $grid->url = $this->router->generate("gridL_load", array(), true);
        }
        $grid = new jqGridConfig;
        $meta = $this->EntityFields($class);
        $fields = $meta->fieldNames;
        $grid->setColNames($fields);
        $fieldsMap = $meta->fieldMappings;
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

}


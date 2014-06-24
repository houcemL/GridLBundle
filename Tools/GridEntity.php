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

    public function __construct(ContainerInterface $container) {
        $this->em = $container->get('doctrine.orm.entity_manager');
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
    public function EntityFetchData($class) {
        
    }

    public function gridByDoctrineEntity($class) {
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
//        return array(
//                "grid" => $grid,
//                "id" => "id",
//                "saveId" => "saveId",
//                "restoreId" => "restoreId",
//                "editId" => "editId"
//            );
    }

    //put your code here
}


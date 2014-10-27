<?php
namespace Lamari\GridLBundle\Model;
/**
 * @author houceml
 */
class Jqdata {
  public $page;
  public $total;
  public $records;
  public $rows;
  public function getJson() {
      return json_encode($this);
  }
}

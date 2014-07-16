namespace Lamari\GridLBundle\Model;
/**
 * Description of jqdata
 *
 * @author houceml
 */
class jqdata {
  public $page;
  public $total;
  public $records;
  public $rows;
  public function getJson() {
      return json_encode($this);
  }
}

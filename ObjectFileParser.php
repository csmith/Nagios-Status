<?PHP

 require_once(dirname(__FILE__) . '/FileParser.php');

 class ObjectFileParser extends FileParser {

  private $hosts = array();
  private $services = array();

  protected function parse_line($line) {
   $index = strpos($line, "\t");
   return array(substr($line, 0, $index) => substr($line, 1 + $index));
  }

  protected function parse_blockname($name) {
   return substr($name, 7);
  }

  protected function parse_command($data) {}
  protected function parse_service($data) { $this->services[$data['host_name']][$data['service_description']] = $data; }
  protected function parse_servicegroup($data) {}
  protected function parse_host($data) { $this->hosts[$data['host_name']] = $data; }
  protected function parse_hostextinfo($data) {}
  protected function parse_hostgroup($data) {}
  protected function parse_contact($data) {}
  protected function parse_contactgroup($data) {} 
  protected function parse_timeperiod($data) {}

  protected function analyse() {
   foreach ($this->hosts as $hostname => $data) {
    $this->hosts[$hostname]['services'] = $this->services[$hostname];
   }

   unset($this->services);
  }

  public function getHosts() { return $this->hosts; }

  public function __construct($file = '/var/cache/nagios3/objects.cache') {
   parent::__construct($file);
  }

 } 

?>

<?PHP

 require_once(dirname(__FILE__) . '/FileParser.php');

 class StatusFileParser extends FileParser {

  private $hosts = array();
  private $services = array();

  protected function parse_line($line) {
   $index = strpos($line, '=');
   return array(substr($line, 0, $index) => substr($line, 1 + $index));
  }

  protected function parse_servicestatus($data) { $this->services[$data['host_name']][$data['service_description']] = $data; }
  protected function parse_hoststatus($data) { $this->hosts[$data['host_name']] = $data; }
  protected function parse_info($data) {}
  protected function parse_programstatus($data) { }
  protected function parse_contactstatus($data) { }
  protected function parse_servicecomment($data) { }

  protected function analyse() {
   foreach ($this->hosts as $hostname => $data) {
    $this->hosts[$hostname]['services'] = $this->services[$hostname];
   }

   unset($this->services);
  }

  public function getHosts() { return $this->hosts; }

  public function __construct($file = '/var/cache/nagios3/status.dat') {
   parent::__construct($file);
  }

 } 

?>

<?PHP

 abstract class FileParser {

  protected abstract function parse_line($line);

  protected function parse_blockname($block) { return $block; }
  protected function analyse() {}

  public function __construct($file) {
   $contents = file($file);

   $block = '';
   $lines = array();
   foreach ($contents as $line) {
    $tline = trim($line);

    // Comments and empty lines
    if (empty($tline) || $tline[0] == '#') {
     continue;
    }

    // Close braces
    if ($tline[0] == '}') {
     call_user_func(array(&$this, 'parse_' . $block), $lines);
     continue;
    }

    // Open braces
    if (substr($tline, -1) == '{') {
     $block = $this->parse_blockname(trim(substr($tline, 0, -1)));
     $lines = array();
     continue;
    }

    // Other lines
    $lines = array_merge($lines, $this->parse_line($tline));
   }

   $this->analyse();
  }
 } 

?>

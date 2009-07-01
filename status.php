<?PHP

if (isset($_GET['xml'])) {
 header('Content-type: text/xml');
} else {
 header('Content-type: application/xhtml+xml');
}

echo '<?xml version="1.0" encoding="UTF-8"?>', "\n";

?>
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title>Nagios status</title>
  <link rel="stylesheet" href="style.css" type="text/css"/>
  <script src="http://ajax.googleapis.com/ajax/libs/prototype/1.6/prototype.js" type="text/javascript"></script>
 </head>
 <body>
<?PHP

 require_once(dirname(__FILE__) . '/Formats.php');
 require_once(dirname(__FILE__) . '/ObjectFileParser.php');
 require_once(dirname(__FILE__) . '/StatusFileParser.php');

 $op = new ObjectFileParser();
 $sp = new StatusFileParser();
 $sh = $sp->getHosts();

 echo '<table class="status">';
 echo '<tr><th>Host</th><th>Service</th><th>Status</th><th>Last check</th><th>Next check</th><th>Comment</th></tr>';

 $hosts = $op->getHosts();
 knatsort($hosts);

 foreach ($hosts as $hn => $host) {
  echo '<tr><td rowspan="', count($host['services']), '">', $host['alias'], '</td>';
  $first = true; 

  foreach ($host['services'] as $sn => $service) {
   if ($first) {
    $first = false;
   } else {
    echo '<tr>';
   }

   $services = $sh[$hn]['services'][$sn];
   $status = translateStatus($services['current_state']);
   $prefix = $host['host_name'] . '_' . str_replace(' ', '_', $service['service_description']) . '_';
   echo '<td>', $service['service_description'], '</td>';
   echo '<td class="update status ', $status, '" id="', $prefix, '_status">', $status, '</td>';
   echo formatDate($services['last_check'], false, $prefix . 'last');
   echo formatDate($services['next_check'],  true, $prefix . 'next');
   echo '<td class="update output" id="', $prefix, '_output">', trunc($services['plugin_output']), '</td>';
   echo '</tr>';
  }
 }

 echo '</table>';

?>
  <script src="script.js" type="text/javascript"></script>
 </body>
</html>

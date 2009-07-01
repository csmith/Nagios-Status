<?PHP

 function translateStatus($status) {
  switch ($status) {
   case  0: return 'OK';
   case  1: return 'Warning';
   case  2: return 'Critical';
   default: return 'Unknown';
  }
 }

 function formatDate($date, $scheduled = false, $id) {
  if ($date == 0) {
   return '<td class="date never update" id="' . $id . '">Never</td>';
  } else if ($date < strtotime('-30 seconds') && $scheduled) {
   return '<td class="date overdue update" id="' . $id . '">' . date('d/m/Y H:i', $date) . '</td>';
  } else {
   return '<td class="date update" id="' . $id . '">' . date('d/m/Y H:i', $date) . '</td>';
  }
 }

 function trunc($string) {
  if (strlen($string) > 60) {
   $string = substr($string, 0, 59).'…';
  }
  return $string;
 }

 function knatsort(&$karr){
   $kkeyarr = array_keys($karr);
   natsort($kkeyarr);
   $ksortedarr = array();
   foreach($kkeyarr as $kcurrkey){
    $ksortedarr[$kcurrkey] = $karr[$kcurrkey];
   }
   $karr = $ksortedarr;
   return true;
 }

?>

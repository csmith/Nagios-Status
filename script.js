function update() {
 new Ajax.Request(document.location.href, {method: 'get', parameters: {xml: 'true', rand: Math.random() * 1000}, onSuccess: updateResult});
}

function updateResult(transport) {
 var xml = transport.responseXML;
 var updated = false;

 $$('.update').each(function(el) {
  try {
   var updatable = xml.getElementById(el.id);

   if (el.innerHTML != updatable.innerHTML || el.className != updatable.className) {
    el.innerHTML = updatable.innerHTML;
    el.className = updatable.className + ' updated';
    updated = true;
   }
  } catch (e) {
   //alert('Something broke: ' + e);
  }
 });

 if (updated) {
  setTimeout(updateCancel, 3000);
 }
}

function updateCancel() {
 $$('.updated').each(function(el) {
  el.removeClassName('updated');
 });
}

new PeriodicalExecuter(update, 10);

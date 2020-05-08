
  $( "#toggle_btn" ).click(function() {
    if (getStyle("btmnav", "display") === "none") {
      $( "#topmenu" ).slideToggle(500);
    }
  });

function getStyle(id, name)
{
  var element = document.getElementById(id);
  return element.currentStyle ? element.currentStyle[name] : window.getComputedStyle ? window.getComputedStyle(element, null).getPropertyValue(name) : null;
}

var $window = $(window);
$window.resize(function() {
    if($window.width() >= 480) {
      document.getElementById("topmenu").style.display = "none";
        // getStyle("topmenu", "display")
    } else {
    }
});
<div id="fixed" style="z-index:10">
  <div class="w3-bar w3-amber w3-hover-red w3-card">
    <a href="./" class="w3-bar-item w3-button w3-hide-small w3-hover-amber">Home</a>
    <a href="#" class="w3-bar-item w3-button w3-hide-small w3-hover-amber">Change Content</a>
    <div class="w3-dropdown-hover">
      <button class="w3-button w3-hide-small w3-hover-amber">Resources</button>
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
        <a href="#" class="w3-bar-item w3-button w3-hover-amber">Brochures</a>
        <a href="#" class="w3-bar-item w3-button w3-hover-amber">e-book</a>
      </div>
    </div>
    <div class="w3-dropdown-hover">
      <button class="w3-button w3-hide-small  w3-hover-amber">Pages</button>
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
        <a href="#" class="w3-bar-item w3-button w3-hover-amber">login</a>
        <a href="#" class="w3-bar-item w3-button w3-hover-amber">register</a>
      </div>
    </div>
    <a href="#" class="w3-bar-item w3-button w3-hide-small w3-hover-amber">Take a quiz</a>
    <a href="contact" class="w3-bar-item w3-button w3-hide-small w3-hover-amber">Contact us</a>
    <?php if (!isset($_SESSION['login'])) { ?>
      <a href="#" class="w3-bar-item w3-button w3-right " onclick="confirmFunction()"><i style="font-size:15px" class="fa">Login?</i></a>
    <?php } else { ?>
      <a href="#" class="w3-bar-item w3-button w3-right" onclick="confirmFunction()"><i style="font-size:15px" class="fa">&#xf08b;</i></a>
      <span class="w3-bar-item w3-button w3-right" style="font-size:15px">Hello? groot</span>
    <?php } ?>
    <a href="javascript:void(0)" class="w3-bar-item w3-button w3-left w3-hide-large w3-hide-medium w3-hover-amber" onclick="myFunction()">&#9776;</a>
  </div>
  <script>
    function confirmFunction() {
      if (confirm("Are you Sure you want to logout?")) {
        document.location = './class/logout.php';
      } else {
        // cancel
      }
    }
  </script>
  <div id="demo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium">
    <a href="./" class="w3-bar-item w3-button w3-hover-red w3-amber">Home</a>
    <a href="#" class="w3-bar-item w3-button w3-hover-red w3-amber">Change Content</a>
    <div class="w3-dropdown-hover">
      <button class="w3-button w3-amber w3-hover-red w3-amber">Resources</button>
      <div class="w3-dropdown-content w3-bar-block w3-card-4 w3-amber">
        <a href="#" class="w3-bar-item w3-button w3-hover-red w3-amber">Brochures</a>
        <a href="#" class="w3-bar-item w3-button w3-hover-red w3-amber">e-book</a>
      </div>
    </div>
    <div class="w3-dropdown-hover">
      <button class="w3-button w3-hover-red w3-amber">action</button>
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
        <a href="#" class="w3-bar-item w3-button w3-hover-red w3-amber" disabled>Login</a>
        <a href="#" class="w3-bar-item w3-button w3-hover-red w3-amber">Register</a>
      </div>
    </div>
    <a href="#" class="w3-bar-item w3-button w3-hover-red w3-amber">Take a quiz</a>
    <a href="contact" class="w3-bar-item w3-button w3-hover-red w3-amber">Contact us</a>
  </div>
</div>
<script>
  // For sticky nav bar when reached top
  window.onscroll = function() {
    myFunctionSticky()
  };
  var header = document.getElementById("fixed");
  var sticky = header.offsetTop;

  function myFunctionSticky() {
    if (window.pageYOffset >= sticky) {
      header.classList.add("w3-top");
    } else {
      header.classList.remove("w3-top");
    }
  }
</script>
<script>
  // nav bar toggle in small screen
  function myFunction() {
    var x = document.getElementById("demo");
    if (x.className.indexOf("w3-show") == -1) {
      x.className += " w3-show";
    } else {
      x.className = x.className.replace(" w3-show", "");
    }
  }
</script>
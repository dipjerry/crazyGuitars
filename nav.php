<div id="fixed">
  <div class="w3-bar  w3-text-white w3-card transparentNav nav">
    <a href="#" class="w3-bar-item w3-button w3-hide-small w3-hover-orange">Home</a>
    <a href="#band" class="w3-bar-item w3-button w3-hide-small w3-hover-orange">Band</a>
    <a href="#song" class="w3-bar-item w3-button w3-hide-small w3-hover-orange">Latest Songs</a>
    <a href="#contact" class="w3-bar-item w3-button w3-hide-small w3-hover-orange">Contact us</a>
    <?php if (!isset($_SESSION['login'])) { ?>
      <a href="#" class="w3-bar-item w3-button w3-right " onclick="confirmFunction()"><i style="font-size:15px" class="fa">Login?</i></a>
    <?php } else { ?>
      <a href="#" class="w3-bar-item w3-button w3-right" onclick="confirmFunction()"><i style="font-size:15px" class="fa">&#xf08b;</i></a>
      <span class="w3-bar-item w3-button w3-right" style="font-size:15px">Hello? groot</span>
    <?php } ?>
    <a href="javascript:void(0)" class="w3-bar-item w3-button w3-left w3-hide-large w3-hide-medium w3-hover-orange" onclick="myFunction()">&#9776;</a>
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
    <a href="./" class="w3-bar-item w3-button w3-hover-red w3-orange">Home</a>
    <a href="#" class="w3-bar-item w3-button w3-hover-red w3-orange">Change Content</a>
    <div class="w3-dropdown-hover">
      <button class="w3-button w3-orange w3-hover-red w3-orange">Resources</button>
      <div class="w3-dropdown-content w3-bar-block w3-card-4 w3-orange">
        <a href="#" class="w3-bar-item w3-button w3-hover-red w3-orange">Brochures</a>
        <a href="#" class="w3-bar-item w3-button w3-hover-red w3-orange">e-book</a>
      </div>
    </div>
    <div class="w3-dropdown-hover">
      <button class="w3-button w3-hover-red w3-orange">action</button>
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
        <a href="#" class="w3-bar-item w3-button w3-hover-red w3-orange" disabled>Login</a>
        <a href="#" class="w3-bar-item w3-button w3-hover-red w3-orange">Register</a>
      </div>
    </div>
    <a href="#" class="w3-bar-item w3-button w3-hover-red w3-orange">Take a quiz</a>
    <a href="contact" class="w3-bar-item w3-button w3-hover-red w3-orange">Contact us</a>
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
<script>
  $(document).ready(function() {
    $(window).scroll(function() {
      var scroll = $(window).scrollTop();
      var nav = document.getElementsByClassName("nav");
      if (scroll > 300) {
        $(".nav").removeClass("transparentNav");
        $(".nav").addClass("mars_concuest");
      } else {
        $(".nav").removeClass("mars_concuest");
        $(".nav").addClass("transparentNav");
      }
    })
  })
</script>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Price | {{env('APP_NAME')}}</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

  <link href="/css/price/index.css" rel="stylesheet" type="text/css">
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">

      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="fas fa-list"></span>
      </button>

      <img src="/favicon.ico" width="20px" alt="{{env('APP_NAME')}}" style="padding-bottom: 7px;">
      <a class="navbar-brand" href="/">{{env('APP_NAME')}}</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#about">ABOUT</a></li>
{{-- 
        <li><a href="#services">SERVICES</a></li>
{{--
        <li><a href="#portfolio">PORTFOLIO</a></li>
 --}}
        <li><a href="#pricing">PRICING</a></li>
        <li><a href="#contact">CONTACT</a></li>
      </ul>
    </div>
  </div>
</nav>

{{--

<div class="jumbotron text-center">
  <h1>Company</h1>
  <p>We specialize in blablabla</p>
  <form>
    <div class="input-group">
      <input type="email" class="form-control" size="50" placeholder="Email Address" required>
      <div class="input-group-btn">
        <button type="button" class="btn btn-danger">Subscribe</button>
      </div>
    </div>
  </form>
</div>

--}}

<!-- Container (About Section) -->
<div id="about" class="container-fluid">
  <div class="row">
    <div class="col-sm-8">
      <h2>About system</h2><br>
      <h4>
        <ul>
          <li>Records all working time of all staffs, members in all departments.</li>
          <li>Managers can see immediately summarized data and export to Excel by day, months, departments or projects.</li>
          <li>Easily input by dragging mouse.</li>
          <li>Easily click on buttons.</li>
          <li>Clear view for end users.</li>
          <li>Free for 5 users or below.</li>
        </ul>
      </h4>
      <br>
    </div>
    <div class="col-sm-4">
      <span class="fas fa-signal logo"></span>
    </div>
  </div>
</div>

{{--

<div class="container-fluid bg-grey">
  <div class="row">
    <div class="col-sm-4">
      <span class="fas fa-globe-asia logo slideanim"></span>
    </div>
    <div class="col-sm-8">
      <h2>Our Values</h2><br>
      <h4><strong>MISSION:</strong> Our mission lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</h4><br>
      <p><strong>VISION:</strong> Our vision Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
  </div>
</div>
--}}

<!-- Container (Services Section) -->
<div id="services" class="container-fluid text-center">
  <h2>SERVICES</h2>
  <h4>What we offer</h4>
  <br>
  <div class="row slideanim">
    <div class="col-sm-4">
      <span class="fas fa-calendar-alt logo-small"></span>
      <h4>TIME MANAGEMENT</h4>
      <p>
        Manage all working hours for all staffs.<br>
      </p>
    </div>
    <div class="col-sm-4">
      <span class="fas fa-landmark logo-small"></span>
      <h4>FOR OWNER</h4>
      <p>
        Easily adding, editing, deleting managers, staffs.<br>
        Easily changing permission, role for managers, staffs.<br>
      </p>
    </div>
    <div class="col-sm-4">
      <span class="fas fa-user-cog logo-small"></span>
      <h4>FOR MANAGERS</h4>
      <p>
        Easily input by dragging mouse.<br>
        Easily views by days, months, departments, projects.<br>
        Records all working time of all staffs, members.<br>
        See immediately summarized data and export to Excel.<br>
      </p>
    </div>
  </div>
  <br><br>
  <div class="row slideanim">
    <div class="col-sm-6">
      <span class="fas fa-user logo-small"></span>
      <h4>FOR STAFFS</h4>
      <p>
        Easily input by dragging mouse.<br>
        Easily views by days, months, departments, projects.<br>
        Records all working time of all staffs, members. Easily export data to Excel.<br>
      </p>
    </div>
    <div class="col-sm-6">
      <span class="fas fa-file-invoice-dollar logo-small"></span>
      <h4>FOR ACCOUNTANTS</h4>
      <p>
        Easily calculating working hours of staffs.<br>
      </p>
    </div>
{{-- 
    <div class="col-sm-4">
      <span class="fas fa-wrench logo-small"></span>
      <h4 style="color:#303030;">HARD WORK</h4>
      <p>Lorem ipsum dolor sit amet..</p>
    </div>
 --}}
  </div>
</div>

{{--
<!-- Container (Portfolio Section) -->
<div id="portfolio" class="container-fluid text-center bg-grey">
  <h2>Portfolio</h2><br>
  <h4>What we have created</h4>
  <div class="row text-center slideanim">
    <div class="col-sm-4">
      <div class="thumbnail">
        <img src="paris.jpg" alt="Paris" width="400" height="300">
        <p><strong>Paris</strong></p>
        <p>Yes, we built Paris</p>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="thumbnail">
        <img src="newyork.jpg" alt="New York" width="400" height="300">
        <p><strong>New York</strong></p>
        <p>We built New York</p>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="thumbnail">
        <img src="sanfran.jpg" alt="San Francisco" width="400" height="300">
        <p><strong>San Francisco</strong></p>
        <p>Yes, San Fran is ours</p>
      </div>
    </div>
  </div><br>

  <h2>What our customers say</h2>
  <div id="myCarousel" class="carousel slide text-center" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <h4>"This company is the best. I am so happy with the result!"<br><span>Michael Roe, Vice President, Comment Box</span></h4>
      </div>
      <div class="item">
        <h4>"One word... WOW!!"<br><span>John Doe, Salesman, Rep Inc</span></h4>
      </div>
      <div class="item">
        <h4>"Could I... BE any more happy with this company?"<br><span>Chandler Bing, Actor, FriendsAlot</span></h4>
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="fas fa-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="fas fa-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>

--}}

<!-- Container (Pricing Section) -->
<div id="pricing" class="container-fluid">
  <div class="text-center">
    <h2>Pricing</h2>
    <h4>Choose a payment plan that works for you</h4>
  </div>
  <div class="row slideanim">
    <div class="col-sm-3 col-xs-12">
      <div class="panel panel-default text-center">
        <div class="panel-heading">
          <h1>Free</h1>
        </div>
        <div class="panel-body">
          <p>Upto <strong>5</strong> users</p>
        </div>
        <div class="panel-footer">
          <h3>$0</h3>
          <h4>per month</h4>
          <a class="btn btn-lg" href=mlregister?ml=5">Sign Up</a>
{{-- 
          <div>
            Sign up by messaging me through <a href="https://www.linkedin.com/in/nguyenngocnam/" title="nguyenngocnam">LinkedIn</a>
          </div>
 --}}
        </div>
      </div>
    </div>

    <div class="col-sm-3 col-xs-12">
      <div class="panel panel-default text-center">
        <div class="panel-heading">
          <h1>Basic</h1>
        </div>
        <div class="panel-body">
          <p>Upto <strong>50</strong> users</p>
        </div>
        <div class="panel-footer">
          <h3>$350</h3>
          <h4>per month (<font color="lightgreen"><strong>tax included</strong></font>)</h4>
          <a class="btn btn-lg" href="/register?ml=50">Sign Up</a>
{{-- 
          <div>
            Sign up by messaging me through <a href="https://www.linkedin.com/in/nguyenngocnam/" title="nguyenngocnam">LinkedIn</a>
          </div>
 --}}
        </div>
      </div>
    </div>

    <div class="col-sm-3 col-xs-12">
      <div class="panel panel-default text-center">
        <div class="panel-heading">
          <h1>Medium</h1>
        </div>
        <div class="panel-body">
          <p>Upto <strong>100</strong> users</p>
        </div>
        <div class="panel-footer">
          <h3>$500</h3>
          <h4>per month (<font color="lightgreen"><strong>tax included</strong></font>)</h4>
          <a class="btn btn-lg" href="/register?ml=100">Sign Up</a>
{{-- 
          <div>
            Sign up by messaging me through <a href="https://www.linkedin.com/in/nguyenngocnam/" title="nguyenngocnam">LinkedIn</a>
          </div>
 --}}
        </div>
      </div>
    </div>

    <div class="col-sm-3 col-xs-12">
      <div class="panel panel-default text-center">
        <div class="panel-heading">
          <h1>Premium</h1>
        </div>
        <div class="panel-body">
          <p>Upto <strong>200</strong> users</p>
        </div>
        <div class="panel-footer">
          <h3>$900</h3>
          <h4>per month (<font color="lightgreen"><strong>tax included</strong></font>)</h4>
          <a class="btn btn-lg" href="/register?ml=200">Sign Up</a>
{{-- 
          <div>
            Sign up by messaging me through <a href="https://www.linkedin.com/in/nguyenngocnam/" title="nguyenngocnam">LinkedIn</a>
          </div>
 --}}
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
/*
$(document).ready(function(){
  $("[action=contact]").click(function(){
    window.location = "https://www.linkedin.com/in/nguyenngocnam/";
  });
});
*/
</script>


<!-- Container (Contact Section) -->
<div id="contact" class="container-fluid bg-grey">
  <h2 class="text-center">CONTACT</h2>
  <div class="row">
    <div class="col-sm-5">
      <div>Contact us and we'll get back to you soon.</div>
      <div><i class="fas fa-map-marker-alt"></i></span> Japan, Tokyo, Adachi ku</div>
      <div><i class="fas fa-envelope"></i> <a href="https://www.linkedin.com/in/nguyenngocnam/" target="_blank">Contact through LinkedIn</a></div>

      <br>

      <p><strong>Bank account</strong></p>
      <p>Mizuho (みずほ銀行)</p>
      <p>Account type: Normal</p>
      <p>Bank branch: Ayase (綾瀬支店: 179)</p>
      <p>Account number: 1405218</p>
      <p>Account user: NGUYEN NGOC NAM</p>

    </div>
    <div class="col-sm-7 slideanim">
      <a href="https://www.linkedin.com/in/nguyenngocnam/" class="btn btn-primary">Message to me through LinkedIn</a><br><br>
      <div class="row">
        <div class="col-sm-6 form-group">
          <input class="form-control" id="name" name="name" placeholder="Name" type="text" required disabled="disabled">
        </div>
        <div class="col-sm-6 form-group">
          <input class="form-control" id="email" name="email" placeholder="Email" type="email" required disabled="disabled">
        </div>
      </div>
      <textarea class="form-control" id="comments" name="comments" placeholder="Content" rows="10" required disabled="disabled"></textarea><br>
      <div class="row">
        <div class="col-sm-12 form-group">
          <button class="btn btn-default pull-right" type="submit" disabled="disabled">Send</button>
        </div>
      </div>
    </div>
  </div>
</div>


{{--

<!-- Add Google Maps -->
<div id="googleMap" style="height:400px;width:100%;"></div>
<script>
function myMap() {
var myCenter = new google.maps.LatLng(41.878114, -87.629798);
var mapProp = {center:myCenter, zoom:12, scrollwheel:false, draggable:false, mapTypeId:google.maps.MapTypeId.ROADMAP};
var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
var marker = new google.maps.Marker({position:myCenter});
marker.setMap(map);
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu-916DdpKAjTmJNIgngS6HL_kDIKU0aU&callback=myMap"></script>
<!--
To use this code on your website, get a free API key from Google.
Read more at: https://www.w3schools.com/graphics/google_maps_basic.asp
-->

--}}

<footer class="container-fluid text-center">

  <a href="#myPage" title="To Top">
    <i class="fas fa-chevron-up"></i>
  </a>

  <p>{{env('APP_NAME')}} &copy; 2018</p>
</footer>

<script src="/js/price/index.js"></script>

</body>
</html>

<?php
//Create date May 18, 2018

$page_title="View Vehicle";
include ('includes/header.html');
require ('../mysqli_connect.php');
?>

<body onload="showslides(1)">
<style>
.slideshow-container {
    max-width: 960px;
    position: relative;
    margin:auto;
}

.slides {
    display: none;
}

.text {
    color: #f2f2f2;
    font-size: 15px;
    padding: 8px 12px;
    position: absolute;
    bottom: 8px;
    width: 100%;
    text-align: center;
}

.dot {
    cursor: pointer; 
    height: 15px;
    width: 15px;
    margin: 0 2px;
    background-color: #bbb;
    border-radius: 50%;
    display: inline-block;
    transition: background-color 0.6s ease;
}

.active, .dot:hover {
    background-color: #717171;
} 

.fade {
    -webkit-animation-name: fade;
    -webkit-animation-duration: 1.5s;
    animation-name: fade;
    animation-duration: 1.5s;
}

@-webkit-keyframes fade {
    from {opacity: 0.4}
    to {opacity: 1}
}

@keyframes fade {
    from {opacity: 0.4}
    to {opacity: 1}
}

</style>

<script>
    showslides(1);

    function currentslide(n) {
        showslides(slideindex=n);
    }

    function showslides(n) {
        var i;
        var slides = document.getElementsByClassName("slides");
        var dots = document.getElementsByClassName("dot");
        if(n > slides.length) {
            slideindex = 1;
        }
        if(n < 1) {slideindex = slides.length}
        for(i=0;i < slides.length;i++) {
            slides[i].style.display = 'none';

        }

        for(i=0;i < dots.length;i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }

        slides[slideindex-1].style.display = "block";
        slide[slideindex-1].className += " active";
    } 
</script>

<div class="content">
    <h1>View Vehicle</h1>
    <?php
    //Grab the vehid from the url
    if(isset($_GET['vehid'])) {
        $vehicleid = $_GET['vehid'];
        //echo $vehicleid;

        //Display results including pictures

    } else {
        echo '<p id="error">No vehicle was selected to show<p>';
    }

    ?>
<div class="slide-show container">
    <figure>
    <div class="slides fade">
        <div class="numbertext">1/4</div>
        <img src="/vehicles/J2609-1.jpg">    
        <figcaption>Front</figcaption>
    </div>
    </figure>

    <figure>
    <div class="slides fade">
        <div class="numbertext">2/4</div>
        <img src="/vehicles/J2609-A.jpg">
        <figcaption>Driver Side</figcaption>
    </div>
    </figure>

    <figure>
    <div class="slides fade">
        <div class="numbertext">3/4</div>
        <img src="/vehicles/J2609-B.jpg">
        <figcaption>Passenger Side</figcaption>
    </div>
    </figure>

    <figure>
    <div class="slides fade">
        <div class="numbertext">4/4</div>
        <img src="/vehicles/J2609-C.jpg">
        <figcaption>Interior</figcaption>
    </div>
    </figure>

</div> 

<div style="text align: center">
    <span class="dot" onclick="currentslide(1)"></span>
    <span class="dot" onclick="currentslide(2)"></span>
    <span class="dot" onclick="currentslide(3)"></span>
    <span class="dot" onclick="currentslide(4)"></span>
</div>
    
    

    <form action="view-vehicle.php" method="post">
        <fieldset>




</div>
</body>
</html>

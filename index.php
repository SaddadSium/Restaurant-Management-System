<!--sani's code starts-->
<!doctype html>
<html>
    <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Home | S&S Heritage</title>
        <link rel="stylesheet" href="home.css">
    </head>
    <body>
         <div id="logo">
                <img src="logo.png" alt="logo">
            </div>
           <div class="" id="navbar">
                <ul>
                     <li><a href="index.php">Home</a></li>
                     <li><a href="Menu/menu.php">Menu</a></li>
                     <li><a href="AboutUs/aboutus.php">About Us</a></li>
                     <li><a href="CustomerReview/review.php">Customer's Reviews</a></li>

                     <?php 
                         if (isset($_SESSION['user_id'])) {

                             echo '<li><a href="Views/customer/dashboard.php">Dashboard</a></li>';
                             echo '<li><a href="Views/logout.php">Log Out</a></li>';
                           } 

                         else {

                             echo '<li><a href="Views/login.php">Log In</a></li>';
                           }
                     ?>

                     </ul>
           </div><br><br>
           
           <div class= "HomeIntro1">

           <section class="block" id="text">
            <h2>A Warm Heritage Welcome</h2>
            <p>Step into a world where tradition meets luxury. At S&S Heritage, we believe every meal is a celebration. 
               From the moment you walk through our doors in Purbachal, you are treated as a guest of honor in our family home</p>
            <h3>--Your Seat at Our Table Awaits</h3>
           </section>

           <section class="block" id="HomeImg">
           <img src="IndexImges/Homeimg-1.png" alt="interior img" >
           </section>

           </div> 

            <div class= "HomeIntro2">

           <section class="block" id="HomeImg">
           <img src="IndexImges/Homeimg-2.png" alt="celebrationg img" >
           </section>

           <section class="block" id="text">
            <h2>An Exquisite Ambiance</h2>
            <p>Whether it’s a romantic dinner or a family celebration, our heritage-inspired interior provides the perfect backdrop. 
               Relax in a setting where elegance meets comfort</p>
            <h3>--Dine in Timeless Elegance</h3>
           </section>

           </div> 

           
            <div class= "HomeIntro3">

            <section class="block" id="text">
            <h2>The Secret of Heritage</h2>
            <p>What makes us unique? Our signature spice blends, passed down through generations. 
                These flavors are the soul of S&S Heritage, offering a taste you won't find anywhere else</p>
            <h3>--Authentic Flavors, Deeply Rooted delecious</h3>
           </section>

           <section class="block" id="HomeImg">
           <img src="IndexImges/Homeimg-3.png" alt="spice img" >
           </section>

           </div>

           <div class= "HomeIntro4">
            
           <section class="block" id="HomeImg">
           <img src="IndexImges/Homeimg-4.png" alt="dine img" >
           </section>

            <section class="block" id="text">
            <h2>Exceptional Hospitality</h2>
            <p>To us, you are more than a customer; you are a guest in our home. 
               Our dedicated team is committed to providing a seamless and warm dining experience from the moment you walk in.</p>
            <h3>--Feel The Heritage Warmth</h3>
           </section>

           </div>


           <div id="footer">
           <footer><br>
            <p>2026 S & S Heritage Restaurant.All rights reserved.</p> <br>
            <p> S & S Heritage Restaurant<br> Purbachal-300fit, Dhaka-1216, Bangladesh<br>Opening Hours: 10am - 10pm</p><br><br>
            </footer>
            </div>
        </body>
</html>
<!--sani's code ends-->
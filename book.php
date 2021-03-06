<?php 
  session_start(); 
  include_once('config/config.php');
  include_once('classes/makeBooking.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Booking | HotelBooking</title>
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
		$(window).on("load", function() {
      $('main').fadeIn(355).removeClass('hidden');

      $("button").click(function(){
          $("main").fadeOut(355).addClass('hidden');
      });

      $("a").click(function(){
          $("main").fadeOut(355).addClass('hidden');
      });

      $( "select" ).change(function() {
        var sel = $( "select option:selected" );
        var star = '<i class="fas fa-star"></i>';
        var starO = '<i class="far fa-star"></i>';
        window.console&&console.log(sel.val());

        if (sel.val() === "lsb") {
          $( "#hotel_image" ).css("background-image", "url('assets/lsb.jpg')");
          $( "#hotel_name" ).text("Long Street Backpackers");
          $( "#hotel_blurb" ).text("Long Street Backpackers is an old school, communal, traveller’s hostel in the heart of Cape Town. Here, we’re all about new friends, spontaneity and laid-back fun. It is centrally located in Cape Town’s City Bowl, making it the perfect home base while you explore the Mother City.");
          $( "#stars" ).html(star + star + starO + starO + starO);
          $( "#price" ).text("R300.00 p/n");

        } else if(sel.val() === "dlla") {
          $( "#hotel_image" ).css("background-image", "url('assets/dlla.jpg')");
          $( "#hotel_name" ).text("Daddy Long Legs Art Hotel & Self-Catering Apartments");
          $( "#hotel_blurb" ).text("As an independent travellers’ hotel, Daddy Long Legs will appeal to those seeking an authentic experience of Cape Town. It is a place to meet others and is ideally situated for exploring the character and nightlife of the city and its surrounds.");
          $( "#stars" ).html(star + star + star + star + starO);
          $( "#price" ).text("R1251.00 p/n");

        } else if(sel.val() === "ttb") {
          $( "#hotel_image" ).css("background-image", "url('assets/ttb.jpg')");         
          $( "#hotel_name" ).text("The Table Bay Hotel");
          $( "#hotel_blurb" ).text("The Table Bay offers the ultimate in 5-star luxury hotel accommodation in Cape Town. Considered to be the best address in Cape Town, this sophisticated Sun International property was opened in May 1997 by former South African president, Nelson Mandela. As part of the Sunlux Collection, The Table Bay continues to set its own standards in international service, cuisine and luxury.");
          $( "#stars" ).html(star + star + star + star + star);
          $( "#price" ).text("R8993.00 p/n");
          
        } else if(sel.val() === "dth") {   
          $( "#hotel_image" ).css("background-image", "url('assets/dth.jpg')");   
          $( "#hotel_name" ).text("DoubleTree by Hilton Hotel Cape Town - Upper Eastside");
          $( "#hotel_blurb" ).text("Overlooking the busy Cape Town harbor and with an impressive backdrop of the green slopes of Devil’s Peak, DoubleTree by Hilton Hotel Cape Town - Upper Eastside offers easy access to the vibrant downtown area and the central business district.");
          $( "#stars" ).html(star + star + star + star + starO);
          $( "#price" ).text("R1214.00 p/n");
        }      
      }); 
		});
  </script>
</head>
<body>
  <div class="preload">
    <img src="assets/lsb.jpg" alt="">
    <img src="assets/dlla.jpg" alt="">
    <img src="assets/ttb.jpg" alt="">
    <img src="assets/dth.jpg" alt="">
  </div>
  <header>
  <h2>HotelBooking</h2>
  <?php
  if (isset($_SESSION['user'])) {
    $makeBooking = new makeBooking($conn);
    if (isset($_POST['book'])) {
      $makeBooking->insertBooking($conn);
    }
    if (isset($_POST['edit'])) {
      $makeBooking->editBooking($conn);
    }
    ?>
    <form action="index.php" method="post">
      <h3 id="logged_user">
        Logged in as&nbsp<span class="cap"><?php echo $_SESSION['user'] . " " . $_SESSION['surname']; ?></span>&nbsp|&nbsp<button class="link" type="submit" name="logout">Sign out</button>
      </h3>
    </form>
  </header>
  <main class="hidden">
    <form action="book.php" method="post" class="grid">
        <div class="logbox">
          <h2>
            <?php if(isset($_SESSION['edit_booking'])) {
              echo "Edit Booking ID: #" . $_SESSION['booking_id']; 
            } else {
              echo "Make a Booking";
            }
            ?>
          </h2>
          <div class="inputs">
            <div class="field date">
              <span class="label_mini">
                <label for="hotel">Select a hotel</label>
              </span>
              <div>
                <i class="fas fa-hotel"></i>
                <select name="hotel" id="">
                  <option value="lsb">Long Street Backpackers</option>
                  <option value="dlla">Daddy Long Legs Art Hotel</option>
                  <option value="ttb">The Table Bay Hotel</option>
                  <option value="dth">DoubleTree by Hilton Hotel</option>
                </select>
              </div>
            </div>
            <div class="field date">
              <span class="label_mini">
                <label for="date_in">Check-in</label>
              </span>
              <div>
                <i class="far fa-calendar-alt"></i>
                <input type="date" name="date_in" value="<?php echo date('Y-m-d');?>">
              </div>
            </div>
            <div class="field date">
              <span class="label_mini">
                <label for="date_out">Check-out</label>
              </span>
              <div>
                <i class="far fa-calendar-alt"></i>
                <input type="date" name="date_out" value="<?php echo date('Y-m-d');?>">
              </div>
            </div>
            <div class="field">
              <div class="drop_down"> 
                <span class="label_mini">
                  <label for="guests">No. guests</label>            
                </span>
                <select name="guests">
                  <?php for ($i=1; $i<=100; $i++) { ?>
                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="drop_down">
                <span class="label_mini">
                  <label for="rooms">No. rooms</label>             
                </span>
                <select name="rooms">
                  <?php for ($i=1; $i<=50; $i++) { ?>
                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <span class="hidden">
              <input type="text" name="submit_id" <?php if(isset($_SESSION['edit_booking'])){ echo "value='" . $_SESSION['booking_id'] . "'"; }?>>
            </span>
            <button type="submit" name="<?php if(isset($_SESSION['edit_booking'])){ echo 'edit'; } else { echo 'book'; } ?>">
              <?php if(isset($_SESSION['edit_booking'])){ echo 'Edit booking'; } else { echo 'Make booking'; } ?>
            </button>
          </div>
        </div>
        <div id="hotel_image">
          <div class="overlay">
            <div class="description" id="description">
              <div class="stars" id="stars">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>
              </div>
              <div class="hotel_blurb" id="hotel_blurb">
                Long Street Backpackers is an old school, communal, traveller’s hostel in the heart of Cape Town. Here, we’re all about new friends, spontaneity and laid-back fun. It is centrally located in Cape Town’s City Bowl, making it the perfect home base while you explore the Mother City.
              </div>
            </div>
          </div>
          <div class="hotel_desc">
            <h2 id="hotel_name">Long Street Backpackers</h2>
          </div>
          <div class="price" id="price">
            R300.00 p/n
          </div>
        </div>
    </form>
  </main>
    <?php
  } else {
    ?>
    <h3>
      <a href="register.php">Create an account</a> &nbsp | &nbsp <a href="index.php">Sign in</a>
    </h3>
  </header>
  <main class="hero">
    <section>
      <h1>HotelBooking</h1>
      <p class="hero_greeting">
        To make a booking
        <a href="index.php" class="cta">Sign in</a> or 
        <a href="register.php" class="cta">Create an account</a>
      </p>
    </section>
  </main>
  <?php
  }
  ?>
  <footer>
    <h2>copyright &copy EVAN CHRISTIANS <?php echo date("Y") ?></h2>
  </footer>
</body>
</html>
<?php
session_start();
if (isset($_SESSION['id'])){
  header("Location: home.php");
  exit;
}
// Fetch membership plans from the database
include('dbconnection.php');

$query = "SELECT plans_id, plan_name, duration FROM plans";
$result = $conn->query($query);
$plans = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $plans[] = $row; // Store plans in an array
    }
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Styling-->
    <link rel="stylesheet" href="css/style.css" />

    <!-- FavIcon -->
    <link rel="shortcut icon" href="image/workout (1).png" />

    <!-- RemixIcon -->
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
    />
    <link rel="stylesheet" href="./css/Timetable.css" />
    <style>
      /* Container for dropdown */
.dropdown {
    position: relative;
    display: inline-block;
}

/* Dropdown menu */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

/* Change color of links on hover */
.dropdown-content a:hover {
    background-color: #f1f1f1;
}

/* Show the dropdown menu when hovering over the button */
.dropdown:hover .dropdown-content {
    display: block;
}

/* Change the button background on hover */
.dropdown:hover .dropdown-btn {
    background-color: #3e8e41;
}
    </style>
    <title>Cardio Crush Fitness Zone</title>
  </head>
  <body>
    <!--------------- Header ----------------------->

    <div class="header" id="header">
      <nav class="nav container">
        <a href="#" class="nav__logo">
          <img src="image/workout (1).png" alt="logo" />
          𝐂𝐚𝐫𝐝𝐢𝐨 𝐂𝐫𝐮𝐬𝐡
        </a>

        <div class="nav__menu" id="nav-menu">
          <ul class="nav__list">
            <li class="nav__item">
              <a href="#home" class="nav__link active-link">Home</a>
            </li>
            <li class="nav__item">
              <a href="#about" class="nav__link">About Us</a>
            </li>
            <li class="nav__item">
              <a href="#program" class="nav__link">Program</a>
            </li>
            <li class="nav__item">
              <a href="#choose" class="nav__link">Choose Us</a>
            </li>
            <li class="nav__item">
              <a href="#pricing" class="nav__link">Pricing</a>
            </li>
           
<!-- Register Section (only visible when logged out) -->
<div class="nav__link">
    <div class="dropdown">
        <button class="button nav__button dropdown-btn">Login</button>
        <div class="dropdown-content">
            <a href="admin/admin_signin.php">Admin</a>
            <a href="./signin.php">User</a>
        </div>
    </div>
</div>





          </ul>
          <div class="nav__close" id="nav-close">
            <i class="ri-close-line"></i>
          </div>
        </div>
        <!-- Toggle button -->
        <div class="nav__toggle" id="nav-toggle">
          <i class="ri-menu-fill"></i>
        </div>
      </nav>
    </div>

    <!--------------------- main --------------------------------->
    <main class="main">
      <section class="home" id="home">
        <div class="home-overlay"></div>
        <!----------------- === Banner Starts ===------------------->
        <div class="banner">
          <div class="banner-contents">
            <h2>Start your training at <span id="span">Cardio Crush</span></h2>
            <h1>Fit body needs more training</h1>
            <p>where your journey to a healthier, more energized you begins!</p>
            <!-- <button class="btnn read-more-btn"> <a href="./signin.html">Join Now</a></button> -->
          </div>
        </div>
        <!----------------- === Banner Ends === ----------------------->
      </section>
      <!---------------------- Home Section Ends ------------------------------>
    </main>

    <!-- ==============About Us==================== -->

    <section class="section__container about__container" id="about">
      <div class="about__header">
        <h2 class="section__header">ABOUT US</h2>
      </div>
      <div class="about__grid">
        <div class="about__card">
          <h4>WINNER COACHES</h4>
          <p>
            We pride ourselves on having a team of dedicated and experienced
            coaches who are committed to helping you succeed.
          </p>
        </div>
        <div class="about__card">
          <h4>AFFORDABLE PRICE</h4>
          <p>
            We believe that everyone should have access to high-quality fitness
            facilities without breaking the bank.
          </p>
        </div>
        <div class="about__card">
          <h4>MODERN EQUIPMENTS</h4>
          <p>
            Stay ahead of the curve with our state-of-the-art equipment designed
            to elevate your workout experience.
          </p>
        </div>
      </div>
    </section>

    <!-- ========== Program =============-->
    <section class="program section" id="program">
      <div class="container">
        <div class="section__data">
          <h2 class="section__subtitle">Our Program</h2>
          <div class="section__titles">
            <h1 class="section__title-border">BUILD YOUR</h1>
            <h1 class="section__title">BEST BODY</h1>
          </div>
        </div>
        <div class="program__container grid">
          <article class="program__card">
            <div class="program__shape">
              <img
                src="image/program1.png"
                alt="program image"
                class="program__img"
              />
            </div>
            <h3 class="program__title">Strength Training</h3>
            <p class="program__description">
              Creating tension that's temporarily making the muscle fibers
              smaller or contracted.
            </p>
            <!-- <a href="#" class="program__button">
              <i class="ri-arrow-right-line"></i>
            </a> -->
          </article>
          <article class="program__card">
            <div class="program__shape">
              <img
                src="image/program2.png"
                alt="program image"
                class="program__img"
              />
            </div>
            <h3 class="program__title">Cardio Exercises</h3>
            <p class="program__description">
              Exercise your heart rate up and keeps it up for a prolonged period
              of time.
            </p>
            <!-- <a href="#" class="program__button">
              <i class="ri-arrow-right-line"></i>
            </a> -->
          </article>
          <article class="program__card">
            <div class="program__shape">
              <img
                src="image/program3.png"
                alt="program image"
                class="program__img"
              />
            </div>
            <h3 class="program__title">Yoga</h3>
            <p class="program__description">
              Diaphragmatic this is the most common breathing technique you'll
              find in yoga.
            </p>
            <!-- <a href="#" class="program__button">
              <i class="ri-arrow-right-line"></i>
            </a> -->
          </article>
          <article class="program__card">
            <div class="program__shape">
              <img
                src="image/program4.png"
                alt="program image"
                class="program__img"
              />
            </div>
            <h3 class="program__title">Weight Lifting</h3>
            <p class="program__description">
              Attempts a maximum weight single lift of a barbell loaded with
              weight plates.
            </p>
            <!-- <a href="#" class="program__button">
              <i class="ri-arrow-right-line"></i>
            </a> -->
          </article>
        </div>
      </div>
    </section>

      <!-- ==========Trainers ============ -->
      <section class="trainer" id="trainer">
        <div class="trainer-section">
          <h1 class="section__subtitle">Meet Our Trainers</h1>
          <div class="trainer-grid" id="trainerGrid">
            <!-- Trainer cards will be dynamically loaded here -->
          </div>
        </div>
    </section>

    <!--================= Choose Us ================-->
    <section class="choose section" id="choose">
      <div class="choose__overflow">
        <div class="choose__container container grid">
          <div class="choose__content">
            <div class="section__data">
              <h2 class="section__subtitle">Best Reason</h2>
              <div class="section__titles">
                <h1 class="section__title-border">WHY</h1>
                <h1 class="section__title">CHOOSE US?</h1>
              </div>
            </div>
            <p class="choose__description">
              Choose your favorite class and start now. Remember the only bad
              workout is the one you didn't do.
            </p>
            <div class="choose__data">
              <div class="choose__group">
                <h3 class="choose__number">200+</h3>
                <p class="choose__subtitle">Total Members</p>
              </div>
              <div class="choose__group">
                <h3 class="choose__number">30+</h3>
                <p class="choose__subtitle">Trainers</p>
              </div>
              <div class="choose__group">
                <h3 class="choose__number">20+</h3>
                <p class="choose__subtitle">Programs</p>
              </div>
              <div class="choose__group">
                <h3 class="choose__number">100+</h3>
                <p class="choose__subtitle">Awards</p>
              </div>
            </div>
          </div>
          <div class="choose__images">
            <img
              src="image/choose-img.png"
              alt="choose img"
              class="choose__img"
            />
          </div>
        </div>
      </div>
    </section>

    <!-- ============== LOGOS ===================== -->
    <section class="logos section">
      <div class="logos__container container grid">
        <img src="image/logo1.png" alt="logo image" class="logos__img" />
        <img src="image/logo2.png" alt="logo image" class="logos__img" />
        <img src="image/logo3.png" alt="logo image" class="logos__img" />
        <img src="image/logo4.png" alt="logo image" class="logos__img" />
      </div>
    </section>
    <!-- ============ LOOGS ENDS HERE ============= -->

    <!-- ===============PRICING==================== -->
    <section class="section__container price__container" id="pricing">
      <h2 class="section__header">OUR PRICING PLAN</h2>
      <p class="section__subheader">
        Our pricing plan comes with various membership tiers, each tailored to
        cater to different preferences and fitness aspirations.
      </p>
      <div class="price__grid">
        <div class="price__card">
          <div class="price__card__content">
            <h3 id="plan-name-1" class="section__title-border"></h3>
            <p id="plan-description-1" class="section_subheader"></p>
            <h4><span id="plan-duration-1"></span> Month</h4>
            <h3>Rs.<span id="price-1"></span></h3>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              Admission fee (Rs. 500)
            </p>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              Smart workout plan
            </p>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              All member events
            </p>
          </div>
          <!-- <button class="btn price__btn">
            <a id="2" href="">Join Now</a>
          </button> -->
        </div>
        <div class="price__card">
          <div class="price__card__content">
            <h3 id="plan-name-2" class="section__title-border"></h3>
            <p id="plan-description-2"></p>
            <h4><span id="plan-duration-2"></span> Month</h4>
            <h3>Rs.<span id="price-2"></span></h3>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              Admission fee (Rs. 500)
            </p>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              Smart workout plan
            </p>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              All member events
            </p>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              All classes
            </p>
          </div>
          <!-- <button class="btn price__btn">
            <a id="2" href="/signin.html">Join Now</a>
          </button> -->
        </div>

        <div class="price__card">
          <div class="price__card__content" >
          <h3 id="plan-name-3" class="section__title-border"></h3>
          <p id="plan-description-3"></p>
            <h4><span id="plan-duration-3"></span> Month</h4>
            <h3>Rs.<span id="price-3"></span></h3>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              Admission fee (Rs. 500)
            </p>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              All members events
            </p>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              Full gym access
            </p>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              Personal Training
            </p>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              All classes
            </p>
          </div>
          <!-- <button class="btn price__btn">
            <a id="2" href="/signin.html">Join Now</a>
          </button> -->
        </div>
        <div class="price__card">
          <div class="price__card__content">
            <h3 id="plan-name-4" class="section__title-border"></h3>
             <p id="plan-description-4"></p>
            <h4><span id="plan-duration-4"></span> Month</h4>
            <h3>Rs.<span id="price-4"></span></h3>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              Admission fee (Rs. 500)
            </p>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              All members events
            </p>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              Smart workout plan
            </p>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              Full gym access
            </p>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              Personal Training
            </p>
            <p>
              <i class="ri-checkbox-circle-line"></i>
              All classes
            </p>
          </div>
          <!-- <button class="btn price__btn">
            <a id="2" href="/signin.html">Join Now</a>
          </button> -->
        </div>
      </div>
    </section>

    <!-- ===============CALCULATE=================== -->
    <section class="calculate section">
      <div class="calculate__container container grid">
        <div class="calculate__content">
          <div class="section__titles">
            <h1 class="section__title-border">CALCULATE</h1>
            <h1 class="section__title">YOUR BMI</h1>
          </div>
          <p class="calculate__description">
            Enter your height and weight to calculate your Body Mass Index
            (BMI). BMI is a measure of body fat based on height and weight, and
            it's important for diagnosing and managing various health
            conditions.
          </p>
          <form action="" class="calculate__form" id="calculate-form">
            <div class="calculate__box">
              <input
                type="number"
                placeholder="Height"
                class="calculate__input"
                id="calculate-cm"
              />
              <label for="" class="calculate__label">cm</label>
            </div>
            <div class="calculate__box">
              <input
                type="number"
                placeholder="Weight"
                class="calculate__input"
                id="calculate-kg"
              />
              <label for="" class="calculate__label">kg</label>
            </div>
            <button class="button button__flex">
              CALCULATE NOW<i class="ri-arrow-right-fill"></i>
            </button>
          </form>
          <p class="calculate__message" id="calculate-message"></p>
        </div>
        <img
          src="image/d0543dec11af1979cbecb5dd66352145-removebg-preview.png"
          alt="calculate img"
          class="calculate__img"
        />
      </div>
    </section>

    <!--==================Footer========================-->
    <footer class="footer section" id="footer">
      <div class="footer__container container grid">
        <div>
          <a href="#" class="footer__logo">
            <img src="image/workout (1).png" alt="GYM Logo" />Cardio Crush
          </a>
          <p class="footer__description">
            Subscribe for gym <br />
            updates below.
          </p>
          <form action="" class="footer__form" id="contact-form">
            <input
              type="email"
              name="user_email"
              placeholder="Your email"
              class="footer__input"
              id="contact-user"
            />
            <button type="submit" class="button">Subscribe</button>
          </form>
          <p class="footer__message" id="contact-message"></p>
        </div>
        <div class="footer__content">
          <div>
            <h3 class="footer__title">SERVICES</h3>
            <ul class="footer__links">
              <li>
                <a href="" class="footer__link">Flex Muscle</a>
              </li>
              <li>
                <a href="" class="footer__link">Cardio Exercises</a>
              </li>
              <li>
                <a href="" class="footer__link">Basic Yoga</a>
              </li>
              <li>
                <a href="" class="footer__link">Weight Lifting</a>
              </li>
            </ul>
          </div>
          <div>
            <h3 class="footer__title">PRICING</h3>
            <ul class="footer__links">
              <li>
                <a href="" class="footer__link">1 month</a>
              </li>
              <li>
                <a href="" class="footer__link">3 months</a>
              </li>
              <li>
                <a href="" class="footer__link">6 months</a>
              </li>
              <li>
                <a href="" class="footer__link">1 Year</a>
              </li>
            </ul>
          </div>
          <div>
            <h3 class="footer__title">CARDIO CRUSH</h3>
            <ul class="footer__links">
              <li>
                <a href="" class="footer__link">Home</a>
              </li>
              <li>
                <a href="" class="footer__link">About us</a>
              </li>
              <li>
                <a href="" class="footer__link">Program</a>
              </li>
              <li>
                <a href="" class="footer__link">Choose Us</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
         </footer>
    <!--==================== Scroll Up================-->
    <a href="#" class="scrollup" id="scroll-up">
      <i class="ri-arrow-up-line"></i>
    </a>
    <!-- ==============Scroll Reveal=================-->

    <!-- ==============Email js==================-->

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
    <!-- ========Main JS=============-->
    <script src="js/main.js"></script>
    <script>        
// Trainers load
async function fetchTrainers() {
    try {
        const response = await fetch('fetch_trainers.php');
        console.log('Response:', response); // Debug: Check if the response is okay
        if (!response.ok) {
            throw new Error('Failed to fetch trainers: ' + response.statusText);
        }
        const trainers = await response.json();
        console.log('Trainers data:', trainers); // Debug: Check the fetched data
        const trainerGrid = document.getElementById('trainerGrid');

        trainerGrid.innerHTML = ''; // Clear existing data

        trainers.forEach(trainer => {
            const card = document.createElement('div');
            card.classList.add('trainer-card');
            card.innerHTML = `
                <img src="${trainer.image}" alt="${trainer.trainer_name}">
                <h3>${trainer.trainer_name}</h3>
            `;
            trainerGrid.appendChild(card);
        });
    } catch (error) {
        console.error('Error fetching trainers:', error);
    }
}

async function fetchPlans() {
    try {
        const response = await fetch('fetch_plans.php');
        const data = await response.json();
        console.log('Plans data:', data); // Debug: Check the fetched data
        console.log('Response:', response); // Debug: Check if the response is okay
        if (!response.ok) {
            throw new Error('Failed to fetch plans: ' + response.statusText);
        }

        if (data.length === 0) {
            console.error('No plans found in the database.');
            return;
        }

        // Debugging: Check if price__grid exists
        const priceGrid = document.querySelector('.price__grid');
        if (!priceGrid) {
            console.error('Price grid not found');
            return;
        }

        // Update the DOM with pricing plan data
        data.forEach((plan, index) => {
            const planName = document.getElementById(`plan-name-${index + 1}`);
            // const planDescription = document.getElementById(`plan-description-${index + 1}`);
            const planDuration = document.getElementById(`plan-duration-${index + 1}`);
            const planPrice = document.getElementById(`price-${index + 1}`);
            
            // Ensure the plan elements are found before setting
            if (planName && planDuration && planPrice) {
                planName.innerText = plan.plan_name;
                // planDescription.innerText = plan.description;
                planDuration.innerText = plan.duration;
                planPrice.innerText = plan.price;
            } else {
                console.error(`Missing element for plan index ${index + 1}`);
            }
        });
    } catch (error) {
        console.error('Error fetching plans:', error);
    }
}
// Run the functions once the page is loaded
document.addEventListener('DOMContentLoaded', function () {
    fetchTrainers();
    fetchPlans();
});
</script>
  </body>
</html>

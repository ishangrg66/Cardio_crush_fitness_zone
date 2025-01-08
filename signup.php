<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color:rgb(19,23,24);
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      width: 100%;
      max-width: 400px;
      background:hsla(240, 37%, 89%, 0.075);
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 6px  hsl(34, 30.40%, 95.50%)
    }

    .form-box {
      text-align: center;
    }

    .title {
      font-size: 28px;
      margin-bottom: 10px;
      color: white;
    }

    .underline {
      width: 70px;
      height: 3px;
      background:rgb(232, 41, 12);
      margin: 0 auto 20px auto;
    }

    .input-field {
      margin-bottom: 15px;
      text-align: left;
    }

    .input-field label {
      display: block;
      font-size: 18px;
      margin-bottom: 5px;
      color: white;
    }

    .input-field input {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      outline: none;
      transition: 0.3s;
    }

    .input-field input:focus {
      border-color: #3498db;
    }

    .input-field span {
      color: red;
      font-size: 12px;
    }

    .btn-field {
      margin-top: 20px;
    }

    .btn-field button {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      background: #3498db;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn-field button:hover {
      background:rgb(238, 32, 13);
    }
    p span{
      color: white;
    }

    p span a {
      color:rgb(238, 32, 9);
      text-decoration: none;
    }

    p span a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="form-box">
      <h1 class="title">Sign Up</h1>
      <div class="underline"></div>
      <form action="register.php" method="post" onsubmit="return form_validate()">
        <div class="input-field" id="fname-field">
          <label for="fname">First Name</label>
          <input type="text" name="fname" id="fname" placeholder="First name" required />
          <span id="fname_msg"></span>
        </div>
        <div class="input-field" id="lname-field">
          <label for="lname">Last Name</label>
          <input type="text" name="lname" id="lname" placeholder="Last name" required />
          <span id="lname_msg"></span>
        </div>
        <div class="input-field" id="email-field">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" placeholder="Email" required />
          <span id="email_msg"></span>
        </div>
        <div class="input-field" id="phone-field">
          <label for="phone">Phone</label>
          <input type="text" name="phone" id="phone" placeholder="Phone" required />
          <span id="phone_msg"></span>
        </div>
        <div class="input-field" id="dob-field">
          <label for="date">Date of Birth</label>
          <input type="date" id="date" name="dob" placeholder="Date of Birth" />
        </div>
        <div class="input-field" id="password-field">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" placeholder="Password" required />
          <span id="password_msg"></span>
        </div>
        <div class="input-field" id="cpassword-field">
          <label for="cpassword">Confirm Password</label>
          <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password" required />
          <span id="cpassword_msg"></span>
        </div>
        <p>
          <span>Already have an account? <a href="signin.php">Click Here</a></span>
        </p>
        <div class="btn-field">
          <button type="submit" id="signUpBtn" name="signUp">
            <span>Sign Up</span>
          </button>
        </div>
      </form>
    </div>
  </div>


  <script src="./signUpscript.js"></script>
</body>
</html>

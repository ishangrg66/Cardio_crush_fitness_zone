<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register Page</title>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Poppins"
    />
    <style>
      * {
        margin: 0;
        padding: 0;
        font-family: "Poppins", sans-serif;
        box-sizing: border-box;
      }

      body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        min-width: 100vw;
      }

      .container {
        width: 100%;
        height: 100vh;
        background-position: center;
        background-size: cover;
        display: flex;
        justify-content: center;
        align-items: center;
      }
      .error {
        color: red;
        text-align: center;
        margin-bottom: 10px;
      }

      .form-box {
        width: 90%;
        max-width: 450px;
        min-width: 300px;
        background: white;
        padding: 55px;
        text-align: center;
        border-radius: 10px;
        box-shadow: -2px 2px 15px rgba(0, 0, 0, 0.5);
      }

      .form-box h1 {
        font-size: 25px;
        color: green;
      }
      .form-box h1:hover {
        color: rgb(75, 176, 212);
        transition: 1s;
      }

      .form-box .underline {
        width: 80px;
        height: 3px;
        background-color: green;
        margin: 1px auto 40px auto;
        border-radius: 50px;
        transition: transform 0.5s;
      }
      .form-box .underline:hover {
        background-color: red;
        transition: 0.1s;
      }

      .input-field {
        background: #eaeaea;
        margin: 15px 0;
        border-radius: 10px;
        display: flex;
        align-items: center;
        max-height: 80px;
        transition: max-height 0.5s;
        overflow: hidden;
      }

      .input-field input {
        width: 100%;
        background: transparent;
        border: 0;
        outline: 0;
        padding: 10px 15px;
      }

      form p {
        text-align: left;
        font-size: 15px;
        margin: 10px 0;
      }

      form p a {
        text-decoration: none;
        color: green;
      }

      .btn-field {
        width: 100%;
        display: flex;
        justify-content: center;
        margin-top: 5px;
      }

      .btn-field button {
        width: 45%;
        background: green;
        color: white;
        height: 40px;
        border-radius: 20px;
        border: 0;
        outline: 0;
        cursor: pointer;
      }

      p {
        display: flex;
        justify-content: space-between;
      }
      span {
        height: 2rem;
        padding: 0.125vh;
        font-size: 14px;
      }
    </style>
  </head>

  <body>
    <div class="container">
      <div class="form-box">
        <h1 class="title">Recover Your Account</h1>
        <!-- <div class="underline"></div> -->
        <!-- Error message section -->
        <?php if (isset($_GET['error'])): ?>
        <div class="error">
          <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
        <?php endif; ?>
        <form
          action="recover_email.php"
          method="post"
          onsubmit="return form_validate()"
        >
          <div class="input-group">
            <div class="input-field" id="email-field">
              <input
                type="email"
                name="email"
                id="email"
                placeholder="Enter your registered email here"
                required
              />
            </div>

          </div>
          <div class="btn-field">
            <button type="submit" id="signInBtn" name="sendmail">
              <span>Send Mail</span>
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Script file -->
  </body>
</html>

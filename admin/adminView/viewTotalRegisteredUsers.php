<!-- This is view registration of sidebar -->
<!-- total no of users who register in our website -->

<div >
  <h2 class="text-center">Registered Users Details</h2>
  <table class="table ">
    <thead>
      <tr>
        <!-- <th class="text-center">User_ID</th> -->
        <th class="text-center">Full Name</th>
        <th class="text-center">Email</th>
        <th class="text-center">Phone</th>
        <th class="text-center">Birthdate</th>
        <th class="text-center" colspan="2">Action</th>
      </tr>
    </thead>
    <?php
      include_once "db.php";
      $sql="SELECT * from user_account";
      $result=$conn-> query($sql);
      $count=1;
      if ($result-> num_rows > 0){
        while ($row=$result-> fetch_assoc()) {
    ?>
    <tr>
    
      <td><?=$row["f_name"]?> <?=$row["l_name"]?></td>   
      <td><?=$row["email"]?></td>   
      <td><?=$row["phone"]?></td>
      <td><?=$row["birthdate"]?></td>
      <!-- <td><?=$row["password"]?></td>    -->
      <td>
   <!-- Edit Button: Triggers the modal with user data -->
   <button class="btn btn-success" style="height:40px" onclick="openEditModal(<?=$row['id']?>, '<?=$row['f_name']?>', '<?=$row['l_name']?>', '<?=$row['email']?>', '<?=$row['phone']?>', '<?=$row['birthdate']?>')">Edit</button>
</td>
      <td><button class="btn btn-danger" style="height:40px" onclick="totalRegisteredUsersDelete('<?=$row['id']?>')">Delete</button></td>
      </tr>
      <?php
            $count=$count+1;
          }
        }
      ?>
  </table>


        <!-- Add New User Start -->

   <!-- Trigger the modal with a button -->
<button type="button" class="btn btn-primary" style="height:40px" onclick="openModal()">Add New User</button>

<!-- Modal -->
<div id="myModal" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
  <div style="background-color: white; width: 50%; margin: 50px auto; padding: 20px; border-radius: 8px;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
      <h4>New User Details</h4>
      <button onclick="closeModal()" style="border: none; background: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>
    <form id="addUserForm" enctype="multipart/form-data" action="./controller/addNewUsersController.php" method="POST">
      <!-- First Name -->
      <div class="form-group" style="margin-bottom: 15px;">
        <label for="f_name">First Name:</label>
        <input type="text" name="f_name" id="f_name" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"/>
        <small class="text-danger" id="f_name_error" style="color: red;"></small>
      </div>
      <!-- Last Name -->
      <div class="form-group" style="margin-bottom: 15px;">
        <label for="l_name">Last Name:</label>
        <input type="text" name="l_name" id="l_name" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"/>
        <small class="text-danger" id="l_name_error" style="color: red;"></small>
      </div>
      <!-- Email -->
      <div class="form-group" style="margin-bottom: 15px;">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"/>
        <small class="text-danger" id="email_error" style="color: red;"></small>
      </div>
      <!-- Phone -->
      <div class="form-group" style="margin-bottom: 15px;">
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"/>
        <small class="text-danger" id="phone_error" style="color: red;"></small>
      </div>
      <!-- Birthdate -->
      <div class="form-group" style="margin-bottom: 15px;">
        <label for="birthdate">Date of Birth:</label>
        <input type="date" name="birthdate" id="birthdate" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"/>
        <small class="text-danger" id="birthdate_error" style="color: red;"></small>
      </div>
      <!-- Password -->
      <div class="form-group" style="margin-bottom: 15px;">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;"/>
        <small class="text-danger" id="password_error" style="color: red;"></small>
      </div>
      <!-- Submit Button -->
      <div class="form-group" style="margin-bottom: 15px;">
        <button type="submit" name="user_submit" id="addUserButton" style="padding: 10px 20px; background-color: #333; color: white; border: none; border-radius: 4px;">
          Add User
        </button>
      </div>
    </form>
    <button onclick="closeModal()" style="background-color: #ccc; padding: 10px 20px; border: none; border-radius: 4px;"></button>
  </div>
</div>
    </div>
  </div>
</div>
 <!-- Modal for Edit User -->
 <div id="editUserModal" class="modal" style="display: none;">
    <div class="modal-content">
      <span class="close-btn" id="closeFormBtn">&times; </span>
      <h2>Edit User Details</h2>
      <form id="editUserForm" action="./controller/users.php" method="post">
        <input type="hidden" name="id" id="editUserId"> <!-- Hidden field for user ID -->
        
        <label for="f_name">First Name:</label>
        <input type="text" name="f_name" id="editFName" class="inp">
        <div class="error" id="editFNameError"></div>

        <label for="l_name">Last Name:</label>
        <input type="text" name="l_name" id="editLName" class="inp">
        <div class="error" id="editLNameError"></div>

        <label for="email">Email:</label>
        <input type="email" name="email" id="editEmail" class="inp">
        <div class="error" id="editEmailError"></div>

        <label for="phone">Contact:</label>
        <input type="number" name="phone" id="editPhone" class="inp">
        <div class="error" id="editPhoneError"></div>

        <label for="birthdate">Date of Birth:</label>
        <input type="date" name="birthdate" id="editBirthdate" class="inp">
        <div class="error" id="editBirthdateError"></div>

        <label for="password">Password:</label>
        <input type="password" name="password" id="editPassword" class="inp">
        <div class="error" id="editPasswordError"></div>

        <input type="submit" name="user_update_submit" value="Submit" class="btn">
      </form>
    </div>
  </div>

</div>


<script>
   function openModal() {
    document.getElementById('myModal').style.display = 'block';
  }

  // Function to close the modal
  function closeModal() {
    document.getElementById('myModal').style.display = 'none';
  }

  // Validate form on submission
  document.getElementById("addUserForm").addEventListener("submit", function (e) {
    let valid = true;

    // Clear previous error messages
    document.querySelectorAll(".text-danger").forEach((el) => {
      el.textContent = "";
    });

    // First Name Validation
    const fName = document.getElementById("f_name").value.trim();
    if (!fName) {
      valid = false;
      document.getElementById("f_name_error").textContent = "First name is required.";
    }

    // Last Name Validation
    const lName = document.getElementById("l_name").value.trim();
    if (!lName) {
      valid = false;
      document.getElementById("l_name_error").textContent = "Last name is required.";
    }

    // Email Validation
    const email = document.getElementById("email").value.trim();
    if (!email) {
      valid = false;
      document.getElementById("email_error").textContent = "Email is required.";
    }

    // Phone Validation
    const phone = document.getElementById("phone").value.trim();
    const phoneRegex = /^(96|97|98)\d{8}$/;
    if (!phone) {
      valid = false;
      document.getElementById("phone_error").textContent = "Phone number is required.";
    } else if (!phoneRegex.test(phone)) {
      valid = false;
      document.getElementById("phone_error").textContent = "Phone number must start with 96, 97, or 98 and have 10 digits.";
    }

    // Birthdate Validation
    const birthdate = document.getElementById("birthdate").value;
    if (!birthdate) {
      valid = false;
      document.getElementById("birthdate_error").textContent = "Birthdate is required.";
    } else {
      const birthYear = new Date(birthdate).getFullYear();
      const currentYear = new Date().getFullYear();
      if (currentYear - birthYear < 10) {
        valid = false;
        document.getElementById("birthdate_error").textContent = "User must be at least 10 years old.";
      }
    }

    // Password Validation
    const password = document.getElementById("password").value.trim();
    if (!password) {
      valid = false;
      document.getElementById("password_error").textContent = "Password is required.";
    }

    // Prevent form submission if validation fails
    if (!valid) {
      e.preventDefault();
    }
  });


  document.getElementById("editUserForm").addEventListener("submit", function (e) {
  let valid = true;

  // Clear previous error messages
  document.querySelectorAll(".error").forEach((el) => {
    el.textContent = "";
  });

  // First Name Validation
  const fName = document.getElementById("editFName").value.trim();
  if (!fName) {
    valid = false;
    document.getElementById("editFNameError").textContent = "First name is required.";
  }

  // Last Name Validation
  const lName = document.getElementById("editLName").value.trim();
  if (!lName) {
    valid = false;
    document.getElementById("editLNameError").textContent = "Last name is required.";
  }

  // Email Validation
  const email = document.getElementById("editEmail").value.trim();
  const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
  if (!email || !emailRegex.test(email)) {
    valid = false;
    document.getElementById("editEmailError").textContent = "Valid email is required.";
  }

  // Phone Validation
  const phone = document.getElementById("editPhone").value.trim();
  const phoneRegex = /^(96|97|98)\d{8}$/; // Starts with 96, 97, or 98 and is 10 digits long
  if (!phone) {
    valid = false;
    document.getElementById("editPhoneError").textContent = "Phone number is required.";
  } else if (!phoneRegex.test(phone)) {
    valid = false;
    document.getElementById("editPhoneError").textContent = "Phone number must start with 96, 97, or 98 and have 10 digits.";
  }

  // Birthdate Validation
  const birthdate = document.getElementById("editBirthdate").value;
  if (!birthdate) {
    valid = false;
    document.getElementById("editBirthdateError").textContent = "Birthdate is required.";
  } else {
    const birthYear = new Date(birthdate).getFullYear();
    const currentYear = new Date().getFullYear();
    if (currentYear - birthYear < 10) {
      valid = false;
      document.getElementById("editBirthdateError").textContent = "User must be at least 10 years old.";
    }
  }

  // Password Validation
  const password = document.getElementById("editPassword").value.trim();
  if (!password) {
    valid = false;
    document.getElementById("editPasswordError").textContent = "Password is required.";
  }

  // Prevent form submission if validation fails
  if (!valid) {
    e.preventDefault();
  }
});

  // Function to open the modal and populate it with user data
function openEditModal(id, firstName, lastName, email, phone, birthdate) {
  // Populate the form fields with the current user's data
  document.getElementById('editUserId').value = id;
  document.getElementById('editFName').value = firstName;
  document.getElementById('editLName').value = lastName;
  document.getElementById('editEmail').value = email;
  document.getElementById('editPhone').value = phone;
  document.getElementById('editBirthdate').value = birthdate;

  // Show the modal
  document.getElementById('editUserModal').style.display = 'block';
}

// Function to close the modal
document.getElementById('closeFormBtn').onclick = function() {
  document.getElementById('editUserModal').style.display = 'none';
}

// Close the modal if clicked outside of the modal content
window.onclick = function(event) {
  if (event.target == document.getElementById('editUserModal')) {
    document.getElementById('editUserModal').style.display = 'none';
  }
}
</script>
<style>
  /* Overall Body Styling */
  body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7fa;
    margin: 0;
    padding: 0;
  }

  /* Modal Styling */
  .modal {
   /* Hidden by default */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
    padding-top: 60px;
    transition: all 0.3s ease;
  }

  .modal-content {
    background-color: #fff;
    margin: 5% auto;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #ddd;
    width: 50%;
    max-height: 80vh; /* Limit height */
    overflow-y: auto; /* Allow scrolling if content exceeds height */
    box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-out;
  }

  .modal-content h2 {
    text-align: center;
    font-size: 24px;
    color: #333;
    margin-bottom: 15px;
  }

  .close-btn {
    color: #aaa;
    font-size: 30px;
    font-weight: bold;
    position: absolute;
    top: 10px;
    right: 15px;
    cursor: pointer;
  }

  .close-btn:hover,
  .close-btn:focus {
    color: #333;
  }

  /* Form Styling */
  form {
    display: flex;
    flex-direction: column;
    gap: 15px;
  }

  label {
    font-size: 14px;
    font-weight: 600;
    color: #555;
  }

  input[type="text"],
  input[type="email"],
  input[type="number"],
  input[type="date"],
  input[type="password"] {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 100%;
    box-sizing: border-box;
    transition: border 0.3s ease;
  }

  input[type="text"]:focus,
  input[type="email"]:focus,
  input[type="number"]:focus,
  input[type="date"]:focus,
  input[type="password"]:focus {
    border: 1px solid #007bff;
    outline: none;
  }

  .error {
    color: red;
    font-size: 12px;
  }
/* 
  .btn {
    background-color: #007bff;
    color: white;
    padding: 12px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  } */

  .btn:hover {
    background-color: #0056b3;
  }

  /* Modal Button Styling */
  .modal-footer {
    text-align: center;
  }

  /* Responsive Design for Smaller Screens */
  @media (max-width: 768px) {
    .modal-content {
      width: 80%;
    }

    .close-btn {
      font-size: 24px;
    }

    form {
      gap: 10px;
    }

    label {
      font-size: 13px;
    }

    .btn {
      padding: 10px;
      font-size: 14px;
    }
  }
</style>

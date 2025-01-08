<!-- This is Trainers of sidebar -->

<div>
  <h3 class="text-center">Trainers Details</h3>
  <table class="table">
    <thead>
      <tr>
        <th>Trainer Name</th>
        <th>Image</th>
        <th>Phone Number</th>
        <th class="text-center" colspan="2">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      include_once "db.php";
      $sql = "SELECT * FROM trainers";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
      ?>
       <tr>
    <td>
        <?= htmlspecialchars($row["trainer_name"]) ?>
    </td>
    <td>
    <?php if (!empty($row["image"])): ?>
        <img 
            src="<?= htmlspecialchars($row["image"]) ?>" 
            style="width: 100px; height: 150px; border-radius: 5px;"
        >
    <?php else: ?>
        <p>No Image Available</p>
    <?php endif; ?>
</td>

    <td><?= htmlspecialchars($row["phone_number"]) ?></td>
    <td>
       <!-- Button to trigger edit modal -->
<button type="button" class="btn btn-success" onclick="openEditModal('<?= $row['trainer_id'] ?>', '<?= htmlspecialchars($row['trainer_name']) ?>', '<?= htmlspecialchars($row['phone_number']) ?>', '<?= htmlspecialchars($row['image']) ?>', '<?= htmlspecialchars($row['address']) ?>')">
    Edit
</button>
    </td>
    <td>
        <form action="controller/trainerDeleteController.php" method="POST">
            <input type="hidden" name="trainer_id" value="<?= $row['trainer_id'] ?>">
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </td>
</tr>

      <?php
        }
      } else {
      ?>
        <tr>
          <td colspan="5" class="text-center">No trainers found</td>
        </tr>
      <?php
      }
      ?>
    </tbody>
  </table>
</div>



        <!-- Add New Trainer Start -->

 <!-- Button to trigger modal -->
<button type="button" class="btn btn-secondary" style="height:40px" data-toggle="modal" data-target="#myModal">
    Add New Trainer
</button>    

<!-- Modal Structure -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Trainer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="add_trainer.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label for="trainer_name">Trainer Name</label>
                        <input type="text" name="trainer_name" id="trainer_name" class="form-control" placeholder="Enter Trainer Name" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-control-file" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="Enter Phone Number" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" class="form-control" placeholder="Enter Address" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Add Trainer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Trainer Modal Structure -->
<div class="modal fade" id="editTrainerModal" tabindex="-1" role="dialog" aria-labelledby="editTrainerLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTrainerLabel">Edit Trainer Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="controller/edit_trainer.php" method="POST" enctype="multipart/form-data" onsubmit="return validateEditForm()">
                    <input type="hidden" name="trainer_id" id="edit_trainer_id">

                    <div class="form-group">
                        <label for="edit_trainer_name">Trainer Name</label>
                        <input type="text" name="trainer_name" id="edit_trainer_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_image">Image</label>
                        <input type="file" name="image" id="edit_image" class="form-control-file" accept="image/*">
                        <small>Leave blank to keep the current image</small>
                    </div>

                    <div class="form-group">
                        <label for="edit_phone_number">Phone Number</label>
                        <input type="text" name="phone_number" id="edit_phone_number" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_address">Address</label>
                        <textarea name="address" id="edit_address" class="form-control" rows="4" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-success mt-3">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap CSS and JS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Custom CSS -->
<style>
    .modal-body form {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-control, 
    .form-control-file, 
    textarea {
        border-radius: 5px;
        resize: none;
    } 

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .modal-header {
        border-bottom: 1px solid #dee2e6;
    }

    .modal-title {
        font-size: 1.25rem;
    }
</style>

<script>
  // Client-side validation before form submission
  function validateForm() {
            const name = document.querySelector('input[name="trainer_name"]').value;
            const phone = document.querySelector('input[name="phone_number"]').value;
            const address = document.querySelector('textarea[name="address"]').value;
            const image = document.querySelector('input[name="image"]').files[0];

            // Validate Trainer Name (non-empty)
            if (name.trim() === '') {
                alert('Please enter the trainer\'s name.');
                return false;
            }

            // Validate Phone Number (non-empty and numeric)
            const phonePattern = /^(96|97|98)[0-9]{8}$/;
            if (!phonePattern.test(phone)) {
                alert('Please enter a valid phone number with 10 digits.');
                return false;
            }

            // Validate Address (non-empty)
            if (address.trim() === '') {
                alert('Please enter the address.');
                return false;
            }

            // Validate Image (non-empty and valid image type)
            if (!image) {
                alert('Please upload an image.');
                return false;
            }

            const allowedImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!allowedImageTypes.includes(image.type)) {
                alert('Please upload a valid image (JPEG, PNG, JPG).');
                return false;
            }

            return true; // Form is valid
        }


        function trainerDelete(trainer_id) {
    if (confirm('Are you sure you want to delete this trainer?')) {
        // AJAX request to delete the trainer
        $.ajax({
            url: '/controller/trainerDeleteController.php',
            type: 'POST',
            data: { id: trainer_id },
            success: function(response) {
                if (response === 'success') {
                    alert('Trainer deleted successfully');
                    // Optionally refresh the page or table
                    location.reload();
                } else {
                    alert('Error deleting trainer');
                }
            }
        });
    }
}

function openEditModal(id, name, phone, image, address) {
    document.getElementById('edit_trainer_id').value = id;
    document.getElementById('edit_trainer_name').value = name;
    document.getElementById('edit_phone_number').value = phone;
    document.getElementById('edit_address').value = address;

    $('#editTrainerModal').modal('show');
}

function validateEditForm() {
    const name = document.getElementById('edit_trainer_name').value.trim();
    const phone = document.getElementById('edit_phone_number').value.trim();
    const address = document.getElementById('edit_address').value.trim();

    if (name === '' || phone === '' || address === '') {
        alert('All fields are required!');
        return false;
    }

    const phonePattern = /^(96|97|98)[0-9]{8}$/;
    if (!phonePattern.test(phone)) {
        alert('Please enter a valid phone number with 10 digits.');
        return false;
    }

    return true;
}
</script>

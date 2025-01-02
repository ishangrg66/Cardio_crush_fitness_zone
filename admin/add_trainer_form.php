<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Trainer - Admin Dashboard</title>
    <style>
        /* General page styling */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: #f2f3f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        /* Form container styling */
        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
            box-sizing: border-box;
        }

        .form-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #4CAF50;
        }

        /* Input fields styling */
        .form-container input[type="text"],
        .form-container input[type="file"],
        .form-container textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        /* Input focus state */
        .form-container input[type="text"]:focus,
        .form-container input[type="file"]:focus,
        .form-container textarea:focus {
            border-color: #4CAF50;
            outline: none;
        }

        /* Textarea specific styling */
        textarea {
            resize: none;
            height: 120px; /* Adjust height for better visibility */
            font-family: 'Arial', sans-serif;
        }

        /* Submit button styling */
        .form-container button {
            padding: 12px 25px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 100%; /* Full-width button */
        }

        /* Button hover effect */
        .form-container button:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        /* Responsive styling for mobile */
        @media (max-width: 600px) {
            .form-container {
                padding: 20px;
                width: 90%;
            }

            .form-container h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add New Trainer</h2>
        <form action="add_trainer.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            <input type="text" name="trainer_name" placeholder="Trainer Name" required>
            <input type="file" name="image" accept="image/*" required>
            <input type="text" name="phone_number" placeholder="Phone Number" required>
            <textarea name="address" placeholder="Address" rows="4" required></textarea>
            <button type="submit">Add Trainer</button>
        </form>
    </div>

    <script>
        // JavaScript form validation
        function validateForm() {
            const name = document.getElementById('trainer_name').value;
            const phone = document.getElementById('phone_number').value;
            const address = document.getElementById('address').value;
            const image = document.getElementById('image').files[0];

            // Validate Trainer Name (non-empty)
            if (name.trim() === '') {
                alert('Please enter the trainer\'s name.');
                return false;
            }

            // Validate Phone Number (non-empty and numeric)
            const phonePattern = /^(96|97|98)[0-9]{7}$/;
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
    </script>
</body>
</html>

<style>
  /* Membership Verification Section */
  .membership-verification-section {
    padding: 30px;
    font-family: Arial, sans-serif;
  }

  .membership-verification-section h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 1.8rem;
    color: #333;
  }

  /* Table Styles */
  .membership-table {
    width: 100%;
    border-collapse: collapse;
    margin: 0 auto;
  }

  .membership-table th,
  .membership-table td {
    border: 1px solid #ddd;
    width: 100%;
    padding: 20px;
    text-align: center;
    font-size: 1rem;
    color: #555;
  }

  /* Header Row Styling */
  .membership-table th {
    background-color: #007BFF;
    /* Blue header background */
    color: white;
    /* White text */
    font-weight: bold;
  }

  /* Alternate Row Styling */
  .membership-table tr:nth-child(even) {
    background-color: #f9f9f9;
  }

  /* Hover Effect */
  .membership-table tr:hover {
    background-color: #f1f1f1;
  }

  /* No Data Styling */
  .no-data {
    text-align: center;
    font-size: 1.1rem;
    color: #888;
  }

  /* Button Styles */
  .action-button {
    padding: 8px 15px;
    font-size: 0.9rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  /* Accept Button */
  .action-button.accept {
    background-color: #4CAF50;
    color: white;
  }

  .action-button.accept:hover {
    background-color: #45a049;
  }

  /* Reject Button */
  .action-button.reject {
    background-color: #f44336;
    color: white;
  }

  .action-button.reject:hover {
    background-color: #d32f2f;
  }

  /* Cancel Button */
  .action-button.cancel {
    background-color: #FFC107;
    color: white;
  }

  .action-button.cancel:hover {
    background-color: #FFB300;
  }
</style>

<div class="membership-verification-section">
  <h2>New Membership Verification</h2>
  <table class="membership-table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Plan Name</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Status</th>
        <th>Payment Status</th>
        <th>Payment Proof</th>
        <th colspan="2">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      include_once "db.php";

      $sql = "
                SELECT m.membership_id, u.f_name, u.l_name, p.plan_name, m.start_date, m.end_date, m.status, m.payment_status, m.payment_proof
                FROM memberships m
                JOIN user_account u ON m.id = u.id
                JOIN plans p ON m.plans_id = p.plans_id
            ";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
      ?>
          <tr>
            <td><?= htmlspecialchars($row["f_name"] . " " . $row["l_name"]) ?></td>
            <td><?= htmlspecialchars($row["plan_name"]) ?></td>
            <td><?= htmlspecialchars($row["start_date"]) ?></td>
            <td><?= htmlspecialchars($row["end_date"]) ?></td>
            <td><?= htmlspecialchars($row["status"]) ?></td>
            <td><?= htmlspecialchars($row["payment_status"]) ?></td>
            <td>
              <?php if (!empty($row["payment_proof"])): ?>
                <img src="C:/Xamppppp/htdocs/cardiocrush-master/admin/payment_proofs/<?= htmlspecialchars($row["payment_proof"]) ?>"
                  width="200"
                  alt="Payment Proof"
                  height="200">
              <?php else: ?>
                <p>No payment proof provided.</p>
              <?php endif; ?>
            </td>
            <td>
              <form action="controller/update_membership_status.php" method="POST" onsubmit="return confirm('Are you sure you want to update the membership status?')">
                <input type="hidden" name="membership_id" value="<?= $row['membership_id'] ?>">

                <?php if ($row['status'] !== 'active'): ?>
                  <button class="action-button accept" type="submit" name="update_status" value="active">Accept</button>
                  <button class="action-button reject" type="submit" name="update_status" value="rejected">Reject</button>
                <?php else: ?>
                  <button class="action-button cancel" type="submit" name="cancel_membership">Cancel Membership</button>
                <?php endif; ?>
              </form>
            </td>
          </tr>
      <?php
        }
      } else {
        echo "<tr><td colspan='9' class='no-data'>No memberships found.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>
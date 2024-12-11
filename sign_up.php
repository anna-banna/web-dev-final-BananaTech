<?php
require_once '../secure_conn.php';
require 'includes/header.php';
if (isset($_POST['submit']) && $_POST['submit'] == 'Register') {
    $missing = array();

    $firstname = trim($_POST['firstname']);
    if (!empty($_POST['firstname']))
        $firstname = $_POST['firstname'];
    else
        $missing['firstname'] = 'First name is required:';

    $lastname = trim($_POST['lastname']);
    if (!empty($_POST['lastname']))
        $lastname = $_POST['lastname'];
    else
        $missing['lastname'] = 'Last name is required:';

    if (!empty($_POST['useCase']))
        $useCase = $_POST['useCase'];
    else
        $missing['useCase'] = 'A use case is required:';

    $valid_email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    if (empty($_POST['email']))
        $missing['email'] = 'Please enter an email address';
    elseif (!$valid_email)
        $missing['email'] = 'Please enter a valid email address';
    else
        $email = $valid_email;

    if (!empty($_POST['pwd'])) {
        $pwd = $_POST['pwd'];
        if ($_POST['pwd'] != $_POST['confirm'])
            $missing['confirm'] = 'Passwords do not match:';
    } else
        $missing['pwd'] = 'Password is required:';

    try {
        require_once '../../pdo_connect.php';
        $sql = "SELECT * FROM btUsers WHERE emailAddr = :email";
        $stmt = $dbc->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $numRows = $stmt->rowCount();
        if ($numRows >= 1) {
            $missing['exists'] = 'An account with this email already exists. Please log in or use a different email.';
        }

        if (empty($missing)) {
            //Use a regular expression to create a older name from email stripped of nonalphanumeric characters
            $folder = preg_replace("/[^a-zA-Z0-9]/", "", $email);
            // make lowercase
            $folder = strtolower($folder);
            $sql2 = "INSERT INTO btUsers (firstname, lastname, emailAddr, pw, useType, folder) VALUES (:firstname, :lastname, :email, :pwd, :useCase, :folder)";
            $stmt2 = $dbc->prepare($sql2);
            $pw_hash = password_hash($pwd, PASSWORD_DEFAULT);
            $stmt2->bindParam(':firstname', $firstname);
            $stmt2->bindParam(':lastname', $lastname);
            $stmt2->bindParam(':email', $email);
            $stmt2->bindParam(':pwd', $pw_hash);
            $stmt2->bindParam(':useCase', $useCase);
            $stmt2->bindParam(':folder', $folder);
            $stmt2->execute();
            $numRows2 = $stmt2->rowCount();
            if ($numRows2 != 1) {
                echo '<h2>There was a problem with your registration. Please try again.</h2>';
            } else {
                //create the directory in the uploads folder
                $dirPath = "../../uploads/" . $folder;
                mkdir($dirPath, 0777);
                echo '<h2>Thank you for registering!</h2>';
                echo '<p>You are now registered as a valued BananaTech customer.</p>';
                echo '<p>Please <a href="login.php">log in</a> to access the customer portal.</p>';
            }
            require 'includes/footer.php';
            exit;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
<section>
    <h3>Register to be a valued BananaTech Customer</h3>
    <p>
        Please fill out the form below to register for our services.
        If you already have an account, please <a href="login.php">log in</a>.
    </p>
</section>
<form method="post" action="sign_up.php">
    <fieldset>
        <legend>Register for our services:</legend>
        <?php if (!empty($missing))
            echo '<span class="warning">Please fix the item(s) indicated.</span>';
        ?>
        <label for="firstname">First Name:</label>
        <?php if (isset($missing['firstname']))
            echo '<span class="warning">' . $missing['firstname'] . '</span><br>';
        ?>
        <input type="text" id="firstname" name="firstname" <?php if (isset($firstname)) echo 'value = "' . htmlspecialchars($firstname) . '"'; ?>>
        <label for="lastname">Last Name:</label>
        <?php if (isset($missing['lastname']))
            echo '<span class="warning">' . $missing['lastname'] . '</span><br>';
        ?>
        <input type="text" id="lastname" name="lastname" <?php if (isset($lastname)) echo 'value = "' . htmlspecialchars($lastname) . '"'; ?>>
        <label for="useCase">Use Case:</label>
        <?php if (isset($missing['useCase']))
            echo '<span class="warning">' . $missing['useCase'] . '</span><br>';
        ?>
        <select id="useCase" name="useCase">
            <option value="">Select Use Case:</option>
            <option value="personal" <?php if (isset($useCase) && $useCase == 'personal') echo ' selected'; ?>>Personal</option>
            <option value="small" <?php if (isset($useCase) && $useCase == 'small') echo ' selected'; ?>>Small Business</option>
            <option value="corporate" <?php if (isset($useCase) && $useCase == 'corporate') echo ' selected'; ?>>Corporate</option>
        </select>
        <label for="email">Email:</label>
        <?php if (isset($missing['email']))
            echo '<span class="warning">' . $missing['email'] . '</span><br>';
        if (isset($missing['exists']))
            echo '<span class="warning">' . $missing['exists'] . '</span><br>';
        ?>
        <input type="email" id="email" name="email" <?php if (isset($email)) echo 'value = "' . htmlspecialchars($email) . '"'; ?>>
        <label for="pwd">Password:</label>
        <?php if (isset($missing['pwd']))
            echo '<span class="warning">' . $missing['pwd'] . '</span><br>';
        ?>
        <?php if (isset($missing['confirm']))
            echo '<span class="warning">' . $missing['confirm'] . '</span><br>';
        ?>
        <input type="password" id="pwd" name="pwd">
        <label for="pwd">Confirm Password:</label>
        <input type="password" id="confirm" name="confirm">
        <p><input type="submit" name="submit" value="Register"></p>
    </fieldset>
</form>
<?php require 'includes/footer.php'; ?>
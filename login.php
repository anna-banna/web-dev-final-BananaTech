<?php
require '../secure_conn.php';
require 'includes/header.php';
if (isset($_POST['send']) && $_POST['send'] == "Login") {
    $errors = array();

    $valid_email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    if (empty($_POST['email'])) {
        $errors['email'] = 'Email is required.';
    } elseif (!$valid_email) {
        $errors['email'] = 'Please enter a valid email address.';
    } else {
        $email = $valid_email;
    }

    $pwd = trim($_POST['pwd']);
    if (empty($pwd)) {
        $errors['pwd'] = 'Password is required.';
    }

    while (!$errors) {
        try {
            require_once '../../pdo_connect.php';
            $sql = "SELECT * FROM btUsers WHERE emailAddr = :email";
            $stmt = $dbc->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $numRows = $stmt->rowCount();
            if ($numRows == 0)
                $errors['no_email'] = "Uh oh. We don't have an account with that email address. Please try again.";
            else {
                $result = $stmt->fetch();
                $pw_hash = $result['pw'];
                if (password_verify($pwd, $pw_hash)) {
                    $firstname = $result['firstName'];
                    $email = $result['emailAddr'];
                    $folder = $result['folder'];
                    session_start();
                    $_SESSION['firstname'] = $firstname;
                    $_SESSION['email'] = $email;
                    $_SESSION['folder'] = $folder;
                    header('Location: logged_in.php');

                    exit;
                } else {
                    $errors['wrong_pwd'] = "Hm. That password doesn't match the email address you entered. Please try again.";
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>

<h2> Sign in to access the BananaTech Customer Portal. </h2>
<p> If you do not have an account, please <a href="index.php">register</a>. </p>
<form method="post" action="login.php">
    <fieldset>
        <legend> Customer Login </legend>
        <?php if ($errors) {
            if ($errors['email']) {
                echo "<p class=\"warning\">{$errors['email']}</p>";
            }
            if ($errors['no_email']) {
                echo "<p class=\"warning\">{$errors['no_email']}</p>";
            }
        }
        ?>
        <p>
            <label for="email">Email: </label>
            <input name="email" id="email" type="text" <?php if (isset($email) && !$errors['no_email']) {
                                                            echo 'value="' . htmlspecialchars($email) . '"';
                                                        } ?>>
        </p>
        <?php if ($errors['pwd']) echo "<h2 class=\"warning\">{$errors['pwd']}</h2>";
        if ($errors['wrong_pwd']) echo "<h2 class=\"warning\">{$errors['wrong_pwd']}</h2>";
        ?>
        <p>
            <label for="pwd">Password: </label>
            <input name="pwd" id="pwd" type="password">
        </p>
        <p>
            <input name="send" type="submit" value="Login">
        </p>
    </fieldset>
</form>
<?php include 'includes/footer.php'; ?>
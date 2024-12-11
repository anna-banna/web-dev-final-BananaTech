<?php
require 'includes/header.php';
if (isset($_SESSION['folder'])) {
    // Check if the form has been submitted:
    if (isset($_POST['submit'])) {
        if (isset($_POST['description'])) {
            $description = $_POST['description'];
        } else {
            $description = '';
        }
        // Check for an uploaded file:
        if (isset($_FILES['upload'])) {
            // Validate the type. Should be GIF, JPEG or PNG.
            $allowed = array('image/jpeg', 'image/png', 'image/gif', 'application/pdf');
            if (in_array($_FILES['upload']['type'], $allowed)) {
                // Move the file over.
                $folder = $_SESSION['folder'];
                $image_path = $_FILES['upload']['tmp_name'];
                $image_info = getimagesize($image_path);
                if (move_uploaded_file($_FILES['upload']['tmp_name'], "../../uploads/$folder/{$_FILES['upload']['name']}")) {
                    echo '<h2>The file ' . $_FILES['upload']['name'] . ' has been uploaded!</h2>';
                    $name = $_FILES['upload']['name'];
                    $type = $_FILES['upload']['type'];

                    //write to database
                    $email = $_SESSION['email'];
                    require_once('../../pdo_connect.php'); // Connect to the db.
                    $sql = "INSERT into btUserUploads (email, fileName, fileType, description) VALUES (?, ?, ?, ?)";
                    $stmt = $dbc->prepare($sql);
                    $stmt->bindParam(1, $email);
                    $stmt->bindParam(2, $name);
                    $stmt->bindParam(3, $type);
                    $stmt->bindParam(4, $description);
                    $stmt->execute();
                    $numRows = $stmt->rowCount();
                    if ($numRows == 1) {
                        echo '<h3>And the file data has been saved.</h3>';
                        //include ('create_thumb.php');
                    } else {
                        echo '<h2>We were unable to save your file data.</h2>';
                    }
                    echo "</main>";
                    include './includes/footer.php';
                    // Delete the file if it still exists:
                    if (file_exists($_FILES['upload']['tmp_name']) && is_file($_FILES['upload']['tmp_name'])) {
                        unlink($_FILES['upload']['tmp_name']);
                    }
                    exit;
                } // End of move... IF.		
            } else { // Invalid type.
                echo '<h2 class="warning">Please upload a GIF, JPEG, PNG, or PDF file.</h2>';
            }
        } // End of isset($_FILES['upload']) IF.
        // Check for an error:
        if ($_FILES['upload']['error'] > 0) {
            echo '<p class="warning">The file could not be uploaded because: <strong>';
            // Print a message based upon the error.
            switch ($_FILES['upload']['error']) {
                case 1:
                    echo 'The file exceeds the upload_max_filesize setting in php.ini.';
                    break;
                case 2:
                    echo 'The file exceeds the MAX_FILE_SIZE setting in the HTML form.';
                    break;
                case 3:
                    echo 'The file was only partially uploaded.';
                    break;
                case 4:
                    echo 'No file was uploaded.';
                    break;
                case 6:
                    echo 'No temporary folder was available.';
                    break;
                case 7:
                    echo 'Unable to write to the disk.';
                    break;
                case 8:
                    echo 'File upload stopped.';
                    break;
                default:
                    echo 'A system error occurred.';
                    break;
            } // End of switch.
            echo '</strong></p>';
        } // End of error IF.		
    } // End of the submitted conditional.
} //end of session IF
else {
    echo "<h2>We are sorry, but you must be logged in as a registered user to submit a ticket</h2>";
    echo "<h3>Use the Register link at the left to create an account</h2></main>";
    include('./includes/footer.php');
    exit;
}
?>
<h2>Submit a Help Ticket</h2>
<form enctype="multipart/form-data" action="ticket_submit.php" method="post">
    <fieldset>
        <legend>Describe the issue and upload supporting documentation:</legend>
        <label for="description"> Description </label>
        <textarea name="description" id="description"><?php echo htmlspecialchars($description); ?></textarea>
        <label for="file">
            File: <input type="file" name="upload" id="file"></label>
        <label for="submit">
            <input type="submit" name="submit" value="Submit" id="submit"></label>
    </fieldset>
</form>
<?php include './includes/footer.php'; ?>
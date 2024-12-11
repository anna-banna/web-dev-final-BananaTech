<?php
$currentPage = basename($_SERVER['SCRIPT_FILENAME']); ?>
<ul id="nav">
    <li><a href="index.php" <?php if ($currentPage == 'index.php') {
                                echo 'id="here"';
                            } ?>>Home</a></li>
    <li><a href="services.php" <?php if ($currentPage == 'services.php') {
                                    echo 'id="here"';
                                } ?>>Services</a></li>
    <?php if (isset($_SESSION['firstname'])) { ?>
        <li><a href="ticket_submit.php" <?php if ($currentPage == 'ticket_submit.php') {
                                            echo 'id="here"';
                                        } ?>>Submit a Ticket</a></li>
        <li><a href="logged_out.php" <?php if ($currentPage == 'logged_out.php') {
                                            echo 'id="here"';
                                        } ?>>Logout</a></li>
    <?php } else { ?>
        <li><a href="sign_up.php" <?php if ($currentPage == 'sign_up.php') {
                                        echo 'id="here"';
                                    } ?>>Sign Up</a></li>
        <li><a href="login.php" <?php if ($currentPage == 'login.php') {
                                    echo 'id="here"';
                                } ?>>Login</a></li>
    <?php } ?>
</ul>
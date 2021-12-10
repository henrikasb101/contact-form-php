<?php

session_start();

require_once 'app/config.php';
require_once 'app/models/Message.php';
use app\models\Message;

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = '<p>'.$_POST['message'].'</p>';
    
    $newMessage = new Message();
    $newMessage->name = $name;
    $newMessage->email = $email;
    $newMessage->message = $message;
    $result = $newMessage->save();

    if ($result) {
        $_SESSION['msgSent'] = $result;
        header('Location: ./');
    } else {
        header('Location: index.php?status=0');
    }

    die();
}

function isMessageSent() {
    return isset($_SESSION['msgSent']) && $_SESSION['msgSent'];
}

function isAlertPresent() {
    return isset($_GET['status']) && $_GET['status'] == 0;
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= WEB_TITLE ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </head>
    <body class="bg-light">
        <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
            <div class="p-5 my-5 bg-white shadow rounded-3 position-relative">
                <h4 class="text-center mb-5 position-relative" style="z-index: 3;">Feel free to contact us!</h4>
                <?php if (isMessageSent()) { ?>
                    <div class="container position-absolute top-0 start-0 bg-white h-100 opacity-75" style="z-index: 1;"></div>
                    <div class="container position-absolute top-0 start-0 h-100 d-flex flex-column justify-content-center align-items-center" style="z-index: 2;">
                        <svg class="mb-3" width="150" height="150" viewBox="0 0 150 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="75" cy="75" r="75" fill="#0BE881"/>
                            <path d="M110 50L61.875 100L40 77.2727" stroke="white" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <h4>Message sent!</h4>
                    </div>
                <?php } ?>
                <form action="./" method="POST">
                    <fieldset class="d-flex flex-column justify-content-center align-items-center" <?= (isMessageSent()) ? 'disabled' : '' ?>>
                    <?php if (isAlertPresent()) { ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="max-width: 230px;">
                            <strong>Oops!</strong> Message could not be sent.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control disabled" id="floatingInput" name="name" placeholder="First name" pattern="^[^'\x22`]+$" minlength="4" maxlength="32" required>
                        <label for="floatingInput" class="user-select-none">First name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" pattern="^[^'\x22`]+$" maxlength="128" required>
                        <label for="floatingInput">Email address</label>
                    </div>
                    <div class="form-floating mb-5">
                        <textarea class="form-control" placeholder="Leave a message here" id="floatingTextarea" name="message" style="height: 100px" minlength="6" maxlength="255" required></textarea>
                        <label for="floatingTextarea">Message</label>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Send</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </body>
</html>

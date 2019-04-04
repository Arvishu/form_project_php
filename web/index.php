<?php
$firstname = $name = $email = $phone = $message = "";
$firstnameError = $nameError = $emailError = $phoneError = $messageError = "";
$isSuccess = false;
$emailTo = "arvishugo@hotmail.fr";

if ($_SERVER["REQUEST_METHOD"]=="POST"){
$firstname = verifyInput($_POST["firstname"]);
$name = verifyInput($_POST["name"]);
$email = verifyInput($_POST["email"]);
$phone = verifyInput($_POST["phone"]);
$message = verifyInput($_POST["message"]);
$isSuccess = true;
$emailText ="";

    if(empty($firstname)){
        $firstnameError = "Je veux connaitre ton prenom !";
        $isSuccess = false;
    }else {$emailText .="Firstname: $firstname\n";}

    if(empty($name)){
        $nameError = "Je veux aussi connaitre ton nom !";
        $isSuccess = false;
    }else {$emailText .="name: $name\n";}

    if(!isEmail($email)){
        $emailError = "Il faut saisir un email valide.";
        $isSuccess = false;
    }else {$emailText .="email: $email\n";}

    if(!isPhone($phone)){
        $phoneError ="Que des chiffres et des espaces s'il te plait.";
        $isSuccess = false;
    }else {$emailText .="phone: $phone\n";}

    if(empty($message)){
        $messageError = "Que veux tu me dire ?";
        $isSuccess = false;
    }else {$emailText .="message: $message\n";}

    if($isSuccess){
        $headers = "From: $firstname $name <$email>\r\nReply-To: $email";
        mail($emailTo,"message de votre site", $emailText , $headers);
        $firstname = $name = $email = $phone = $message = "";
    }

}

function isPhone($var){
    return preg_match("/^[0-9 ]*$/", $var);
}

function isEmail($var){
    return filter_var($var, FILTER_VALIDATE_EMAIL);
}

//creation permettant de verifier les inputs nettoyer les injections dans les inputs
function verifyInput($var){
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlspecialchars($var);

    return $var;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <link rel='stylesheet'
        href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css' />
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js'></script>
    <link rel="stylesheet" href="css/style.css">
    <title>Contactez-moi!</title>
</head>

<body>
    <div class="container">
        <div class="divider"></div>
        <div class="heading">
            <h2>Contactez-moi !</h2>
        </div>
        <div class="row center" >
            <div class="col-lg-10 col-lg-offset-1">
            <!-- eviter les failles xss avec htmlspecialchars permet d'éviter les injections js  dans l'url. -->
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" id="contact-form" method="POST" role="form">

                    <div class="row">
                        <div class="col-md-6">
                            <label for="firstname">Prenom <span class="blue">*</span></label>
                            <input id="firstname" type="text" name="firstname" class="form-control"
                                placeholder="Votre Prénom" value="<?php echo $firstname;?>">
                            <p class="comments"><?php echo $firstnameError ?></p>
                        </div>
                        <div class="col-md-6">
                            <label for="name">Nom <span class="blue">*</span></label>
                            <input id="name" type="text" name="name" class="form-control" placeholder="Votre Nom"value="<?php echo $name;?>">
                            <p class="comments"><?php echo $nameError ?></p>
                        </div>
                        <div class="col-md-6">
                            <label for="email">Email <span class="blue">*</span></label>
                            <input id="email" type="email" name="email" class="form-control" placeholder="Votre email"value="<?php echo $email;?>">
                            <p class="comments"><?php echo $emailError?></p>
                        </div>
                        <div class="col-md-6">
                            <label for="phone">Téléphone</label>
                            <input id="phone" type="tel" name="phone" class="form-control"
                                placeholder="Votre Téléphone" value="<?php echo $phone;?>">
                            <p class="comments"></p>
                        </div>
                        <div class="col-md-12">
                            <label for="message">Message <span class="blue">*</span></label>
                            <textarea name="message" id="message" class="form-control" rows="4" ><?php echo $message;?></textarea>
                            <p class="comments"><?php echo $messageError?></p>
                        </div>
                        <div class="col-md-12">
                            <p class="blue"><strong>* Ces informations sont requises</strong></p>
                        </div>
                        <div class="col-md-12">
                            <input type="submit" class="button1" value="Envoyer">
                        </div>

                    </div>
                    <p class="thank-you" style="display:<?php if($isSuccess) echo'block'; else echo'none';?>">Votre message a bien été envoyé. Merci de m'avoir contacté.</p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
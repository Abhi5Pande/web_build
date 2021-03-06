<?php
require_once("session.php");
require_once("php/user.php");
require_once("php/script.php");
$user = new User();
$id = $_SESSION['user-session'];

$query = $user->Query("SELECT * FROM user WHERE id=:id");
$query->execute(array(":id" => $id));
$row = $query->fetch(PDO::FETCH_ASSOC);

/** On update button click  */
if (isset($_POST['btn-update'])){
    $msg='';
    $oldname = explode('_',$_POST['btn-update'])[0];
    $oldmail = explode('_',$_POST['btn-update'])[1];
    $name = $_POST['txt-username'];
    $email = $_POST['txt-email'];
    $password = $_POST['txt-newpwd'];
    $retpwd = $_POST['txt-retpwd'];
    $ownpwd = strip_tags($_POST['txt-pwd']);
    if(Script::UpdateUser($user, $oldname, $oldmail, $ownpwd, $name, $email, $password, $retpwd, $msg)){
        $user->Redirect('home.php?updated');
    }
    else{
        $user->Redirect('home.php?err');
        $_SESSION['err'] = 'mod_'.$msg;
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
    }
}

/** On delete button click  */
if (isset($_POST['btn-delete'])){
    $msg='';
    $name = explode('_',$_POST['btn-delete'])[0];
    $email = explode('_',$_POST['btn-delete'])[1];
    $password = strip_tags($_POST['txt-pwd']);
    if(Script::DeleteUser($user, $name, $email, $password,$msg)){
        if($msg<>'logout') {
            $user->Redirect('home.php?deleted');
        }
    }
    else{
        $user->Redirect('home.php?err');
        $_SESSION['err'] = 'del_'.$msg;
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
    }
}

/** On add button click  */
if (isset($_POST['btn-add'])){
    $msg='';
    $name = $_POST['txt-username'];
    $email = $_POST['txt-email'];
    $password = $_POST['txt-newpwd'];
    $retpwd = $_POST['txt-retpwd'];
    $ownpwd = strip_tags($_POST['txt-pwd']);
    if(Script::AddUser($user, $name, $email, $password, $retpwd, $ownpwd, $msg)){
        $user->Redirect('home.php?joined');
    }
    else{
        $user->Redirect('home.php?err');
        $_SESSION['err'] = 'add_'.$msg;
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
    }
}

if(isset($_GET['joined'])){
    $success = "User successfully registered";
}
if(isset($_GET['deleted'])){
    $success = "User successfully deleted";
}
if(isset($_GET['updated'])){
    $success = "User successfully updated";
}
if(isset($_GET['err'])){
    $error = $_SESSION['err'];
    $name= $_SESSION['name'];
    $email= $_SESSION['email'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome, <?php print($row['username']); ?>!</title>
    <link rel="icon" href="cont/favicon.png">
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
            integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
            crossorigin="anonymous"></script>
    <script src="js/script.js" type="text/javascript"></script>
</head>

<body>
<!--Navbar-->

        
       
    
<!--Body-->
<a href="./examples/basic_with_blank_content.php">Start</a>

<script>
    <?php
    /** On Error */
    if(isset($error)){
        $type = explode('_', $error)[0];
        $err_msg = explode('_', $error)[1];
        if($type == 'mod' || $type =='del'){
    ?>
            ModifyUser(<?php echo '"' . $name . '","' . $email . '","div-modify-user", true'; ?>);
    <?php
        }
        else{
            ?>
            AddUser("div-modify-user", true);
    <?php
        }
    ?>
    ErrorAlert('form-modify-user', '<?php echo $err_msg ?>', 'txt-pwd');
    <?php
    unset($error);
    }
    ?>
</script>

</body>
</html>

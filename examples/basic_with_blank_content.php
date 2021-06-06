
<?php require "../php/database.php";
require "../php/script.php";
require "../php/user.php";
require "../session.php" ;


$dbconn = mysqli_connect("localhost","root","","page_builder");
if( isset($_SESSION['username'])){
    $thisUser = $_SESSION['username'];
}

if( isset( $_POST['action'])){
    $content = mysqli_real_escape_string($dbconn,$_POST['content']) ;
    $sql1 = "UPDATE `user` SET `Content`='".$content."'  WHERE `username`='".$thisUser."'";
    $query1 = mysqli_query( $dbconn, $sql1 );
}

$sql2 = "SELECT * FROM `user` WHERE `username`='".$thisUser."'";
$query2 = mysqli_query($dbconn, $sql2);
$row = mysqli_fetch_assoc($query2);
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Web Builder</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="./plugins/bootstrap-3.4.1/css/bootstrap.min.css" data-type="keditor-style" />
        <link rel="stylesheet" type="text/css" href="./plugins/font-awesome-4.7.0/css/font-awesome.min.css" data-type="keditor-style" />
       
        <!-- Start of KEditor styles -->
        <link rel="stylesheet" type="text/css" href="../dist/css/keditor.css" data-type="keditor-style" />
        <link rel="stylesheet" type="text/css" href="../dist/css/keditor-components.css" data-type="keditor-style" />
        <!-- End of KEditor styles -->
        <link rel="stylesheet" type="text/css" href="./plugins/code-prettify/src/prettify.css" />
        <link rel="stylesheet" type="text/css" href="./css/examples.css" />

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script type="text/javascript" src="./plugins/jquery-1.11.3/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="./plugins/bootstrap-3.4.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="./plugins/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
        <script type="text/javascript" src="./plugins/ckeditor-4.11.4/ckeditor.js"></script>
        <script type="text/javascript" src="./plugins/formBuilder-2.5.3/form-builder.min.js"></script>
        <script type="text/javascript" src="./plugins/formBuilder-2.5.3/form-render.min.js"></script>
        <!-- Start of KEditor scripts -->
        <script type="text/javascript" src="../dist/js/keditor.js"></script>
        <script type="text/javascript" src="../dist/js/keditor-components.js"></script>
        <!-- End of KEditor scripts -->
        <script type="text/javascript" src="./plugins/code-prettify/src/prettify.js"></script>
        <script type="text/javascript" src="./plugins/js-beautify-1.7.5/js/lib/beautify.js"></script>
        <script type="text/javascript" src="./plugins/js-beautify-1.7.5/js/lib/beautify-html.js"></script>
        <script type="text/javascript" src="./js/examples.js"></script>
        <style>
            a[title="Save"], a[title="View on mobile"], a[title="View on tablet"], a[title="View on laptop"], a[title="View on desktop"]{
                display: none;
            }
        </style>
    </head>
    
    <body>
         <!--Right side buttons
       
        
        <H3 class="text-dark ">web_Builder</H3>
        
            <a class="bt1 btn btn-dark my-2 my-sm-0" href="../logout.php?logout=true">Logout</a>
            <button type=" button" class="bt2 btn btn-dark" id = "save">Save</button>
        -->
        <div data-keditor="html">
            <div id="content-area">
                <?php 
                if($row["Content"] != "")
                {
                    echo $row["Content"];
                }
                ?>
            </div>
            
        </div>
        <style>
            a[title="Save"], a[title="View on mobile"], a[title="View on tablet"], a[title="View on laptop"], a[title="View on desktop"]{
                display: none;
            }
        </style>
        <script type="text/javascript" data-keditor="script">
        
            $(function () {
                $('#content-area').keditor();
                $("a[title='Preview OFF']").parent().addClass("keditor-topbar-right");
                $("#save").click(function(){
                    $.ajax({
                        type: 'post',
                        data: {action: "send-content",
                        content: $('#content-area').keditor('getContent')
                        },
                        success: function(data){
                            console.log(data);
                            alert("Saved");
                        },
                        error : function(data){
                            console.log(data)
                        }
                    });

                });
             });
        </script>
    </body>
</html>

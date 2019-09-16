<?php
// Include config file
require_once "../Controllers/config.php";

// Define variables and initialize with empty values
$firstname = $surname  ="";
$surphones = $suremails = array(); 
$name1_err = $name2_err = $name3_err = $name4_err = "";
$imgData;
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    print_r($_POST);
    print_r($_FILES);
    
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 0;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
//    if(isset($_POST["fileToUpload"]["name"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".";
            $imgData = addslashes(file_get_contents($_FILES['fileToUpload']['tmp_name']));
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $name0_err = "File is not an image.";
            $uploadOk = 0;
        }
//    }
    
    
    $input_name1 = trim($_POST["fname"]);
    if(empty($input_name1)){
        $name1_err = "Write a Name.";
    } elseif(!filter_var($input_name1, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name1_err = "Write a Valid Name.";
    } else{
        $firstname = $input_name1;
    }
    $input_name2 = trim($_POST["sname"]);
    if(empty($input_name2)){
        $name2_err = "Write a Last Name.";
    } elseif(!filter_var($input_name1, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name2_err = "Write a Valid Last Name.";
    } else{
        $surname = $input_name2;
    }
    
    $input_name3 = trim($_POST["snum0"]);
    $input_name6 = trim($_POST["snum1"]);
    //echo $input_name3;
    if(empty($input_name3) && empty($input_name6)){
        $name3_err = "Please enter a phone number.";     
    }elseif(!ctype_digit($input_name3) || !ctype_digit($input_name6)){
        $name3_err = "Please enter a valid phone number";
    } 
    
    
    $input_name4 = trim($_POST["smail0"]);
    $input_name5 = trim($_POST["smail1"]);
    if(empty($input_name4) && empty($input_name5)){
        $name4_err = "write an Email";
    } elseif(!filter_var($input_name4, FILTER_VALIDATE_EMAIL) || !filter_var($input_name5, FILTER_VALIDATE_EMAIL)){
        $name4_err = "Write a Valid Email.";
    }

    
    $i = 0;
    $j = 0;
    //$var = "snum".strval($i);
    foreach($_POST as $data){
        //echo $data;
        if(ctype_digit($data)){//numeros
            $surphones[$i] = $data;
            $i++;
        }elseif (filter_var($data, FILTER_VALIDATE_EMAIL)) {//correos
            $suremails[$j] = $data;
            $j++;
        }else{
            $firstname = $_POST["fname"];
            $surname = $_POST["sname"];
        }
            
        
    }
    
//    $var = "snum"."1";
//    echo $var;
//    print_r($_POST[$var]);
//    echo $firstname."   ";
//    echo $surname."   ";
//    print_r($surphones);
//    print_r($suremails);
    // Check input errors before inserting in database
    //if(1 == 0){
    if(!empty($firstname) && !empty($surname) && !empty($surphones) && !empty($suremails) && $uploadOk == 1){
        // Prepare an insert statement
        $sql = "INSERT INTO general (firstname, surname) VALUES (?, ?)";        
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_firstname, $param_surname);
            
            // Set parameters
            $param_firstname = $firstname;
            $param_surname = $surname;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                
                $last_id = mysqli_insert_id($link);
                $sql1 = "INSERT INTO datos (idgeneral,campo,tipocampo) VALUES (?,?,?)";
                if($stmt1 = mysqli_prepare($link, $sql1)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt1, "isi", $param_idgeneral, $param_campo, $param_tipocampo);
                    foreach ($surphones as $surphone){
                        // Set parameters
                        $param_idgeneral = $last_id;
                        $param_campo = $surphone;
                        $param_tipocampo = 0;
                        if(!mysqli_stmt_execute($stmt1)){
                            echo "Something went wrong. Please try again later.";
                        }
                    }
                }

                $sql2 = "INSERT INTO datos (idgeneral,campo,tipocampo) VALUES (?,?,?)";
                if($stmt2 = mysqli_prepare($link, $sql2)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt2, "isi", $param_idgeneral, $param_campo, $param_tipocampo);
                    foreach ($suremails as $suremail){
                        // Set parameters
                        $param_idgeneral = $last_id;
                        $param_campo = $suremail;
                        $param_tipocampo = 1;
                        if(!mysqli_stmt_execute($stmt2)){
                            echo "Something went wrong. Please try again later.";
                        }
                    }
                }
                $sql3 = "INSERT INTO fotos (idgeneral,foto) VALUES (?,?)";
                //$imagetmp=addslashes (file_get_contents($_FILES["fileToUpload"]['tmp_name']));
                $imagetmp=file_get_contents($_FILES["fileToUpload"]['tmp_name']);
                if($stmt3 = mysqli_prepare($link, $sql3)){
                    // Bind variables to the prepared statement as parameters
                    
                    
                    mysqli_stmt_bind_param($stmt3, "is", $param_idgeneral, $param_photo);
                    //$_FILES["fileToUpload"]
    
                        $param_idgeneral = $last_id;
                        $param_photo = $imagetmp;
                        mysqli_stmt_send_long_data($stmt3, $imagetmp);
                        
                        if(!mysqli_stmt_execute($stmt3)){
                            echo "Something went wrong. Please try again later.";
                        }
//                    }
                }
                
                
                // Records created successfully. Redirect to landing page
                //header("location: index.php");
                header("location: /PhpProject1/app/Views/index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
        <script src="../../public/create.js"></script>
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2 class="pull-left">Create Record</h2>
                        <a href="../Views/index.php" class="btn btn-success pull-right">Back</a>
                        <br>
                        <br>
                        <br>
                    </div>
                    <div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" >
                        <div class="form-group <?php echo (!empty($name0_err)) ? 'has-error' : ''; ?>">
                            <label>Upload Image:</label><br /> 
                            <input id="fileToUpload" name="fileToUpload" type="file" class="inputFile" value="<?php $_FILES["fileToUpload"]?>"/> 
                            <span class="help-block"><?php echo $name0_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($name1_err)) ? 'has-error' : ''; ?>">
                            <label>First Name</label>
                            <input id="inputname" type="text" name="fname" class="form-control" value="<?php echo $firstname; ?>">
                            <span class="help-block"><?php echo $name1_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($name2_err)) ? 'has-error' : ''; ?>">
                            <label>SurName</label>
                            <input id="inputlname" type="text" name="sname" class="form-control" value="<?php echo $surname; ?>">
                            <span class="help-block"><?php echo $name2_err;?></span>
                        </div>
                        <div id="form1" class="form-group <?php echo (!empty($name3_err)) ? 'has-error' : ''; ?>">
                            <label>Phone Number</label>
                            <input id="inputphone0" type="text" name="snum0" class="form-control" value="<?php //echo $surphones; ?>">
                            <span id="help-block1" class="help-block"><?php echo $name3_err;?></span>
                            <?php echo "<a id='addphone' title='Attach Number' data-toggle='tooltip'><span class='glyphicon glyphicon glyphicon-plus pull-right'></span></a>"?>
                            
                        </div>
                        <div id="form2" class="form-group <?php echo (!empty($name4_err)) ? 'has-error' : ''; ?>">
                            <label>email Adress</label>
                            <input id="inputmail0" type="text" name="smail0" class="form-control" value="<?php //echo $suremail; ?>">
                            <span id="help-block2" class="help-block"><?php echo $name4_err;?></span>
                            <?php echo "<a id='addemail' title='Attach Email' data-toggle='tooltip'><span class='glyphicon glyphicon glyphicon-plus pull-right'></span></a>"?>
                        </div>
                        <input id="createSubmit" type="submit" class="btn btn-primary" value="Acept">
                        <a href="../Views/index.php" class="btn btn-default">Cancel</a>
                    </form>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
        <link rel="stylesheet" type="text/css" href="../../public/css/zoom.css">
        <script src="../../public/js/zoom.js"></script>
        <script src="../../public/update.js"></script>
        <style type="text/css">
            .wrapper{
                width: 90%;
                margin: 0 auto;
            }
            .page-header h2{
                margin-top: 0;
            }
            table tr td:last-child a{
                margin-right: 15px;
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();   
            });
        </script>
    </head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Update Contact</h2>
                        <a href="../Views/index.php" class="btn btn-success pull-right">Back</a>
                    </div>

<?php
$firstname = $surname  ="";
$surphones = $suremails =  array(); 
$name1_err = $name2_err = "";
$name3_err;
$name4_err;
$imgData;
$uploadOk = 0;
$band = 0;

// Include config file
require_once "../Controllers/config.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //print_r($_POST);
    //print_r($_FILES);
    //print_r($_POST["id"]);
    $input_id = trim($_POST["id"]);
    //modificar sql
    if(isset($_POST["id"])){
        $input_id = trim($_POST["id"]);
        if(isset($_POST["fname"])){
            $input_name1 = trim($_POST["fname"]);
            if(empty($input_name1)){
                $name1_err = "Write a Name.";
            } elseif(!filter_var($input_name1, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Zñ-Ñ\s]+$/")))){
                $name1_err = "Write a Valid Name.";
            } else{
                $firstname = $input_name1;
            }
        }
        if(isset($_POST["sname"])){
            $input_name2 = trim($_POST["sname"]);
            if(empty($input_name2)){
                $name2_err = "Write a Last Name.";
            } elseif(!filter_var($input_name2, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Zñ-Ñ\s]+$/")))){
                $name2_err = "Write a Valid Last Name.";
            } else{
                $surname = $input_name2;
            }
        }
        $i = 0;
        $j = 0;

        
        while (isset($_POST["snum". strval($i)])){
            $data = $_POST["snum". strval($i)];
            $surphones[$i] = $data;
            if(empty($data)){
                $name3_err[$i] = "Please enter a phone number.";     
            }elseif(!ctype_digit($data) ){
                $name3_err[$i] = "Please enter a valid phone number";
            } 
            $i++;
        }
        $i = 0;
        $j = 0;
        while (isset($_POST["smail". strval($i)])){
            $data = $_POST["smail". strval($i)];
            $suremails[$i] = $data;
            if(empty($data)){
                $name4_err[$i] = "Write a Email";;     
            }elseif(!filter_var($data, FILTER_VALIDATE_EMAIL)) {
                $name4_err[$i] = "Write a Valid Email.";
            } 
            $i++;
        }
        
        

        
        
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 0;
    if(isset($_FILES["fileToUpload"])){
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
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

        }
        
        
        echo "<div><form action='".$_SERVER["PHP_SELF"]."?id=".$input_id."' method='post' enctype='multipart/form-data'><table style='width:100%' class='table table-bordered table-striped'>";
        echo "<thead>";
        echo "<tr>";
                    echo "<th>#</th>";
                    echo "<th style='width:30%'>Name</th>";
                    echo "<th style='width:25%'>Phone Numbers</th>";
                    echo "<th style='width:25%'>emails</th>";
                    echo "<th style='width:20%'>Photo</th>";
                echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

                echo "<tr>";
                    echo "<td><label name='id' class='control-label'>" . $input_id. "</label></td>";
                    echo '<input type="hidden" name="id" value="'.$input_id.'">';
                    echo "<td>";
                    echo "<table class='table'><tbody>";
                    echo "<tr><td>";
                    echo '<input id="inputname" type="text" name="fname" class="form-control" value="'. $firstname.'">';
                    echo '<span id="help-blockf" class="help-block">'. $name1_err.'</span>';
                    echo "</td></tr>";
                    echo "<tr><td>";
                    echo '<input id="inputlname" type="text" name="sname" class="form-control" value="'. $surname.'">';
                    echo '<span id="help-blocks" class="help-block">'. $name2_err.'</span>';
                    echo "</td></tr>";
                    echo "</tbody></table>";
                    echo "</td>";
                    echo '<td><div id="form1" class="form-group ">';
                    $i = 0;
                    foreach ($surphones as $surphone){
                       echo "<table  id='tablephones'".$i. "' class='table'><tbody>";
                       //echo "<tr><td>&nbsp;</td></tr>";
                       echo "<tr><td>";
                       echo '<input id="inputphone'. $i.'" type="text" name="snum'. $i.'" class="form-control" value="'. $surphone.'">';
                       echo '<span id="help-blocka'. $i.'" class="help-block">'. $name3_err[$i].'</span>';
                       echo '<a id="delphone'.$i.'" title="Delete Number" data-toggle="tooltip"><span id="delphoneh'. $i .'" class="glyphicon glyphicon glyphicon-minus pull-left"></span></a>';
                       echo "</td></tr>";
                       echo "</tbody></table>";
                       $i++;
                    }
                   
                    echo "</div>";//Consulta
                    echo "<a id='addphone' title='Attach Number' data-toggle='tooltip'><span class='glyphicon glyphicon glyphicon-plus pull-right'></span></a>";
                    echo "</td>";
                    echo '<td><div id="form2" class="form-group">';
                    $i = 0;
                    foreach ($suremails as $suremail){
                        echo "<table id='tablemails'".$i. "' class='table'><tbody>";
                        //echo "<tr><td>&nbsp;</td></tr>";
                        echo "<tr><td>";
                        echo '<input id="inputmail'. $i.'" type="text" name="smail'. $i.'" class="form-control" value="'. $suremail.'">';
                        echo '<span id="help-blockb'. $i.'" class="help-block">'. $name4_err[$i].'</span>';
                        echo '<a id="delmail'.$i.'" title="Delete Email" data-toggle="tooltip"><span id="delmailh'. $i .'" class="glyphicon glyphicon glyphicon-minus pull-left"></span></a>';
                        echo "</td></tr>";
                        echo "</tbody></table>";
                        $i++;
                    }
                    
                    
                    echo "</div>";//Consulta
                    echo "<a id='addemail' title='Attach Email' data-toggle='tooltip'><span class='glyphicon glyphicon glyphicon-plus pull-right'></span></a>";
                    echo "</td>";
            }       
            

                echo "<td>";
                if($uploadOk == 1){
                    $imagetmp=file_get_contents($_FILES["fileToUpload"]['tmp_name']);
                    echo '<img class="img-thumbnail" src="data:image/jpeg;base64,'.base64_encode( $imagetmp ).'" data-action="zoom"/>';
                    echo '<input id="fileToUpload" name="fileToUpload" type="file" class="inputFile" value="'.base64_encode( $imagetmp ).'"/> ';
                    
                }else{
                    $sql2 = "SELECT * FROM fotos WHERE idgeneral =" .strval($input_id);
                    if($result2 = mysqli_query($link, $sql2)){
                        $image = mysqli_fetch_array($result2);
                        //echo $image["foto"];
                        echo '<img class="img-thumbnail" src="data:image/jpeg;base64,'.base64_encode( $image["foto"] ).'" data-action="zoom"/>';
                        echo '<input id="fileToUpload" name="fileToUpload" type="file" class="inputFile" value=""/> ';
                     }
                     mysqli_free_result($result2);
                }
                    

                echo "</td>";//Consulta Photo

             echo "</tr>";

            echo "</tbody>";                            
        echo "</table><input id='createSubmit1' type='submit' class='btn btn-primary pull-right' value='Acept'></form></div>";


        //Sql Area
        if(!empty($firstname) && !empty($surname)){
            $sql = "UPDATE general SET firstname = ?, surname =? WHERE id =".$input_id;        
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ss", $firstname, $surname);
                // Set parameters

                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){

                }
            }
        }
        
        //update phones
        if(empty($name3_err) && empty($name4_err)){
            $sql1 = "DELETE FROM datos WHERE idgeneral = ?";
            if($stmt1 = mysqli_prepare($link, $sql1)){
                mysqli_stmt_bind_param($stmt1, "i", $input_id);
                if(mysqli_stmt_execute($stmt1)){
                    $last_id = $input_id;
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
            }
        }
        }
        if($uploadOk == 1){
            $sql3 = "UPDATE fotos SET foto = ? WHERE idgeneral=".$input_id;
            $imagetmp=file_get_contents($_FILES["fileToUpload"]['tmp_name']);
            $imagetmp=file_get_contents($_FILES["fileToUpload"]['tmp_name']);
            if($stmt3 = mysqli_prepare($link,$sql3)){
                mysqli_stmt_bind_param($stmt3, "s", $imagetmp);

                //mysqli_stmt_send_long_data($stmt3, $imagetmp);
                if(!mysqli_stmt_execute($stmt3)){
                    echo "Something went wrong. Please try again later.";
                }
            }
        }

    
}else{
    
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        if(isset($_GET["id"])){
            $input_id = trim($_GET["id"]);
            // Attempt select query execution
                    $sql = "SELECT * FROM general WHERE id =". strval($input_id);
                    if($result = mysqli_query($link, $sql) ){
                        if(mysqli_num_rows($result) > 0){
                            echo "<div><form action='".$_SERVER["PHP_SELF"]."?id=".$input_id."' method='post' enctype='multipart/form-data'><table style='width:100%' class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th style='width:30%'>Name</th>";
                                        echo "<th style='width:25%'>Phone Numbers</th>";
                                        echo "<th style='width:25%'>emails</th>";
                                        echo "<th style='width:20%'>Photo</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td><label name='id' class='control-label'>" . $input_id. "</label></td>";
                                        echo '<input type="hidden" name="id" value="'.$input_id.'">';
                                        echo "<td>";
                                        echo "<table class='table'><tbody>";
                                        echo "<tr><td>";
                                        echo '<input id="inputname" type="text" name="fname" class="form-control" value="'. $row['firstname'].'">';
                                        echo '<span id="help-blockf" class="help-block">'. $name1_err.'</span>';
                                        echo "</td></tr>";
                                        echo "<tr><td>";
                                        echo '<input id="inputlname" type="text" name="sname" class="form-control" value="'. $row['surname'].'">';
                                        echo '<span id="help-blocks" class="help-block">'. $name2_err.'</span>';
                                        echo "</td></tr>";
                                        echo "</tbody></table>";
                                        echo "</td>";
                                        echo '<td><div id="form1" >';
                                        $sql1 = "SELECT * FROM datos WHERE idgeneral =" . $row['id'];
                                        if($result1 = mysqli_query($link, $sql1)){
                                            $i = 0;
                                             while($row1 = mysqli_fetch_array($result1)){
                                                 if($row1['tipocampo'] == 0){
                                                    echo "<table id='tablephones".$i. "' class='table'><tbody>";
                                                     //echo "<tr><td>&nbsp;</td></tr>";
                                                    echo '<tr><td id="tdp'. $i.'">';
                                                    echo '<input id="inputphone'. $i.'" type="text" name="snum'. $i.'" class="form-control" value="'. $row1['campo'].'">';
                                                    echo '<a id="delphone'.$i.'" title="Delete Number" data-toggle="tooltip"><span id="delphoneh'. $i .'" class="glyphicon glyphicon glyphicon-minus pull-left"></span></a>';
                                                    echo '<span id="help-blocka'. $i.'" class="help-block">'. $name3_err.'</span>';
                                                    echo "</td></tr>";
                                                    echo "</tbody></table>";
                                                    $i++;
                                                 }
                                             }
                                        }
                                        
                                        echo "</div>";//Consulta
                                        echo "<a id='addphone' title='Attach Number' data-toggle='tooltip'><span class='glyphicon glyphicon glyphicon-plus pull-right'></span></a>";
                                        echo "</td>";
                                        echo '<td><div id="form2" >';
                                        if($result1 = mysqli_query($link, $sql1)){
                                            $i = 0;
                                             while($row1 = mysqli_fetch_array($result1)){
                                                 if($row1['tipocampo'] == 1){
                                                     echo "<table id='tablemails".$i. "' class='table'><tbody>";
                                                     //echo "<tr><td>&nbsp;</td></tr>";
                                                     echo '<tr><td id="tdp'. $i.'">';
                                                     echo '<input id="inputmail'. $i.'" type="text" name="smail'. $i.'" class="form-control" value="'. $row1['campo'].'">';
                                                     echo '<a id="delmail'.$i.'" title="Delete Email" data-toggle="tooltip"><span id="delmailh'. $i .'" class="glyphicon glyphicon glyphicon-minus pull-left"></span></a>';
                                                     echo '<span id="help-blockb'. $i.'" class="help-block">'. $name4_err.'</span>';
                                                     echo "</td></tr>";
                                                     echo "</tbody></table>";
                                                     $i++;
                                                 }
                                             }
                                        }
                                        
                                        echo "</div>";
                                        echo "<a id='addemail' title='Attach Email' data-toggle='tooltip'><span class='glyphicon glyphicon glyphicon-plus pull-right'></span></a>";
                                        echo "</td>";
                                }
                                mysqli_free_result($result1);
                                
                                    echo "<td>";
                                        $sql2 = "SELECT * FROM fotos WHERE idgeneral =" .strval($input_id);
                                        if($result2 = mysqli_query($link, $sql2)){
                                            $image = mysqli_fetch_array($result2);
                                            //echo $image["foto"];
                                            echo '<img class="img-thumbnail" src="data:image/jpeg;base64,'.base64_encode( $image["foto"] ).'" data-action="zoom"/>';
                                            echo '<input id="fileToUpload" name="fileToUpload" type="file" class="inputFile" value=""/> ';
                                         }
                                         mysqli_free_result($result2);
                                        
                                    echo "</td>";//Consulta Photo
                                
                                 echo "</tr>";
                                
                                echo "</tbody>";                            
                            echo "</table><input id='createSubmit1' type='submit' class='btn btn-primary pull-right' value='Acept'></form></div>";
                            //echo "<div> <input id='createSubmit' type='submit' class='btn btn-primary pull-right' value='Acept'></div>";
                            // Free result set
                                        //mysqli_free_result($result2);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    // Close connection
                    mysqli_close($link);
            
        }
    }
    
}


?>

                </div>
            </div>        
        </div>
    </div>

        
</body>
</html>





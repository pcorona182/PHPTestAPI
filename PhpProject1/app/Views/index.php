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
        <style type="text/css">
            .wrapper{
                width: 650px;
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
                        <h2 class="pull-left">Agenda</h2>
                        <a href="../Models/create.php" class="btn btn-success pull-right">Add</a>
                    </div>
                    <div>
                        
                    </div>
                </div>
    <?php
    $busqueda = "";
    $tipo = 0;
    $id;
    require_once "../Controllers/config.php";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //print_r($_POST);
        if(isset($_POST["inputsearch"])){
            $busqueda = $_POST["inputsearch"];
            if(ctype_digit($busqueda) ){
                $tipo = 1;
                $sql = "SELECT * FROM datos WHERE campo LIKE '".$busqueda."'";
                
                if($result1 = mysqli_query($link, $sql)){
                    if(mysqli_num_rows($result1) > 0){
                        while($row2 = mysqli_fetch_array($result1)){
                            $sql = "SELECT * FROM general WHERE id =".$row2['idgeneral'];
                            if($result = mysqli_query($link, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    echo "<table class='table table-bordered table-striped'>";
                                    echo "<thead>";
                                        echo "<tr>";
                                            echo "<th>#</th>";
                                            echo "<th>First Name</th>";
                                            echo "<th>SurName</th>";
                                            echo "<th></th>";
                                        echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<tr>";
                                            echo "<td>" . $row['id'] . "</td>";
                                            echo "<td>" . $row['firstname'] . "</td>";
                                            echo "<td>" . $row['surname'] . "</td>";
                                            echo "<td>";
                                            echo "<a href='../Models/read.php?id=". $row['id'] ."' title='View Records' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "   ";
                                            echo "<a href='../Models/update.php?id=". $row['id'] ."' title='Update Records' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "   ";
                                            echo "<a href='../Models/delete.php?id=". $row['id'] ."' title='Delete Records' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                            echo "</td>";

                                        echo "</tr>";
                                    }
                                    echo "</tbody>";                            
                                echo "</table>";
                                // Free result set
                                mysqli_free_result($result);
                                }
                            }
                            //echo $sql;
                        }
                        
                        
                        
                    }
                }
                //echo 'telefono';
            }elseif(filter_var($busqueda, FILTER_VALIDATE_EMAIL)) {
                $tipo = 2;
                $sql = "SELECT * FROM datos WHERE campo LIKE '".$busqueda."'";
                
                if($result1 = mysqli_query($link, $sql)){
                    if(mysqli_num_rows($result1) > 0){
                        while($row2 = mysqli_fetch_array($result1)){
                            $sql = "SELECT * FROM general WHERE id =".$row2['idgeneral'];
                            if($result = mysqli_query($link, $sql)){
                                if(mysqli_num_rows($result) > 0){
                                    echo "<table class='table table-bordered table-striped'>";
                                    echo "<thead>";
                                        echo "<tr>";
                                            echo "<th>#</th>";
                                            echo "<th>First Name</th>";
                                            echo "<th>SurName</th>";
                                            echo "<th></th>";
                                        echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<tr>";
                                            echo "<td>" . $row['id'] . "</td>";
                                            echo "<td>" . $row['firstname'] . "</td>";
                                            echo "<td>" . $row['surname'] . "</td>";
                                            echo "<td>";
                                            echo "<a href='../Models/read.php?id=". $row['id'] ."' title='View Records' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "   ";
                                            echo "<a href='../Models/update.php?id=". $row['id'] ."' title='Update Records' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "   ";
                                            echo "<a href='../Models/delete.php?id=". $row['id'] ."' title='Delete Records' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                            echo "</td>";

                                        echo "</tr>";
                                    }
                                    echo "</tbody>";                            
                                echo "</table>";
                                // Free result set
                                mysqli_free_result($result);
                                }
                            }
                            //echo $sql;
                        }
                        
                        
                        
                    }
                }
            
                
                
                //echo 'correo';
            }elseif(filter_var($busqueda, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Zñ-Ñ\s]+$/")))){
                $tipo = 3;
                //echo "string";
                $sql = "SELECT * FROM general WHERE firstname LIKE '".$busqueda."' OR surname LIKE '".$busqueda."'";
                //echo $sql;
                if($result = mysqli_query($link, $sql)){
                   if(mysqli_num_rows($result) > 0){
                       echo "<table class='table table-bordered table-striped'>";
                            echo "<thead>";
                                echo "<tr>";
                                    echo "<th>#</th>";
                                    echo "<th>First Name</th>";
                                    echo "<th>SurName</th>";
                                    echo "<th></th>";
                                echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while($row = mysqli_fetch_array($result)){
                                echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['firstname'] . "</td>";
                                    echo "<td>" . $row['surname'] . "</td>";
                                    echo "<td>";
                                    echo "<a href='../Models/read.php?id=". $row['id'] ."' title='View Records' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                    echo "   ";
                                    echo "<a href='../Models/update.php?id=". $row['id'] ."' title='Update Records' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                    echo "   ";
                                    echo "<a href='../Models/delete.php?id=". $row['id'] ."' title='Delete Records' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                    echo "</td>";

                                echo "</tr>";
                            }
                            echo "</tbody>";                            
                        echo "</table>";
                        // Free result set
                        mysqli_free_result($result);
                   }else{
                       echo "No Results";
                   }
                
            }else{
                
            }
             
        }else{
            echo "Parametro no valido";
            $tipo = 0;
        }
            if($tipo > 0){
               
               } 
            }
    }else{
        $sql = "SELECT * FROM general";
        if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table class='table table-bordered table-striped'>";
                    echo "<thead>";
                        echo "<tr>";
                            echo "<th>#</th>";
                            echo "<th>First Name</th>";
                            echo "<th>SurName</th>";
                            echo "<th></th>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while($row = mysqli_fetch_array($result)){
                        echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['firstname'] . "</td>";
                            echo "<td>" . $row['surname'] . "</td>";
                            echo "<td>";
                            echo "<a href='../Models/read.php?id=". $row['id'] ."' title='View Records' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                            echo "   ";
                            echo "<a href='../Models/update.php?id=". $row['id'] ."' title='Update Records' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                            echo "   ";
                            echo "<a href='../Models/delete.php?id=". $row['id'] ."' title='Delete Records' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                            echo "</td>";

                        echo "</tr>";
                    }
                    echo "</tbody>";                            
                echo "</table>";
                // Free result set
                mysqli_free_result($result);
            } else{
                echo "<p class='lead'><em>No records were found.</em></p>";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
        mysqli_close($link);
    }
    
        ?>

                </div>
            </div>        
        </div>
        <div class="form-group row align-items-center justify-content-center  wrapper clearfix ">
            <table class='table table-bordered table-striped'>
            <thead><tr>
            <form class="form-group" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" >
                <input id="inputsearch" type="text" name="inputsearch" class="form-control " value="<?php echo $busqueda;?>">
                
                <input type="submit" value="Search" class="btn btn-success pull-right">

            </form>
            </tr></thead>
            </table>
        </div>
    </div>
    
</body>
</html>

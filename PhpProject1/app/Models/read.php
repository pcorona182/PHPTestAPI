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
                        <h2 class="pull-left">Review Agenda</h2>
                        <a href="../Views/index.php" class="btn btn-success pull-right">Back</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "../Controllers/config.php";
                    //print_r($_GET["id"]);
                    $input_id = trim($_GET["id"]);
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM general WHERE id =". strval($input_id);
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-sm table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th style='width:30%'>Name</th>";
                                        //echo "<th>Last Name</th>";
                                        
                                        echo "<th style='width:25%'>Phones</th>";
                                        echo "<th style='width:25%'>emails</th>";
                                        echo "<th style='width:20%'>Photo</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        
                                        echo "<td>";
                                        echo "<table class='table'><tbody>";
                                        echo "<tr><td>".$row['firstname']."</td></tr>";
                                        echo "<tr><td>".$row['surname']."</td></tr>";
                                        echo "</tbody></table>";
                                        echo "</td>";
                                        
                                        echo "<td>";
                                        $sql1 = "SELECT * FROM datos WHERE idgeneral =" . $row['id'];
                                        if($result1 = mysqli_query($link, $sql1)){
                                            
                                             while($row1 = mysqli_fetch_array($result1)){
                                                 if($row1['tipocampo'] == 0){
                                                     echo "<table class='table'><tbody>";
                                                     //echo "<tr><td>&nbsp;</td></tr>";
                                                     echo "<tr><td>".$row1['campo']."</td></tr>";
                                                     echo "</tbody></table>";
                                                     //echo $row1['campo'];
                                                 }
                                                 
                                             }
                                        }
                                        echo "</td>";//Consulta
                                        
                                        
                                        echo "<td>";
                                        if($result1 = mysqli_query($link, $sql1)){
                                            
                                             while($row1 = mysqli_fetch_array($result1)){
                                                 if($row1['tipocampo'] == 1){
                                                     echo "<table class='table'><tbody>";
                                                     //echo "<tr><td>&nbsp;</td></tr>";
                                                     echo "<tr><td>".$row1['campo']."</td></tr>";
                                                     echo "</tbody></table>";
                                                     
                                                     //echo $row1['campo'];
                                                     //echo "<br>";
                                                 }
                                                 
                                             }
                                        }
                                        echo "</td>";
                                   
                                }
                                mysqli_free_result($result1);
                                
                                    echo '<td><div id="overlay">';
                                        $sql2 = "SELECT * FROM fotos WHERE idgeneral =" .strval($input_id);
                                        if($result2 = mysqli_query($link, $sql2)){
                                            $image = mysqli_fetch_array($result2);
                                            //echo $image["foto"];
                                            echo '<img class="img-thumbnail" src="data:image/jpeg;base64,'.base64_encode( $image["foto"] ).'" data-action="zoom"/>';
                                            
                                            
                                            
                                         }
                                        
                                    echo "</td></div>";//Consulta Photo
                                
                                 echo "</tr>";
                                
                                echo "</tbody>";                            
                            echo "</table>";
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
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>

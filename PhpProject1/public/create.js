/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var surname;
var surlname;
var surphones = [];
var suremails = [];
$(document).ready(function() { 
 
    $( "#photoSubmit" ).click(function() {
        
    });
 
    $( "#addphone" ).click(function() {
        //validaciones y errores
        surname = $( "#inputname").val();
        surlname = $( "#inputlname").val();
        if(validatePhone('inputphone0')){
            surphones.push($( "#inputphone0").val());
            $("#form1").append('<input id="inputphone'+ surphones.length +'" type="text" name="snum'+ surphones.length +'" class="form-control" value="'+ surphones[surphones.length - 1] +'">');
            $("#form1").append('<a id="delphone'+ (surphones.length -1)+'" title="Delete Number" data-toggle="tooltip"><span id="delphoneh'+ (surphones.length -1)+'" class="glyphicon glyphicon glyphicon-minus pull-left"></span></a>');
            $( "#inputphone0").val("");
            $("#inputphone0").css('border-color','#ccc');
            $( "#help-block1").html("");
            $( "#form1" ).change();
        }else{
           $( "#help-block1").html("Please enter 10 digits phone number");
           $( "#help-block1").css('color','#a94442');
           $("#inputphone0").css('border-color','#a94442');
        }

    });

    $( "#form1" ).change(function() {
        console.log("Tamano array = "+surphones.length);
        if(surphones.length > 0){
            $.each(surphones,function(i,val){
                $("body").on("click", "#delphone"+i+"", function() {
                    //alert("Clicked"+i.toString());
                    surphones.splice(i,1)
                    $("#inputphone"+(i+1)+"").remove();
                    $("#delphone"+i+"").remove();
                    $("#delphoneh"+i+"").remove();
                    console.log("Tamano array = "+surphones.length);
                });
            });                   
        }
    });



    $( "#addemail" ).click(function() {
        //validaciones y errores
        if(validateMail('inputmail0')){
            suremails.push($( "#inputmail0").val());
            $("#form2").append('<input id="inputmail'+ suremails.length +'" type="text" name="smail'+ suremails.length +'" class="form-control" value="'+ suremails[suremails.length - 1] +'">');
            $("#form2").append('<a id="delmail'+ (suremails.length -1)+'" title="Delete email" data-toggle="tooltip"><span id="delmailh'+ (suremails.length -1)+'" class="glyphicon glyphicon glyphicon-minus pull-left"></span></a>');
            $( "#inputmail0").val("");
            $("#inputmail0").css('border-color','#ccc');
            $( "#help-block2").html("");
            $( "#form2" ).change();
        }else{
           $( "#help-block2").html("Please enter valid email");
           $( "#help-block2").css('color','#a94442');
           $("#inputmail0").css('border-color','#a94442');
        }
    });

    $( "#form2" ).change(function() {
        console.log("Tamano array = "+suremails.length);
        if(suremails.length > 0){
            $.each(suremails,function(i,val){
                $("body").on("click", "#delmail"+i+"", function() {
                    //alert("Clicked"+i.toString());
                    suremails.splice(i,1)
                    $("#inputmail"+(i+1)+"").remove();
                    $("#delmail"+i+"").remove();
                    $("#delmailh"+i+"").remove();
                    console.log("Tamano array = "+surphones.length);
                });
            });                   
        }
    });
}); 


function validatePhone(txtPhone) {
    var a = document.getElementById(txtPhone).value;
    var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
    if (filter.test(a)) {
        return true;
    }
    else {
        return false;
    }
}
function validateMail(txtMail) {
    var a = document.getElementById(txtMail).value;
    var filter = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    if (filter.test(a)) {
        return true;
    }
    else {
        return false;
    }
}
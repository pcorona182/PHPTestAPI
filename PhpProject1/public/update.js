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
    $("#form1").find( ':input[type="text"]' ).each( function( index, val ) {
            surphones.push(val['value']);
            $( "#form1" ).change();
    });
        
    $( "#addphone" ).click(function() {
        surname = $( "#inputname").val();
        surlname = $( "#inputlname").val();
        //temp = $("#inputphone"+(surphones.length -1)).val();
        if(validatePhone("inputphone"+(surphones.length -1) )){
            $("#form1").append('<table id="tablephones'+surphones.length+'" class="table"><tbody>');
            $("#form1").append('<tr><td id="td'+surphones.length+'">')
            $("#form1").append('<input id="inputphone'+ surphones.length +'" type="text" name="snum'+ surphones.length +'" class="form-control" value="">');
            $("#form1").append('<a id="delphoneh'+ (surphones.length)+'" title="Delete Number" data-toggle="tooltip"><span id="delphoneh'+ (surphones.length)+'" class="glyphicon glyphicon glyphicon-minus pull-left"></span></a>');
            $("#form1").append('<span id="help-blocka'+(surphones.length)+'" class="help-block"></span>');
            $("#form1").append("</td></tr>");
            $("#form1").append("</tbody></table>");
            surphones.push(" ");
            $( "#form1" ).change();
        }
        console.log(surphones);

    });
        
        //console.log(surphones);
        console.log("Tamano array = "+surphones.length);
      // if(surphones.length > 0){
            $( "#form1" ).change(function() {
                
                $.each(surphones,function(i,val){
                    //$("body").on("click", "#delphoneh"+i+"", function() {
                    $("#delphoneh"+i).click(function(){
                        //alert("Clicked"+i.toString());
                        if(surphones.length > 1){
                            surphones.splice(i,1)
                            $("#inputphone"+(i)+"").remove();
                            $("#delphone"+i+"").remove();
                            $("#delphoneh"+i+"").remove();
                            $("#help-blocka"+i+"").remove();
                            $("#tdp"+i+"").remove();
                            $("#tablephones"+i+"").remove();
                            //
                        }
                        
                        console.log("Tamano array = "+surphones.length);
                    });
            });                   
           });                   

    $( "#form1" ).change();

$("#form2").find( ':input[type="text"]' ).each( function( index, val ) {
            suremails.push(val['value']);
            $( "#form2" ).change();
    });
        
    $( "#addemail" ).click(function() {
        surname = $( "#inputname").val();
        surlname = $( "#inputlname").val();
        //temp = $("#inputphone"+(surphones.length -1)).val();
        if(validateMail("inputmail"+(suremails.length -1) )){
            $("#form2").append('<table id="tablemails'+suremails.length+'" class="table"><tbody>');
            $("#form2").append('<tr><td id="td'+suremails.length+'">')
            $("#form2").append('<input id="inputmail'+ suremails.length +'" type="text" name="smail'+ suremails.length +'" class="form-control" value="">');
            $("#form2").append('<a id="delmail'+ (suremails.length)+'" title="Delete Email" data-toggle="tooltip"><span id="delmailh'+ (suremails.length)+'" class="glyphicon glyphicon glyphicon-minus pull-left"></span></a>');
            $("#form2").append('<span id="help-blockb'+(suremails.length)+'" class="help-block"></span>');
            $("#form2").append("</td></tr>");
            $("#form2").append("</tbody></table>");
            suremails.push(" ");
            $( "#form2" ).change();
        }
        console.log(suremails);

    });
        
        //console.log(surphones);
        console.log("Tamano array = "+suremails.length);
      // if(surphones.length > 0){
            $( "#form2" ).change(function() {
                
                $.each(suremails,function(i,val){
                    //$("body").on("click", "#delphoneh"+i+"", function() {
                    $("#delmailh"+i).click(function(){
                        //alert("Clicked"+i.toString());
                        if(suremails.length > 1){
                            suremails.splice(i,1)
                            $("#inputmail"+(i)+"").remove();
                            $("#delmail"+i+"").remove();
                            $("#delmailh"+i+"").remove();
                            $("#help-blockb"+i+"").remove();
                            $("#tdm"+i+"").remove();
                            $("#tablemails"+i+"").remove();
                            
                        }
                        
                        console.log("Tamano array = "+suremails.length);
                    });
            });                   
           });   
        $( "#form2" ).change();
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
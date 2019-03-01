$(document).ready(function(){ 

//EDITOR CKE EDITOR
    ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            // console.error( error );
        } );

//OTHER JAVASCRIPT

//SELECT ALL CHECKBOXES

// to test : alert("hello");


    $('#selectAllBoxes').click(function(event){
        if(this.checked) {
            $('.checkBoxes').each(function(){
                this.checked = true;
            });
            
        } else {
            $('.checkBoxes').each(function(){
                this.checked = false;
            });
        }
        
    });   

});
 
//Loader screen JQuery

// var div_box = "<div id='load-screen'><div id='loading'></div></div>";

// $("body").prepend(div_box);
// $('#load-screen').delay(350).fadeOut(300, function() {
//     $(this).remove(); 
// });



//AJAX / JQUERY instant loading from DB

function loadUsersOnline() {

    //use JQUERY get request to send to functions PHP
    $.get("functions.php?onlineusers=result", function(data){

    //Once we get the data we insert it somewhere
    //targetting teh class of usersonline from admin navigation 
    $(".usersonline").text(data);
    
});
}

//need to call funtion right after creating

setInterval(function(){
    
    loadUsersOnline();

},500);





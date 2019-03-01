$(document).ready(function(){ 

//EDITOR CKE EDITOR
    ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
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





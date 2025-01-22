$(document).ready(function(){
    // Cuando se suba una imagen...
    $("#imageInput").change(function() 
    {
        // Llama la función que muestra el preview.
        readURL(this);
    });
});

function readURL(input) 
{
    if (input.files && input.files[0])
    {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            $('#imagePreview').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}
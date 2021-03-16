<?php

    session_start();
    $title='Create Tutorial';

    $showDataTables=1;
    include "controller.php";

    $controller = new Controller(); 
    include "../include/include.php";

?>
<div class="jumbotron jumbotron-fluid text-center">
    <div class="container">
        <h1 class="display-4">Create Tutorial</h1>
    </div>
</div>

<form id="new-tutorial">
    <div class="container">
        <input style="width:100%; height:40px; font-size:30px" id="title" name="title" class="form-control form-control-lg" type="text" placeholder="Title">
        <p>
        <div id="editor">
        </div>
        <p>
        <div class="form-group form-control-lg">
            <input type="file" class="form-control-file" id="file-input">
        </div>
        <br></br>
        <button type="button" id="submittutorial" class="btn btn-primary btn-lg pull-right">
            Submit
        </button>
    </div>
</form>

<?php 

    include "../include/footer.php";

?>

<script>
    var toolbarOptions = [
    [ 'bold', 'italic' , 'underline' , 'strike' ],        
    [ 'blockquote' , 'code-block' ],

    [{ 'header': 1 } , { 'header': 2 }],               
    [{ 'list': 'ordered'} , { 'list': 'bullet' }],
    [{ 'script': 'sub'} , { 'script': 'super' }],      
    [{ 'indent': '-1'} , { 'indent': '+1' }],          
    [{ 'direction': 'rtl' }],                         

    [{ 'size': [ 'small' , false , 'large' , 'huge' ] }],  
    [{ 'header': [ 1 , 2 , 3 , 4 , 5 , 6 , false ] }],
    [ 'link' ],

    [{ 'color': [] }, { 'background': [] }],          
    [{ 'font': [] }],
    [{ 'align': [] }],

    [ 'image' ],

    [ 'clean' ]

];

var quill = new Quill('#editor', {
    modules: {
        toolbar: toolbarOptions
    },
    theme: 'snow',
    modules: {
        toolbar: {
            container: toolbarOptions,
            handlers: {
                image: imageHandler
            }
        }
    },
});

function imageHandler() {
    var range = this.quill.getSelection();
    var value = prompt('Please copy paste the image url here!');
    if(value){
        this.quill.insertEmbed(range.index, 'image', value, Quill.sources.USER);
    }
}
</script>
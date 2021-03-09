<?php include "../include/include.php" ?>

<div class="container">
    <div id="editor">
    </div>
    <button type="button" id="submittutorial" class="btn btn-primary btn-lg pull-right">
        Submit
    </button>
</div>



<?php include "../include/footer.php" ?>

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
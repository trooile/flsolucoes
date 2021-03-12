<?php 

    session_start();
    include "include_view.php";   

?>

<div class="container"> 
    <a class="btn btn-primary pull-right" href="/tutorials/tutorial_create.php" role="button">
        <span class="glyphicon glyphicon-pencil"></span>
    </a>
</div>

<p>

<div class="container">
    <div class="jumbotron vertical-center">
        <div class="row" style="margin-top: 15px;">
            <table id="tableTutorials" class="table table-striped table-bordered" cellspacing="0" width="100%">
            </table>
        </div>
    </div>
</div>

<?php 

    include "../include/footer.php";

?>

<script type="text/javascript">

	$(document).ready(function(){

        generateTable();

    });

    function generateTable(){
            $.ajax({
                type: 'POST',
                url: "/tutorials/actions.php?action=",
                dataType: "json",

            }).done(function (return) {
                if(return.error){
                    alerta(return.message);  
                }else{
                    $('#tableTutorials').DataTable({

                                            columns:[
                                                    {data: 'id', title: "Tutorial", className: "text-center"},
                                                    {data: 'title', title: "Title", className: "text-center"},
                                                    {data: 'creator', title: "Autor", className: "text-center"},
                                                    {data: 'create_date', title: "Date Create", className: "text-center"},
                                                    {data: 'open_tutorial', title: "Open", className: "text-center", orderable: false, render: btnOpen},
                                                    ],
                                            data:return.data,
                                            paging: false,
                                            destroy: true,
                                            info: false,
                                            bFilter: false,
                                            dom: 'Bfrtip', 
                                            buttons: []       

                        });
                }
            });
        }

    function btnOpen(data, type, row){

        var btnopen = '';

        btnopen +='<button type="button" class="btn btn-secondary btn-xs btn-grid" onclick="openTutorial('+row.id+')" title="Open">';
        btnopen +='<span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>';
        btnopen +='</button>';

        return btnopen;

    }

</script>
<?php
	ini_set("display_errors", "1");
	date_default_timezone_set('America/Sao_Paulo');
	error_reporting(E_ALL ^ E_DEPRECATED);
	//include_once $INCLUDE_PATH . 'bd.php';
?>
<!DOCTYPE html>
	<html lang="pt">
		<style>

			.navbar {
				background-color: #000033;
				position: fixed; 
				top: 5; 
				width: 100%; 
				font-family: Verdana;
				font-size: 12px
			}

			.navbar a {
				float: left;
				display: block;
				color: #FFFFFF;
				padding: 20px 22px;
				text-decoration: none;
			}

			.navbar a:hover {
				background: #DDDDDD;
				color: black;
			}

			#navbar a.active {
				background-color: #000099;
				color: white;
			}

			.main {
				margin-top: 60px;
			}

			.sticky {
				position: fixed;
				top: 0;
				width: 100%;
			}

			.content {
				padding: 16px;
			}
			
			.sticky + .content {
				padding-top: 60px;
			}

		</style>

		<head>

			<title>
				<?php 
				
				echo isset($title) ? $title : "MeltedSplit"; 
				
				?>
			</title>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">

			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
			<script	src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/additional-methods.min.js"></script>
			<script src="/public/includes/jquery.maskMoney.min.js"></script>
			<script src="/public/includes/loadingoverlay.min.js"></script>
			<link href="/public/includes/componentes/select2/css/select2.min.css" rel="stylesheet" />
			<script src="/public/includes/componentes/select2/js/select2.min.js"></script>
			<script src="/public/includes/componentes/select2/js/i18n/pt-BR.js"></script>
			<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
			<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

			<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
			<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
			<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
			<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.15/sorting/datetime-moment.js"></script>
			<script type="text/javascript" src="https://cdn.datatables.net/select/1.2.5/js/dataTables.select.min.js"></script>
			<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
			<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.2.5/css/select.dataTables.min.css">

			<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
			<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
			<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
			<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
			<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
			<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
			<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
			<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">

			<script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
			<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
			<link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
			<link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
			<link href="//cdn.quilljs.com/1.3.6/quill.core.css" rel="stylesheet">
			<script src="//cdn.quilljs.com/1.3.6/quill.core.js"></script>
			<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
			<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

				<style type='text/css'>
					
					@import url('/public/includes/datepicker.min.css');

				</style>

			<script type="text/javascript" src='/public/includes/datepicker.min.js'></script>
			<script type="text/javascript" src='/public/includes/datepicker.pt-BR.min.js'></script>

			<style type='text/css'>

				@import url('/public/includes/estilo.css?12');

				<?php 

					include 'include_css_perm.php';

				?>

			</style>

			<script type='text/javascript' src='/public/includes/java.js?51'></script>
			<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.3/jquery.mask.min.js'></script>

			<?php

				include "header.php";

			?>

		</head>
	</html>
</html>
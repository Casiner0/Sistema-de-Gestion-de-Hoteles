<!--<div class="container">-->
    <div class="row clearfix">
        <div class="col-md-12 column">
            <div class="alert alert-dismissable alert-danger">
				 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4>
					Error!
				</h4>
                    <?php if (isset($_SESSION['error']) && !empty($_SESSION['error']))
                        echo $_SESSION['error'];
                    else
                        echo 'Opción no válida';
                    ?>

            </div>
        </div>
    </div>
<!--</div>-->

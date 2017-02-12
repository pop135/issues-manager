<?php
require('inc/config.php');
require('inc/functions.php');

/*Check for authentication otherwise user will be redirects to main.php page.*/
if (!isset($_SESSION['UserData']) || !get_user_data($con, $_SESSION['UserData']['user_id'])) {
    exit(header("location:main.php"));
}

require('include/header.php');
require('include/navbar.php');
?>

<div class="container">
<?php

if(!empty($_POST)){
	if(isset($_POST["data"]) && isset($_POST["lloc"])
	){
		if((($_POST["data"]) != "") && (trim($_POST["lloc"]) != "")
		){
			$cnx = conectar();
			$loged_in_user_id = $_SESSION['UserData']['user_id'];
			$data = mysql_real_escape_string($_POST["data"]);	
			$averia = isset($_POST["averia"])?"'".mysql_real_escape_string($_POST["averia"])."'":'NULL';
			$prod_averiat_marca = isset($_POST["prod_averiat_marca"])?"'".mysql_real_escape_string($_POST["prod_averiat_marca"])."'":'NULL';
			$prod_averiat_model = isset($_POST["prod_averiat_model"])?"'".mysql_real_escape_string($_POST["prod_averiat_model"])."'":'NULL';
			$prod_averiat_sn = isset($_POST["prod_averiat_sn"])?"'".mysql_real_escape_string($_POST["prod_averiat_sn"])."'":'NULL';
			$prod_nou_marca = isset($_POST["prod_nou_marca"])?"'".mysql_real_escape_string($_POST["prod_nou_marca"])."'":'NULL';
			$prod_nou_model = isset($_POST["prod_nou_model"])?"'".mysql_real_escape_string($_POST["prod_nou_model"])."'":'NULL';
			$prod_nou_sn = isset($_POST["prod_nou_sn"])?"'".mysql_real_escape_string($_POST["prod_nou_sn"])."'":'NULL';
			$lloc = mysql_real_escape_string($_POST["lloc"]);
			$aula = isset($_POST["aula"])?"'".mysql_real_escape_string($_POST["aula"])."'":'NULL';
			$reposar_prod_averiat = isset($_POST["reposar_prod_averiat"])?"'".mysql_real_escape_string($_POST["reposar_prod_averiat"])."'":'NULL';;
			$final_garantia = isset($_POST["final_garantia"])?"'".mysql_real_escape_string($_POST["final_garantia"])."'":'NULL';
			
			$sql_query = "INSERT INTO averies(	user_id,
												data,
												averia,
												prod_averiat_marca,
												prod_averiat_model,
												prod_averiat_sn,
												prod_nou_marca,
												prod_nou_model,
												prod_nou_sn,
												lloc,
												aula,
												reposar_prod_averiat,
												garantia_fins) 
								VALUES(	'$loged_in_user_id',
										'$data',
										$averia,
										$prod_averiat_marca,
										$prod_averiat_model,
										$prod_averiat_sn,
										$prod_nou_marca,
										$prod_nou_model,
										$prod_nou_sn,
										'$lloc',
										$aula,
										'$reposar_prod_averiat',
										$final_garantia)";
			
			mysql_query($sql_query,$cnx);
			$product_id = mysql_insert_id();
			mysql_close($cnx);
			echo ('<div id="success_alert" class="text-center alert alert-success" role="alert">Ticket obert correctament, escriu l\'identificador <b>'.$product_id.'</b> a la caixa del producte...</div>');
		}
	} 
}

?>

<form name="form_obrir" id="form_obrir" action="index.php" method="post">

	<div class="form-group row">
		<label for="data" class="col-form-label col-sm-3 col-sm-offset-3">Date</label>
		<div class="col-sm-3">
			<input id="data" name="data" class="form-control" type="date" step="1" min="2016-01-01" value="<?php echo date("Y-m-d");?>" required >
		</div>
	</div>
	<div class="form-group row">
		<label for="lloc" class="col-form-label col-sm-3 col-sm-offset-3">Location</label>
		<div class="col-sm-3">
			<INPUT type="text" id="lloc" name="lloc" class="form-control" maxlength="50" placeholder="Location" required/>
		</div>
	</div>
	<div class="form-group row">
		<label for="aula" class="col-form-label col-sm-3 col-sm-offset-3">Room</label>
		<div class="col-sm-3">
			<INPUT type="text" id="aula" name="aula" class="form-control" maxlength="50" placeholder="Room" />
		</div>
	</div>
	<div class="form-group row">
		<label for="prod_averiat_marca" class="col-form-label col-sm-3 col-sm-offset-3">Broken product</label>
		<div class=" col-sm-3">
			<INPUT type="text" id="prod_averiat_marca" name="prod_averiat_marca" class="form-control" maxlength="50" placeholder="Brand" />
		</div>
	</div>
	<div class="form-group row">
		<div class="col-sm-offset-6 col-sm-3">
			<INPUT type="text" id="prod_averiat_model" name="prod_averiat_model" class="form-control" maxlength="50" placeholder="Model"  />
		</div>
	</div>
	<div class="form-group row">
		<div class="col-sm-offset-6 col-sm-3">
			<INPUT type="text" id="prod_averiat_sn" name="prod_averiat_sn" class="form-control" maxlength="50" placeholder="S/N"  />
		</div>
	</div>
	<div class="form-group row">
		<label for="final_garantia" class="col-form-label col-sm-3 col-sm-offset-3">Warranty ends</label>
		<div class="col-sm-3">
			<input id="final_garantia" name="final_garantia" class="form-control" type="date" step="1" min="2016-01-01" />
		</div>
	</div>
	<div class="form-group row">
		<label for="averia" class="col-form-label col-sm-3 col-sm-offset-3">Issue</label>
		<div class="col-sm-3">
			<textarea id="averia" name="averia" class="form-control" style="min-width: 100%" placeholder="Issue" ></textarea>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-sm-offset-5 col-sm-2">
			<button id="open_ticket" type="submit" class=" btn btn-default btn-primary btn-fade-in">Open ticket</button>
		</div>
	</div>  
	</form>
</div>

<?php require('include/footer.php');?>
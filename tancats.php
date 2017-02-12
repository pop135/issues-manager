<?php
require('inc/config.php');
require('inc/functions.php');

/*Check for authentication otherwise user will be redirects to main.php page.*/
if (!isset($_SESSION['UserData']) || !get_user_data($con, $_SESSION['UserData']['user_id'])['status']) {
    exit(header("location:main.php"));
}

require('include/header.php');
require('include/navbar.php');
?>


<div class="container">
<?php
$cnx = conectar();

if(isset($_GET["o"])) {
	$idtancar = $_GET["o"];
	mysql_query("UPDATE averies SET tancat='0' WHERE id='$idtancar'",$cnx);
}	

//filtrar per lloc, marca averiat i model averiat

//comprovar si hem filtrat abans
$lloc_default = null;
$marca_default = null;
$model_default = null;
if(isset($_GET["l"])) {
	$lloc_default = urldecode($_GET["l"]);
}
if(isset($_GET["ma"])) {
	$marca_default = urldecode($_GET["ma"]);
}
if(isset($_GET["mo"])) {
	$model_default = urldecode($_GET["mo"]);
}

//modifiquem les consultes perque s'adaptin als filtres
$sql_lloc = "";
$sql_marques = "";
$sql_models = "";
if($lloc_default && !$marca_default && !$model_default){//lloc
	$sql_lloc = "AND lloc='$lloc_default'";
	$sql_marques = "AND lloc='$lloc_default'";
	$sql_models = "AND lloc='$lloc_default'";
}
if(!$lloc_default && $marca_default && !$model_default){//marca
	$sql_lloc = "AND prod_averiat_marca='$marca_default'";
	$sql_marques = "AND prod_averiat_marca='$marca_default'";
	$sql_models = "AND prod_averiat_marca='$marca_default'";
}
if(!$lloc_default && !$marca_default && $model_default){//model
	$sql_lloc = "AND prod_averiat_model='$model_default'";
	$sql_marques = "AND prod_averiat_model='$model_default'";
	$sql_models = "AND prod_averiat_model='$model_default'";
}
if($lloc_default && $marca_default && !$model_default){//lloc,marca
	$sql_lloc = "AND lloc='$lloc_default' AND prod_averiat_marca='$marca_default'";
	$sql_marques = "AND lloc='$lloc_default' AND prod_averiat_marca='$marca_default'";
	$sql_models = "AND lloc='$lloc_default' AND prod_averiat_marca='$marca_default'";
}
if($lloc_default && !$marca_default && $model_default){//lloc,model
	$sql_lloc = "AND lloc='$lloc_default' AND prod_averiat_model='$model_default'";
	$sql_marques = "AND lloc='$lloc_default' AND prod_averiat_model='$model_default'";
	$sql_models = "AND lloc='$lloc_default' AND prod_averiat_model='$model_default'";
}
if(!$lloc_default && $marca_default && $model_default){//marca,model
	$sql_lloc = "AND prod_averiat_marca='$marca_default' AND prod_averiat_model='$model_default'";
	$sql_marques = "AND prod_averiat_marca='$marca_default' AND prod_averiat_model='$model_default'";
	$sql_models = "AND prod_averiat_marca='$marca_default' AND prod_averiat_model='$model_default'";
}
if($lloc_default && $marca_default && $model_default){//lloc,marca,model
	$sql_lloc = "AND lloc='$lloc_default' AND prod_averiat_marca='$marca_default' AND prod_averiat_model='$model_default'";
	$sql_marques = "AND lloc='$lloc_default' AND prod_averiat_marca='$marca_default' AND prod_averiat_model='$model_default'";
	$sql_models = "AND lloc='$lloc_default' AND prod_averiat_marca='$marca_default' AND prod_averiat_model='$model_default'";
}


$resultComen = mysql_query("SELECT * FROM averies WHERE tancat='1' ORDER BY id ASC");
$llocs = mysql_query("SELECT DISTINCT lloc FROM averies WHERE tancat='1' ".$sql_lloc." ORDER BY lloc ASC");
$marques = mysql_query("SELECT DISTINCT prod_averiat_marca FROM averies WHERE tancat='1' ".$sql_marques." ORDER BY prod_averiat_marca ASC");
$models = mysql_query("SELECT DISTINCT prod_averiat_model FROM averies WHERE tancat='1' ".$sql_models." ORDER BY prod_averiat_model ASC");


if(mysql_num_rows($resultComen)){
	echo '<div class="container"><form class="form-inline col-sm-6 col-sm-offset-3">
	<div class="form-group">
	<label for="filtrar_lloc">Filter results by  </label>
	<select class="form-control" id="filtrar_lloc" name="filtrar_lloc" onchange="reload(filtrar_lloc.value,filtrar_prod_averiat_marca.value,filtrar_prod_averiat_model.value,\'tancats.php\')">
	<option value="null">place</option>';
	while($rowllocs = mysql_fetch_array($llocs)){
		if($rowllocs["lloc"] != ""){
			if($lloc_default == $rowllocs["lloc"]){
				echo '<option value="'.$rowllocs["lloc"].'" selected="selected">'.$rowllocs["lloc"].'</option>';
			}
			else{
				echo '<option value="'.$rowllocs["lloc"].'">'.$rowllocs["lloc"].'</option>';
			}
		}
	};
	echo'</select></div>

	<div  class="form-group"><select class="form-control" id="filtrar_prod_averiat_marca" name="filtrar_prod_averiat_marca" onchange="reload(filtrar_lloc.value,filtrar_prod_averiat_marca.value,filtrar_prod_averiat_model.value,\'tancats.php\')">
	<option value="null">brand</option>';
	while($rowmarques = mysql_fetch_array($marques)){
		if($rowmarques["prod_averiat_marca"] != ""){
			if($marca_default == $rowmarques["prod_averiat_marca"]){
				echo '<option value="'.$rowmarques["prod_averiat_marca"].'" selected="selected">'.$rowmarques["prod_averiat_marca"].'</option>';
			}
			else{
				echo '<option value="'.$rowmarques["prod_averiat_marca"].'">'.$rowmarques["prod_averiat_marca"].'</option>';
			}
		}
	};
	echo'</select></div>

	<div  class="form-group"><select class="form-control" id="filtrar_prod_averiat_model" name="filtrar_prod_averiat_model" onchange="reload(filtrar_lloc.value,filtrar_prod_averiat_marca.value,filtrar_prod_averiat_model.value,\'tancats.php\')">
	<option value="null">model</option>';
	while($rowmodels = mysql_fetch_array($models)){
		if($rowmodels["prod_averiat_model"] != ""){
			if($model_default == $rowmodels["prod_averiat_model"]){
				echo '<option value="'.$rowmodels["prod_averiat_model"].'" selected="selected">'.$rowmodels["prod_averiat_model"].'</option>';
			}
			else{
				echo '<option value="'.$rowmodels["prod_averiat_model"].'">'.$rowmodels["prod_averiat_model"].'</option>';
			}
		}
	};
	echo'</select></div>
	</form></div>';
}

if(mysql_num_rows($resultComen)){
	
	$num_mostrats=0;
	
	setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
	echo '<div class="container"><table class="table">
		<thead><tr>
		<th>#</th><th>date</th><th>place</th><th>room</th><th>broken product</th><th>show</th><th>reopen</th>
		</tr></thead>';
		
	while($rowComen = mysql_fetch_array($resultComen)){

		//l'hem de mostrar??
		$mostrar_element = false;
		if($lloc_default == null && $marca_default == null && $model_default == null) $mostrar_element = true;//tot es null mostrem tots
		if($lloc_default == $rowComen["lloc"] && $marca_default == null && $model_default == null) $mostrar_element = true;//lloc
		if($lloc_default == null && $marca_default == $rowComen["prod_averiat_marca"] && $model_default == null) $mostrar_element = true;//marca
		if($lloc_default == null && $marca_default == null && $model_default == $rowComen["prod_averiat_model"]) $mostrar_element = true;//model
		if($lloc_default == $rowComen["lloc"] && $marca_default == $rowComen["prod_averiat_marca"] && $model_default == null) $mostrar_element = true;//lloc marca
		if($lloc_default == $rowComen["lloc"] && $marca_default == null && $model_default == $rowComen["prod_averiat_model"]) $mostrar_element = true;//lloc model
		if($lloc_default == null && $marca_default == $rowComen["prod_averiat_marca"] && $model_default == $rowComen["prod_averiat_model"]) $mostrar_element = true;//marca model
		if($lloc_default == $rowComen["lloc"] && $marca_default == $rowComen["prod_averiat_marca"] && $model_default == $rowComen["prod_averiat_model"]) $mostrar_element = true;//lloc marca model

		if($mostrar_element){
			$num_mostrats++;
			
			if($rowComen["prod_averiat_marca"] && $rowComen["prod_averiat_model"]) $barra = " / ";
			else $barra = "";
			echo "<tr><td>".$rowComen["id"]."</td><td>".strftime("%d/%m/%Y",strtotime($rowComen["data"]))."</td><td>".$rowComen["lloc"]."</td><td>".$rowComen["aula"]."</td><td>".$rowComen["prod_averiat_marca"].$barra.$rowComen["prod_averiat_model"]."</td><td><a href=\"#show_modal".$rowComen["id"]."\" class=\"btn btn-primary\" role=\"button\" data-toggle=\"modal\" data-target=\"#show_modal".$rowComen["id"]."\">show</a></td><td><a href=\"tancats.php?o=".$rowComen["id"]."\" class=\"btn btn-danger\" role=\"button\">reopen</a></td></tr>";
			
			//producte substituit
			if($rowComen["prod_nou_marca"])$prod_nou = true;
			else $prod_nou = false;
			
			//producte reparat
			if($rowComen["reposar_prod_averiat"])$reposar_prod_averiat = true;
			else $reposar_prod_averiat = false;
			
			echo'<!-- Registration Form -->
			  <div class="modal fade" role="dialog" id="show_modal'.$rowComen["id"].'">
				<div class="modal-dialog">
				  <div class="modal-content">

					<!-- HTML Form -->
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Showing ticket #'.$rowComen["id"].'</h4>
					</div>
					<!-- Modal Body -->
					<div class="modal-body">
						<div class="form-group row">
							<div class="col-sm-8 col-sm-offset-2"><h2>Ticket info</h2></div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 col-sm-offset-1">Date</div>
							<div class="col-sm-7">'.strftime("%d/%m/%Y",strtotime($rowComen["data"])).'</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 col-sm-offset-1">Location</div>
							<div class="col-sm-7">'.$rowComen["lloc"].'</div>	
						</div>';
						if($rowComen["aula"] != NULL){
						echo '<div class="form-group row">
							<div class="col-sm-3 col-sm-offset-1">Room</div>
							<div class="col-sm-7">'.$rowComen["aula"].'</div>
						</div>';
						}
						if(($rowComen["prod_averiat_marca"] != NULL) || ($rowComen["prod_averiat_model"] != NULL) || ($rowComen["prod_averiat_sn"] != NULL)){
							echo'<div class="form-group row">
								<div class="col-sm-3 col-sm-offset-1">Broken product</div>
								<div class="col-sm-7">'.$rowComen["prod_averiat_marca"].'</div>	
							</div>
							<div class="form-group row">
								<div class="col-sm-7 col-sm-offset-4">'.$rowComen["prod_averiat_model"].'</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-7 col-sm-offset-4">'.$rowComen["prod_averiat_sn"].'</div>
							</div>';
						}
						if(($rowComen["garantia_fins"] != NULL) && ($rowComen["garantia_fins"] != "0000-00-00")){
						echo'<div class="form-group row">
							<div class="col-sm-3 col-sm-offset-1">Warranty ends</div>
							<div class="col-sm-7">'.strftime("%d/%m/%Y",strtotime($rowComen["garantia_fins"])).'</div>	
						</div>';
						}
						echo'<div class="form-group row">
							<div class=" col-sm-3 col-sm-offset-1">Issue</div>
							<div class="col-sm-7">'.$rowComen["averia"].'</div>
						</div>';
						if($prod_nou){
							echo'<div class="form-group row">
								<div class="col-sm-11 col-sm-offset-1">Product broken was <b>replaced</b>...</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3 col-sm-offset-1">New product</div>
								<div class="col-sm-7">'.$rowComen["prod_nou_marca"].'</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-7 col-sm-offset-4">'.$rowComen["prod_nou_model"].'</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-7 col-sm-offset-4">'.$rowComen["prod_nou_sn"].'</div>
							</div>';
						}
						
						if($reposar_prod_averiat){
							echo'<div class="form-group row">
								<div class="col-sm-11 col-sm-offset-1">Product broken was <b>repaired</b>...</div>
							</div>';
							if(($rowComen["enviat_reparar"] != NULL) && ($rowComen["enviat_reparar"] != "0000-00-00")){
								echo'<div class="form-group row">
									<div class="col-sm-3 col-sm-offset-1">Sent to SAT</div>
									<div class="col-sm-7">'.strftime("%d/%m/%Y",strtotime($rowComen["enviat_reparar"])).'</div>
								</div>';
							}
							if(($rowComen["tornat_reparar"] != NULL) && ($rowComen["tornat_reparar"] != "0000-00-00")){
								echo'<div class="form-group row">
									<div class="col-sm-3 col-sm-offset-1">Recieved from SAT</div>
									<div class="col-sm-7">'.strftime("%d/%m/%Y",strtotime($rowComen["tornat_reparar"])).'</div>
								</div>';
							}
						}
						if(!$reposar_prod_averiat && !$prod_nou){
							echo'<div class="form-group row">
								<div class="col-sm-11 col-sm-offset-1">Product broken was <b>not replaced</b> (this means that the product is still broken)...</div>
							</div>';
						}
						
						//show all interactions
						echo'<div class="form-group row">
								<div class="col-sm-8 col-sm-offset-2"><h2>Interactions with client</h2></div>
							</div>';
						
						$id_averia=$rowComen["id"];
						$resultInteractions = mysql_query("SELECT * FROM interactions WHERE id_averia='$id_averia' ORDER BY id ASC");
						if(mysql_num_rows($resultInteractions)){
							while($rowInteractions = mysql_fetch_array($resultInteractions)){
								echo'
								<div class="form-group row">
									<span class="col-form-label col-sm-2">'.strftime("%d/%m/%Y",strtotime($rowInteractions["data"])).'</span>
									<span class="col-form-label col-sm-10">'.nl2br($rowInteractions["cos"]).'</span>
								</div>
								
								';
							}	
						}
						else{
							echo'
								<div class="form-group row">
									<span class="col-form-label col-sm-10 col-sm-offset-1">There are no client interactions :(</span>
								</div>
								
							';
						}
						
						
						echo'
					</div>

					<!-- Modal Footer -->
					<div class="modal-footer">
						<button type="button" class="btn  btn-lg  btn-default" data-dismiss="modal">Close</button>
					</div>

				  </div>
				</div>
			  </div>';
		}
	}
		echo "</table></div>";
	
	echo'<div id="success_alert" class="text-center alert alert-success" role="alert">There are <b>'.$num_mostrats.'</b> tickets of this kind.....</div>';
	
	mysql_free_result($resultComen);
	mysql_free_result($resultInteractions);
}
else{
	echo '<div class="container"><div id="success_alert" class="text-center alert alert-success" role="alert">There are no closed tickets.....</div></div>';
};
mysql_close($cnx);
?>
</div>
<?php require('include/footer.php');?>
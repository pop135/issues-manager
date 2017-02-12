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

if(isset($_GET["t"])) {
	$idtancar = $_GET["t"];
	mysql_query("UPDATE averies SET tancat='1' WHERE id='$idtancar'",$cnx);
}	

if(!empty($_POST)){
	//step modal
	
	if(isset($_POST["step_data"]) && isset($_POST["step_body"])
	){
		if((($_POST["step_data"]) != "") && (trim($_POST["step_body"]) != "")
		){
			$step_id_averia = mysql_real_escape_string($_POST["step_id"]);
			$step_data = mysql_real_escape_string($_POST["step_data"]);
			$step_body = mysql_real_escape_string($_POST["step_body"]);
			$sql_query = "INSERT INTO interactions(	id_averia,data,cos)VALUES('$step_id_averia','$step_data','$step_body')";
			
			mysql_query($sql_query,$cnx);
			echo ('<div id="success_alert" class="text-center alert alert-success fadeout" role="alert">Step for ticket <b>#'.$step_id_averia.'</b> succesfully created...</div>');
		}
	}
	
	
	
	//edit modal
	if(isset($_POST["data"]) && isset($_POST["lloc"])
	){
		if((($_POST["data"]) != "") && (trim($_POST["lloc"]) != "")
		){
			
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
			$reposar_prod_averiat = mysql_real_escape_string($_POST["reposar_prod_averiat"]);
			
			$sql_query = "UPDATE averies SET data='$data',
												averia=$averia,
												prod_averiat_marca=$prod_averiat_marca,
												prod_averiat_model=$prod_averiat_model,
												prod_averiat_sn=$prod_averiat_sn,
												prod_nou_marca=$prod_nou_marca,
												prod_nou_model=$prod_nou_model,
												prod_nou_sn=$prod_nou_sn,
												lloc='$lloc',
												aula=$aula,
												reposar_prod_averiat='$reposar_prod_averiat'";
			
			
			if(isset($_POST["garantia_fins"]) && $_POST["garantia_fins"] != "0000-00-00"){
				$garantia_fins = mysql_real_escape_string($_POST["garantia_fins"]);
				$sql_query = $sql_query.",garantia_fins='$garantia_fins'";
			};
			if(isset($_POST["enviat_reparar"]) && $_POST["enviat_reparar"] != "0000-00-00"){
				$enviat_reparar = mysql_real_escape_string($_POST["enviat_reparar"]);
				$sql_query = $sql_query.",enviat_reparar='$enviat_reparar'";
			};
			if(isset($_POST["tornat_reparar"]) && $_POST["tornat_reparar"] != "0000-00-00"){
				$tornat_reparar = mysql_real_escape_string($_POST["tornat_reparar"]);
				$sql_query = $sql_query.",tornat_reparar='$tornat_reparar'";
			};			
			$id = mysql_real_escape_string($_POST["id"]);
			$sql_query = $sql_query."WHERE id='$id'";
			
			mysql_query($sql_query,$cnx);
			echo ('<div id="success_alert" class="text-center alert alert-success fadeout" role="alert">Ticket <b>'.$id.'</b> succesfully updated...</div>');
		}
	} 
}

$resultComen = mysql_query("SELECT * FROM averies WHERE tancat='0' ORDER BY id ASC");

if(mysql_num_rows($resultComen)){
	setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
	echo '<div class="container"><table class="table"><thead>
		<tr>
		<th>#</th><th>date</th><th>place</th><th>room</th><th>broken product</th><th>ticket history</th><th>edit</th><th>close</th>
		</tr></thead>';
		
	while($rowComen = mysql_fetch_array($resultComen)){

			if($rowComen["prod_averiat_marca"] && $rowComen["prod_averiat_model"]) $barra = " / ";
			else $barra = "";
			echo "<tr><td>".$rowComen["id"]."</td><td>".strftime("%d/%m/%Y",strtotime($rowComen["data"]))."</td><td>".$rowComen["lloc"]."</td><td>".$rowComen["aula"]."</td><td>".$rowComen["prod_averiat_marca"].$barra.$rowComen["prod_averiat_model"]."</td><td><a href=\"#edit_modal".$rowComen["id"]."\" class=\"btn btn-primary\" role=\"button\" data-toggle=\"modal\" data-target=\"#step_modal".$rowComen["id"]."\">ticket history</a></td><td><a href=\"#edit_modal".$rowComen["id"]."\" class=\"btn btn-primary\" role=\"button\" data-toggle=\"modal\" data-target=\"#edit_modal".$rowComen["id"]."\">edit</a></td><td><a href=\"oberts.php?t=".$rowComen["id"]."\" class=\"btn btn-danger\" role=\"button\">close</a></td></tr>";
			
			$prod_averiat_status = "";
			$prod_averiat_substituit_status = "checked";
			if(empty($rowComen["prod_nou_marca"])){
				$prod_averiat_status = "disabled";
				$prod_averiat_substituit_status = "";
			}
			$reposar_prod_averiat_yes_status = "";
			$reposar_prod_averiat_no_status = "checked";
			if($rowComen["reposar_prod_averiat"]){
				$reposar_prod_averiat_yes_status = "checked";
				$reposar_prod_averiat_no_status = "";
			}
			$warranty_ends_status ="readonly";
			if($rowComen["garantia_fins"] == NULL){
				
				$warranty_ends_status="";
			}
			
			//step in modal
			
			echo'<!-- Registration Form -->
			  <div class="modal fade" role="dialog" id="step_modal'.$rowComen["id"].'">
				<div class="modal-dialog">
				  <div class="modal-content">

					<!-- HTML Form -->
					<form action="oberts.php" method="post" name="step_form" id="step_form" autocomplete="off">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Adding interaction into ticket #'.$rowComen["id"].'</h4>
					</div>
					<!-- Modal Body -->
					<div class="modal-body">
					<input type="hidden" class="form-control" name="step_id" value="'.$rowComen["id"].'">';
					
					
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
						
						
						echo'<input type="hidden" class="form-control" name="id" value="'.$rowComen["id"].'">
						<div class="form-group row">
							<label for="step_data" class="col-form-label col-sm-3 col-sm-offset-1">Date</label>
							<div class="col-sm-7">
								<input id="step_data" name="step_data" class="form-control" type="date" step="1" min="2016-01-01" value="'.date("Y-m-d").'" required >
							</div>
						</div>
						<div class="form-group row">
							<label for="step_body" class="col-form-label col-sm-3 col-sm-offset-1">Interaction</label>
							<div class="col-sm-7">
								<textarea id="step_body" name="step_body" class="form-control" style="min-width: 100%" placeholder="Interaction" required></textarea>
							</div>
						</div>
					</div>

					<!-- Modal Footer -->
					<div class="modal-footer">
					<input type="submit" class="btn btn-lg btn-primary" value="Create" id="submit">
					  <button type="button" class="btn  btn-lg  btn-default" data-dismiss="modal">Cancel</button>
					</div>
					</form>

				  </div>
				</div>
			  </div>';
			
			
			
			
			//edit modal
			echo'<!-- Registration Form -->
			  <div class="modal fade" role="dialog" id="edit_modal'.$rowComen["id"].'">
				<div class="modal-dialog">
				  <div class="modal-content">

					<!-- HTML Form -->
					<form action="oberts.php" method="post" name="edit_form" id="edit_form" autocomplete="off">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Editing ticket #'.$rowComen["id"].'</h4>
					</div>
					<!-- Modal Body -->
					<div class="modal-body">
						<input type="hidden" class="form-control" name="id" value="'.$rowComen["id"].'">
						<div class="form-group row">
							<label for="data" class="col-form-label col-sm-3 col-sm-offset-1">Date</label>
							<div class="col-sm-7">
								<input id="data" name="data" class="form-control" type="date" step="1" min="2016-01-01" value="'.$rowComen["data"].'" required >
							</div>
						</div>
						<div class="form-group row">
							<label for="lloc" class="col-form-label col-sm-3 col-sm-offset-1">Location</label>
							<div class="col-sm-7">
								<INPUT type="text" id="lloc" name="lloc" class="form-control" maxlength="50" placeholder="Location" value="'.$rowComen["lloc"].'" required/>
							</div>	
						</div>
						<div class="form-group row">
							<label for="aula" class="col-form-label col-sm-3 col-sm-offset-1">Room</label>
							<div class="col-sm-7">
								<INPUT type="text" id="aula" name="aula" class="form-control" maxlength="50" placeholder="Room" value="'.$rowComen["aula"].'" />
							</div>
						</div>
						<div class="form-group row">
							<label for="prod_averiat_marca" class="col-form-label col-sm-3 col-sm-offset-1">Broken product</label>
							<div class="col-sm-7">
								<INPUT type="text" id="prod_averiat_marca" name="prod_averiat_marca" class="form-control" maxlength="50" placeholder="Brand" value="'.$rowComen["prod_averiat_marca"].'" />
							</div>	
						</div>
						<div class="form-group row">
							<div class="col-sm-7 col-sm-offset-4">
								<INPUT type="text" id="prod_averiat_model" name="prod_averiat_model" class="form-control" maxlength="50" placeholder="Model" value="'.$rowComen["prod_averiat_model"].'"  />
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-7 col-sm-offset-4">
								<INPUT type="text" id="prod_averiat_sn" name="prod_averiat_sn" class="form-control" maxlength="50" placeholder="S/N" value="'.$rowComen["prod_averiat_sn"].'"  />
							</div>
						</div>
						<div class="form-group row">
							<label for="garantia_fins" class="col-form-label col-sm-3 col-sm-offset-1">Warranty ends</label>
							<div class="col-sm-7">
								<input id="garantia_fins" name="garantia_fins" class="form-control" type="date" step="1" value="'.$rowComen["garantia_fins"].'" />
							</div>
						</div>
						<div class="form-group row">
							<label for="averia" class="col-form-label col-sm-3 col-sm-offset-1">Issue</label>
							<div class="col-sm-7">
								<textarea id="averia" name="averia" class="form-control" style="min-width: 100%" placeholder="Issue" >'.$rowComen["averia"].'</textarea>
							</div>
						</div>
						<div class="checkbox row">
							<div class="col-form-label col-sm-3 col-sm-offset-1">Broken product changed</div>
							<div class="col-sm-7">
								<label class="checkbox-inline">
									<INPUT type="checkbox" id="prod_averiat_substituit" name="prod_averiat_substituit" '.$prod_averiat_substituit_status.' onclick="enable_prod_substitut('.$rowComen["id"].')"/>
								</label>
							</div>
						</div>
						<div class="form-group row">
							<label for="prod_nou_marca" class="col-form-label col-sm-3 col-sm-offset-1">New product</label>
							<div class="col-sm-7">
								<INPUT type="text" id="prod_nou_marca'.$rowComen["id"].'" name="prod_nou_marca" class="form-control" maxlength="50" '.$prod_averiat_status.' placeholder="Brand" value="'.$rowComen["prod_nou_marca"].'"/>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-7 col-sm-offset-4">
								<INPUT type="text" id="prod_nou_model'.$rowComen["id"].'" name="prod_nou_model" class="form-control" maxlength="50" '.$prod_averiat_status.' placeholder="Model" value="'.$rowComen["prod_nou_model"].'"  />
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-7 col-sm-offset-4">
								<INPUT type="text" id="prod_nou_sn'.$rowComen["id"].'" name="prod_nou_sn" class="form-control" maxlength="50" '.$prod_averiat_status.' placeholder="S/N" value="'.$rowComen["prod_nou_sn"].'"  />
							</div>
						</div>
						<div class="radio row">
							<div class="col-form-label col-sm-3 col-sm-offset-1">Get back their repaired product</div>
							<div id="reposar_prod_averiat_group" class="col-sm-7">
								<label class="radio-inline">
								<input id="reposar_prod_averiat" name="reposar_prod_averiat" type="radio" value="1" '.$reposar_prod_averiat_yes_status.' /> Yes
								</label>
								<label class="radio-inline">
								<input id="reposar_prod_averiat" name="reposar_prod_averiat" type="radio" value="0" '.$reposar_prod_averiat_no_status.' /> No
								</label>
							</div>
						</div>
					
						<div class="form-group row">
							<label for="enviat_reparar" class="col-form-label col-sm-3 col-sm-offset-1">Sent to SAT</label>
							<div class="col-sm-7">
								<input id="enviat_reparar" name="enviat_reparar" class="form-control" type="date" step="1" min="2016-01-01" value="'.$rowComen["enviat_reparar"].'">
							</div>
						</div>
						<div class="form-group row">
							<label for="tornat_reparar" class="col-form-label col-sm-3 col-sm-offset-1">Recieved from SAT</label>
							<div class="col-sm-7">
								<input id="tornat_reparar" name="tornat_reparar" class="form-control" type="date" step="1" min="2016-01-01" value="'.$rowComen["tornat_reparar"].'">
							</div>
						</div>
					</div>

					<!-- Modal Footer -->
					<div class="modal-footer">
					<input type="submit" class="btn btn-lg btn-primary" value="Edit" id="submit">
					  <button type="button" class="btn  btn-lg  btn-default" data-dismiss="modal">Cancel</button>
					</div>
					</form>

				  </div>
				</div>
			  </div>';
	}
		echo "</table></div>";
	
	mysql_free_result($resultComen);
	mysql_free_result($resultInteractions);
	mysql_close($cnx);
}
else{
	echo '<div class="container"><div id="success_alert" class="text-center alert alert-success" role="alert">There are no open tickets.....</div></div>';
};
?>

</div>

<?php require('include/footer.php');?>
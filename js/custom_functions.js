function reload(lloc,marca,model,urlServed) {
	var url = urlServed;
	//lloc
	if((marca == "null") && (lloc != "null") && (model == "null")){
		url = url + "?l=" + lloc;
	}
	//marca
	else if((marca != "null") && (lloc == "null") && (model == "null")){
		url = url + "?ma=" + marca;
	}
	//model
	else if((marca == "null") && (lloc == "null") && (model != "null")){
		url = url + "?mo=" + model;
	}
	//lloc,marca
	else if((marca != "null") && (lloc != "null") && (model == "null")){
		url = url + "?l=" + lloc + "&ma=" + marca;
	}
	//lloc,model
	else if((marca == "null") && (lloc != "null") && (model != "null")){
		url = url + "?l=" + lloc + "&mo=" + model;
	}
	//marca,model
	else if((marca != "null") && (lloc == "null") && (model != "null")){
		url = url + "?ma=" + marca + "&mo=" + model;
	}
	//lloc,marca,model
	else if((marca != "null") && (lloc != "null") && (model != "null")){
		url = url + "?l=" + lloc + "&ma=" + marca + "&mo=" + model;
	}
	window.location = url;
    
};

function enable_prod_substitut(id){
	if(document.getElementById("prod_nou_marca"+id).disabled){
		document.getElementById("prod_nou_marca"+id).disabled = false;
		document.getElementById("prod_nou_model"+id).disabled = false;
		document.getElementById("prod_nou_sn"+id).disabled = false;
	}
	else{
		document.getElementById("prod_nou_marca"+id).disabled = true;
		document.getElementById("prod_nou_model"+id).disabled = true;
		document.getElementById("prod_nou_sn"+id).disabled = true;
	}
}

function enable_instalat(id){
	if(document.getElementById("data_instalacio"+id).disabled){
		document.getElementById("data_instalacio"+id).disabled = false;
		document.getElementById("lloc"+id).disabled = false;
		document.getElementById("aula"+id).disabled = false;
	}
	else{
		document.getElementById("data_instalacio"+id).disabled = true;
		document.getElementById("lloc"+id).disabled = true;
		document.getElementById("aula"+id).disabled = true;
	}
}
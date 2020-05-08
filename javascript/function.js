function translate_month (month) {
	var trans_month;
	switch(month) {
		case 1 :
			trans_month = "JAN";
		break;
		case 2 :
			trans_month = "FRB";
		break;
		case 3 :
			trans_month = "MAR";
		break;
		case 4 :
			trans_month = "APR";
		break;
		case 5 :
			trans_month = "MAY";
		break;
		case 6 :
			trans_month = "JUN";
		break;
		case 7 :
			trans_month = "JUL";
		break;
		case 8 :
			trans_month = "AUG";
		break;
		case 9 :
			trans_month = "Sep";
		break;
		case 10 :
			trans_month = "OCT";
		break;
		case 11 :
			trans_month = "NOV";
		break;
		default :
			trans_month = "DEC";
	}
	return trans_month;
}

function redirect_post(url, name, data) {
	var form = document.createElement('form');
	document.body.appendChild(form);
	form.method = 'post';
	form.action = url;
    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = data;
    form.appendChild(input);
form.submit();
}
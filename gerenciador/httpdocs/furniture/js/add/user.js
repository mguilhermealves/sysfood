$(document).ready(function () { 
	var users_profiles_id = ($('#users_profiles_id').val());

    if (users_profiles_id == 41 || users_profiles_id == 42 || users_profiles_id == 43) {
        $("#parent").prop('disabled', true);
		$("#units_id").prop('disabled', true);
		$("#profiles_id").prop('disabled', true);
    }
})

$("#users_profiles_id").change(function () { 
	var users_profiles_id = ($(this).val());

	if (users_profiles_id == 41 || users_profiles_id == 42 || users_profiles_id == 43) {
		$("#parent").show();
	} else {
		$("#parent").hide();
	}
});

$('input[name="phone"]').inputmask("(99) 9999-9999");
$('input[name="celphone"]').inputmask("(99) 99999-9999");
$('input[name="address_zip_code"]').inputmask("99999-999");
$('input[name="cpf"]').inputmask("999.999.999-99");

$("#btntk_pwd").bind("click", function () {
	copyToClipboard($("#tk_pwd"));
});

function copyToClipboard(element) {
	var $temp = $("<input>");
	$("body").append($temp);
	$temp.val($(element).val()).select();
	document.execCommand("copy");
	$temp.remove();
	alert("Link Copiado")
}

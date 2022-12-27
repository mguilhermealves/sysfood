$("#btn-sp").click(function () {
    $('#sp-map').removeClass('d-none');
    $('#sc-map').addClass('d-none');
    $('#ch-map').addClass('d-none');
});

$("#btn-sc").click(function () {
    $('#sc-map').removeClass('d-none');
    $('#sp-map').addClass('d-none');
    $('#ch-map').addClass('d-none');
});

$("#btn-ch").click(function () {
    $('#ch-map').removeClass('d-none');
    $('#sc-map').addClass('d-none');
    $('#sp-map').addClass('d-none');
});
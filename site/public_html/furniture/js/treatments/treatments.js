$('#searchTratament').submit(function (e) { 
    e.preventDefault();
    
    var typestreatmentsName = $("#typestreatmentsName").val();
    var typestreatmentsId = $("#typestreatmentsId").val();

    $.ajax({
        type: "POST",
        url: "/tratamentos",
        data: {
            typestreatmentsName: typestreatmentsName,
            typestreatmentsId: typestreatmentsId
        },
        dataType: "dataType",
        success: function (response) {
            
        }
    });
});
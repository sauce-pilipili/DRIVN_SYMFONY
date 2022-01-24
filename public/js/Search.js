function AjaxSearch(text) {

    $.ajax(
        {
            url: "",
            type: "GET",
            data: {
                'text': text,
            },
            success: function (data) {
                console.log(data.nom)
                 $("#bodylist").html(data.content);
            }
        }
    )
}
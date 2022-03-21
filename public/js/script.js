$(function() {
    $('.rate input').on('click', function(e){
        e.preventDefault();
        let ratingNum = $(this).val();
        let form = $('form'),
        url = form.attr('action');
        // url = "../pages/controllers/AjaxHandler.php";
        let action = "rating";
        // insertRating(url, action, ratingNum);
        postAjax(url, action, ratingNum);
    });
    // });
});

function postAjax(url, action, ratingNum)
{
    $.ajax({
        type: "POST",
        url: url,
        data: {ajax: action, rating: ratingNum},
        dataType: "json",
        success: function(resp) {
            if(resp.status == 1){
                $('#avgrat').text(resp.data[0].average_rating);
                $('#totalrat').text(resp.data[0].rating_num);
                alert("Thank you for rating this product!");
            }else if(resp.status == 2){
                alert("You have already rated this product");
            }

            $('.rate input').each(function() {
                if($(this).val() <= parseInt(resp.data[0].average_rating)){
                    $(this).attr('checked', 'checked');
                }else{
                    $(this).prop( 'checked', false );
                }
            });
        },
        error: function(resp){
            console.log(resp);
            console.log("Error: "+resp);
        }
    });
}

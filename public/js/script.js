$(function() {
    $('.rate input').on('click', function(e){
        e.preventDefault();
        let ratingNum = $(this).val();
        let form = $('form');
        url = form.attr('action');
        let action = "rating";
        postAjax(url, action, ratingNum);
    });
    
    $("#country-select").on("change", function(e){
        // on change country
        document.getElementById("state-hidden").style.display = "none";
        document.getElementById("state-select").style.display = "none";
        document.getElementById("city-hidden").style.display = "none";
        document.getElementById("city-select").style.display = "none";
        let countryId = (this).value;
        countryChangeValue(countryId);
    });

    $("#state-select").on("change", function(e){
        // on change state
        let stateId = (this).value;
        stateChangeValue(stateId);
    });
    
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

function countryChangeValue(id){
    document.getElementById("state-hidden").style.display = "block";
    document.getElementById("state-select").style.display = "block";

    $.ajax({
        type: "POST",
        url: "",
        data: { ajax: "register", country_id: id},
        success: function(resp){
            $("#state-select").html(resp);
        }
    })
}

function stateChangeValue(stateId)
{
    document.getElementById("city-hidden").style.display = "block";
    document.getElementById("city-select").style.display = "block";

    $.ajax({
        type: "POST",
        url: "",
        data: { ajax: "register", state_id: stateId},
        success: function(resp){
            $("#city-select").html(resp);
        }
    })
}
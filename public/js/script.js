$(function() {
    // localStorage.clear();

    $('.rate input').on('click', function(e){
        e.preventDefault();
        let ratingNum = $(this).val();
        let form = $('form');
        url = form.attr('action');
        let action = "rating";
        postAjax(url, action, ratingNum);
    });
    
    let selCountry = (sessionStorage["selCountry"] > 0 ? sessionStorage["selCountry"] : 0);
    let selState = (sessionStorage["selState"] > 0 ? sessionStorage["selState"] : 0);
    let selCity = (sessionStorage["selCity"] > 0 ? sessionStorage["selCity"] : 0);

    if(sessionStorage["selCountry"] > 0)
    {
        countryChangeValue(sessionStorage["selCountry"]);
        $("#country-select").val(selCountry);
    }
    
    if(sessionStorage["selState"] > 0)
    {
        stateChangeValue(sessionStorage["selState"]);
        $("#state-select").val(selState);
    }

    if(sessionStorage["selCity"] > 0)
    {
        $("#city-select").val(selCity);
    }

    $("#country-select").on("change", function(e){
        // on change country
        document.getElementById("state-hidden").style.display = "none";
        document.getElementById("state-select").style.display = "none";
        document.getElementById("city-hidden").style.display = "none";
        document.getElementById("city-select").style.display = "none";
        let countryId = $(this).val();
        
        sessionStorage["selCountry"] = countryId;

        countryChangeValue(countryId);
    });


    $("#state-select").on("change", function(e){
        // on change state
        let stateId = $(this).val();
        sessionStorage["selState"] = stateId;
        stateChangeValue(stateId);
    });

    
    $("#city-select").on("change", function(e){
        // on change state
        let cityId = (this).value;
        sessionStorage["selCity"] = cityId;
    });

    function clearSessionStorage()
    {
        sessionStorage.clear();
    }
});

function postAjax(url, action, ratingNum)
{
    $.ajax({
        type: "POST",
        url: url,
        data: {ajax: action, rating: ratingNum},
        dataType: "json",
        success: function(resp) {
            if(resp.status == 1)
            {
                $('#avgrat').text(resp.data.average_rating);
                $('#totalrat').text(resp.data.rating_num);
                alert("Thank you for rating this product!");
            }
            else if(resp.status == 2)
            {
                alert("You have already rated this product!");
            }
            else if(resp.status == 3)
            {
                alert("You need to be logged in to give a rating!");
            }

            $('.rate input').each(function() {
                if($(this).val() <= parseInt(resp.data.average_rating)){
                    $(this).attr('checked', 'checked');
                }else{
                    $(this).prop( 'checked', false );
                }
            });
        },
        error: function(resp){
            console.log("Error: "+resp);
        }
    });
}

function countryChangeValue(id){
    document.getElementById("state-hidden").style.display = "block";
    document.getElementById("state-select").style.display = "block";
    let state = sessionStorage["selState"];
    $.ajax({
        type: "POST",
        url: "",
        data: { ajax: "register", country_id: id, state_id: state},
        success: function(resp){
            $("#state-select").html(resp);
        }
    })
}

function stateChangeValue(stateId)
{
    document.getElementById("city-hidden").style.display = "block";
    document.getElementById("city-select").style.display = "block";
    let city = sessionStorage["selCity"];
    $.ajax({
        type: "POST",
        url: "",
        data: { ajax: "register", state_id: stateId, city_id: city},
        success: function(resp){
            $("#city-select").html(resp);
        }
    })
}


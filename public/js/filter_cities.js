
$(document).ready(function(){
        
    $('#region').on('change', function(){
        $('#city').val('');
        $('#city_id').val('');
    });
});

$(document).on('focus', '.autocomplete', function () {
    var element = $(this);
    var region_id = $('#region').val();

    element.autocomplete({
        source: function( request, response ) {            
            if(request.term.length>3){  
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/admin/get_autocomplete_cities',
                    type: 'POST',
                    data: {'city' : request.term,
                           'region_id' : region_id},

                    success: function(data) {
                        $('#city_id').val('');
                        response( data);
                    }
                });
            }               
        },
        select:function(e,ui)
        {
            e.preventDefault();
            $('#region').val(ui.item.region_id).trigger('change');
            $('#city_id').val(ui.item.id); 
            element.val(ui.item.zip + ' ' + ui.item.name);
        }
    }).data("ui-autocomplete")._renderItem = function (ul, item) {
        return $("<li></li>")
                .data("ui-autocomplete-item", item)
                .append("<li style='padding:5px;'>" + item.zip +' '+ item.name + "</li>")
                .appendTo(ul);   
    };
});
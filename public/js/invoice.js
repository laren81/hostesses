
var j=0;

$(document).ready(function(){    
    for(var i in rows){
        add_row(rows[i]);
    }
    sum();
});
        
function add_row(row){   
    add_empty_row();  
    
    $('#service_'+j).val(row.service);
    $('#quantity_'+j).val(row.quantity!=null ? row.quantity : row.count_hosteses*row.days);
    $('#staff_wages_'+j).val(row.staff_wages.toFixed(2)).attr('data-value',row.staff_wages.toFixed(2));
    $('#booking_charge_'+j).val(row.booking_charge.toFixed(2));
    $('#additional_charge_'+j).val(row.additional_charge.toFixed(2));
    $('#value_'+j).val((row.value!=null ? row.value : row.count_hosteses*row.total).toFixed(2));
}

function add_empty_row(){
    
    j++;                    

    var row = '<tr><td><input type="text" class="form-control service" id="service_' + j + '" name="stocks[' + j + '][service]" value="" />'
        + '<td><input type="text" class="form-control quantity" id="quantity_' + j + '" name="stocks[' + j + '][quantity]" required="required" min="1" value="0"/></td>'
        + '<td><input type="text" class="form-control number staff_wages" id="staff_wages_' + j + '" name="stocks['+ j + '][staff_wages]" required="required" value="0"/></td>'
        + '<td><input type="text" class="form-control number booking_charge" id="booking_charge_' + j + '" name="stocks['+ j + '][booking_charge]" required="required" value="0"/></td>'
        + '<td><input type="text" class="form-control number additional_charge" id="additional_charge_' + j + '" name=stocks['+ j + '][additional_charge]" value="0"/></td>'
        + '<td><input type="text" class="form-control value" id="value_' + j + '" name=stocks['+ j + '][value]" required="required" value="0" readonly/></td>'
        + '<td><button type="button" class="btn btn-danger btn-xs" id="position_' + j + '" title="Изтрий" data-toggle="tooltip"><i class="glyphicon glyphicon-trash"></i></button></td></tr>';

    $('table#positions > tbody').append(row);

    
    $('.service').each(function() {
        $(this).rules("add", {
            required: true,
            messages: {
                required: "Please fill service."
            }
        });
    });
    
    $('.quantity').each(function() {
        $(this).rules("add", {
            required: true,
            number:true,
            digits:true,
            messages: {
                required: "Please fill quantity.",
                number: "Please fill valid quantity.",
                digits: "Please fill valid quantity.",
                min: "Please fill value not less than 1"
            }
        });
    });
    
    $('.staff_wages').each(function() {
        $(this).rules("add", {
            required: true,
            number:true,
            messages: {
                required: "Please fill valid staff wages.",
                number: "Please fill valid staff wages."
            }
        });
    });
    
    $('.booking_charge').each(function() {
        $(this).rules("add", {
            required: true,
            number:true,
            messages: {
                required: "Please fill valid booking charge.",
                number: "Please fill valid booking charge."
            }
        });
    });
    
    $('.additional_charge').each(function() {
        $(this).rules("add", {
            required: true,
            number:true,
            messages: {
                required: "Please fill valid additional charge.",
                number: "Please fill valid additional charge."
            }
        });
    });

    $('button#position_' + j).click(function(){
        $(this).closest('tr').remove();
        sum();
    });

    $('input#quantity_' + j).on('input', function(){
        var current_id = $(this).attr('id').replace('quantity_','');
        if($(this).val()==''){
            $(this).val(0);
        }
        $('input#value_' + current_id).val((parseFloat($('input#quantity_' + current_id).val()) * (parseFloat($('input#staff_wages_' + current_id).val()) + parseFloat($('input#booking_charge_' + current_id).val()) + parseFloat($('input#additional_charge_' + current_id).val()))).toFixed(2));
        sum();
    });
    
    $('input#staff_wages_' + j).on('input', function(){
        var current_id = $(this).attr('id').replace('staff_wages_','');
        if($(this).val()==''){
            $(this).val(0);
        }
        $('input#value_' + current_id).val((parseFloat($('input#quantity_' + current_id).val()) * (parseFloat($('input#staff_wages_' + current_id).val()) + parseFloat($('input#booking_charge_' + current_id).val()) + parseFloat($('input#additional_charge_' + current_id).val()))).toFixed(2));
        sum();
    });
    
    $('input#booking_charge_' + j).on('input', function(){
        var current_id = $(this).attr('id').replace('booking_charge_','');
        if($(this).val()==''){
            $(this).val(0);
        }
        $('input#value_' + current_id).val((parseFloat($('input#quantity_' + current_id).val()) * (parseFloat($('input#staff_wages_' + current_id).val()) + parseFloat($('input#booking_charge_' + current_id).val()) + parseFloat($('input#additional_charge_' + current_id).val()))).toFixed(2));
        sum();
    });
    
    $('input#additional_charge_' + j).on('input', function(){
        var current_id = $(this).attr('id').replace('additional_charge_','');
        if($(this).val()==''){
            $(this).val(0);
        }
        $('input#value_' + current_id).val((parseFloat($('input#quantity_' + current_id).val()) * (parseFloat($('input#staff_wages_' + current_id).val()) + parseFloat($('input#booking_charge_' + current_id).val()) + parseFloat($('input#additional_charge_' + current_id).val()))).toFixed(2));
        sum();
    });
}

function sum() {
    var value = 0.0, vat = 0.0, total = 0.0;

    $('input.form-control.value').each(function(index) {
        value += parseFloat($(this).val());
    });
    
    vat = value * 0.19;
    total = value + vat;

    $('#vat').text(vat.toFixed(2));
    $('#value').text(value.toFixed(2));
    $('#total').text(total.toFixed(2));
}
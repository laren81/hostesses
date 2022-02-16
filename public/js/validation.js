jQuery.validator.setDefaults({
    errorPlacement: function(error, element) {
        if(element.attr('name')=="round[]")
            error.appendTo(element.closest('.form-group').find('.errorBox'));
        else if(element.attr('name')=="bonus_figure[]")
            error.appendTo(element.closest('.choosen_bonus_products').find('.errorBox'));
        else if(element.hasClass("gen_set")){
            error.appendTo(element.closest('td').find('.errorBox'));
        }
        else if(element.hasClass('custom-file-input')){
            error.appendTo(element.closest('.margin--bottom-5').find('.errorBox'));
        }
        else{
            error.appendTo(element.closest('.col-xs-12').find('.errorBox'));
        }
    },
    focusInvalid: false,
    invalidHandler: function(form, validator) {

        if (!validator.numberOfInvalids())
            return;

        var first_tab = $(validator.errorList[0].element).closest('.tab-pane');    
        
        var first_tab_id = $(first_tab).attr('id');
        
        $('.tab-pane').removeClass('active');
        $('.nav-tabs li').removeClass('active');
        
        $('a[href="#'+first_tab_id+'"]').parent('li').addClass('active');
                
        $(first_tab).addClass('active');
        
        $('html, body').animate({
            scrollTop: $(validator.errorList[0].element).offset().top-150
        }, 1000);

    }
});

jQuery.validator.addMethod("allRequired", function(value, elem){
    // Use the name to get all the inputs and verify them
    var name = elem.name;
    return  $('input[name="'+name+'"]').map(function(i,obj){return $(obj).val();}).get().every(function(v){ return v; });
});

jQuery.validator.addMethod("pow_2", function(value, elem){
    // Use the name to get all the inputs and verify them
    var name = elem.name;
    
    return Math.log($('input[name="'+name+'"]').val()) / Math.log(2) % 1=== 0;
});
    
jQuery.validator.addMethod("requiredNotZero", function (value, element) {
    var flag = true;
    $("[name^=quantity]").each(function (i, j) {
        $(this).parent('td').find('label.error').remove();
        if ($.trim($(this).val()) == 0 || $.trim($(this).val()) == '') {
            flag = false;
            $(this).parent('td').append('<label id="id_ct'+i+'-error" class="error">Въведете количество.</label>');
        }
    });
    return flag;
}, "");   

jQuery.validator.addMethod('filesize', function (value, element, param) {
    return this.optional(element) || (element.files[0].size <= param*1000)
}, 'Размерът на снимката трябва да бъде по-малък от {0}');

jQuery.validator.addMethod("greaterThan", function(value, elem){
    // Use the name to get all the inputs and verify them
    var name = elem.name;
    return  $('input[name="'+name+'"]').val()>0;
});

jQuery.validator.addMethod("notBefore", function(value,elem, param){
    var selectedDate = $(elem).datepicker('getDate');
    
    param.setHours(0);
    param.setMinutes(0);
    param.setSeconds(0);
    
    return  Date.parse(selectedDate)>=Date.parse(param);
});

jQuery.validator.addMethod("NotEqualTo", function(value, elem, param){
    return  value!==param;
});

jQuery(document).ready(function(){
        
    $("#user_create").validate({
        rules: {
            first_name:{ 
                required: true
            },
            last_name:{ 
                required: true
            },
            email:{ 
                required: true,
                email:true
            },
            phone:{
                digits:true
            },
            "role_id":{
                required: true
            }
        },
        messages: {
            first_name: {required: "Полето 'Име' е задължително"},
            last_name: {required: "Полето 'Фамилия' е задължително"},
            email: {required: "Полето 'И-мейл' е задължително",
                    email: 'Моля, въведете валиден и-мейл'                    
            },
            'role_id': "Моля, изберете роля",
            phone:{ required: "Моля, въведете телефонен номер.",
                    digits: "Моля, въведете валиден телефонен номер"                
            }
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.closest('.form-group').find('.errorBox'));
            
        }
    });
    
    $("#user_edit").validate({   
        rules: {
            first_name:{ 
                required: true
            },
            last_name:{ 
                required: true
            },
            email:{ 
                required: true,
                email:true
            },
            phone:{
                required:true,
                digits:true
            },
            password:{ 
                minlength: 6
            },
            password_confirmation:{
                equalTo:'#password'
            },
            "role_id":{
                required: true
            }
        },
        messages: {
            first_name: {required: "Полето 'Име' е задължително"},
            last_name: {required: "Полето 'Фамилия' е задължително"},
            email: {required: "Полето 'И-мейл' е задължително",
                    email: 'Моля, въведете валиден и-мейл'                    
            },
            password_confirmation: 
                    {equalTo:'Потвърждението не съвпада с въведената парола'
            },
            'role_id': "Моля, изберете роля",
            phone:{ required: "Моля, въведете телефонен номер.",
                    digits: "Моля, въведете валиден телефонен номер"                
            }
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.closest('.form-group').find('.errorBox'));
            
        }
    });
    
    $("#role_create,#role_update").validate({
        rules: {
            name:{ 
                required: true
            }
        },
        messages: {
            name: {required: "Полето 'Име' е задължително"}
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.closest('.form-group').find('.errorBox'));
            
        }
    });    
    
    $("#create_hostess").validate({      
        ignore: [],
        rules: {
            "preferred_occupation[]": {
                required:true
            },
           sex: {
               required:true
           },
           first_name: {
               required:true
           },
           last_name: {
               required:true
           },
           address: {
               required:true
           },
           city_id: {
               required:true
           },
           zip: {
               required:true
           },
           region_id: {
               required:true
           },
           country: {
               required:true
           },
           nationality: {
               required:true
           },
           email: {
               required:true,
               email:true
           },
           phone: {
               required:true
           },
           birth_date: {
               required:true
           },
           "type": {
               required:true
           },
           height: {
               required:true
           },
           cloth_size: {
               required:true
           },
           chest: {
               required:true
           },
           waist: {
               required:true
           },
           hips: {
               required:true
           },
            hair_color: {
                required:true
            },
            eye_color: {
                required:true
            },
            shoe_size:{
                required: true
            },
            tattoo: {
                required:true
            },
            piercing: {
                required:true
            },
            occupation:{
                required: true
            },
            profession: {
                required:true
            },
            education: {
                required:true
            },
            driver_licence: {
                required:true
            },
            own_car: {
                required:true
            },
            trade_licence: {
                required:true
            },
            health_certificate: {
                required:true
            },
            de: {
                required: true
            },
            en: {
                required: true
            },
            sp: {
                required: true
            },
            fr: {
                required: true
            },
            modeling: {
                required: true
            },
            presentation: {
                required: true
            },
            gastronomy: {
                required: true
            },
            team_leader: {
                required: true
            },
            experience_abroad: {
                required: true
            },
            musical_instrument: {
                required: true
            },
            past_experience: {
                required: true
            },
            public_consent: {
                required:true
            },
            terms_agreed: {
                required:true
            },
            portrait: {
                required:true
            },
            body_image: {
                required:true
            },
            "images[]": {
                required:true
            }
        },
        messages: {
            terms_agreed: 'Please accept our terms',
            portrait: 'Please add portrait',
            body_image: 'Please add body image',
            'images[]': 'Please add some images'
        }
    });
    
    $("#edit_hostess").validate({      
        ignore: [],
        rules: {
            "preferred_occupation[]": {
                required:true
            },
            sex: {
                required:true
            },
            address: {
                required:true
            },
            city_id: {
                required:true
            },
            zip: {
                required:true
            },
            region_id: {
                required:true
            },
            country: {
                required:true
            },
            nationality: {
                required:true
            },           
            birth_date: {
                required:true
            },
            "type": {
                required:true
            },
            height: {
                required:true
            },
            cloth_size: {
                required:true
            },
            chest: {
                required:true
            },
            waist: {
                required:true
            },
            hips: {
                required:true
            },           
            hair_color: {
                required:true
            },
            eye_color: {
                required:true
            },
            shoe_size:{
                required: true
            },
            tattoo: {
                required:true
            },
            piercing: {
                required:true
            },
            occupation:{
                required: true
            },
            profession: {
                required:true
            },
            education: {
                required:true
            },
            driver_licence: {
                required:true
            },
            own_car: {
                required:true
            },
            trade_licence: {
                required:true
            },
            health_certificate: {
                required:true
            },
            de: {
                required: true
            },
            en: {
                required: true
            },
            sp: {
                required: true
            },
            fr: {
                required: true
            },
            modeling: {
                required: true
            },
            presentation: {
                required: true
            },
            gastronomy: {
                required: true
            },
            team_leader: {
                required: true
            },
            experience_abroad: {
                required: true
            },
            musical_instrument: {
                required: true
            },
            past_experience: {
                required: true
            },
            public_consent: {
                required:true
            },
            terms_agreed: {
                required:true
            },
            portrait: {
                required: {
                    depends: function(element) {
                        return ($('.edit_image_div.portrait').length==0);
                    }
                }
            },
            body_image: {
                required: {
                    depends: function(element) {
                        return ($('.edit_image_div.body_image').length==0);
                    }
                }
            },
            "images[]": {
                required: {
                    depends: function(element) {
                        return ($('.edit_image_div.images').length==0);
                    }
                }
            },
            password:{ 
                minlength: 6
            },
            password_confirmation:{
                equalTo:'#password'
            }
        },

         messages: {
             
             terms_agreed: 'Please accept our terms',
             portrait: 'Please add portrait',
             body_image: 'Please add body image',
             'images[]': 'Please add some images',
            password_confirmation:{
                equalTo:'Password confirmation does not match'
            }
        }  
    });
    
    $("#create_hostess_profile").validate({      
        ignore: [],
        rules: {
            "preferred_occupation[]": {
                required:true
            },
            sex: {
                required:true
            },
            address: {
                required:true
            },
            city_id: {
                required:true
            },
            zip: {
                required:true
            },
            region_id: {
                required:true
            },
            country: {
                required:true
            },
            nationality: {
                required:true
            },           
            birth_date: {
                required:true
            },
            "type": {
                required:true
            },
            height: {
                required:true
            },
            cloth_size: {
                required:true
            },
            chest: {
                required:true
            },
            waist: {
                required:true
            },
            hips: {
                required:true
            },           
            hair_color: {
                required:true
            },
            eye_color: {
                required:true
            },
            shoe_size:{
                required: true
            },
            tattoo: {
                required:true
            },
            piercing: {
                required:true
            },
            occupation:{
                required: true
            },
            profession: {
                required:true
            },
            education: {
                required:true
            },
            driver_licence: {
                required:true
            },
            own_car: {
                required:true
            },
            trade_licence: {
                required:true
            },
            health_certificate: {
                required:true
            },
            de: {
                required: true
            },
            en: {
                required: true
            },
            sp: {
                required: true
            },
            fr: {
                required: true
            },
            modeling: {
                required: true
            },
            presentation: {
                required: true
            },
            gastronomy: {
                required: true
            },
            team_leader: {
                required: true
            },
            experience_abroad: {
                required: true
            },
            musical_instrument: {
                required: true
            },
            past_experience: {
                required: true
            },
            public_consent: {
                required:true
            },
            terms_agreed: {
                required:true
            },
            portrait: {
                required: {
                    depends: function(element) {
                        return ($('.edit_image_div.portrait').length==0);
                    }
                }
            },
            body_image: {
                required: {
                    depends: function(element) {
                        return ($('.edit_image_div.body_image').length==0);
                    }
                }
            },
            "images[]": {
                required: {
                    depends: function(element) {
                        return ($('.edit_image_div.images').length==0);
                    }
                }
            },
            password:{ 
                minlength: 6
            },
            password_confirmation:{
                equalTo:'#password'
            }
        },

         messages: {
             
             terms_agreed: 'Please accept our terms',
             portrait: 'Please add portrait',
             body_image: 'Please add body image',
             'images[]': 'Please add some images',
            password_confirmation:{
                equalTo:'Password confirmation does not match'
            }
        }  
    });
    
    $('#create_client').validate({      
        ignore: [],
        rules: {
            title: {
                required:true
            },
            first_name: {
                required:true
            },
            last_name: {
                required: true
            },
            company_name: {
                required:true
            },
            street: {
                required:true
            },
            house_number: {
                required:true
            },
            zip: {
                required:true
            },
            city_id: {
                required:true
            },
            region_id: {
                required:true
            },
            email: {
                required:true,
                email:true
            },
            phone: {
                required:true,
                digits: true
            },
            name: {
                required: true
            },
            event_region_id: {
                required:true
            },
            event_city_id: {
                required:true
            },
            date_from: {
                required: true
            },
            date_to: {
                required: true
            },
            location: {
                required: true
            },
            staff_type: {
                required: true
            },
            staff_number: {
                required: true
            },
            staff_gender: {
                required: true
            },
            time_from: {
                required: true
            },
            time_till: {
                required: true
            },
            job_description: {
                required: true
            },      
            terms_agreed: {
                required:true
            }
        },
         messages: {
            terms_agreed: 'Please accept our terms' 
        }  
    });
    
    $('#edit_client,#create_client_profile').validate({      
        ignore: [],
        rules: {   
            title: {
                required:true
            },
            company_name: {
                required:true
            },
            street: {
                required:true
            },
            house_number: {
                required:true
            },
            zip: {
                required:true
            },
            region_id: {
                required:true
            },
            city_id: {
                required:true
            },
            password:{ 
                minlength: 6
            },
            password_confirmation:{
                equalTo:'#password'
            },
            terms_agreed: {
                required: true
            }
        },
        messages: {            
            terms_agreed: 'Please accept our terms' 
        }  
    });
    
    $('#event_create,#event_edit').validate({      
        ignore: [],
        rules: {
            name: {
                required: true
            },
            region_id: {
                required: function() {
                    return $('#radio1').is(':checked')==true;
                }
            },
            city_id: {
                required: function() {
                    return $('#radio1').is(':checked')==true;
                }  
            },
            external_city: {
                required: function() {
                    return $('#radio2').is(':checked')==true;
                }
            },
            date_from: {
                required: true
            },
            date_to: {
                required: true
            },
            location: {
                required: true
            }            
        },
         messages: {      
            city_id: 'Please select item from the list'
        }
    });
    
    $('#admin_event_create,#admin_event_edit').validate({      
        ignore: [],
        rules: {
            client_id: {
                required:true
            },
            region_id: {
                required:true
            },
            city_id: {
              required:true  
            },
            name: {
                required: true
            },
            date_from: {
                required: true
            },
            date_to: {
                required: true
            },
            location: {
                required: true
            },
            staff_type: {
                required: true
            },
            staff_number: {
                required: true
            },
            staff_gender: {
                required: true
            },
            time_from: {
                required: true
            },
            time_till: {
                required: true
            },
            job_description: {
                required: true
            },
            language_1_lvl: {
                required: {
                    function() {
                        return $('#language_1').val()!=='';
                    }
                }
            },
            language_2_lvl: {
                required: {
                    function() {
                        return $('#language_1').val()!=='';
                    }
                }
            },
            language_3_lvl: {
                required: {
                    function() {
                        return $('#language_1').val()!=='';
                    }
                }
            }
        },

         messages: {      
            client_id: 'Client field is required', 
            region_id: 'Region field is required',
            name: 'Event name field is required',
            date_from: 'Date from field is required',
            date_to: 'Date to field is required',
            location: 'Event location field is required',
            staff_type: 'Staff type field is required',
            staff_number: 'Staff number field is required',
            staff_gender: 'Gender field is required',
            time_from: 'Time from field is required',
            time_till: 'Time till field is required',
            job_description: 'Job description field is required',
            city_id: 'Please select item from the list'
        },
        errorPlacement: function(error, element) {
            if(element.closest('div').hasClass('input-group')){
                error.appendTo(element.closest('.input-group').find('.errorBox'));
            }
            else{
                error.appendTo(element.closest('.form-group').find('.errorBox'));
            }
            
        }  
    });
    
    $('#event_offer_create').validate({
        ignore: [],
        errorPlacement: function(error, element) {
            error.appendTo(element.closest('td').find('.errorBox'));            
        } 
    });
    
    $('#invoice_create,#invoice_edit').validate({
        ignore: [],
        errorPlacement: function(error, element) {
             error.appendTo(element.closest('.col-sm-8').find('.errorBox'));            
        },
        client_id : {
            requried:true
        },
        event_id : {
            requried:true
        },
        date:{
            required:true,
        },
        payment_date:{
            required:true
        }
    });
});
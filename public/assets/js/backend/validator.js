// for validate all form
function check_validation_Form(class_you_want_to_check){
    var validate = true;

    let area_need_to_check = class_you_want_to_check;
    $(''+area_need_to_check+' input[required]').each(function(){
        // alert('test');
        let field_value = $(this).val();
        if ($(this).prop('required') && ((field_value === '') || (!field_value))) {
            $(this).css("border-color", "red");
            if ($(this).next('.error-tag').length == 0) {
                $(this).after('<small class="error-tag">This field is required</small>');
            }
            validate = false;
        }else{
            $(this).css("border-color", "#d4d4d4");
            $(this).next('.error-tag').remove();
        }
    });

    $(''+area_need_to_check+' select[required]').each(function(){
        let field_value = $(this).val();
        if ($(this).prop('required') && ((field_value === '') || (!field_value))) {
            $(this).css("border-color", "red");
            if ($(this).next('.error-tag').length == 0) {
                $(this).after('<small class="error-tag">This field is required</small>');
            }
            validate = false;
        }else{
            $(this).css("border-color", "#d4d4d4");
            $(this).next('.error-tag').remove();
        }
    });

    $(''+area_need_to_check+' textarea[required]').each(function(){
        let field_value = $(this).val();
        if ($(this).prop('required') && ((field_value === '') || (!field_value))) {
            $(this).css("border-color", "red");
            if ($(this).next('.error-tag').length == 0) {
                $(this).after('<small class="error-tag">This field is required</small>');
            }
            validate = false;
        }else{
            $(this).css("border-color", "#d4d4d4");
            $(this).next('.error-tag').remove();
        }
    });

    return validate;
}

$(document).on('click', '.create_form_btn', function(e) {
    e.preventDefault();
    let modal = $(this).attr('data-bs-target');
    let multistep = $(''+modal+'').find('.step');
    let form = $(''+modal+'').find('form');
    if (multistep.length > 0) {
        $(''+modal+' .step').removeClass('active show');
        $(''+modal+' .step_btn').removeClass('d-block');
        $(''+modal+' .step_btn').addClass('d-none');

        $(''+modal+' .step_1').addClass('active show');
        $(''+modal+' .step_btn_1').removeClass('d-none');
        $(''+modal+' .step_btn_1').addClass('d-block');
    }

    $(''+modal+' .server_side_error').empty();

    form[0].reset();
    $(''+modal+' input[required]').each(function(){
        $(this).css("border-color", "#d4d4d4");
        $(this).next('.error-tag').remove();
    });

    $(''+modal+' select[required]').each(function(){
        $(this).css("border-color", "#d4d4d4");
        $(this).next('.error-tag').remove();
    });
    $(''+modal+'').modal('show');
});

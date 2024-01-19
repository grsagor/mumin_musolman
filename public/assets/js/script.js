$(document).ready(function() {
    $(document).on('input', '.input__with__icon', function() {
        var label = $(this).siblings('label');
        if ($(this).val()) {
            label.addClass('d-none').removeClass('d-flex');
        } else {
            label.addClass('d-flex').removeClass('d-none')
        }
    })
})

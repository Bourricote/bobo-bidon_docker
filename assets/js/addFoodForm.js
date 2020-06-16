let $category = $('#add_foods_category');
// When category gets selected ...
$category.change(function() {
    // ... retrieve the corresponding form.
    let $form = $(this).closest('form');
    // Simulate form data, but only include the selected category value.
    let data = {};
    data[$category.attr('name')] = $category.val();
    // Submit data via AJAX to the form's action path.
    $.ajax({
        url : $form.attr('action'),
        type: $form.attr('method'),
        data : data,
        success: function(html) {
            // Replace current food field ...
            $('#add_foods_food').replaceWith(
                // ... with the returned one from the AJAX response.
                $(html).find('#add_foods_food')
            );
            // Food field now displays the appropriate foods.
        }
    });
});
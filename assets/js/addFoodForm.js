// Dynamic food select //

let $category = $('#add_foods_category');
let $loader = $('#loader');
console.log($loader);
// When category gets selected ...
$category.change(function() {
    $('#loader').show();
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
            $('#loader').hide();
            // Food field now displays the appropriate foods.
        }
    });
});


// Add new food to list //
jQuery(document).ready(function () {
    let $collectionHolder = $('div.foods');

    // setup an "add a food" link
    let $addFoodButton = $('#add_food_link');
    let $newLinkLi = $collectionHolder.append($addFoodButton);
    // add the "add a food" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find('input').length);

    $addFoodButton.on('click', function (e) {
        let $selectedFood = $('#add_foods_food').children("option:selected");
        let inputsIds = addFoodItem($collectionHolder, $newLinkLi);
        let $newInputName = $('#' + inputsIds[0]);
        let $newInputId = $('#' + inputsIds[1]);
        $newInputName.val($selectedFood.text());
        $newInputId.val($selectedFood.val());
    });

});

function addFoodItem($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    let prototype = $collectionHolder.data('prototype');

    // get the new index
    let index = $collectionHolder.data('index');

    let newForm = prototype;
    // You need this only if you didn't set 'label' => false in your foods field in AddFoodsType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);
    let newInputName = 'add_foods_foods_' + index + '_name';
    let newInputId = 'add_foods_foods_' + index + '_id';

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    let $newFormLi = $collectionHolder.append(newForm);
    $newLinkLi.after($newFormLi);

    return [newInputName, newInputId];
}
//console.log('hello');


var $collectionHolder;

var $addNewItem = $('<a href="#" class="btn btn-info">Add Client info</a>');

$(document).ready(function () {
   
    $collectionHolder = $('#info_list');
   
    $collectionHolder.append($addNewItem);
 
    $collectionHolder.data('index', $collectionHolder.find('.panel').length)

    $collectionHolder.find('.panel').each(function () {

        addRemoveButton($(this));
    });
  
    $addNewItem.click(function (e) {

        e.preventDefault();

        addNewForm();
    })
});
/*
 * creates a new form and appends it to the collectionHolder
 */
function addNewForm() {
    
    var prototype = $collectionHolder.data('prototype');

    var index = $collectionHolder.data('index');
   
    var newForm = prototype;

    newForm = newForm.replace(/__name__/g, index);
 
    $collectionHolder.data('index', index+1);

    var $panel = $('<div class="panel panel-warning"><div class="panel-heading"></div></div>');
 
    var $panelBody = $('<div class="panel-body"></div>').append(newForm);

    $panel.append($panelBody);

    addRemoveButton($panel);
   
    $addNewItem.before($panel);
}

/**
 * adds a remove button to the panel that is passed in the parameter
 * @param $panel
 */
function addRemoveButton ($panel) {
   
    var $removeButton = $('<a href="#" class="btn btn-danger">Remove</a>');
    
    var $panelFooter = $('<div class="panel-footer"></div>').append($removeButton);
   
    $removeButton.click(function (e) {
        e.preventDefault();
        $(e.target).parents('.panel').slideUp(1000, function () {
            $(this).remove();
        })
    });
    $panel.append($panelFooter);
}
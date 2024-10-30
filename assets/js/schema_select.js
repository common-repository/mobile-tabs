jQuery(document).ready(function() {
  jQuery(".select2").select2();
  /*
  jQuery(".type_of_tabs").select2();
  jQuery(".tab_option").select2();
  */
  $(".tipclass").tipTip();
  $( "#myTable" ).sortable({
        update: function (event, ui) {

            console.log(jQuery( "#myTable" ).sortable('serialize'));
            $('#sortable_field').val(jQuery( "#myTable" ).sortable('toArray').toString() );
        }
    })
});
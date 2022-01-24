jQuery('body').on("click", ".dropdown-menu", function (e) {
    jQuery(this).parent().is(".open") && e.stopPropagation();
});

jQuery('.selectall').click(function() {
    if (jQuery(this).is(':checked')) {
        jQuery('.option').prop('checked', true);
        var total = jQuery('input[name="options[]"]:checked').length;
        jQuery(".dropdown-text").html('(' + total + ') Selected');
        jQuery(".select-text").html(' Deselect');
    } else {
        jQuery('.option').prop('checked', false);
        jQuery(".dropdown-text").html('(0) Selected');
        jQuery(".select-text").html(' Select');
    }
});

jQuery("input[type='checkbox'].justone").change(function(){
    var a = jQuery("input[type='checkbox'].justone");
    if(a.length == a.filter(":checked").length){
        jQuery('.selectall').prop('checked', true);
        jQuery(".select-text").html(' Deselect');
    }
    else {
        jQuery('.selectall').prop('checked', false);
        jQuery(".select-text").html(' Select');
    }
  var total = jQuery('input[name="options[]"]:checked').length;
  jQuery(".dropdown-text").html('(' + total + ') Selected');
});
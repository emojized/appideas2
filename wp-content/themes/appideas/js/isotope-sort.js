// external js: isotope.pkgd.js


// init Isotope
var $grid = jQuery('.grid').isotope({
  itemSelector: '.element-item',
  layoutMode: 'masonry',
  getSortData: {
    name: '.name',
    postid: '.postid parseInt',
    rating: '.rating parseInt'
  }, 
  sortAscending: {
    name: true,
    postid: false,
    rating: false,
  }
});

// bind sort button click
jQuery('.sort-by-button-group').on( 'click', 'button', function() {
  var sortValue = jQuery(this).attr('data-sort-value');
  $grid.isotope({ sortBy: sortValue });
});

// change is-checked class on buttons
jQuery('.button-group').each( function( i, buttonGroup ) {
  var $buttonGroup = jQuery( buttonGroup );
  $buttonGroup.on( 'click', 'button', function() {
    $buttonGroup.find('.is-checked').removeClass('is-checked');
    jQuery( this ).addClass('is-checked');
  });
});


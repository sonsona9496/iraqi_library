/*--------------------------------------------------------------
Theme JS
--------------------------------------------------------------*/
jQuery(function($){
  $('.owl-categories').owlCarousel({
      margin:10,
      nav:true,
      responsiveClass:true,
      rtl: true,
      dots : false,
      responsive:{
          0:{
              items:1,
              nav:false,
          },
          600:{
              items:3,
              nav:false
          },
          1000:{
              items:10,
              nav:true,
              // loop:true
          }
      }
  });
  $('.owl-featured-stories').owlCarousel({
    margin:10,
    nav:true,
    responsiveClass:true,
    rtl: true,
    dots : false,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        767:{
            items:3,
            nav:true
        },
        992:{
            items:4,
            nav:true,
            // loop:true
        },
        1100:{
            items:5,
            nav:true,
            // loop:true
        }
    }
  })
  $('.owl-best-stories').owlCarousel({
    margin:10,
    nav:true,
    responsiveClass:true,
    rtl: true,
    dots : false,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        767:{
            items:3,
            nav:true
        },
        992:{
            items:4,
            nav:true,
            // loop:true
        },
        1100:{
            items:5,
            nav:true,
            // loop:true
        }
    }
  })
})

// =========================
jQuery(function ($) {
  // Close offcanvas on click a, keep .dropdown-menu open (see https://github.com/bootscore/bootscore/discussions/347)
  $('.offcanvas a:not(.dropdown-toggle, .remove_from_cart_button)').on('click', function () {
    $('.offcanvas').offcanvas('hide');
  });

  // Search collapse button hide if empty
  // Deprecated v5.2.3.4, done by php if (is_active_sidebar('top-nav-search')) in header.php
  // Remove in v6
  if ($('#collapse-search').children().length == 0) {
    $('.top-nav-search-md, .top-nav-search-lg').remove();
  }

  // Searchform focus
  $('#collapse-search').on('shown.bs.collapse', function () {
    $('.top-nav-search input:first-of-type').trigger('focus');
  });

  // Close collapse if click outside searchform
  $(document).on('click', function (event) {
    if ($(event.target).closest('#collapse-search').length === 0) {
      $('#collapse-search').collapse('hide');
    }
  });

  // Scroll to top Button
  $(window).on('scroll', function () {
    var scroll = $(window).scrollTop();

    if (scroll >= 500) {
      $('.top-button').addClass('visible');
    } else {
      $('.top-button').removeClass('visible');
    }
  });

  // div height, add class to your content
  $('.height-50').css('height', 0.5 * $(window).height());
  $('.height-75').css('height', 0.75 * $(window).height());
  $('.height-85').css('height', 0.85 * $(window).height());
  $('.height-100').css('height', 1.0 * $(window).height());

  // IE Warning
  if (window.document.documentMode) {
    let IEWarningDiv = document.createElement('div');
    IEWarningDiv.setAttribute('class', 'position-fixed top-0 end-0 bottom-0 start-0 d-flex justify-content-center align-items-center');
    IEWarningDiv.setAttribute('style', 'background:white;z-index:1999');
    IEWarningDiv.innerHTML = '<div style="max-width: 90vw;">' + '<h1>' + bootscore.ie_title + '</h1>' + '<p className="lead">' + bootscore.ie_limited_functionality + '</p>' + '<p className="lead">' + bootscore.ie_modern_browsers_1 + bootscore.ie_modern_browsers_2 + bootscore.ie_modern_browsers_3 + bootscore.ie_modern_browsers_4 + bootscore.ie_modern_browsers_5 + '</p>' + '</div>';
    document.body.appendChild(IEWarningDiv);
  }
  // IE Warning End
}); // jQuery End
// Favorite
jQuery(function($) {
  //adding to favorite
  $('body').on('click', '.add-favorite', function() {
      var post_id = $(this).data('post_id');
      $.ajax({
          url: "/wp-admin/admin-ajax.php",
          type: 'POST',
          data: {
              'action': 'favorite',
              'post_id': post_id,
          },
          success: function(data) {
              $('.fv_' + post_id).html('<i class="fas fa-heart add-to-favo"></i>');
              $('.num-favorite').html(data);
          },
      });
  });
  //deleting from favorite
  $('body').on('click', '.delete-favorite', function() {
      var post_id = $(this).data('post_id');
      $.ajax({
          url: "/wp-admin/admin-ajax.php",
          type: 'POST',
          data: {
              'action': 'delfavorite',
              'post_id': post_id,
          },
          success: function(data) {
              $('.fv_' + post_id).html('<p class="delete-item">Deleted</p>');
              $('.num-favorite').html(data);
          },
      });
  });
});
// Toggle Search Form
// jQuery(function($){
//   $('.open-search-form').on('click',()=>{
//     $('.search-form-mobile').add('active-search-form');
//   })
// })
// Filter Categories In Categories Page
const filterContainer = document.querySelector(".all-categories");
const galleryItems = document.querySelectorAll(".item-gallery");
filterContainer.addEventListener("click", (event) =>{
    if(event.target.classList.contains("cate-link")){
 
      // deactivate existing active 'filter-item'
     filterContainer.querySelector(".activeFilter").classList.remove("activeFilter");
 
      // activate new 'filter-item'
     event.target.classList.add("activeFilter");
 
     const filterValue = event.target.getAttribute("data-filter");
 
     galleryItems.forEach((item) =>{
 
        if(item.classList.contains(filterValue) || filterValue === 'all'){
          item.classList.remove("hide");
          item.classList.add("show");
        }
 
        else{
         item.classList.remove("show");
         item.classList.add("hide");
        }
 
      });
    }
  });
// Menu Mobile
const btnOpenMenuMobile = document.querySelector('.open-menu-mobile');
const menuMobile = document.querySelector('.menu-mobile-items');
const btnCloseMenuMobile = document.querySelector('.btn-close-menu');
const btnSearchForm = document.querySelector('.open-search-form');
const SearchForm = document.querySelector('.search-form-mobile');
// Open Menu
btnOpenMenuMobile.onclick = ()=>{
  menuMobile.classList.add('active-menu-mobile');
}
// Close Menu
btnCloseMenuMobile.onclick = ()=>{
  menuMobile.classList.remove('active-menu-mobile');
}
btnSearchForm.onclick = ()=>{
  SearchForm.classList.toggle('active-search-form');
}
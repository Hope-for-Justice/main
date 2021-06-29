jQuery(document).ready(function($) {

  //shows 6 posts 
  var x = 6;
  var y = 6;
  $('.category_4:lt('+x+')').show();
  $('.category_5:lt('+x+')').show();
  $('.category_7:lt('+x+')').show();
  $('.category_6:lt('+x+')').show();

  //shows 3 more or goes to archive
  $(document).on('click','.more_posts', function () {
    let term_id = $(this).data('term');
    let term_href = $(this).data('href');
    let total_col_news = $('.category_'+term_id).length;
    
    let visible_col_news = $('.category_'+term_id+':visible').length;
    if(total_col_news > 6) {
      if(visible_col_news > 6) {
        window.location.href = term_href; 
      }
    } else if (total_col_news < 6) {
      window.location.href = term_href; 
    }
    x = (x+3 <= total_col_news) ? x+3 : total_col_news;
      $('.category_'+term_id+':lt('+x+')').show();

    $(".cards__title").each(function(){ 
      checkTitles(this); 
    });
  });

  //shows 6 posts 
  $('.scategory_4 .card:lt('+y+')').css('display','flex');
  $('.scategory_5 .card:lt('+y+')').css('display','flex');
  $('.scategory_7 .card:lt('+y+')').css('display','flex');
  $('.scategory_6 .card:lt('+y+')').css('display','flex');
  
  //shows 3 more or goes to archive
  $(document).on('click','.more_postss', function () {
   
    let term_id = $(this).data('term');
    let term_href = $(this).data('href');
    let total_col_news = $('.scategory_'+term_id+' .card').length;
    
    let visible_col_news = $('.scategory_'+term_id+' .card:visible').length;
   
    if(total_col_news > 6) {
      if(visible_col_news > 6) {
        window.location.href = term_href; 
      }
    } else if (total_col_news < 6) {
      window.location.href = term_href; 
    }
    y = (y+3 <= total_col_news) ? y+3 : total_col_news;
    $('.scategory_'+term_id+' .card:lt('+y+')').css('display','flex');
    
  });


  //archive page function
  $(document).on('keypress','',function(e){
      if(e.which == 13){
        if($('.scategory_id').val() != '') {
            $('.search-posts').click();
        }
      }
  });
  $(document).on('change','.custom-category',function() {
    $('.scategory_id').val($(this).data('value'));
  });
  if($('.custom-category').find(":selected").data('value') != '') {
    $('.scategory_id').val($('.custom-category').find(":selected").data('value'));
  }

  //add a dash on a third line if title only spans 2 lines
  $(".threeLines").each(function(){ 
      checkTitles(this); 
  });

  //bit of a hack
  function checkTitles(obj){
    let title = $(obj);
    title.html(title.html() + '<span class="word-height"></span>');

    let wordHeight = title.children(".word-height").outerHeight();
    let titleHeight = title.outerHeight();

    if (titleHeight < wordHeight * 3) {
      title.html(title.html() + '<span class="break"><br>-</span>');
    }
  }


 
});


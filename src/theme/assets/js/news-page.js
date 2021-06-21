jQuery(document).ready(function($) {
  

    var x = 6;
    var y = 6;
    $('.category_4:lt('+x+')').show();
    $('.category_5:lt('+x+')').show();
    $('.category_7:lt('+x+')').show();
    $('.category_6:lt('+x+')').show();
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
    });
    $('.scategory_4 .card:lt('+y+')').css('display','flex');
    $('.scategory_5 .card:lt('+y+')').css('display','flex');
    $('.scategory_7 .card:lt('+y+')').css('display','flex');
    $('.scategory_6 .card:lt('+y+')').css('display','flex');
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
 
    $(document).on('click','.play-button-news, .play-button-newss',function() {
        let id = $(this).data('id');;
        modal('','loading','','modal-lg',false,function(modal_Id){
            $.post(ajax_object.ajax_url, {action: 'ajax_news_video', id: id}).done(response => {
                $('#'+modal_Id).find('.modal-body').html(response);

            });
            
        },'modal_video_class');
    });

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
   
    $('.scategory_id').val($('.custom-category').find(":selected").data('value'));
  

   
});

function modal(header, body, footer, size, center, callback,classes) {
    header = header !== undefined ? header : 'Modal header';
    body = body !== undefined ? body : 'Modal body';
    footer = footer !== undefined ? footer : 'Modal footer';
    center = center !== undefined ? 'modal-dialog-centered' : '';
    size = size !== undefined ? size : '';
    classes = classes !== undefined ? classes : '';
    let closeBtn = `<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>`;
    let $modalId = new Date().getSeconds();
    let $modal = `<div class="modal fade ${classes}" tabindex="-1" role="dialog" id="modal-${$modalId}">
      <div class="modal-dialog ${center} ${size}" role="document">
        <div class="modal-content border-orange">
          <div class="custom_modal modal-header">
            ${header}${closeBtn}
          </div>
          <div class="custom_modal modal-body">
            ${body}
          </div>
         
        </div>
      </div>
    </div>`;

    jQuery(document.body).append($modal);
    jQuery('#modal-'+$modalId).modal('show');

    jQuery(document).on('hidden.bs.modal', '#modal-'+$modalId, function(e) {
      jQuery('#modal-'+$modalId).remove();
    });
    if (callback !== undefined && typeof callback == 'function') {
      return callback('modal-'+$modalId);
    }
}



jQuery(document).ready(function($) {
	

    x = 6;
    $('#term_slug_4 .category_4:lt('+x+')').show();
    $('#term_slug_5 .category_5:lt('+x+')').show();
    $('#term_slug_7 .category_7:lt('+x+')').show();
    $(document).on('click','.more_posts', function () {
    	let term_id = $(this).data('term');
    	let size_li = $("#term_slug_"+term_id+" .category_"+term_id).size();
        x= (x+3 <= size_li) ? x+3 : size_li;
        $('#term_slug_'+term_id+' .category_'+term_id+':lt('+x+')').show();
        $(this).hide();

        if(term_id == 4 ) {
        	$('.more_posts_top').show();
        }
        if(term_id == 5) {
        	$('.more_posts_video').show();
        }
        if(term_id == 7) {
        	$('.more_posts_blogs').show();
        }
        
       

    });
    // $(document).on('click','.play-button-news',function() {
    //     let id = $(this).data('id');;
    //    console.log(id);
    //     modal('','loading','','modal-lg',false,function(modal_Id){
    //         $.post(ajax_object.ajax_url, {action: 'ajax_news_video', id: id}).done(response => {
    //             $('#'+modal_Id).find('.modal-body').html(response);

    //         });
            
    //     },'modal_video_class');


    // });
   
});

// function modal(header, body, footer, size, center, callback,classes) {
//     header = header !== undefined ? header : 'Modal header';
//     body = body !== undefined ? body : 'Modal body';
//     footer = footer !== undefined ? footer : 'Modal footer';
//     center = center !== undefined ? 'modal-dialog-centered' : '';
//     size = size !== undefined ? size : '';
//     classes = classes !== undefined ? classes : '';


//     let closeBtn = `<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>`;

//     let $modalId = new Date().getSeconds();
//     let $modal = `<div class="modal fade ${classes}" tabindex="-1" role="dialog" id="modal-${$modalId}">
//       <div class="modal-dialog ${center} ${size}" role="document">
//         <div class="modal-content border-orange">
//           <div class="custom_modal modal-header">
//             ${header}${closeBtn}
//           </div>
//           <div class="custom_modal modal-body">
//             ${body}
//           </div>
         
//         </div>
//       </div>
//     </div>`;

//     jQuery(document.body).append($modal);
//     jQuery('#modal-'+$modalId).modal('show');

//     jQuery(document).on('hidden.bs.modal', '#modal-'+$modalId, function(e) {
//       jQuery('#modal-'+$modalId).remove();
//     });
//     if (callback !== undefined && typeof callback == 'function') {
//       return callback('modal-'+$modalId);
//     }
// }



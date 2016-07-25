<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
    	<div class="container-fluid">
      		<div class="pull-right">

        		<button type="submit" form="form-video" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>

        		<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
        	</div>

        <h1><?php echo $heading_title; ?></h1>

        <ul class="breadcrumb"> 	
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>

        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
        </ul>    		
    	</div>
	</div>

        <div class="container-fluid">	
        	<?php if ($error_warning) { ?>
       		    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
		    	      <button type="button" class="close" data-dismiss="alert">&times;</button>
		    <?php } ?>	      
      		    </div>

      		<div class="panel panel-default">    
     			<div class="panel-heading">
     				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
     			</div>
     			 <div class="panel-body">
     			 	
     			 	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product" class="form-horizontal">


     			 	<div class="table-responsive">

     			 	<table id="productvideos" class="table table-striped table-bordered table-hover">

 		            <thead>

 		            <tr>

 		            <td class="text-left"><?php echo $entry_image; ?></td>

	                <td class="text-left"><?php echo $entry_videourl; ?></td>

	                <td class="text-left"><?php echo $entry_videodescription; ?></td>

	                <td class="text-right"><?php echo $entry_sort_order; ?></td>

	                <td></td>

 		            </tr>

 		            </thead>

     			 	<tbody>

<?php $productvideo_row = 0; ?>
<?php foreach ($product_videos as $product_video) { ?>

<tr id="video-row<?php echo $productvideo_row; ?>" class="video-rows">

<td class="text-left"><a href="" id="thumb-video<?php echo $productvideo_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $product_video['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a></td>

<td class="text-left">
<input type="text" name="product_video[<?php echo $productvideo_row; ?>][url]" placeholder="<?php echo $entry_videourl; ?>" class="form-control productvideourl" value="<?php echo $product_video['url']; ?>" /> <br />
<input type="hidden" name="product_video[<?php echo $productvideo_row; ?>][product_video_id]" value="<?php echo isset($product_video['product_video_id']) ? $product_video['product_video_id'] : '' ; ?>"></td>



<td class="text-left">

<?php foreach ($languages as $language) { ?>

<div class="input-group">
<span class="input-group-addon">
<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
<input type="text" name="product_video[<?php echo $productvideo_row; ?>][description][<?php echo $language['language_id']; ?>][title]" placeholder="<?php echo $entry_videotitle; ?>" class="form-control productvideotitle" value="<?php echo isset($product_video['description'][$language['language_id']]) ? $product_video['description'][$language['language_id']]['title'] : '' ; ?>" /><br>
<textarea name="product_video[<?php echo $productvideo_row; ?>][description][<?php echo $language['language_id']; ?>][description]" rows="5" placeholder="<?php echo $entry_videodescription; ?>" class="form-control productvideotext"><?php echo isset($product_video['description'][$language['language_id']]) ? $product_video['description'][$language['language_id']]['description'] : '' ; ?></textarea>
<input type="hidden" name="product_video[<?php echo $productvideo_row; ?>][description][<?php echo $language['language_id']; ?>][product_video_description_id]" value="<?php echo isset($product_video['description'][$language['language_id']]['product_video_description_id']) ? $product_video['description'][$language['language_id']]['product_video_description_id'] : '' ; ?>"></div>

	<?php } ?>

</td>



<td class="text-right"><input type="text" name="product_video[<?php echo $productvideo_row; ?>][sort_order]" value="<?php echo $product_video['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>

<td class="text-left"><button type="button" onclick="$('#video-row<?php echo $productvideo_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>

</tr>

<?php $productvideo_row++; ?>

<?php } ?>

</tbody>

<tfoot>

<tr>

<td colspan="4"></td>

<td class="text-left"><button type="button" onclick="addVideo();" data-toggle="tooltip" title="<?php echo $button_video_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>

</tr>

</tfoot>

</table>

</div>




     			 	</form>
     			 </div>
      		</div>
        </div>
   <script type="text/javascript"><!--
   	<?php foreach ($languages as $language) { ?>
   		$('#input-description<?php echo $language['language_id']; ?>').summernote({height: 300});

   	<?php } ?>
   	</script>	

<script type="text/javascript"><!--

$(document).ready(function(){

	$('#productvideos').delegate('.productvideoinfo', 'click', function() {

		var _this = $(this);

		var ids = _this.parent().parent('tr').attr('id');

		id = ids.replace('video-row',''); 

		var productvideourl = $('#'+ ids + ' .productvideourl').val();

			$.ajax({

				url : 'index.php?route=catalog/product/getVideoInformation&token=<?php echo $token?>&video=1',

				type: 'post',

				data : 'url='+encodeURIComponent(productvideourl),

				dataType: 'json',

				beforeSend : function(){

					_this.button('loading');

				},complete : function (){

					_this.button('reset');

				},success: function(json){

					$('.response').remove();

					if(typeof json['error']!='undefined'){

						_this.after('<div class="alert alert-danger response">'+json['error']+'</div>');

					}

					if(typeof json['success']!='undefined'){

						var title = $('#'+ ids + ' .productvideotitle').val();

						var description = $('#'+ ids + ' .productvideotext').val();

						if(title=='' || title!=json['data']['title']) {

							$('#'+ ids + ' .productvideotitle').val(json['data']['title']);

						}

						if(description==''|| description!=json['data']['description']) {

							$('#'+ ids + ' .productvideotext').val(json['data']['description']);

						}

						if(json['data']['image']['thumb']!=''){

							$('#'+ ids + ' .img-thumbnail img').attr({'src': json['data']['image']['thumb']});

						}

					}

				},error: function(xhr, ajaxOptions, thrownError) {

					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);

				}

			});		//alert(productvideourl);	

	});

});

var productvideo_row = <?php echo $productvideo_row; ?>;

function addVideo() {

	html = '<tr id="video-row'+ productvideo_row +'" class="video-rows">';

	html += '	<td class="text-left"><a href="" id="thumb-video'+ productvideo_row +'" data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="product_image['+ productvideo_row +'][image]" value="" id="input-video'+ productvideo_row +'" /></td>';

	html += '	<td class="text-left"><input type="text" name="product_video['+ productvideo_row +'][url]" placeholder="<?php echo $entry_videourl; ?>" class="form-control productvideourl" value="" /> <br /><input type="hidden" name="product_video['+ productvideo_row +'][product_video_id]" value=""></td>';

	html += '	<td class="text-left">';

		<?php foreach ($languages as $language) { ?>

	html += '<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span><input type="text" name="product_video['+ productvideo_row +'][description][<?php echo $language['language_id']; ?>][title]" placeholder="<?php echo $entry_videotitle; ?>" class="form-control productvideotitle" value="" /><br><textarea name="product_video['+ productvideo_row +'][description][<?php echo $language['language_id']; ?>][description]" rows="5" placeholder="<?php echo $entry_videodescription; ?>" class="form-control productvideotext"></textarea><input type="hidden" name="product_video['+ productvideo_row +'][description][<?php echo $language['language_id']; ?>][product_video_description_id]" value=""></div>';

			<?php } ?>

	html += '	</td>';

	

	html += '	<td class="text-right"><input type="text" name="product_video['+ productvideo_row +'][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';	

	html += '  <td class="text-left"><button type="button" onclick="$(\'#video-row' + productvideo_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';

	html += '</tr>';

	

	$('#productvideos tbody').append(html);

	

	productvideo_row++;

}

</script>


<script type="text/javascript"><!--

$('.date').datetimepicker({

	pickTime: false

});



$('.time').datetimepicker({

	pickDate: false

});



$('.datetime').datetimepicker({

	pickDate: true,

	pickTime: true

});

</script>//-->


<script type="text/javascript"><!--

$('#language a:first').tab('show');

$('#option a:first').tab('show');

//--></script></div>


</div>
<?php echo $footer; ?>

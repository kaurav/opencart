<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-theme-default" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-theme-default" class="form-horizontal">
         <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $text_general; ?></a></li>
            <li><a href="#tab-data" data-toggle="tab"><?php echo $text_image; ?></a></li>
            <li><a href="#tab-links" data-toggle="tab"><?php echo $text_activity_image; ?></a></li>
            
            <li><a href="#tab-image" data-toggle="tab"><?php echo $text_library_image; ?></a></li>
           <!--  <li><a href="#tab-design" data-toggle="tab"><?php echo $text_kirtan_image; ?></a></li>  -->
          </ul>
          <fieldset>
            <legend><?php echo $text_general; ?></legend>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-directory"><span data-toggle="tooltip" title="<?php echo $help_directory; ?>"><?php echo $entry_directory; ?></span></label>
              <div class="col-sm-10">
                <select name="theme_default_directory" id="input-directory" class="form-control">
                  <?php foreach ($directories as $directory) { ?>
                  <?php if ($directory == $theme_default_directory) { ?>
                  <option value="<?php echo $directory; ?>" selected="selected"><?php echo $directory; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $directory; ?>"><?php echo $directory; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
              <div class="col-sm-10">
                <select name="theme_default_status" id="input-status" class="form-control">
                  <?php if ($theme_default_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </fieldset>
          <fieldset>
            <legend><?php echo $text_product; ?></legend>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-catalog-limit"><span data-toggle="tooltip" title="<?php echo $help_product_limit; ?>"><?php echo $entry_product_limit; ?></span></label>
              <div class="col-sm-10">
                <input type="text" name="theme_default_product_limit" value="<?php echo $theme_default_product_limit; ?>" placeholder="<?php echo $entry_product_limit; ?>" id="input-catalog-limit" class="form-control" />
                <?php if ($error_product_limit) { ?>
                <div class="text-danger"><?php echo $error_product_limit; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-description-limit"><span data-toggle="tooltip" title="<?php echo $help_product_description_length; ?>"><?php echo $entry_product_description_length; ?></span></label>
              <div class="col-sm-10">
                <input type="text" name="theme_default_product_description_length" value="<?php echo $theme_default_product_description_length; ?>" placeholder="<?php echo $entry_product_description_length; ?>" id="input-description-limit" class="form-control" />
                <?php if ($error_product_description_length) { ?>
                <div class="text-danger"><?php echo $error_product_description_length; ?></div>
                <?php } ?>
              </div>
            </div>
          </fieldset>
          <fieldset><!-- <h1>hello news</h1> -->
            <legend><?php echo $text_image; ?></legend>
             <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-image-location"><?php echo $entry_image_location; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_location_width" value="<?php echo $theme_default_image_location_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-location" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_location_height" value="<?php echo $theme_default_image_location_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_image_location) { ?>
                <div class="text-danger"><?php echo $error_image_location; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-image-category-width"><?php echo $entry_image_category; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_category_width" value="<?php echo $theme_default_image_category_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-category-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_category_height" value="<?php echo $theme_default_image_category_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_image_category) { ?>
                <div class="text-danger"><?php echo $error_image_category; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-image-thumb-width"><?php echo $entry_image_thumb; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_thumb_width" value="<?php echo $theme_default_image_thumb_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-thumb-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_thumb_height" value="<?php echo $theme_default_image_thumb_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_image_thumb) { ?>
                <div class="text-danger"><?php echo $error_image_thumb; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-image-popup-width"><?php echo $entry_image_popup; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_popup_width" value="<?php echo $theme_default_image_popup_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-popup-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_popup_height" value="<?php echo $theme_default_image_popup_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_image_popup) { ?>
                <div class="text-danger"><?php echo $error_image_popup; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-image-product-width"><?php echo $entry_image_product; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_product_width" value="<?php echo $theme_default_image_product_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-product-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_product_height" value="<?php echo $theme_default_image_product_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_image_product) { ?>
                <div class="text-danger"><?php echo $error_image_product; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-image-additional-width"><?php echo $entry_image_additional; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_additional_width" value="<?php echo $theme_default_image_additional_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-additional-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_additional_height" value="<?php echo $theme_default_image_additional_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_image_additional) { ?>
                <div class="text-danger"><?php echo $error_image_additional; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-image-related"><?php echo $entry_image_related; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_related_width" value="<?php echo $theme_default_image_related_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-related" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_related_height" value="<?php echo $theme_default_image_related_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_image_related) { ?>
                <div class="text-danger"><?php echo $error_image_related; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required hide">
              <label class="col-sm-2 control-label" for="input-image-compare"><?php echo $entry_image_compare; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_compare_width" value="<?php echo $theme_default_image_compare_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-compare" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_compare_height" value="<?php echo $theme_default_image_compare_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_image_compare) { ?>
                <div class="text-danger"><?php echo $error_image_compare; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required hide">
              <label class="col-sm-2 control-label" for="input-image-wishlist"><?php echo $entry_image_wishlist; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_wishlist_width" value="<?php echo $theme_default_image_wishlist_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-wishlist" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_wishlist_height" value="<?php echo $theme_default_image_wishlist_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_image_wishlist) { ?>
                <div class="text-danger"><?php echo $error_image_wishlist; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required hide">
              <label class="col-sm-2 control-label" for="input-image-cart"><?php echo $entry_image_cart; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_cart_width" value="<?php echo $theme_default_image_cart_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-image-cart" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_image_cart_height" value="<?php echo $theme_default_image_cart_height; ?>" placeholder="<?php echo $entry_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_image_cart) { ?>
                <div class="text-danger"><?php echo $error_image_cart; ?></div>
                <?php } ?>
              </div>
            </div>
           
          </fieldset>
          
          <fieldset><!-- <h1>hello Gallery</h1> -->
            <legend><?php echo $text_gallery_image; ?></legend>
             <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-gallery_image-location"><?php echo $entry_gallery_image_location; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_gallery_image_location_width" value="<?php echo $theme_default_gallery_image_location_width; ?>" placeholder="<?php echo $entry_gallery_width; ?>" id="input-gallery_image-location" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_gallery_image_location_height" value="<?php echo $theme_default_gallery_image_location_height; ?>" placeholder="<?php echo $entry_gallery_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_gallery_image_location) { ?>
                <div class="text-danger"><?php echo $error_gallery_image_location; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-gallery_image-category-width"><?php echo $entry_gallery_image_category; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_gallery_image_category_width" value="<?php echo $theme_default_gallery_image_category_width; ?>" placeholder="<?php echo $entry_gallery_width; ?>" id="input-gallery_image-category-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_gallery_image_category_height" value="<?php echo $theme_default_gallery_image_category_height; ?>" placeholder="<?php echo $entry_gallery_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_gallery_image_category) { ?>
                <div class="text-danger"><?php echo $error_gallery_image_category; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-gallery_image-thumb-width"><?php echo $entry_gallery_image_thumb; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_gallery_image_thumb_width" value="<?php echo $theme_default_gallery_image_thumb_width; ?>" placeholder="<?php echo $entry_gallery_width; ?>" id="input-gallery_image-thumb-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_gallery_image_thumb_height" value="<?php echo $theme_default_gallery_image_thumb_height; ?>" placeholder="<?php echo $entry_gallery_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_gallery_image_thumb) { ?>
                <div class="text-danger"><?php echo $error_gallery_image_thumb; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-gallery_image-popup-width"><?php echo $entry_gallery_image_popup; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_gallery_image_popup_width" value="<?php echo $theme_default_gallery_image_popup_width; ?>" placeholder="<?php echo $entry_gallery_width; ?>" id="input-gallery_image-popup-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_gallery_image_popup_height" value="<?php echo $theme_default_gallery_image_popup_height; ?>" placeholder="<?php echo $entry_gallery_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_gallery_image_popup) { ?>
                <div class="text-danger"><?php echo $error_gallery_image_popup; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-gallery_image-product-width"><?php echo $entry_gallery_image_product; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_gallery_image_product_width" value="<?php echo $theme_default_gallery_image_product_width; ?>" placeholder="<?php echo $entry_gallery_width; ?>" id="input-gallery_image-product-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_gallery_image_product_height" value="<?php echo $theme_default_gallery_image_product_height; ?>" placeholder="<?php echo $entry_gallery_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_gallery_image_product) { ?>
                <div class="text-danger"><?php echo $error_gallery_image_product; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-gallery_image-additional-width"><?php echo $entry_gallery_image_additional; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_gallery_image_additional_width" value="<?php echo $theme_default_gallery_image_additional_width; ?>" placeholder="<?php echo $entry_gallery_width; ?>" id="input-gallery_image-additional-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_gallery_image_additional_height" value="<?php echo $theme_default_gallery_image_additional_height; ?>" placeholder="<?php echo $entry_gallery_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_gallery_image_additional) { ?>
                <div class="text-danger"><?php echo $error_gallery_image_additional; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-gallery_image-related"><?php echo $entry_gallery_image_related; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_gallery_image_related_width" value="<?php echo $theme_default_gallery_image_related_width; ?>" placeholder="<?php echo $entry_gallery_width; ?>" id="input-gallery_image-related" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_gallery_image_related_height" value="<?php echo $theme_default_gallery_image_related_height; ?>" placeholder="<?php echo $entry_gallery_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_gallery_image_related) { ?>
                <div class="text-danger"><?php echo $error_gallery_image_related; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required hide">
              <label class="col-sm-2 control-label" for="input-gallery_image-compare"><?php echo $entry_gallery_image_compare; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_gallery_image_compare_width" value="<?php echo $theme_default_gallery_image_compare_width; ?>" placeholder="<?php echo $entry_gallery_width; ?>" id="input-gallery_image-compare" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_gallery_image_compare_height" value="<?php echo $theme_default_gallery_image_compare_height; ?>" placeholder="<?php echo $entry_gallery_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_gallery_image_compare) { ?>
                <div class="text-danger"><?php echo $error_gallery_image_compare; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required hide">
              <label class="col-sm-2 control-label" for="input-gallery_image-wishlist"><?php echo $entry_gallery_image_wishlist; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_gallery_image_wishlist_width" value="<?php echo $theme_default_gallery_image_wishlist_width; ?>" placeholder="<?php echo $entry_gallery_width; ?>" id="input-gallery_image-wishlist" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_gallery_image_wishlist_height" value="<?php echo $theme_default_gallery_image_wishlist_height; ?>" placeholder="<?php echo $entry_gallery_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_gallery_image_wishlist) { ?>
                <div class="text-danger"><?php echo $error_gallery_image_wishlist; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required hide">
              <label class="col-sm-2 control-label" for="input-gallery_image-cart"><?php echo $entry_gallery_image_cart; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_gallery_image_cart_width" value="<?php echo $theme_default_gallery_image_cart_width; ?>" placeholder="<?php echo $entry_gallery_width; ?>" id="input-gallery_image-cart" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_gallery_image_cart_height" value="<?php echo $theme_default_gallery_image_cart_height; ?>" placeholder="<?php echo $entry_gallery_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_gallery_image_cart) { ?>
                <div class="text-danger"><?php echo $error_gallery_image_cart; ?></div>
                <?php } ?>
              </div>
            </div>
           
          </fieldset>
          
          <fieldset><!-- <h1>hello activity</h1> -->
            <legend><?php echo $text_activity_image; ?></legend>
             <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-activity_image-location"><?php echo $entry_activity_image_location; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_activity_image_location_width" value="<?php echo $theme_default_activity_image_location_width; ?>" placeholder="<?php echo $entry_activity_width; ?>" id="input-activity_image-location" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_activity_image_location_height" value="<?php echo $theme_default_activity_image_location_height; ?>" placeholder="<?php echo $entry_activity_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_activity_image_location) { ?>
                <div class="text-danger"><?php echo $error_activity_image_location; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-activity_image-category-width"><?php echo $entry_activity_image_category; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_activity_image_category_width" value="<?php echo $theme_default_activity_image_category_width; ?>" placeholder="<?php echo $entry_activity_width; ?>" id="input-activity_image-category-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_activity_image_category_height" value="<?php echo $theme_default_activity_image_category_height; ?>" placeholder="<?php echo $entry_activity_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_activity_image_category) { ?>
                <div class="text-danger"><?php echo $error_activity_image_category; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-activity_image-thumb-width"><?php echo $entry_activity_image_thumb; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_activity_image_thumb_width" value="<?php echo $theme_default_activity_image_thumb_width; ?>" placeholder="<?php echo $entry_activity_width; ?>" id="input-activity_image-thumb-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_activity_image_thumb_height" value="<?php echo $theme_default_activity_image_thumb_height; ?>" placeholder="<?php echo $entry_activity_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_activity_image_thumb) { ?>
                <div class="text-danger"><?php echo $error_activity_image_thumb; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-activity_image-popup-width"><?php echo $entry_activity_image_popup; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_activity_image_popup_width" value="<?php echo $theme_default_activity_image_popup_width; ?>" placeholder="<?php echo $entry_activity_width; ?>" id="input-activity_image-popup-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_activity_image_popup_height" value="<?php echo $theme_default_activity_image_popup_height; ?>" placeholder="<?php echo $entry_activity_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_activity_image_popup) { ?>
                <div class="text-danger"><?php echo $error_activity_image_popup; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-activity_image-product-width"><?php echo $entry_activity_image_product; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_activity_image_product_width" value="<?php echo $theme_default_activity_image_product_width; ?>" placeholder="<?php echo $entry_activity_width; ?>" id="input-activity_image-product-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_activity_image_product_height" value="<?php echo $theme_default_activity_image_product_height; ?>" placeholder="<?php echo $entry_activity_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_activity_image_product) { ?>
                <div class="text-danger"><?php echo $error_activity_image_product; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-activity_image-additional-width"><?php echo $entry_activity_image_additional; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_activity_image_additional_width" value="<?php echo $theme_default_activity_image_additional_width; ?>" placeholder="<?php echo $entry_activity_width; ?>" id="input-activity_image-additional-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_activity_image_additional_height" value="<?php echo $theme_default_activity_image_additional_height; ?>" placeholder="<?php echo $entry_activity_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_activity_image_additional) { ?>
                <div class="text-danger"><?php echo $error_activity_image_additional; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-activity_image-related"><?php echo $entry_activity_image_related; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_activity_image_related_width" value="<?php echo $theme_default_activity_image_related_width; ?>" placeholder="<?php echo $entry_activity_width; ?>" id="input-activity_image-related" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_activity_image_related_height" value="<?php echo $theme_default_activity_image_related_height; ?>" placeholder="<?php echo $entry_activity_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_activity_image_related) { ?>
                <div class="text-danger"><?php echo $error_activity_image_related; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required hide">
              <label class="col-sm-2 control-label" for="input-activity_image-compare"><?php echo $entry_activity_image_compare; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_activity_image_compare_width" value="<?php echo $theme_default_activity_image_compare_width; ?>" placeholder="<?php echo $entry_activity_width; ?>" id="input-activity_image-compare" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_activity_image_compare_height" value="<?php echo $theme_default_activity_image_compare_height; ?>" placeholder="<?php echo $entry_activity_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_activity_image_compare) { ?>
                <div class="text-danger"><?php echo $error_activity_image_compare; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required hide">
              <label class="col-sm-2 control-label" for="input-activity_image-wishlist"><?php echo $entry_activity_image_wishlist; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_activity_image_wishlist_width" value="<?php echo $theme_default_activity_image_wishlist_width; ?>" placeholder="<?php echo $entry_activity_width; ?>" id="input-activity_image-wishlist" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_activity_image_wishlist_height" value="<?php echo $theme_default_activity_image_wishlist_height; ?>" placeholder="<?php echo $entry_activity_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_activity_image_wishlist) { ?>
                <div class="text-danger"><?php echo $error_activity_image_wishlist; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required hide">
              <label class="col-sm-2 control-label" for="input-activity_image-cart"><?php echo $entry_activity_image_cart; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_activity_image_cart_width" value="<?php echo $theme_default_activity_image_cart_width; ?>" placeholder="<?php echo $entry_activity_width; ?>" id="input-activity_image-cart" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_activity_image_cart_height" value="<?php echo $theme_default_activity_image_cart_height; ?>" placeholder="<?php echo $entry_activity_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_activity_image_cart) { ?>
                <div class="text-danger"><?php echo $error_activity_image_cart; ?></div>
                <?php } ?>
              </div>
            </div>
           
          </fieldset>
          <fieldset><!-- <h1>hello library</h1> -->
            <legend><?php echo $text_library_image; ?></legend>
             <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-library_image-location"><?php echo $entry_library_image_location; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_library_image_location_width" value="<?php echo $theme_default_library_image_location_width; ?>" placeholder="<?php echo $entry_library_width; ?>" id="input-library_image-location" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_library_image_location_height" value="<?php echo $theme_default_library_image_location_height; ?>" placeholder="<?php echo $entry_library_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_library_image_location) { ?>
                <div class="text-danger"><?php echo $error_library_image_location; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-library_image-category-width"><?php echo $entry_library_image_category; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_library_image_category_width" value="<?php echo $theme_default_library_image_category_width; ?>" placeholder="<?php echo $entry_library_width; ?>" id="input-library_image-category-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_library_image_category_height" value="<?php echo $theme_default_library_image_category_height; ?>" placeholder="<?php echo $entry_library_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_library_image_category) { ?>
                <div class="text-danger"><?php echo $error_library_image_category; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-library_image-thumb-width"><?php echo $entry_library_image_thumb; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_library_image_thumb_width" value="<?php echo $theme_default_library_image_thumb_width; ?>" placeholder="<?php echo $entry_library_width; ?>" id="input-library_image-thumb-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_library_image_thumb_height" value="<?php echo $theme_default_library_image_thumb_height; ?>" placeholder="<?php echo $entry_library_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_library_image_thumb) { ?>
                <div class="text-danger"><?php echo $error_library_image_thumb; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-library_image-popup-width"><?php echo $entry_library_image_popup; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_library_image_popup_width" value="<?php echo $theme_default_library_image_popup_width; ?>" placeholder="<?php echo $entry_library_width; ?>" id="input-library_image-popup-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_library_image_popup_height" value="<?php echo $theme_default_library_image_popup_height; ?>" placeholder="<?php echo $entry_library_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_library_image_popup) { ?>
                <div class="text-danger"><?php echo $error_library_image_popup; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-library_image-product-width"><?php echo $entry_library_image_product; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_library_image_product_width" value="<?php echo $theme_default_library_image_product_width; ?>" placeholder="<?php echo $entry_library_width; ?>" id="input-library_image-product-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_library_image_product_height" value="<?php echo $theme_default_library_image_product_height; ?>" placeholder="<?php echo $entry_library_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_library_image_product) { ?>
                <div class="text-danger"><?php echo $error_library_image_product; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-library_image-additional-width"><?php echo $entry_library_image_additional; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_library_image_additional_width" value="<?php echo $theme_default_library_image_additional_width; ?>" placeholder="<?php echo $entry_library_width; ?>" id="input-library_image-additional-width" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_library_image_additional_height" value="<?php echo $theme_default_library_image_additional_height; ?>" placeholder="<?php echo $entry_library_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_library_image_additional) { ?>
                <div class="text-danger"><?php echo $error_library_image_additional; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="col-sm-2 control-label" for="input-library_image-related"><?php echo $entry_library_image_related; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_library_image_related_width" value="<?php echo $theme_default_library_image_related_width; ?>" placeholder="<?php echo $entry_library_width; ?>" id="input-library_image-related" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_library_image_related_height" value="<?php echo $theme_default_library_image_related_height; ?>" placeholder="<?php echo $entry_library_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_library_image_related) { ?>
                <div class="text-danger"><?php echo $error_library_image_related; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required hide">
              <label class="col-sm-2 control-label" for="input-library_image-compare"><?php echo $entry_library_image_compare; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_library_image_compare_width" value="<?php echo $theme_default_library_image_compare_width; ?>" placeholder="<?php echo $entry_library_width; ?>" id="input-library_image-compare" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_library_image_compare_height" value="<?php echo $theme_default_library_image_compare_height; ?>" placeholder="<?php echo $entry_library_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_library_image_compare) { ?>
                <div class="text-danger"><?php echo $error_library_image_compare; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required hide">
              <label class="col-sm-2 control-label" for="input-library_image-wishlist"><?php echo $entry_library_image_wishlist; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_library_image_wishlist_width" value="<?php echo $theme_default_library_image_wishlist_width; ?>" placeholder="<?php echo $entry_library_width; ?>" id="input-library_image-wishlist" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_library_image_wishlist_height" value="<?php echo $theme_default_library_image_wishlist_height; ?>" placeholder="<?php echo $entry_library_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_library_image_wishlist) { ?>
                <div class="text-danger"><?php echo $error_library_image_wishlist; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="form-group required hide">
              <label class="col-sm-2 control-label" for="input-library_image-cart"><?php echo $entry_library_image_cart; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_library_image_cart_width" value="<?php echo $theme_default_library_image_cart_width; ?>" placeholder="<?php echo $entry_library_width; ?>" id="input-library_image-cart" class="form-control" />
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="theme_default_library_image_cart_height" value="<?php echo $theme_default_library_image_cart_height; ?>" placeholder="<?php echo $entry_library_height; ?>" class="form-control" />
                  </div>
                </div>
                <?php if ($error_library_image_cart) { ?>
                <div class="text-danger"><?php echo $error_library_image_cart; ?></div>
                <?php } ?>
              </div>
            </div>
           
          </fieldset>
 
      
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-4'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-8'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <div class="">
        
        <div class="">
          
          
          <div id="galleries" class="">
            
             <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
          <!-- BEGIN CONTENT -->
          <div class="col-md-12 col-sm-12">
            

             <div class="portlet light" id='' style='margin-bottom: 10px;'>
             <div class="portlet-title">
              <div class="caption">
              <i class="fa fa-image"></i>
              <span class="caption-subject bold uppercase"> <?php echo $heading_title; ?> </span>
              <span class="caption-helper"></span>
              </div>
              <div class="actions">
              </div>
              </div>
              <div class="portlet-body">
            <div class="content-page">
                <div class="filter-v1">
                  
                <div class="row mix-grid">


                <?php foreach($sikhethehass as $sikhethehas) { ?>

                  <div class="col-md-4 col-sm-4 mix category_1 mix_all" style="display: block; opacity: 1; ">
                      <div class="mix-inner">
                      <a href="<?php echo $sikhethehas['href']; ?>">
                         <img alt="<?php echo $sikhethehas['name']; ?>"  src="<?php echo $sikhethehas['thumb']; ?>" >
                         </a>
                      </div>
                      <div style="min-height:50px;">
                      <a href="<?php echo $sikhethehas['href']; ?>"> <h4 style="margin-bottom: 50px;"> <?php echo $sikhethehas['name']; ?></h4></a>
                      </div>
                     
                      <div style="height:30px;">
                      <?php echo $sikhethehas['date']; ?>
                      </div>
                  </div>

                  <?php } ?>
  
                </div>
              </div>
            </div>
            </div>
            </div>

          </div>
 
          <!-- END CONTENT -->
        </div>
        <!-- BEGIN SIDEBAR & CONTENT -->
           
          </div>
          
        </div>
      </div>
      
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
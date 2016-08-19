<?php echo $header; ?>

<div class="container 
      ">
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
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top;

    

     ?>
<div class="row">
        <div class="col-md-12 blog-page ">
          
            <div class="col-md-8 article-block portlet light">
              <h3><?php echo $heading_title; ?></h3>
              <div class="blog-tag-data">
             <!--    -->
                <a class="fancybox-button" data-rel="fancybox-button"
                 title = "<?php echo $heading_title;?> " href= "<?php echo $popup;?>"> 

               <img src="<?php echo $popup;?>" class="img-responsive" alt="">

                </a>
                <div class="col-md-12">
                <br>
                  <div class="col-md-8" style="text-align:left;">
                  <?php if (count($tags) > 0 )
                  {
                  ?>
                   <ul class="list-inline blog-tags" >
                      <li>
                        <i class="fa fa-tags"></i>

                        <?php 
                          foreach ($tags as $value) {
                             ?><a href="<?php echo $value['href']?>">
                              <?php echo $value['tag'];?> </a>
                        <?php
                          }
                        ?>
                    
                      </li>
                    </ul>
                  <?php
                  }



                  ?>


                   
                  </div>
                  <div class="col-md-4 blog-tag-data-inner" style="text-align:right;">
                    <ul class="list-inline">
                      <li>
                        <i class="fa fa-calendar"></i>
                        <?php echo $date_added;?> 
                      </li>
                     
                  </ul>
                  </div>
                </div>
              </div>
              <!--end sikhethehas-tag-data-->
              <br><br>
              <div>
                <p>
                  <?php echo $description;?>
                </p>
                
              
              </div>
             
            
            </div>
            <!--end col-md-9-->
            <div class="col-md-4 article-block">
        

            <div class="caption-subject bold uppercase portlet light" style="min-height:60px; ">
              <h3 
              ><?php echo $related_pics;?></h3>
              <hr>

              <ul class="list-inline blog-images">


              <?php 
                foreach($images as $image){
                ?>
                <li>
                  <a class="fancybox-button" data-rel="fancybox-button" title="<?php echo $heading_title;?>" href="<?php  echo $image['popup'];?>">
                  <img alt="" src=<?php echo $image['thumb']; ?>>
                  </a>
                </li>
                <?php
                }
              ?>

           
              </ul>
              </div>
        

<div style="margin-bottom: 10px;  min-height: 200px;" id="" class="portlet light">

      <div class="portlet-title">
      <div class="caption">
      <i class="fa fa-video-sikhethehas"></i>
      <span class="caption-subject bold uppercase"><?php echo $related_sikhethehas;?> </span>
      <span class="caption-helper"></span>
      </div>
      <div class="actions">
      </div>
      </div>
     
      <div class="portlet-body">
      
      <div class="row">
      <?php 
        foreach ($sikhethehass as $value) {
      ?>
    <div class="col-md-12">
    <div class="col-md-4">
    <a href="<?php echo $value['href'];?>">
    <img id="image-<?php echo $value['sikhethehas_id'];?>" src="<?php echo $value['thumb'];?>"> </a>
    </div>
    
      
    <div class="col-md-8">
      <a href="<?php echo $value['href'];?>"><?php echo $value['name']; ?><br>
      <span><?php echo  $value['date_added'];?></span></a>
      
     
    </div>
  <br>
  <div class="col-md-12">
    <hr>

  </div>

    </div>
          <?php
        }

      ?>
   
    </div>
  
  </div>
            </div>
           
          </div>
        </div>
      </div>



      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
</div>

<?php echo $footer; ?>
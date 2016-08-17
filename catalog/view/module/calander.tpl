
<hr/>
<div class="calander-module">
<div class="row" id="fullcalendar-<?php echo $module; ?>">

          <div class="col-md-5">
                
              <div class="row">
              <div class="col-md-12">
              
               <div style="background : #fff;" id='calendar-<?php echo $module;?>'></div>
               <div class="text-right">
               <!-- <a class="btn btn-mehroon " href="<?php echo $fullalender; ?>">fullcalender</a> -->
              
              </div></div>
              
              </div>
              
          </div>

          <div class="col-md-7">
            <div class="portlet light" id='' style="min-height: 390px;">
                <div class="portlet-title">
                <div class="caption">
                <i class="fa fa-history"></i>
                <span class="caption-subject bold uppercase"> <span id="itehas-<?php echo $module;?>"> <?=date('d M Y')?> </span> <?php echo $text_sikh_itehas; ?></span>
                <span class="caption-helper"></span>
                </div>
                <div class="actions">
                </div>
                </div>
                <div class="portlet-body">
                <div class="eventlists">
                <div class="scroller" style="height: 290px;">
                    <table cellspacing="5" cellpadding="5" class="table table-bordered table-striped" id="eventlist-<?php echo $module; ?>">
                      <tbody>
                      <tr valign="top" align="left"> 
                      <td><b>2016</b></td>
                      <td><font size="2">Event title</font></td>
                      </tr>
                      
                      <tr valign="top" align="left"> 
                      <td><b>2016</b></td>
                      <td><font size="2">Event title</font></td>
                      </tr>
                      <tr valign="top" align="left"> 
                      <td><b>2016</b></td>
                      <td><font size="2">Event title</font></td>
                      </tr>
                      <tr valign="top" align="left"> 
                      <td><b>2016</b></td>
                      <td><font size="2">Event title</font></td>
                      </tr>
                      <tr valign="top" align="left"> 
                      <td><b>2016</b></td>
                      <td><font size="2">Event title</font></td>
                      </tr>
                      
                      </tbody>
                    </table>
                </div>
                </div>
                <div class="spinner" style="position: absolute; top: 40%; left: 40%; display: none;"><img src="image/catalog/spinner.gif" style="width: 50px; height: 50px;"></div>

              </div>
          </div>

          </div>
    
  </div>
</div>
  <script type="text/javascript">
    $(document).ready(function() {
      setTimeout(function(){
        var isHome = $('body').hasClass('common-home');

        myfullcalendar('#calendar-<?php echo $module;?>',isHome,'<?php echo $module;?>');

      },500);

    });
  </script>


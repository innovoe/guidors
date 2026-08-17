
  <?php include APPPATH.'views/include/js_msg_list.php'; ?>

  <?php $success = $this->session->flashdata('msg'); ?>
  <?php $error = $this->session->flashdata('error'); ?>
  <input type="hidden" id="filter" value="<?php if (isset($page_title) && $page_title == 'Templates'){echo "1";}else{echo "0";}  ?>">
  <input type="hidden" id="success" value="<?php if(isset($success)){echo html_escape($success);} ?>">
  <input type="hidden" id="alert_success" value="<?php echo trans('successuu') ?>">
  <input type="hidden" id="error" value="<?php if(isset($error)){echo html_escape($error);} ?>">  
  <input type="hidden" id="lc" value="<?php echo strlen(settings()->ind_code); ?>">
  <input type="hidden" class="user_interval" value="<?php echo user()->intervals ?>">
  <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
  <?php echo html_escape($this->session->unset_userdata('msg')); $this->session->unset_userdata('error'); ?>

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <?php echo trans('version') ?> <?php echo html_escape(settings()->version) ?>
    </div>
    <!-- Default to the left -->
    <strong><?php //echo trans('copyright') ?>  <?php //echo date('Y') ?>  <?php //echo trans('all-rights-reserved') ?> <?php echo html_escape(lang_value()->copyright) ?>

  </footer>
</div>
<!-- wrapper -->


<!-- jQuery -->
<script src="<?php echo base_url() ?>assets/front/libs/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url() ?>assets/front/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="<?php echo base_url() ?>assets/front/libs/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="<?php echo base_url() ?>assets/admin/js/bootstrap-datepicker.min.js"></script>

<!-- DataTables -->
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/validation.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/sweet-alert.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/bootstrap-tagsinput.js"></script>
<!-- bs-custom-file-input -->
<script src="<?php echo base_url() ?>assets/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- animation js -->
<script src="<?php echo base_url() ?>assets/front/js/aos.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url() ?>assets/admin/plugins/summernote/summernote-bs4.js"></script>
<!-- Icon Picker -->
<script src="<?php echo base_url() ?>assets/admin/js/bootstrapicon-iconpicker.js"></script>

<script src="<?php echo base_url() ?>assets/admin/js/tata.js"></script>

<script src="<?php echo base_url() ?>assets/admin/js/admin.js?var=<?= settings()->version ?>&time=<?=time();?>"></script>
<script src="<?php echo base_url() ?>assets/admin/js/clipboard.min.js"></script>

<!-- select2 js -->
<script src="<?php echo base_url()?>assets/admin/plugins/select2/js/select2.full.min.js"></script>
<!-- nice select js -->
<script src="<?php echo base_url()?>assets/admin/js/nice-select.min.js"></script>
<script src="<?php echo base_url()?>assets/admin/js/tata.js"></script>

<!-- timepicker -->
<script src="<?php echo base_url()?>assets/admin/js/timepicker.min.js"></script>

<script src="<?php echo base_url() ?>assets/admin/js/bootstrap-colorpicker.min.js"></script>

<?php if (isset($page_title) && $page_title != 'Verification'): ?>
  <script src="<?php echo base_url() ?>assets/admin/js/jquery-ui.min.js"></script>
<?php endif ?>

<!-- lightbox js -->
<script src="<?php echo base_url() ?>assets/admin/lightbox/src/js/lightbox.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
<!-- calendar js -->
<?php if (isset($page_title) && $page_title == 'Calendars'): ?>
<?php include'calendar-js.php'; ?>
<?php endif ?>

<!-- stripe js -->
<?php include'stripe-js.php'; ?>


<?php if (isset($page_title) && $page_title == 'Holidays'): ?>
  <?php $this->load->view('admin/include/datepicker-js.php'); ?>
<?php endif ?>

<!-- chart js -->
<?php if (isset($page) && $page == 'Dashboard'): ?>
  <?php $this->load->view('admin/include/charts'); ?>
<?php elseif (isset($page) && $page == 'Reports'): ?>
  <?php $this->load->view('admin/include/user-charts'); ?>
<?php endif ?>

<script type="text/javascript">
  function CopyMe(TextToCopy) {
    var TempText = document.createElement("input");
    TempText.value = TextToCopy;
    document.body.appendChild(TempText);
    TempText.select();
    
    document.execCommand("copy");
    document.body.removeChild(TempText);
    $(".copy_profile_btn").html('Copied').delay(3000).slideUp('slow');
    //window.location.reload();
    //alert("Copied the text: " + TempText.value);
  }
</script>

<?php if (isset($page_title) && $page_title == 'Holidays'): ?>
  <script src="<?php echo base_url() ?>assets/admin/js/jquery-ui.min.js"></script>
  <script>
      $(document).ready(function () {

          var $datePicker = $("div#holiday_picker");
          var base_url = $('#base_url').val();
          
          var holidays = <?php echo json_encode($holidays) ?>;
          
          if (holidays) {
              var disabledDays = holidays;
          }else{
              var disabledDays = '';
          }

          $.datepicker.regional ['en'] = {
              clearText: 'Clear', 
              clearStatus: '',
              closeText: 'Close',
              closeStatus: 'Close without modifying',
              prevStatus: 'See previous month',
              nextStatus: 'See next month',
              currentText: 'Current',
              currentStatus: 'See current month',
              monthNames: ['<?php echo trans('january') ?>', '<?php echo trans('february') ?>', '<?php echo trans('march') ?>', '<?php echo trans('april') ?>', '<?php echo trans('may') ?>', '<?php echo trans('june') ?>',
              '<?php echo trans('july') ?>', '<?php echo trans('august') ?>', '<?php echo trans('september') ?>', '<?php echo trans('october') ?>', '<?php echo trans('november') ?>', '<?php echo trans('december') ?>'],
              monthNamesShort: ['<?php echo trans('january') ?>', '<?php echo trans('february') ?>', '<?php echo trans('march') ?>', '<?php echo trans('april') ?>', '<?php echo trans('may') ?>', '<?php echo trans('june') ?>',
              '<?php echo trans('july') ?>', '<?php echo trans('august') ?>', '<?php echo trans('september') ?>', '<?php echo trans('october') ?>', '<?php echo trans('november') ?>', '<?php echo trans('december') ?>'],
              monthStatus: 'See another month',
              yearStatus: 'See another year',
              weekHeader: 'Sm',
              weekStatus: '',
              dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
              dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
              dayNamesMin: ['<?php echo trans('su') ?>', '<?php echo trans('mo') ?>', '<?php echo trans('tu') ?>', '<?php echo trans('we') ?>', '<?php echo trans('th') ?>', '<?php echo trans('fr') ?>', '<?php echo trans('sa') ?>'],
              dayStatus: 'Use DD as the first day of the week',
              dateStatus: 'Choose the DD, MM of',
              firstDay: 0,
              initStatus: 'Choose date',
              isRTL: false
          }; 

          $.datepicker.setDefaults($.datepicker.regional['en']);

          $datePicker.datepicker({
              daysOfWeekDisabled: [0],
              changeMonth: true,
              changeYear: true,
              showOtherMonths: true,
              selectOtherMonths: true,
              showButtonPanel: true,
              todayBtn: false,
              dateFormat: 'yy-m-d',

              onSelect: function(){
                  var date = $(this).val();
                 
                  var url = base_url+'admin/settings/add_holidays/'+date;
                  var post_data = {
                      'csrf_test_name' : csrf_token
                  };

                  $('#load_data').html('<span class="spinner-border spinner-border-sm"></span>');

                  $.ajax({
                      type: "POST",
                      url: url,
                      dataType: 'json',
                      data: post_data,
                      success: function(data) {
                          if (data.status == 1) {
                              window.location.href = base_url+'admin/settings/holidays?msg=success';
                          }
                      }
                  })

              },


              beforeShowDay: function(date) {
                  var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();

                  for (i = 0; i < disabledDays.length; i++) {
                      if($.inArray(y + '-' + (m+1) + '-' + d,disabledDays) != -1) {
                          //return [false];
                          return [true, 'ui-state-actived', ''];
                      }
                  }
                  return [true];
              }

          });
      });
  </script>
<?php endif ?>

</body>
</html>

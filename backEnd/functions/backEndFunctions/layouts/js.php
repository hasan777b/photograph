
<!-- jQuery  -->
<script src="/photograph/panel/assets/js/jquery.min.js"></script>
<script src="/photograph/panel/assets/js/bootstrap.bundle.min.js"></script>
<script src="/photograph/panel/assets/js/modernizr.min.js"></script>
<script src="/photograph/panel/assets/js/detect.js"></script>
<script src="/photograph/panel/assets/js/fastclick.js"></script>
<script src="/photograph/panel/assets/js/jquery.slimscroll.js"></script>
<script src="/photograph/panel/assets/js/jquery.blockUI.js"></script>
<script src="/photograph/panel/assets/js/waves.js"></script>
<script src="/photograph/panel/assets/js/jquery.nicescroll.js"></script>
<script src="/photograph/panel/assets/js/jquery.scrollTo.min.js"></script>

<!--Morris Chart-->
<script src="/photograph/panel/plugins/morris/morris.min.js"></script>
<script src="/photograph/panel/plugins/raphael/raphael.min.js"></script>

<!-- dashboard js -->
<script src="/photograph/panel/assets/pages/dashboard.int.js"></script>

<!-- App js -->
<script src="/photograph/panel/assets/js/app.js"></script>

<!-- check for max file  -->
<script type="text/javascript">
    $(document).ready(function(){
        $("#images").change(function(){
            var max_file_uploads = "<?php echo ini_get('max_file_uploads'); ?>";
            var image = $(this)[0];
            var length = image.files.length
            if(length > max_file_uploads){
                $("#submit").prop('disabled',true);
                $("#submit").css('background','orange');
                alert("شما میتوانید فقط "+max_file_uploads+" تصویر انتخاب کنید ");
            }else{
                $("#submit").prop('disabled',false);
                $("#submit").css('background','#46cd93');
            }
        })
    })
</script>
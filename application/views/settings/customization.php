<div onclick="checkMousePointer()">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css"/> <!-- 'classic' theme -->

<div style="width: 100vw;
    height: 100vh;"class="container">
<h1><?=$title?></h1><br><br>
<h2>Change Background:</h2>
<div class="color-picker"></div>


<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
<script src="<?php echo base_url();?>assets/js/main.js"></script>
</form>
</div>

<script>
pickr.on('change', (color, source, instance) => {
    const rgbaColor = color.toRGBA().toString();
    console.log(rgbaColor);
    document.querySelector('body').style.background = rgbaColor;
}).on('save', (color, instance) => {
    const rgbaSave = color.toRGBA().toString();
     
     // save to db
    var colors = {
        color : rgbaSave,
        submit : true
    };
    $.ajax({
     url: '<?php echo base_url();?>Customization/uploadColor',
     type: 'POST',
     data: colors,
     success: function(result){
        console.log(result);
     }
   });
})
</script>
<script>
const rgbaColor = <?php echo json_encode($_SESSION["bgColor"]); ?>; 
document.querySelector('body').style.background = rgbaColor;
</script>
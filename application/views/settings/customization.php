<div onclick="checkMousePointer()">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css"/> <!-- 'classic' theme -->

<div style="width: 100vw;
    height: 100vh;"class="container">
<h1><?=$title?></h1><br><br>
<h2>Change Background:</h2>
<div class="color-picker"></div>


<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
</form>
</div>

<script>
const pickr = Pickr.create({
    el: '.color-picker',
    theme: 'classic', // or 'monolith', or 'nano'
    default: '#000',
    swatches: [
        'rgba(244, 67, 54, 1)',
        'rgba(233, 30, 99, 0.95)',
        'rgba(156, 39, 176, 0.9)',
        'rgba(103, 58, 183, 0.85)',
        'rgba(63, 81, 181, 0.8)',
        'rgba(33, 150, 243, 0.75)',
        'rgba(3, 169, 244, 0.7)',
        'rgba(0, 188, 212, 0.7)',
        'rgba(0, 150, 136, 0.75)',
        'rgba(76, 175, 80, 0.8)',
        'rgba(139, 195, 74, 0.85)',
        'rgba(205, 220, 57, 0.9)',
        'rgba(255, 235, 59, 0.95)',
        'rgba(255, 193, 7, 1)'
    ],

    components: {

        // Main components
        preview: true,
        opacity: true,
        hue: true,

        // Input / output Options
        interaction: {
            hex: true,
            rgba: true,
            input: true,
            save: true
        }
    }
});
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
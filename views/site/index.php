<?php
/* @var $this yii\web\View */
$this->title = 'Культурный код';

$this->registerJs("   
    
    ($('#first-tab-culture').click(function () {
    
        $('#promo').animate({'opacity':'0.8'},300,function(){
            $('#promo').css('background-image', 'url(/img/_index/top/bgSlider_cinema.jpg)');
            $('#promo').animate({'opacity':'1'},300);
        });
    
        $('#slidertwo').hide();        
        $('#sliderthree').hide();
        $('#partners-urban-one').hide();        
        $('#partners-cinema-one').show();
        $('#partners-cinema-two').show();
        $('#info-partners-cinema').show();
        $('#partners-cinema-three').show();
        $('#food-partners-cinema').show();
        $('#partners-cinema-four').show();
    
        var browserMinWidth = $(window).width();
        
        if (browserMinWidth > 770) {
            $('#sliderfour').show();
            $('#sliderfive').hide();
        } else {
            $('#sliderfive').show();
            $('#sliderfour').hide();
        }
        
    }) 
    );
    
    ($('#second-tab-culture').click(function () {
    
        $('#promo').animate({'opacity':'0.8'},300,function(){
            $('#promo').css('background-image', 'url(/img/_index/top/bgSlider.jpg)');
            $('#promo').animate({'opacity':'1'},300);
        });
        
        $('#sliderfour').hide();        
        $('#sliderfive').hide();               
        $('#partners-cinema-one').hide();
        $('#partners-cinema-two').hide();
        $('#info-partners-cinema').hide();
        $('#partners-cinema-three').hide();
        $('#food-partners-cinema').hide();
        $('#partners-cinema-four').hide();
        $('#partners-urban-one').show();
    
        var browserMinWidth = $(window).width();
        
        if (browserMinWidth > 770) {
            $('#slidertwo').show();
            $('#sliderthree').hide();
        } else {
            $('#sliderthree').show();
            $('#slidertwo').hide();
        }
        
    }) 
    );
    
    $(window).resize(function() {    
        
        var browserMinWidthResize = $(window).width();
        
        if ($('#slidertwo').is(':visible')) {
        
            if (browserMinWidthResize > 770) {
                $('#sliderthree').hide();            
            } else {
                $('#sliderthree').show();
                $('#slidertwo').hide();
            }    
        }
        
        if ($('#sliderthree').is(':visible')) {
        
            if (browserMinWidthResize > 770) {
                $('#slidertwo').show();
                $('#sliderthree').hide();            
            } else {                
                $('#slidertwo').hide();
            }    
        }
        
        if ($('#sliderfour').is(':visible')) {
        
            if (browserMinWidthResize > 770) {
                $('#sliderfive').hide();            
            } else {                
                $('#sliderfive').show();
                $('#sliderfour').hide();
            }    
        }
        
        if ($('#sliderfive').is(':visible')) {
        
            if (browserMinWidthResize > 770) {
                $('#sliderfour').show();
                $('#sliderfive').hide();            
            } else {                
                $('#sliderfour').hide();
            }    
        }
        
    });

    window.onorientationchange = function() {
        
        var browserMinWidthOrient = $(window).width();
    
        if ($('#slidertwo').is(':visible')) {
        
            if (browserMinWidthOrient > 770) {
                $('#sliderthree').hide();            
            } else {
                $('#sliderthree').show();
                $('#slidertwo').hide();
            }    
        }
        
        if ($('#sliderthree').is(':visible')) {
        
            if (browserMinWidthOrient > 770) {
                $('#slidertwo').show();
                $('#sliderthree').hide();            
            } else {                
                $('#slidertwo').hide();
            }    
        }
        
        if ($('#sliderfour').is(':visible')) {
        
            if (browserMinWidthOrient > 770) {
                $('#sliderfive').hide();            
            } else {                
                $('#sliderfive').show();
                $('#sliderfour').hide();
            }    
        }
        
        if ($('#sliderfive').is(':visible')) {
        
            if (browserMinWidthOrient > 770) {
                $('#sliderfour').show();
                $('#sliderfive').hide();            
            } else {                
                $('#sliderfour').hide();
            }    
        }

    };    
    
    ( jQuery );", yii\web\View::POS_END);

?>

<?= $this->render('_top') ?>
<?= $this->render('_shedule') ?>
<?= $this->render('_experts') ?>
<?= $this->render('_hackathon') ?>
<?= $this->render('_prize') ?>
<?= $this->render('_partners') ?>
<?= $this->render('_contacts') ?>
<?= $this->render('_regulations') ?>

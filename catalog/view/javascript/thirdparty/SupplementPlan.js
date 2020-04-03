$(document).ready(function(){
    var Sex='';
    var Age='';
    var Goal='';

    $("#Slide1").show();
    //$("#Slide2").hide();
    //$("#Slide3").hide();

    jQuery( "#Male" ).click(function() {
        Sex = 'male';
        animateSlide2();
        jQuery( "#Male" ).addClass('active');
        jQuery( ".step2" ).addClass('active');
    });
    
    jQuery( "#Female" ).click(function() {
        Sex = 'female';
        animateSlide2();
        jQuery( "#Female" ).addClass('active');
        jQuery( ".step2" ).addClass('active');
    });

    jQuery( "#Under21M" ).click(function() {
        Age='U21';
        animateSlide3();
        jQuery( ".under21" ).addClass('active');
        jQuery( ".step3" ).addClass('active');
    });

    jQuery( "#Under21F" ).click(function() {
        Age='U21';
        animateSlide3();
        jQuery( ".under21" ).addClass('active');
        jQuery( ".step3" ).addClass('active');
    });

    jQuery( "#Over21M" ).click(function() {
        Age='O21';
        animateSlide3();
        jQuery( ".over21" ).addClass('active');
        jQuery( ".step3" ).addClass('active');
    });

    jQuery( "#Over21F" ).click(function() {
        Age='O21';
        animateSlide3();
        jQuery( ".over21" ).addClass('active');
        jQuery( ".step3" ).addClass('active');
    });

    jQuery( "#FatLossM" ).click(function() {
        Goal='FL';
        jQuery( ".fatLoss" ).addClass('active');
        calculatePlan();
    });

    jQuery( "#FatLossF" ).click(function() {
        Goal='FL';
        jQuery( ".fatLoss" ).addClass('active');
        calculatePlan();
    });

    jQuery( "#MuscleBuildingM" ).click(function() {
        Goal='MB';
        jQuery( ".muscleBuilding" ).addClass('active');
        calculatePlan();
    });

    jQuery( "#MuscleBuildingF" ).click(function() {
        Goal='MB';
        jQuery( ".muscleBuilding" ).addClass('active');
        calculatePlan();
    });

    jQuery( "#PerformanceM" ).click(function() {
        Goal='PF';
        jQuery( ".performance" ).addClass('active');
        calculatePlan();
    });

    jQuery( "#PerformanceF" ).click(function() {
        Goal='PF';
        jQuery( ".performance" ).addClass('active');
        calculatePlan();
    });

    jQuery( "#step1" ).click(function() {
        animateSlide1();
    });

    jQuery( "#step2" ).click(function() {
        animateSlide2();
    });

    jQuery( "#step3" ).click(function() {
        animateSlide3();
    });

    function animateSlide1() {
        removeActiveStep();
        removeActiveGender();
        removeActiveStep();
        jQuery( "#Slide2, #Slide3, #Slide2 ."+Sex+", #Slide3 ."+Sex ).animate({height: "0px"}, 300);
        jQuery( "#Slide1" ).animate({height: "215px"}, 300);
        jQuery( "#step1" ).addClass("active");
    }

    function animateSlide2() {
        if (Sex!=''){
            removeActiveStep();
            removeActiveGender();
            removeActiveStep();
            jQuery( "#Slide1, #Slide3, #Slide3 ."+Sex ).animate({height: "0px"}, 300);
            jQuery("#Slide2").animate({height: "215px"}, 300);
            jQuery("#Slide2 ."+Sex).animate({height: "130px"}, 300);
            jQuery( "#step1" ).addClass("active");
            jQuery( "#step2" ).addClass("active");
        }
    }
    
    function animateSlide3() {
        if (Age!=''){
            removeActiveStep();
            removeActiveGender();
            removeActiveStep();
            jQuery( "#Slide1, #Slide2, #Slide2 ."+Sex ).animate({height: "0px"}, 300);
            jQuery("#Slide3").animate({height: "215px"}, 300);
            jQuery("#Slide3 ."+Sex).animate({height: "130px"}, 300);
            jQuery( "#step1" ).addClass("active");
            jQuery( "#step2" ).addClass("active");
            jQuery( "#step3" ).addClass("active");
        }
    }

    function calculatePlan() {
        var catID = '/collections/stacks';
        if (Sex=='male' && Age=='U21' && Goal=='FL') { catID = '67'; }
        else if (Sex=='male' && Age=='U21' && Goal=='MB') { catID = '69'; }
        else if (Sex=='male' && Age=='U21' && Goal=='PF') { catID = '75'; }
        else if (Sex=='male' && Age=='O21' && Goal=='FL') { catID = '68'; }
        else if (Sex=='male' && Age=='O21' && Goal=='MB') { catID = '70'; }
        else if (Sex=='male' && Age=='O21' && Goal=='PF') { catID = '76'; }
        else if (Sex=='female' && Age=='U21' && Goal=='FL') { catID = '71'; }
        else if (Sex=='female' && Age=='U21' && Goal=='MB') { catID = '73'; }
        else if (Sex=='female' && Age=='U21' && Goal=='PF') { catID = '77'; }
        else if (Sex=='female' && Age=='O21' && Goal=='FL') { catID = '72'; }
        else if (Sex=='female' && Age=='O21' && Goal=='MB') { catID = '74'; }
        else if (Sex=='female' && Age=='O21' && Goal=='PF') { catID = '78'; }

        window.location = "index.php?route=product/category&path=" + catID;
    }

    function removeActiveGender() {
        jQuery( "#Male" ).removeClass('active');
        jQuery( "#Female" ).removeClass('active');
    }

    function removeActiveAge() {
        jQuery( ".under21" ).removeClass('active');
        jQuery( ".over21" ).removeClass('active');
    }

    function removeActiveGoal() {
        jQuery( ".fatLoss" ).removeClass('active');
        jQuery( ".muscleBuilding" ).removeClass('active');
        jQuery( ".performance" ).removeClass('active');
    }

    function removeActiveStep() {
        jQuery( "#step1" ).removeClass('active');
        jQuery( "#step2" ).removeClass('active');
        jQuery( "#step3" ).removeClass('active');
    }
});
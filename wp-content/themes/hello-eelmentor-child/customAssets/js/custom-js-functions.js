let $ = jQuery;
const alert = function(text, ico = false){if(ico){var img = '<img alt="warning" class="spuser_alert_img" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNTAgNTAiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUwIDUwOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8Y2lyY2xlIHN0eWxlPSJmaWxsOiMyNUFFODg7IiBjeD0iMjUiIGN5PSIyNSIgcj0iMjUiLz4NCjxwb2x5bGluZSBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojRkZGRkZGO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lY2FwOnJvdW5kO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiIHBvaW50cz0iDQoJMzgsMTUgMjIsMzMgMTIsMjUgIi8+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8L3N2Zz4NCg==" />';}else{var img = '<img alt="warning" class="spuser_alert_img" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNTEyIDUxMiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTEyIDUxMjsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPHBhdGggc3R5bGU9ImZpbGw6IzNCNDE0NTsiIGQ9Ik0zMjIuOTM5LDYyLjY0MmwxNzguNzM3LDMwOS41ODNDNTA4LjIzMSwzODMuNTc4LDUxMiwzOTYuNzQsNTEyLDQxMC43OTENCgljMCw0Mi42Ny0zNC41OTIsNzcuMjY0LTc3LjI2NCw3Ny4yNjRIMjU2TDE5NC4xODksMjU2TDI1NiwyMy45NDZDMjg0LjYyLDIzLjk0NiwzMDkuNTg3LDM5LjUxOSwzMjIuOTM5LDYyLjY0MnoiLz4NCjxwYXRoIHN0eWxlPSJmaWxsOiM1MjVBNjE7IiBkPSJNMTg5LjA2MSw2Mi42NDJMMTAuMzIzLDM3Mi4yMjVDMy43NjksMzgzLjU3OCwwLDM5Ni43NCwwLDQxMC43OTENCgljMCw0Mi42NywzNC41OTIsNzcuMjY0LDc3LjI2NCw3Ny4yNjRIMjU2VjIzLjk0NkMyMjcuMzgsMjMuOTQ2LDIwMi40MTMsMzkuNTE5LDE4OS4wNjEsNjIuNjQyeiIvPg0KPHBhdGggc3R5bGU9ImZpbGw6I0ZGQjc1MTsiIGQ9Ik00NzQuOTEzLDM4Ny42NzhMMjk2LjE3Nyw3OC4wOThjLTguMDU2LTEzLjk1OS0yMi44NDktMjIuNzY3LTM4Ljg0OC0yMy4yMmwxNTIuODY5LDQwMi4yNzVoMjQuNTM5DQoJYzI1LjU1OSwwLDQ2LjM1OC0yMC43OTgsNDYuMzU4LTQ2LjM1OEM0ODEuMDk1LDQwMi42NzcsNDc4Ljk1MiwzOTQuNjgzLDQ3NC45MTMsMzg3LjY3OHoiLz4NCjxwYXRoIHN0eWxlPSJmaWxsOiNGRkQ3NjQ7IiBkPSJNNDQ0Ljg1MywzODcuNjc4YzMuNDkyLDcuMDA1LDUuMzM2LDE0Ljk5OSw1LjMzNiwyMy4xMTdjMCwyNS41NTktMTcuOTM1LDQ2LjM1OC0zOS45OTIsNDYuMzU4DQoJSDc3LjI2NGMtMjUuNTU5LDAtNDYuMzU4LTIwLjc5OS00Ni4zNTgtNDYuMzU4YzAtOC4xMTgsMi4xNDMtMTYuMTEyLDYuMTgxLTIzLjExN2wxNzguNzM2LTMwOS41OA0KCWM4LjI4My0xNC4zNCwyMy42NzQtMjMuMjUxLDQwLjE3Ny0yMy4yNTFjMC40NDMsMCwwLjg4NiwwLjAxLDEuMzI5LDAuMDMxYzEzLjczMiwwLjUzNiwyNi40MTQsOS4zMjMsMzMuMzI2LDIzLjIyTDQ0NC44NTMsMzg3LjY3OHoNCgkiLz4NCjxwYXRoIHN0eWxlPSJmaWxsOiMzQjQxNDU7IiBkPSJNMjU2LDM1NC4xMzF2NTEuNTA5YzE0LjIyNywwLDI1Ljc1NS0xMS41MjgsMjUuNzU1LTI1Ljc1NQ0KCUMyODEuNzU1LDM2NS42NTksMjcwLjIyNywzNTQuMTMxLDI1NiwzNTQuMTMxeiIvPg0KPHBhdGggc3R5bGU9ImZpbGw6IzUyNUE2MTsiIGQ9Ik0yNTYsMzU0LjEzMWMyLjg0MywwLDUuMTUxLDExLjUyOCw1LjE1MSwyNS43NTVjMCwxNC4yMjctMi4zMDgsMjUuNzU1LTUuMTUxLDI1Ljc1NQ0KCWMtMTQuMjI3LDAtMjUuNzU1LTExLjUyOC0yNS43NTUtMjUuNzU1QzIzMC4yNDUsMzY1LjY1OSwyNDEuNzczLDM1NC4xMzEsMjU2LDM1NC4xMzF6Ii8+DQo8cGF0aCBzdHlsZT0iZmlsbDojM0I0MTQ1OyIgZD0iTTI1NiwxMzIuNjQ2VjMyMy4yM2MxNC4yMjcsMCwyNS43NTUtMTEuNTM4LDI1Ljc1NS0yNS43NTVWMTU4LjQwMQ0KCUMyODEuNzU1LDE0NC4xNzQsMjcwLjIyNywxMzIuNjQ2LDI1NiwxMzIuNjQ2eiIvPg0KPHBhdGggc3R5bGU9ImZpbGw6IzUyNUE2MTsiIGQ9Ik0yNTYsMTMyLjY0NmMyLjg0MywwLDUuMTUxLDExLjUyOCw1LjE1MSwyNS43NTV2MTM5LjA3NGMwLDE0LjIxNi0yLjMwOCwyNS43NTUtNS4xNTEsMjUuNzU1DQoJYy0xNC4yMjcsMC0yNS43NTUtMTEuNTM4LTI1Ljc1NS0yNS43NTVWMTU4LjQwMUMyMzAuMjQ1LDE0NC4xNzQsMjQxLjc3MywxMzIuNjQ2LDI1NiwxMzIuNjQ2eiIvPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPC9zdmc+DQo=" />';}var el = $("<div />",{class: 'spuser_alert'});el.append($("<div />",{ class: 'spuser_alert_cont' }).append( $("<a />",{href:"#", class: 'spuser_alert_close', text: "x"}).on("click", function(e) { e.preventDefault(); el.removeClass("show"); setTimeout(function(){ el.remove() }, 600); }) ).append( img  ).append( $("<p />",{class: 'spuser_alert_text', html: text}) ));$("body").append(el);setTimeout(function(){ el.addClass("show"); }, 100);return;}

function page_portal_TOP(){

    let foot = $(".foot_portal_TOP").outerHeight(true);

    let head = $(".head_portal_TOP").outerHeight(true);

    $(".unick_portal_pg_TOP").css({paddingBottom: foot});

    $(".content_portal_TOP").css({paddingTop: head});

}

function header_top_TOP(){

    let headHome = parseInt($("#the_unick_header_TOP").outerHeight(true));

    let headOthers = parseInt($("#the_unick_header_TOP_other").outerHeight(true));

    $('.point_head_home').css({paddingTop: headHome});

    if($(window).width() > 1024){

        headOthers += 75;

    } else if ($(window).width() < 768){

        headOthers += 25;

    } else if ($(window).width() < 1025){

        headOthers += 50;

    } 

    $('.first_section_for_head_TOP').css({paddingTop: headOthers});

}

function header_animate(){

    if($(window).scrollTop() > 0){

        $("#the_unick_header_TOP").addClass('active-head');

    }else{

        $("#the_unick_header_TOP").removeClass('active-head');

    }

}

function error_head_theme(){

    if($(".woocommerce-notices-wrapper").length && $(".woocommerce-notices-wrapper").children().length || $(".woocommerce-NoticeGroup-checkout") && $(".woocommerce-NoticeGroup-checkout").children().length){

        if(!$("body").hasClass('woocommerce-lost-password')){

            $(".woocommerce-notices-wrapper").addClass('head');

            $(".woocommerce-error").addClass('head');

            if($(window).width() > 1024){
                $(".secprin_thanks_pg_TOP, .secprin_regis_user_pg_TOP, .secprin_contentaccount_pg_TOP, .first_section_for_head_TOP").addClass('wc_notice');
            }

        }

    }

}

jQuery(document).ready(function($){

    $(".the_unick_very_loader_of_TOP").remove();

    $("body").on("click", ".info_banderas_select_header", function(e){

        $("div.info_banderas_select_header .other_langs").toggleClass('active');

        $("div.info_banderas_select_header .current_lang span i").toggleClass('active');

    }) 

    $(window).resize(function(){

        page_portal_TOP()

        header_top_TOP()

    });

    $(window).scroll(function(){

        header_animate()

    })

    $(".title_filter_toggle_TOP").click((e) => {
        
        e.preventDefault();

        let slct = $(e.target).parents('[tgglrslt]').attr('tgglrslt');

        if(!$(".content_column_filter_rslts_pg_TOP.last[tgglrslt='"+slct+"']").hasClass('active')){

            $(".content_column_filter_rslts_pg_TOP.last[tgglrslt='"+slct+"']").css({height: 'auto', transition: '.3s'});
            $(".content_column_filter_rslts_pg_TOP[tgglrslt='"+slct+"'] .title_filter_toggle_TOP").addClass('open');

        }else{

            $(".content_column_filter_rslts_pg_TOP.last[tgglrslt='"+slct+"']").css({height: '0px', transition: '.3s'});
            $(".content_column_filter_rslts_pg_TOP[tgglrslt='"+slct+"'] .title_filter_toggle_TOP").removeClass('open');

        }

        $(".content_column_filter_rslts_pg_TOP.last[tgglrslt='"+slct+"']").toggleClass('active');

    })

    $(".filters_in_home_checkbox_TOP .title_filter_home_TOP").click((e)=>{
        const current = $(".filters_in_home_checkbox_TOP .title_filter_home_TOP.open");
        const target =  $(e.target).parents('.title_filter_home_TOP'); 
        const ide = $(e.target).parents('.title_filter_home_TOP').attr('fillhm');

        if(current.length && current[0] == target[0]){
            $(".filters_in_home_checkbox_TOP .filter_content_home_TOP[fillhm='"+ide+"']").toggleClass('disable');
            $(".filters_in_home_checkbox_TOP .title_filter_home_TOP[fillhm='"+ide+"']").toggleClass('open');
            return;
        }

        $(".filters_in_home_checkbox_TOP .filter_content_home_TOP").addClass('disable');
        $(".filters_in_home_checkbox_TOP .title_filter_home_TOP").removeClass('open');


        $(".filters_in_home_checkbox_TOP .filter_content_home_TOP[fillhm='"+ide+"']").toggleClass('disable');
        $(".filters_in_home_checkbox_TOP .title_filter_home_TOP[fillhm='"+ide+"']").toggleClass('open');

        $(".filters_in_home_checkbox_TOP .filter_content_home_TOP[fillhm='"+ide+"']").toggleClass('to-disable');


        $(".filters_in_home_checkbox_TOP .filter_content_home_TOP[fillhm='"+ide+"']").removeClass('top');

        $(".filters_in_home_checkbox_TOP .filter_content_home_TOP[fillhm='"+ide+"']").removeClass('btm');

        if($(window).scrollTop() < 200){

            if((ide == 'act' || ide == 'reg') && $(window).width() < 768){

                $(".filters_in_home_checkbox_TOP .filter_content_home_TOP[fillhm='"+ide+"']").addClass('btm');

            }else{

                $(".filters_in_home_checkbox_TOP .filter_content_home_TOP[fillhm='"+ide+"']").addClass('top');

            }

        }else{

            $(".filters_in_home_checkbox_TOP .filter_content_home_TOP[fillhm='"+ide+"']").addClass('btm');

        }

    })

    $(".filters_in_home_checkbox_TOP .title_filter_home_TOP *, .filters_in_home_checkbox_TOP .filter_content_home_TOP *").addClass('not_disa');

    $(window).on('scroll', ()=>{

        if($(window).scrollTop() < 200){

            $(".filters_in_home_checkbox_TOP .filter_content_home_TOP").removeClass('btm');

            if(!$(".filters_in_home_checkbox_TOP .filter_content_home_TOP[fillhm='act']").hasClass('disable')) $(".filters_in_home_checkbox_TOP .filter_content_home_TOP[fillhm='act']").addClass('btm');

            $(".filters_in_home_checkbox_TOP .filter_content_home_TOP").addClass('top');

        }else{

            $(".filters_in_home_checkbox_TOP .filter_content_home_TOP").removeClass('top');

            $(".filters_in_home_checkbox_TOP .filter_content_home_TOP").addClass('btm');

        }

    })

    $(document).on('click', (e)=>{

        if(!$(e.target).hasClass('not_disa') && !$(e.target).hasClass('title_filter_home_TOP') && !$(e.target).hasClass('filter_content_home_TOP')){
            $(".filters_in_home_checkbox_TOP .filter_content_home_TOP").addClass('disable');
            if($(".filters_in_home_checkbox_TOP .title_filter_home_TOP.open").length) $(".filters_in_home_checkbox_TOP .title_filter_home_TOP").removeClass('open');
        }

    })

    $(document).on('click', ".toggle_filter_mbl_results", (e)=>{
        let slct = $(e.target).parents('[tgglmbl]').attr('tgglmbl');
        $(".toggle_filter_mbl_results_conten[tgglmbl='"+slct+"']").toggleClass('active');
        $(".toggle_filter_mbl_results[tgglmbl='"+slct+"']").toggleClass('open');
    })

    // $(".trggr_act_home").click((e)=>{

    //     e.preventDefault();

    //     let filter = $(e.target).parents('.trggr_act_home').attr('trgrcath');

    //     let urlBase = window.location.protocol + "//" + window.location.hostname + '/topcampamentos/actividades:'+filter;

    //     if(filter) window.location.href = urlBase;

    // })

    $(document).on('click', "[wis]", (e)=>{
        let elem = $(e.target).prop('tagName');
        let camp_id = '';
        let act = '';
        if(elem == 'svg' || elem == 'path'){
            camp_id = $(e.target).parents('[wis]').attr('wis');
            act = $(e.target).parents('[wis]').attr('isw');
        }else{
            if($(e.target).attr('wis')){
                camp_id = $(e.target).attr('wis');
                act = $(e.target).attr('isw');
            }else{
                camp_id = $(e.target).parents('[wis]').attr('wis');
                act = $(e.target).parents('[wis]').attr('isw');
            }
            
        }
        if(!camp_id && !act){
            alert('Lo sentimos, se ha producido un error al agregar el campamento a tu lista de deseos. Por favor, inténtalo de nuevo más tarde.');
            return;
        }
        if(!$("[wis='"+camp_id+"'] .wish_load_content").length){
            $("[wis='"+camp_id+"']").append(`<div class="wish_load_content">
                                                <div class="lds-dual-ring_top_wish"></div>
                                            </div>`);
        }
        $.ajax({
            type: "POST",
            url: ajax.url,
            dataType: 'json',
            action: "admin_panel",
            data: {
                action: "admin_panel",
                wishn: ajax.nonce,
                wishlist: 'wishTOP',
                camp_id: camp_id,
                act: act,
            },
            error: function(rsp){
                $("[wis='"+camp_id+"'] .wish_load_content").remove();
                alert("Estamos teniendo algunos problemas, por favor intentalo más tarde.");
            },
            success: function(rsp) {
                $("[wis='"+camp_id+"'] .wish_load_content").remove();
                if(rsp.r){
                    if(act == 'nadd'){
                        $("[wis='"+camp_id+"'] .heart_added").removeClass('disabled');
                        $("[wis='"+camp_id+"'] .heart_empty").addClass('disabled');
                        $("[wis='"+camp_id+"']").attr('isw', 'add');
                    }else{
                        $("[wis='"+camp_id+"'] .heart_empty").removeClass('disabled');
                        $("[wis='"+camp_id+"'] .heart_added").addClass('disabled');
                        $("[wis='"+camp_id+"']").attr('isw', 'nadd');
                    }
                    $(".container_wishlist_btn .content_wihslits_btn span.counter_wishlist_shrtcd_TOP").text(rsp.inx);
                }else{
                    alert(rsp.m);
                }
            }  
        })
    })

    $("body").on('click', '[tdlt]', (e)=>{
        let elem = $(e.target).prop('tagName');
        let camp_id = '';
        let act = 'add';
        if(elem == 'svg' || elem == 'path'){
            camp_id = $(e.target).parents('[tdlt]').attr('tdlt');
        }else{
            camp_id = $(e.target).attr('tdlt');
        }
        if(!camp_id){
            alert('Lo sentimos, se ha producido un error al eliminar el campamento a tu lista de deseos. Por favor, inténtalo de nuevo más tarde.');
            return;
        }
        if(!$("[tdlt='"+camp_id+"'] .wish_load_content").length){
            $("[tdlt='"+camp_id+"']").append(`<div class="wish_load_content oth">
                                                <div class="lds-dual-ring_top_wish"></div>
                                            </div>`);
        }
        $.ajax({
            type: "POST",
            url: ajax.url,
            dataType: 'json',
            action: "admin_panel",
            data: {
                action: "admin_panel",
                wishn: ajax.nonce,
                wishlist: 'wishTOP',
                camp_id: camp_id,
                act: act,
            },
            error: function(rsp){
                $("[tdlt='"+camp_id+"'] .wish_load_content.oth").remove();
                alert("Estamos teniendo algunos problemas, por favor intentalo más tarde.");
            },
            success: function(rsp) {
                $("[tdlt='"+camp_id+"'] .wish_load_content.oth").remove();
                if(rsp.r){
                    if(rsp.rl) window.location.reload();
                    $("[cmpdlt='"+camp_id+"']").remove();
                    $(".container_wishlist_btn .content_wihslits_btn span.counter_wishlist_shrtcd_TOP").text(rsp.inx);
                }else{
                    alert(rsp.m);
                }
            }
        })
    })

    $("body").on('click', '.share_the_camp_btn_TOP', (e)=>{
        e.preventDefault();
        let succes_msg = `<div class="container_succes_clipboard">
                            <span class="message_clipboard">
                                ¡Enlace copiado al portapapeles!
                            </span>
                        </div>`;
        $("body").append(succes_msg);
        let currentUrl = window.location.href;
        let tempInput = $("<input>");
        $("body").append(tempInput);
        tempInput.val(currentUrl).select();
        document.execCommand("copy");
        tempInput.remove();
        setTimeout(()=>{
            $(".container_succes_clipboard").remove();
        }, 750);
    })

    if($(".jet-woo-builder-woocommerce-thankyou")){
        $(".woocommerce > .woocommerce-info").hide();
    }

    $("body").on('change', ".filters_in_home_checkbox_TOP input[type='checkbox']", (e)=>{
        let input = $(e.target);
        let filterContainer = input.parents('[fillhm]');
        let find = filterContainer.attr('fillhm');
        const lengths = {
            act: 9,
            reg: 6,
            lang: 6,
            temp: 9,
            dur: 8,
            age: 6,
        };
        const labels = {
            act: 'Actividad',
            reg: 'Región',
            lang: 'Idioma',
            temp: 'Temporada',
            dur: 'Duración',
            age: 'Edades',
        };
        let baseText = lengths[find];
        let baseLabel = labels[find];
        let baseElem = $(".title_filter_home_TOP[fillhm='"+find+"'] .elementor-heading-title");
        if(input.is(":checked")){
            let valText = input.val();
            if(valText.length > baseText){
                if($(window).width() < 768){
                    if(valText.length > 17){
                        valText = valText.substring(0, 14) + '...';
                    }
                }else{
                    valText = valText.substring(0, (baseText - 3)) + '...';
                }
                baseElem.text(valText);
            }else{
                baseElem.text(valText);
            }
        }else{
            let checks = filterContainer.find(':checkbox:checked');
            if(checks.length){  
                let mText = baseElem.text().substring(0, baseElem.text().length - 3);
                if(input.val().includes(mText)){
                    let value = checks[(checks.length - 1)];
                    value = value.value;
                    if(value.length > baseText){
                        if($(window).width() < 768){
                            if(value.length > 17){
                                value = value.substring(0, 14) + '...';
                            }
                        }else{
                            value = value.substring(0, (baseText - 3)) + '...';
                        }
                        baseElem.text(value);
                    }else{
                        baseElem.text(value);
                    }
                }
            }else{
                baseElem.text(baseLabel)
            }
            
        }
    })

    if($(".diplay_name_company_camp.toPageAuthors").length){
        let attrAuthor = $(".diplay_name_company_camp.toPageAuthors").attr('athr');
        if(attrAuthor){
            let iconToInsert = `<div class="overlay_profile_icon_toggle" title="Ver más campamentos de esta empresa" athr="${attrAuthor}" ><svg version="1.0" xmlns="http://www.w3.org/2000/svg"
            width="512.000000pt" height="512.000000pt" viewBox="0 0 512.000000 512.000000"
            preserveAspectRatio="xMidYMid meet">

            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
            stroke="none">
            <path d="M1976 5110 c-307 -39 -578 -167 -795 -375 -200 -192 -323 -403 -393
            -673 -64 -249 -42 -668 39 -732 50 -39 139 -18 163 40 11 27 10 46 -5 123 -97
            507 123 997 564 1257 198 116 461 173 688 151 494 -50 902 -391 1028 -861 47
            -177 53 -395 15 -555 -5 -22 -10 -57 -10 -78 0 -87 104 -129 171 -69 26 23 34
            42 50 117 11 50 22 149 25 220 19 386 -127 759 -405 1035 -260 259 -573 394
            -935 405 -72 2 -162 0 -200 -5z"/>
            <path d="M1955 4565 c-409 -90 -699 -468 -672 -879 6 -94 20 -132 58 -152 47
            -24 87 -18 125 20 l33 33 -1 119 c-1 142 15 214 75 329 57 111 154 206 268
            263 107 53 181 72 290 72 299 0 549 -194 624 -485 9 -36 15 -103 15 -173 l0
            -114 34 -34 c47 -47 95 -47 140 -1 29 28 34 41 40 103 4 39 2 110 -4 158 -45
            360 -293 644 -638 732 -109 28 -284 32 -387 9z"/>
            <path d="M2015 4037 c-103 -35 -203 -111 -251 -193 -56 -96 -59 -134 -57 -787
            1 -329 -1 -597 -5 -595 -4 2 -35 18 -70 36 -182 95 -374 75 -487 -50 -78 -87
            -77 -72 -72 -710 4 -615 3 -599 68 -794 92 -281 286 -535 534 -704 147 -99
            312 -170 503 -213 93 -21 118 -22 592 -22 482 0 498 1 599 23 234 53 392 126
            576 268 288 222 479 558 525 926 6 47 10 296 10 573 0 534 -2 561 -57 655 -41
            70 -116 138 -191 173 -56 26 -82 32 -157 35 -86 4 -132 -5 -216 -42 -13 -6
            -19 2 -28 40 -37 145 -147 263 -290 309 -80 26 -217 18 -295 -18 -32 -15 -60
            -27 -62 -27 -2 0 -15 21 -28 48 -98 194 -332 281 -535 199 l-61 -25 0 267 c0
            298 -7 346 -63 440 -41 68 -103 123 -185 163 -58 29 -77 33 -161 35 -60 2
            -111 -2 -136 -10z m176 -208 c50 -16 105 -61 132 -112 l22 -42 5 -845 c3 -465
            9 -852 13 -861 5 -9 23 -24 41 -34 42 -23 94 -14 127 21 l24 26 5 426 5 427
            28 47 c47 81 141 120 234 97 65 -17 135 -87 151 -151 8 -32 12 -171 12 -437 0
            -266 4 -398 11 -415 28 -60 122 -71 170 -20 l24 26 5 321 c5 351 6 352 67 408
            43 41 87 59 143 59 88 0 152 -38 193 -115 21 -38 22 -57 27 -355 3 -173 9
            -322 13 -331 5 -9 23 -24 41 -34 42 -23 94 -14 127 21 23 24 24 34 29 187 6
            175 12 198 67 248 45 42 87 59 148 59 98 0 181 -63 204 -156 14 -55 15 -892 1
            -1024 -27 -257 -137 -498 -313 -686 -186 -199 -454 -332 -732 -364 -117 -13
            -764 -13 -880 0 -268 31 -489 133 -680 313 -181 170 -288 354 -348 597 -19 79
            -21 120 -24 610 -3 413 -1 530 9 550 45 86 202 71 311 -29 91 -84 107 -172
            107 -613 0 -190 4 -295 11 -312 28 -60 122 -71 170 -20 l24 26 5 1176 5 1177
            23 38 c55 88 147 124 243 96z"/>
            </g>
            </svg></div>`;
            $(".profile_imgsinglecamp_TOP").append(iconToInsert);
        }

        $("body").on('click', '.diplay_name_company_camp.toPageAuthors, .overlay_profile_icon_toggle', function(e){
            e.preventDefault();
            let subattrAuthor = $(this).attr('athr');
            if(subattrAuthor){
                let urlToSend = window.location.href += `/campamentos-de-empresas/?topBsnss=${subattrAuthor}`;
                window.location.href = urlToSend;
            }
        });
    }

    setTimeout(()=>{
        if($(".woocommerce-notices-wrapper").length){
            console.log('hey si existe mor')
            let heightToTeikInToAccount = 0;
            if($("#the_unick_header_TOP_other").length) heightToTeikInToAccount = $("#the_unick_header_TOP_other").outerHeight(true);
            if($(window).width() > 1024){
                $(".woocommerce-notices-wrapper").css({
                    'margin-top': `calc(48px + ${heightToTeikInToAccount}px)`,
                });
            }else{
                $(".woocommerce-notices-wrapper").css({
                    'margin-top': `calc(32px + ${heightToTeikInToAccount}px)`,
                });
            }
        }
    }, 250);

    page_portal_TOP()
    header_top_TOP()
    header_animate()
    error_head_theme()

})
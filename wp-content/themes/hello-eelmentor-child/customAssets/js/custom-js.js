const ready_data_booking_TOP = function(){
    if(Object.keys(ajax.cluecamp_book).length){
        let cluedata = ajax.cluecamp_book;
        let newCluedata = [];
        $.each(cluedata, (k,v) => {
            if(newCluedata.indexOf(v.edades)){
                $(".body_content_form_book select.age_clue_fich").append(`<option keyclue="${k}" value="${v.edades}">${v.edades}</option>`);
                newCluedata.push(v.edades);
            }else{
                $(".body_content_form_book").append(`<input type="hidden" class="rango_keyspr" value="${k}">`);
            }
            $(".body_content_form_book select.dates_clue_fich").append(`<option class="dates_clue" keyclue="${k}" value="${v.fecha_inicio} - ${v.fechas_final}">${v.fecha_inicio} - ${v.fechas_final}</option>`);
        })
    }else if(ajax.sms){
        let msg = `<div class="msg_rr_camps_TOP">
                    <span>¡Oops! Este campamento aún no tiene fechas ni plazas disponibles para reservar.</span>
                </div>`;
        $(".container_form_booking_fich_TOP .body_content_form_book").append(msg);
    }else{
        let msg = `<div class="msg_rr_contain">
                        <div class="msg_rr_camps_TOP_glbl">
                            <span>Ha ocurrido un error al obtener la información del campamento, por favor regrese más tarde.</span>
                            <button class="cls_msg_rr">Aceptar</button>
                        </div>
                    </div>`;
        $("body").append(msg)
    }
}

const booking_changedata_TOP = function(elem){
    const contendor = elem.parents(".container_form_booking_fich_TOP");
    if(elem.hasClass('age_clue_fich')){
        if(Object.keys(ajax.cluecamp_book).length){
            let cluedata = ajax.cluecamp_book;
            let keyclue = elem.find('option:selected').attr('keyclue');
            let maxinput = ajax.cluecamp_book[keyclue]['plazas_num'] - ajax.plazas_disp[keyclue];
            contendor.find(".plaz_num_descont").attr('max', maxinput);
            contendor.find(".reserve_booking_in_fich").removeClass('active');
            contendor.find(".plaz_num_descont").val(1);
            contendor.find(".agroup_cluecamp_fich_impo").removeClass('active');
            contendor.find(".plaz_num_descont").prop('disabled', true);
            contendor.find(".dates_clue_fich .base").prop('selected', true);
            if(contendor.find(".agroup_cluecamp_fich").hasClass('active')) contendor.find(".agroup_cluecamp_fich").removeClass('active')
            contendor.find(".dates_clue_fich option.dates_clue").remove();
            contendor.find(".agroup_cluecamp_fich .mttdt_book").remove();
            contendor.find(".dates_clue_fich").removeAttr('disabled');
            let other_keys = [];
            $(".body_content_form_book input.rango_keyspr").each((k,v)=>{
                let newKey = $(v).val();
                let edad1 = cluedata[keyclue].edades;
                let edad2 = cluedata[newKey].edades;
                if(edad1 == edad2) other_keys.push(newKey);
            })
            $.each(cluedata, (k,v) => {
                if(keyclue == k || other_keys.includes(k)){
                    contendor.find("select.dates_clue_fich").append(`<option class="dates_clue" keyclue="${k}" value="${v.fecha_inicio} - ${v.fechas_final}">${v.fecha_inicio} - ${v.fechas_final}</option>`);
                } 
            })
        }else if(ajax.sms){
            let msg = `<div class="msg_rr_camps_TOP">
                        <span>¡Oops! Este campamento aún no tiene fechas ni plazas disponibles para reservar.</span>
                    </div>`;
            $(".container_form_booking_fich_TOP .body_content_form_book").append(msg);
        }else{
            let msg = `<div class="msg_rr_contain">
                        <div class="msg_rr_camps_TOP_glbl">
                            <span>Ha ocurrido un error al obtener la información del campamento, por favor regrese más tarde.</span>
                            <button class="cls_msg_rr">Aceptar</button>
                        </div>
                    </div>`;
            $("body").append(msg)
        }
    }else if(elem.hasClass('dates_clue_fich') && elem.val().length){
        let keySelect = elem.find('option:selected').attr('keyclue');
        let theData = ajax.cluecamp_book[keySelect];
        let comi_book = (ajax.comi.length) ? ajax.comi : 15;
        let maxinput = theData.plazas_num - ajax.plazas_disp[keySelect];
        contendor.find(".plaz_num_descont").attr('max', maxinput);
        contendor.find(".agroup_cluecamp_fich .mttdt_book").remove();
        contendor.find(".plaz_num_descont").val(1);
        contendor.find(".agroup_cluecamp_fich_impo span p").text(`${theData.precio}`);
        contendor.find(".agroup_cluecamp_fich_impo span.price__total_percent p").text(`${((theData.precio / 100)*comi_book).toFixed(2)}`);
        contendor.find(".agroup_cluecamp_fich_impo span.price_unitary p").text(`${theData.precio}`);
        contendor.find(".agroup_cluecamp_fich .tmp").append(`<p class="mttdt_book">${theData['mes-temporada']}</p>`);
        contendor.find(".agroup_cluecamp_fich .drc").append(`<p class="mttdt_book">${theData.duracion}</p>`);
        contendor.find(".agroup_cluecamp_fich .fch").append(`<p class="mttdt_book">${theData.fecha_inicio} | ${theData.fechas_final}</p>`);
        contendor.find(".agroup_cluecamp_fich .plz span:first-child p").text(theData.plazas_num);
        contendor.find(".agroup_cluecamp_fich .plz span:last-child p").text(theData.plazas_num - ajax.plazas_disp[keySelect]);
        if(!contendor.find(".agroup_cluecamp_fich").hasClass('active')) contendor.find(".agroup_cluecamp_fich").addClass('active')
        contendor.find(".plaz_num_descont").removeAttr('disabled');
        contendor.find(".agroup_cluecamp_fich_impo").addClass('active');
        contendor.find(".agroup_cluecamp_fich").addClass('active');
        contendor.find(".reserve_booking_in_fich").addClass('active');
    }else if(elem.hasClass('plaz_num_descont')){
        if(Object.keys(ajax.cluecamp_book).length){
            let key_clue_disp = contendor.find(".dates_clue_fich option:selected").attr('keyclue');
            let dtclue = ajax.cluecamp_book;
            let comi_book = (ajax.comi.length) ? ajax.comi : 15;
            let price = parseInt(elem.val()) * dtclue[key_clue_disp]['precio'];
            contendor.find(".agroup_cluecamp_fich_impo span.price__total p").text(price);
            contendor.find(".agroup_cluecamp_fich_impo span.price__total_percent p").text(((price / 100)*comi_book).toFixed(2));
        }else if(ajax.sms){
            let msg = `<div class="msg_rr_camps_TOP">
                        <span>¡Oops! Este campamento aún no tiene fechas ni plazas disponibles para reservar.</span>
                    </div>`;
            $(".container_form_booking_fich_TOP .body_content_form_book").append(msg);
        }else{
            let msg = `<div class="msg_rr_contain">
                        <div class="msg_rr_camps_TOP_glbl">
                            <span>Ha ocurrido un error al obtener la información del campamento, por favor regrese más tarde.</span>
                            <button class="cls_msg_rr">Aceptar</button>
                        </div>
                    </div>`;
            $("body").append(msg)
        }
    }
}

const book_rsrv_btn_act_TOP = function(elem){
    const contenedor = elem.parents('.container_form_booking_fich_TOP');
    if(!$(".loader_booking-un").length){
        contenedor.find(".body_content_form_book").append(`<div class="loader_booking-un"><div class="lds-dual-ring"></div></div>`);
    }
    if(contenedor.find(".age_clue_fich").val() && contenedor.find(".dates_clue_fich").val() && contenedor.find(".plaz_num_descont").val().length){
        let key_clue_disp = contenedor.find(".dates_clue_fich option:selected").attr('keyclue');
        if(Object.keys(ajax.cluecamp_book).length){
            if((parseInt(ajax.cluecamp_book[key_clue_disp]['plazas_num']) - parseInt(ajax.plazas_disp[key_clue_disp])) >= parseInt(contenedor.find(".plaz_num_descont").val())){
               let cant = parseInt(contenedor.find(".plaz_num_descont").val());
                $.ajax({
                    type: "POST",
                    url: ajax.url,
                    dataType: 'json',
                    action: "admin_panel",
                    data: {
                        action: "admin_panel",
                        book: ajax.nonce,
                        getdata_book: 8,
                        clueid: key_clue_disp,
                        cant: cant,
                        post_id: $(".booking_id_post_top").val(),
                    },
                    error: function(rsp){
                        $(".body_content_form_book .loader_booking-un").remove();
                        alert("Error en el servidor, intente más tarde");
                    },
                    success: function(rsp) {
                        if(rsp.r){
                            window.location.href = rsp.u;                                
                        }else{
                            $(".body_content_form_book .loader_booking-un").remove();
                        }
                    }
                })
            }else{
                $(".body_content_form_book .loader_booking-un").remove();
                alert(`No hay disponiblidad para las ${$(".container_form_booking_fich_TOP .plaz_num_descont").val()} plazas que quieres`);
            }
        }else if(ajax.sms){
            let msg = `<div class="msg_rr_camps_TOP">
                        <span>¡Oops! Este campamento aún no tiene fechas ni plazas disponibles para reservar.</span>
                    </div>`;
            $(".container_form_booking_fich_TOP .body_content_form_book").append(msg);
        }else{
            $(".body_content_form_book .loader_booking-un").remove();
            let msg = `<div class="msg_rr_contain">
                        <div class="msg_rr_camps_TOP_glbl">
                            <span>Ha ocurrido un error al obtener la información del campamento, por favor regrese más tarde.</span>
                            <button class="cls_msg_rr">Aceptar</button>
                        </div>
                    </div>`;
            $("body").append(msg)
        }
    }else{
        //cambiar por la función de mensaje
        $(".body_content_form_book .loader_booking-un").remove();
        let msg = `<div class="msg_rr_contain">
                        <div class="msg_rr_camps_TOP_glbl">
                            <span>Ha ocurrido un error al obtener la información del campamento, por favor regrese más tarde.</span>
                            <button class="cls_msg_rr">Aceptar</button>
                        </div>
                    </div>`;
        $("body").append(msg)
    }
}

jQuery(document).ready(function($){

    $("body").on('change', ".container_form_booking_fich_TOP select", (e)=>{
        booking_changedata_TOP($(e.target));
    })

    $("body").on('keyup', '.container_form_booking_fich_TOP input', (e)=>{
        if(!$(e.target).val().length){
            $(e.target).val(1)
        }
        booking_changedata_TOP($(e.target));
    })

    $("body").on('input', '.container_form_booking_fich_TOP input', (e)=>{
        if(!$(e.target).val().length){
            $(e.target).val(1)
        }
        booking_changedata_TOP($(e.target));
    })

    $("body").on('click', ".container_form_booking_fich_TOP .reserve_booking_in_fich", (e)=>{
        if($(".container_form_booking_fich_TOP .reserve_booking_in_fich").hasClass('active')){
            book_rsrv_btn_act_TOP($(e.target))
        }
    })

    $("body").on('click', ".cls_msg_rr", ()=>{
        $(".msg_rr_contain").remove()
        let home_url = ajax.home_url;
        if(!home_url){
            home_url = window.location.protocol + "//" + window.location.hostname;
        }
        window.location.href = home_url;
    })

    ready_data_booking_TOP()

})
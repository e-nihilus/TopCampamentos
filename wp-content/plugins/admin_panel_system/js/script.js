let $ = jQuery;
$.fn.serializeObject = function() {var o = {};var a = this.serializeArray();$.each(a, function() {if (o[this.name]) {if (!o[this.name].push) {o[this.name] = [o[this.name]];}o[this.name].push(this.value || '');} else {o[this.name] = this.value || '';}});return o;};
const alert_confirm = function(text, fun){var img = '<img alt="warning" class="spuser_alert_img" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNTEyIDUxMiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTEyIDUxMjsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPHBhdGggc3R5bGU9ImZpbGw6IzNCNDE0NTsiIGQ9Ik0zMjIuOTM5LDYyLjY0MmwxNzguNzM3LDMwOS41ODNDNTA4LjIzMSwzODMuNTc4LDUxMiwzOTYuNzQsNTEyLDQxMC43OTENCgljMCw0Mi42Ny0zNC41OTIsNzcuMjY0LTc3LjI2NCw3Ny4yNjRIMjU2TDE5NC4xODksMjU2TDI1NiwyMy45NDZDMjg0LjYyLDIzLjk0NiwzMDkuNTg3LDM5LjUxOSwzMjIuOTM5LDYyLjY0MnoiLz4NCjxwYXRoIHN0eWxlPSJmaWxsOiM1MjVBNjE7IiBkPSJNMTg5LjA2MSw2Mi42NDJMMTAuMzIzLDM3Mi4yMjVDMy43NjksMzgzLjU3OCwwLDM5Ni43NCwwLDQxMC43OTENCgljMCw0Mi42NywzNC41OTIsNzcuMjY0LDc3LjI2NCw3Ny4yNjRIMjU2VjIzLjk0NkMyMjcuMzgsMjMuOTQ2LDIwMi40MTMsMzkuNTE5LDE4OS4wNjEsNjIuNjQyeiIvPg0KPHBhdGggc3R5bGU9ImZpbGw6I0ZGQjc1MTsiIGQ9Ik00NzQuOTEzLDM4Ny42NzhMMjk2LjE3Nyw3OC4wOThjLTguMDU2LTEzLjk1OS0yMi44NDktMjIuNzY3LTM4Ljg0OC0yMy4yMmwxNTIuODY5LDQwMi4yNzVoMjQuNTM5DQoJYzI1LjU1OSwwLDQ2LjM1OC0yMC43OTgsNDYuMzU4LTQ2LjM1OEM0ODEuMDk1LDQwMi42NzcsNDc4Ljk1MiwzOTQuNjgzLDQ3NC45MTMsMzg3LjY3OHoiLz4NCjxwYXRoIHN0eWxlPSJmaWxsOiNGRkQ3NjQ7IiBkPSJNNDQ0Ljg1MywzODcuNjc4YzMuNDkyLDcuMDA1LDUuMzM2LDE0Ljk5OSw1LjMzNiwyMy4xMTdjMCwyNS41NTktMTcuOTM1LDQ2LjM1OC0zOS45OTIsNDYuMzU4DQoJSDc3LjI2NGMtMjUuNTU5LDAtNDYuMzU4LTIwLjc5OS00Ni4zNTgtNDYuMzU4YzAtOC4xMTgsMi4xNDMtMTYuMTEyLDYuMTgxLTIzLjExN2wxNzguNzM2LTMwOS41OA0KCWM4LjI4My0xNC4zNCwyMy42NzQtMjMuMjUxLDQwLjE3Ny0yMy4yNTFjMC40NDMsMCwwLjg4NiwwLjAxLDEuMzI5LDAuMDMxYzEzLjczMiwwLjUzNiwyNi40MTQsOS4zMjMsMzMuMzI2LDIzLjIyTDQ0NC44NTMsMzg3LjY3OHoNCgkiLz4NCjxwYXRoIHN0eWxlPSJmaWxsOiMzQjQxNDU7IiBkPSJNMjU2LDM1NC4xMzF2NTEuNTA5YzE0LjIyNywwLDI1Ljc1NS0xMS41MjgsMjUuNzU1LTI1Ljc1NQ0KCUMyODEuNzU1LDM2NS42NTksMjcwLjIyNywzNTQuMTMxLDI1NiwzNTQuMTMxeiIvPg0KPHBhdGggc3R5bGU9ImZpbGw6IzUyNUE2MTsiIGQ9Ik0yNTYsMzU0LjEzMWMyLjg0MywwLDUuMTUxLDExLjUyOCw1LjE1MSwyNS43NTVjMCwxNC4yMjctMi4zMDgsMjUuNzU1LTUuMTUxLDI1Ljc1NQ0KCWMtMTQuMjI3LDAtMjUuNzU1LTExLjUyOC0yNS43NTUtMjUuNzU1QzIzMC4yNDUsMzY1LjY1OSwyNDEuNzczLDM1NC4xMzEsMjU2LDM1NC4xMzF6Ii8+DQo8cGF0aCBzdHlsZT0iZmlsbDojM0I0MTQ1OyIgZD0iTTI1NiwxMzIuNjQ2VjMyMy4yM2MxNC4yMjcsMCwyNS43NTUtMTEuNTM4LDI1Ljc1NS0yNS43NTVWMTU4LjQwMQ0KCUMyODEuNzU1LDE0NC4xNzQsMjcwLjIyNywxMzIuNjQ2LDI1NiwxMzIuNjQ2eiIvPg0KPHBhdGggc3R5bGU9ImZpbGw6IzUyNUE2MTsiIGQ9Ik0yNTYsMTMyLjY0NmMyLjg0MywwLDUuMTUxLDExLjUyOCw1LjE1MSwyNS43NTV2MTM5LjA3NGMwLDE0LjIxNi0yLjMwOCwyNS43NTUtNS4xNTEsMjUuNzU1DQoJYy0xNC4yMjcsMC0yNS43NTUtMTEuNTM4LTI1Ljc1NS0yNS43NTVWMTU4LjQwMUMyMzAuMjQ1LDE0NC4xNzQsMjQxLjc3MywxMzIuNjQ2LDI1NiwxMzIuNjQ2eiIvPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPC9zdmc+DQo=" />';var el = $("<div />",{class: 'spuser_alert'});el.append($("<div />",{ class: 'spuser_alert_cont' }).append($("<a />",{href:"#", class: 'spuser_alert_close', text: "x"}).on("click", function(e) { e.preventDefault(); el.removeClass("show"); setTimeout(function(){ el.remove() }, 600); })).append( img ).append( $("<p />",{class: 'spuser_alert_text', html: text}) ).append( $("<div />",{class: 'spuser_alert_btns'}).append($("<a />",{href:"#", class: 'spuser_alert_btn spuser_alert_accept', text: "Aceptar"}).on("click", function(e) { fun(); e.preventDefault(); el.removeClass("show"); setTimeout(function(){ el.remove() }, 600); })).append($("<a />",{href:"#", class: 'spuser_alert_btn spuser_alert_cancel', text: "Cancelar"}).on("click", function(e) { fun; e.preventDefault(); el.removeClass("show"); setTimeout(function(){ el.remove() }, 600); })) ));$("body").append(el);setTimeout(function(){ el.addClass("show"); }, 100);return;}
const alert = function(text, ico = false){if(ico){var img = '<img alt="warning" class="spuser_alert_img" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNTAgNTAiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUwIDUwOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8Y2lyY2xlIHN0eWxlPSJmaWxsOiMyNUFFODg7IiBjeD0iMjUiIGN5PSIyNSIgcj0iMjUiLz4NCjxwb2x5bGluZSBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojRkZGRkZGO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lY2FwOnJvdW5kO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiIHBvaW50cz0iDQoJMzgsMTUgMjIsMzMgMTIsMjUgIi8+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8L3N2Zz4NCg==" />';}else{var img = '<img alt="warning" class="spuser_alert_img" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNTEyIDUxMiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTEyIDUxMjsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPHBhdGggc3R5bGU9ImZpbGw6IzNCNDE0NTsiIGQ9Ik0zMjIuOTM5LDYyLjY0MmwxNzguNzM3LDMwOS41ODNDNTA4LjIzMSwzODMuNTc4LDUxMiwzOTYuNzQsNTEyLDQxMC43OTENCgljMCw0Mi42Ny0zNC41OTIsNzcuMjY0LTc3LjI2NCw3Ny4yNjRIMjU2TDE5NC4xODksMjU2TDI1NiwyMy45NDZDMjg0LjYyLDIzLjk0NiwzMDkuNTg3LDM5LjUxOSwzMjIuOTM5LDYyLjY0MnoiLz4NCjxwYXRoIHN0eWxlPSJmaWxsOiM1MjVBNjE7IiBkPSJNMTg5LjA2MSw2Mi42NDJMMTAuMzIzLDM3Mi4yMjVDMy43NjksMzgzLjU3OCwwLDM5Ni43NCwwLDQxMC43OTENCgljMCw0Mi42NywzNC41OTIsNzcuMjY0LDc3LjI2NCw3Ny4yNjRIMjU2VjIzLjk0NkMyMjcuMzgsMjMuOTQ2LDIwMi40MTMsMzkuNTE5LDE4OS4wNjEsNjIuNjQyeiIvPg0KPHBhdGggc3R5bGU9ImZpbGw6I0ZGQjc1MTsiIGQ9Ik00NzQuOTEzLDM4Ny42NzhMMjk2LjE3Nyw3OC4wOThjLTguMDU2LTEzLjk1OS0yMi44NDktMjIuNzY3LTM4Ljg0OC0yMy4yMmwxNTIuODY5LDQwMi4yNzVoMjQuNTM5DQoJYzI1LjU1OSwwLDQ2LjM1OC0yMC43OTgsNDYuMzU4LTQ2LjM1OEM0ODEuMDk1LDQwMi42NzcsNDc4Ljk1MiwzOTQuNjgzLDQ3NC45MTMsMzg3LjY3OHoiLz4NCjxwYXRoIHN0eWxlPSJmaWxsOiNGRkQ3NjQ7IiBkPSJNNDQ0Ljg1MywzODcuNjc4YzMuNDkyLDcuMDA1LDUuMzM2LDE0Ljk5OSw1LjMzNiwyMy4xMTdjMCwyNS41NTktMTcuOTM1LDQ2LjM1OC0zOS45OTIsNDYuMzU4DQoJSDc3LjI2NGMtMjUuNTU5LDAtNDYuMzU4LTIwLjc5OS00Ni4zNTgtNDYuMzU4YzAtOC4xMTgsMi4xNDMtMTYuMTEyLDYuMTgxLTIzLjExN2wxNzguNzM2LTMwOS41OA0KCWM4LjI4My0xNC4zNCwyMy42NzQtMjMuMjUxLDQwLjE3Ny0yMy4yNTFjMC40NDMsMCwwLjg4NiwwLjAxLDEuMzI5LDAuMDMxYzEzLjczMiwwLjUzNiwyNi40MTQsOS4zMjMsMzMuMzI2LDIzLjIyTDQ0NC44NTMsMzg3LjY3OHoNCgkiLz4NCjxwYXRoIHN0eWxlPSJmaWxsOiMzQjQxNDU7IiBkPSJNMjU2LDM1NC4xMzF2NTEuNTA5YzE0LjIyNywwLDI1Ljc1NS0xMS41MjgsMjUuNzU1LTI1Ljc1NQ0KCUMyODEuNzU1LDM2NS42NTksMjcwLjIyNywzNTQuMTMxLDI1NiwzNTQuMTMxeiIvPg0KPHBhdGggc3R5bGU9ImZpbGw6IzUyNUE2MTsiIGQ9Ik0yNTYsMzU0LjEzMWMyLjg0MywwLDUuMTUxLDExLjUyOCw1LjE1MSwyNS43NTVjMCwxNC4yMjctMi4zMDgsMjUuNzU1LTUuMTUxLDI1Ljc1NQ0KCWMtMTQuMjI3LDAtMjUuNzU1LTExLjUyOC0yNS43NTUtMjUuNzU1QzIzMC4yNDUsMzY1LjY1OSwyNDEuNzczLDM1NC4xMzEsMjU2LDM1NC4xMzF6Ii8+DQo8cGF0aCBzdHlsZT0iZmlsbDojM0I0MTQ1OyIgZD0iTTI1NiwxMzIuNjQ2VjMyMy4yM2MxNC4yMjcsMCwyNS43NTUtMTEuNTM4LDI1Ljc1NS0yNS43NTVWMTU4LjQwMQ0KCUMyODEuNzU1LDE0NC4xNzQsMjcwLjIyNywxMzIuNjQ2LDI1NiwxMzIuNjQ2eiIvPg0KPHBhdGggc3R5bGU9ImZpbGw6IzUyNUE2MTsiIGQ9Ik0yNTYsMTMyLjY0NmMyLjg0MywwLDUuMTUxLDExLjUyOCw1LjE1MSwyNS43NTV2MTM5LjA3NGMwLDE0LjIxNi0yLjMwOCwyNS43NTUtNS4xNTEsMjUuNzU1DQoJYy0xNC4yMjcsMC0yNS43NTUtMTEuNTM4LTI1Ljc1NS0yNS43NTVWMTU4LjQwMUMyMzAuMjQ1LDE0NC4xNzQsMjQxLjc3MywxMzIuNjQ2LDI1NiwxMzIuNjQ2eiIvPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPC9zdmc+DQo=" />';}var el = $("<div />",{class: 'spuser_alert'});el.append($("<div />",{ class: 'spuser_alert_cont' }).append( $("<a />",{href:"#", class: 'spuser_alert_close', text: "x"}).on("click", function(e) { e.preventDefault(); el.removeClass("show"); setTimeout(function(){ el.remove() }, 600); }) ).append( img  ).append( $("<p />",{class: 'spuser_alert_text', html: text}) ));$("body").append(el);setTimeout(function(){ el.addClass("show"); }, 100);return;}
const loading = function(text){var el = $("#spuser_loading");if(!el.length){el = $('<div class="spuser_modal" id="spuser_loading"><div class="spuser_modal_load"><p class="spuser_modal_load_title"><span id="load-msg">Cargando</span><span>.</span><span>.</span><span>.</span></p></div></div>')};el.find("#load-msg").text(text);$("body").append(el);el.fadeIn();}
const loading_end = function(time = 0){var el = $("#spuser_loading");if(el.length > 0){setTimeout(function(){el.fadeOut();setTimeout(function() { el.remove();}, 500);}, time);}}
const EUR =  function(_cant){return Number(_cant).toFixed(2).replace(".",",") + " €";};
const _data_sp = {"processing":"Procesando...","lengthMenu":"Mostrar _MENU_ registros","zeroRecords":"No se encontraron resultados","emptyTable":"Ningún dato disponible en esta tabla","infoEmpty":"Mostrando registros del 0 al 0 de un total de 0 registros","infoFiltered":"(filtrado de un total de _MAX_ registros)","search":"Buscar:","infoThousands":",","loadingRecords":"Cargando...","paginate":{"first":"Primero","last":"Último","next":"Siguiente","previous":"Anterior"},"aria":{"sortAscending":": Activar para ordenar la columna de manera ascendente","sortDescending":": Activar para ordenar la columna de manera descendente"},"buttons":{"copy":"Copiar","colvis":"Visibilidad","collection":"Colección","colvisRestore":"Restaurar visibilidad","copyKeys":"Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br /> <br /> Para cancelar, haga clic en este mensaje o presione escape.","copySuccess":{"1":"Copiada 1 fila al portapapeles","_":"Copiadas %ds fila al portapapeles"},"copyTitle":"Copiar al portapapeles","csv":"CSV","excel":"Excel","pageLength":{"-1":"Mostrar todas las filas","_":"Mostrar %d filas"},"pdf":"PDF","print":"Imprimir","renameState":"Cambiar nombre","updateState":"Actualizar","createState":"Crear Estado","removeAllStates":"Remover Estados","removeState":"Remover","savedStates":"Estados Guardados","stateRestore":"Estado %d"},"autoFill":{"cancel":"Cancelar","fill":"Rellene todas las celdas con <i>%d</i>","fillHorizontal":"Rellenar celdas horizontalmente","fillVertical":"Rellenar celdas verticalmentemente"},"decimal":",","searchBuilder":{"add":"Añadir condición","button":{"0":"Constructor de búsqueda","_":"Constructor de búsqueda (%d)"},"clearAll":"Borrar todo","condition":"Condición","conditions":{"date":{"after":"Despues","before":"Antes","between":"Entre","empty":"Vacío","equals":"Igual a","notBetween":"No entre","notEmpty":"No Vacio","not":"Diferente de"},"number":{"between":"Entre","empty":"Vacio","equals":"Igual a","gt":"Mayor a","gte":"Mayor o igual a","lt":"Menor que","lte":"Menor o igual que","notBetween":"No entre","notEmpty":"No vacío","not":"Diferente de"},"string":{"contains":"Contiene","empty":"Vacío","endsWith":"Termina en","equals":"Igual a","notEmpty":"No Vacio","startsWith":"Empieza con","not":"Diferente de","notContains":"No Contiene","notStarts":"No empieza con","notEnds":"No termina con"},"array":{"not":"Diferente de","equals":"Igual","empty":"Vacío","contains":"Contiene","notEmpty":"No Vacío","without":"Sin"}},"data":"Data","deleteTitle":"Eliminar regla de filtrado","leftTitle":"Criterios anulados","logicAnd":"Y","logicOr":"O","rightTitle":"Criterios de sangría","title":{"0":"Constructor de búsqueda","_":"Constructor de búsqueda (%d)"},"value":"Valor"},"searchPanes":{"clearMessage":"Borrar todo","collapse":{"0":"Paneles de búsqueda","_":"Paneles de búsqueda (%d)"},"count":"{total}","countFiltered":"{shown} ({total})","emptyPanes":"Sin paneles de búsqueda","loadMessage":"Cargando paneles de búsqueda","title":"Filtros Activos - %d","showMessage":"Mostrar Todo","collapseMessage":"Colapsar Todo"},"select":{"cells":{"1":"1 celda seleccionada","_":"%d celdas seleccionadas"},"columns":{"1":"1 columna seleccionada","_":"%d columnas seleccionadas"},"rows":{"1":"1 fila seleccionada","_":"%d filas seleccionadas"}},"thousands":".","datetime":{"previous":"Anterior","next":"Proximo","hours":"Horas","minutes":"Minutos","seconds":"Segundos","unknown":"-","amPm":["AM","PM"],"months":{"0":"Enero","1":"Febrero","2":"Marzo","3":"Abril","4":"Mayo","5":"Junio","6":"Julio","7":"Agosto","8":"Septiembre","9":"Octubre","10":"Noviembre","11":"Diciembre"},"weekdays":["Dom","Lun","Mar","Mie","Jue","Vie","Sab"]},"editor":{"close":"Cerrar","create":{"button":"Nuevo","title":"Crear Nuevo Registro","submit":"Crear"},"edit":{"button":"Editar","title":"Editar Registro","submit":"Actualizar"},"remove":{"button":"Eliminar","title":"Eliminar Registro","submit":"Eliminar","confirm":{"1":"¿Está seguro que desea eliminar 1 fila?","_":"¿Está seguro que desea eliminar %d filas?"}},"error":{"system":"Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\/a&gt;).</a>"},"multi":{"title":"Múltiples Valores","info":"Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.","restore":"Deshacer Cambios","noMulti":"Este registro puede ser editado individualmente, pero no como parte de un grupo."}},"info":"Mostrando _START_ a _END_ de _TOTAL_ registros","stateRestore":{"creationModal":{"button":"Crear","name":"Nombre:","order":"Clasificación","paging":"Paginación","search":"Busqueda","select":"Seleccionar","columns":{"search":"Búsqueda de Columna","visible":"Visibilidad de Columna"},"title":"Crear Nuevo Estado","toggleLabel":"Incluir:"},"emptyError":"El nombre no puede estar vacio","removeConfirm":"¿Seguro que quiere eliminar este %s?","removeError":"Error al eliminar el registro","removeJoiner":"y","removeSubmit":"Eliminar","renameButton":"Cambiar Nombre","renameLabel":"Nuevo nombre para %s","duplicateError":"Ya existe un Estado con este nombre.","emptyStates":"No hay Estados guardados","removeTitle":"Remover Estado","renameTitle":"Cambiar Nombre Estado"}};

const loader = function(element, id) {
	if(!id.length) return false;
	element.append(`<div loader="${id}" class="loader-unick_TOP">
						<div class="lds-dual-ring"></div>
					</div>`);
}

const loaderEnd = function(element, id) {
	if(!id.length) return false;
	element.find(`[loader="${id}"]`).remove();
}

const printMediaCurrentUser = function(k, v) {
	$(".overlay_custom_dropify .photos .content_photos").append(`
		<span class="container_image_current_user_adpnsy">
			<img src="${v.url}" alt="${(v.title) ? v.title : ''}" acgt="${v.id}">
			<i class="material-icons icon-menu close_media_current_user" dlt="${v.id}">delete</i>
		</span>
	`);
}

function move_save_progress_camps(){
	let save_progress = $(".data_topcampamento_ .save_form");
	let form = $(".data_topcampamento_");
	let widthForm = form.outerWidth(true);
	let height_btm = save_progress.outerHeight(true);
	form.css({paddingBottom: height_btm});
	save_progress.css({transition: '.35s', position: 'fixed', right: '0', bottom: '0', width: widthForm, height: height_btm, background: '#fff', zIndex: '10', boxShadow: '0 -7px 14px rgba(0,0,0,.085)'});
	let ww = $(window);
	if(form.length){
		let pBreak = form.offset().top + form.outerHeight(true);
		$(window).on('scroll', (e)=>{
			if((ww.scrollTop() + ww.height()) > pBreak){
				form.css({paddingBottom: '0'});
				save_progress.css({transition: '.35s', position: 'relative', right: '0', bottom: '0', width: widthForm, height: height_btm, background: '#fff', zIndex: '10', boxShadow: 'none'});
			}else if((ww.scrollTop() + ww.height()) < pBreak){
				form.css({paddingBottom: height_btm});
				save_progress.css({transition: '.35s', position: 'fixed', right: '0', bottom: '0', width: widthForm, height: height_btm, background: '#fff', zIndex: '10', boxShadow: '0 -7px 14px rgba(0,0,0,.085)'});
			}
		})
	}
}

const percentBar = function(){
	removeFieldsRequiredInfo();
	const completed = 31;
	let percent = 0;
	let percentKeysN = {
		'instalaciones[]': true,
		'foto': true,
		'camp_title': 7,
		'descripcion': 250,
		'actividades': true,
		'region': true,
		'idioma[]': true,
		'instalaciones-descripcion': 250,
		'actividades2[]': true,
		'detalles_seguros': 250,
		'detalles_menu': 250,
		'detalles_ubicacion': 250,
		'detalles_cancelacion': 250,
		'servicios_tipo_alojamiento': true,		
		'servicios_alojamiento': true,		
		'servicios_monitores': true,		
		'servicios_centro_salud': true,		
		'servicios_plazas': true,		
		'servicios_alimentacion': true,		
		'servicios_experiencia': true,		
		'servicios_area_privada': true,		
		'servicios_socorrista': true,		
		'servicios_enfermero': true,		
		'ubication_iframe': 1,		
	};

	$.each(percentKeysN, (k,v)=>{
		if(typeof v == 'boolean' && $("#data_topcampamento_ [name='"+k+"']").length && $("#data_topcampamento_ [name='"+k+"']").val()){
			if($("#data_topcampamento_ [name='"+k+"']").val().length){
				if((k == 'instalaciones[]' && $("#data_topcampamento_ [name='instalaciones[]']").length > 3) || k != 'instalaciones[]'){
					percent++
				}
			}
		}else if(typeof v == 'number' &&  $("#data_topcampamento_ [name='"+k+"']").length && $("#data_topcampamento_ [name='"+k+"']").val().length >= v){
			percent++
		}
	})

	$(".content_data_clue[cd='1']").find('input:not(.select-dropdown), select:not(.datepicker-select)').each((k,v)=>{
		if($(v).val()){
			percent++
		}
	})

	let numPercent = (percent / completed) * 100;
	numPercent = Math.floor(numPercent);
	let barPercent = $(".container_form_steps .data_topcampamento_ .save_form .progress_bar").outerWidth(true);
	barPercent = Math.floor((Math.round(barPercent) / 100) * numPercent);
	if(numPercent > 0){
		$(".container_form_steps .data_topcampamento_ .save_form .progress_bar").css({background: '#f30c0c59', transition: '.3s'})
		$(".container_form_steps .data_topcampamento_ .save_form .progress_bar .percent").css({color: '#f30c0c', background: '#f30c0c42', transition: '.3s'})
	}else{
		$(".container_form_steps .data_topcampamento_ .save_form .progress_bar").css({background: '#bbb', transition: '.3s'})
		$(".container_form_steps .data_topcampamento_ .save_form .progress_bar .percent").css({color: '#444', background: '#bbb', transition: '.3s'})
	}
	$(".container_form_steps .data_topcampamento_ .save_form .progress_bar .percent p").text(numPercent)
	$(".container_form_steps .data_topcampamento_ .save_form .progress_bar .unick_bar").css({width: barPercent})
	localStorage.setItem('campPercent', numPercent);
	if(numPercent == 100) $(".container_form_steps .data_topcampamento_ .save_form button:last-child").removeClass('no_publy');
	else if(numPercent < 100) $(".container_form_steps .data_topcampamento_ .save_form button:last-child").addClass('no_publy');
	if(!$(".no_publy").length && $(".container_show_reqflds").length) $(".container_show_reqflds").remove();
}

const instFalse = function(obj) {
	let deterIf = false;
	for (let prop in obj) {
	  if (obj[prop] === false) {
		deterIf = true;
		break;
	  } else if (typeof obj[prop] === "object") {
		deterIf = instFalse(obj[prop]);
		if (deterIf) {
		  break;
		}
	  }
	}
	return deterIf;
}

const print_medias = function(){
	const param = new URLSearchParams(window.location.search);
	if(param.has('edit_campamento')){
		if(!Object.values(foto).includes(false) && typeof foto.id !== 'undefined'){
			let imgs_dorpi = $(`<span class="content_dropify_custom_insert" iacgt="${foto['id']}">
				<img src="${foto['url']}" alt="${foto['title']}" acgt="${foto['id']}">
				<input class="hidden_photo" type="hidden" name="foto" value="${foto['id']}">
				<i class="material-icons icon-menu quit_dropify_custom portrait" iacgt="${foto['id']}">close</i>
				</span>`);
			$(".img_portada_camp[act='custom_dropify_ajax']").append(imgs_dorpi);
		}
		if(!instFalse(instalaciones)){
			let imgs_dorpi_not = '';
			let content_imgs_dropicustom = $('<div class="container_dropify_custom_insert"></div>');
			if(!$(".container_dropify_custom_insert").length) $(".instalaciones_media .media_slider_camps").append(content_imgs_dropicustom);
	
			$.each(instalaciones, (k,v) => {
				imgs_dorpi_not = $(`<span class="content_dropify_custom_insert" iacgt="${v['id']}">
					<img src="${v['url']}" alt="${v['title']}" acgt="${v['id']}">
					<input class="hidden_photo" type="hidden" name="instalaciones[]" value="${v['id']}">
					<i class="material-icons icon-menu quit_dropify_custom" iacgt="${v['id']}">close</i>
				</span>`);
				$(".container_dropify_custom_insert").append(imgs_dorpi_not);
			})
		}

		if(!Object.values(portada).includes(false) && typeof portada.id !== 'undefined'){
			let imgs_portada = $(`<span class="content_dropify_custom_insert" iacgt="${portada['id']}">
				<img src="${portada['url']}" alt="${portada['title']}" acgt="${portada['id']}">
				<input class="hidden_photo" type="hidden" name="portada_camp" value="${portada['id']}">
				<i class="material-icons icon-menu quit_dropify_custom portrait" iacgt="${portada['id']}">close</i>
				</span>`);
			$(".field_portada[act='custom_dropify_ajax']").append(imgs_portada);
		}

		if($(".container_dropify_custom_insert").length && !instalaciones.length) $(".container_dropify_custom_insert").remove();

	}
}

const dropiTextChange = function(elemen, text){
	if(!elemen.length && !text.length) return;
	$(elemen).text(text);
}

const showFieldsRequiredCamps = ()=>{
	if($(".no_publy").length){
		const elemToShowReqFlds = $(`<div class="container_show_reqflds">
				<div class="head">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M256 8C119 8 8 119.1 8 256c0 137 111 248 248 248s248-111 248-248C504 119.1 393 8 256 8zm0 110c23.2 0 42 18.8 42 42s-18.8 42-42 42-42-18.8-42-42 18.8-42 42-42zm56 254c0 6.6-5.4 12-12 12h-88c-6.6 0-12-5.4-12-12v-24c0-6.6 5.4-12 12-12h12v-64h-12c-6.6 0-12-5.4-12-12v-24c0-6.6 5.4-12 12-12h64c6.6 0 12 5.4 12 12v100h12c6.6 0 12 5.4 12 12v24z"/></svg>
					<span>Campos pendientes</span>
					<p></p>
				</div>
				<div class="body"></div>
			</div>`);
		$("body").append(elemToShowReqFlds);
		setTimeout(()=>{
			$(".container_show_reqflds").addClass('active');
		}, 5000);
	}
}

const notifyFieldsRequiredInfo = ()=>{
	let fieldsEmptyF = {
		'instalaciones[]': {
			v: true,
			msgs: 'Debes habilitar al menos 4 imágenes para el campo de instalaciones',
			slct: 'instalaciones[]',
		},
		'foto': {
			v: true,
			msgs: 'Debes insertar la foto principal del campamento',
			slct: 'foto',
		},
		'camp_title': {
			v: 7,
			msgs: 'El título de tu campamento debe tener al menos 7 caracteres',
			slct: '#title_u_camp',
		},
		'descripcion': {
			v: 250,
			msgs: 'La descripción de tu campamento debe tener al menos 250 caracteres',
			slct: `.top_format_text_coe[taid='desc_camp']`,
		},
		'actividades': {
			v: true,
			msgs: 'Debes seleccionar una temática para tu campamento',
			slct: `label[for='actividades']`,
		},
		'region': {
			v: true,
			msgs: 'Debes seleccionar una región para tu campamento',
			slct: `label[for='region']`,
		},
		'idioma[]': {
			v: true,
			msgs: 'Debes seleccionar al menos un idioma para tu campamento',
			slct: `label[for='idioma']`,
		},
		'instalaciones-descripcion': {
			v: 250,
			msgs: 'La descripción de las instalaciones de tu campamento debe tener al menos 250 caracteres',
			slct: `.top_format_text_coe[taid='desc_inst']`,
		},
		'actividades2[]': {
			v: true,
			msgs: 'Debes seleccionar al menos una actividad para tu campamento',
			slct: `label[for='actividades2']`,
		},
		'detalles_seguros': {
			v: 250,
			msgs: 'La descripción de los seguros de tu campamento debe tener al menos 250 caracteres',
			slct: `.top_format_text_coe[taid='det_seg']`,
		},
		'detalles_menu': {
			v: 250,
			msgs: 'La descripción del menú de tu campamento debe tener al menos 250 caracteres',
			slct: `.top_format_text_coe[taid='det_men']`,
		},
		'detalles_ubicacion': {
			v: 250,
			msgs: 'La descripción de la ubicación de tu campamento debe tener al menos 250 caracteres',
			slct: `.top_format_text_coe[taid='det_ubi']`,

		},
		'detalles_cancelacion': {
			v: 250,
			msgs: 'La descripción de tu campamento debe tener al menos 250 caracteres',
			slct: `.top_format_text_coe[taid='det_can']`,
		},
		'servicios_tipo_alojamiento': {
			v: true,
			msgs: 'Debes seleccionar el tipo de alojamiento de tu campamento',
			slct: `label[for='servicios_tipo_alojamiento']`,
		},		
		'servicios_alojamiento': {
			v: true,
			msgs: 'Debes seleccionar el alojamiento de tu campamento',
			slct: `label[for='servicios_alojamiento']`,
		},		
		'servicios_monitores': {
			v: true,
			msgs: 'Debes seleccionar la cantidad de monitores de tu campamento',
			slct: `label[for='servicios_monitores']`,
		},		
		'servicios_centro_salud': {
			v: true,
			msgs: 'Debes seleccionar la información del centro de salud más cercano de tu campamento',
			slct: `label[for='servicios_centro_salud']`,
		},		
		'servicios_plazas': {
			v: true,
			msgs: 'Debes seleccionar la información de plazas de tu campamento',
			slct: `label[for='servicios_plazas']`,
		},		
		'servicios_alimentacion': {
			v: true,
			msgs: 'Debes seleccionar el tipo de alimentación de tu campamento',
			slct: `label[for='servicios_alimentacion']`,
		},		
		'servicios_experiencia': {
			v: true,
			msgs: 'Debes seleccionar la experiencia de tu campamento',
			slct: `label[for='servicios_experiencia']`,
		},		
		'servicios_area_privada': {
			v: true,
			msgs: 'Debes seleccionar la información del área privada de tu campamento',
			slct: `label[for='servicios_area_privada']`,
		},		
		'servicios_socorrista': {
			v: true,
			msgs: 'Debes seleccionar si tu campamento tiene socorrista',
			slct: `label[for='servicios_socorrista']`,
		},		
		'servicios_enfermero': {
			v: true,
			msgs: 'Debes seleccionar si tu campamento tiene enfermero',
			slct: `label[for='servicios_enfermero']`,
		},		
		'ubication_iframe': {
			v: 1,
			msgs: 'Debes ingresar la dirección de tu campamento',
			slct: `[name='ubication_iframe']`,
		},		
	};
	let mesgsToPrint = [];
	$.each(fieldsEmptyF, (k,v)=>{
		if(typeof v.v == 'boolean'){
			if((k == 'instalaciones[]' && $("#data_topcampamento_ [name='instalaciones[]']").length < 4) || (k != 'instalaciones[]' && !$("#data_topcampamento_ [name='"+k+"']").val()) || (k != 'instalaciones[]' && !$("#data_topcampamento_ [name='"+k+"']").val().length)){
				mesgsToPrint.push({elemnt: v.slct, msgs: v.msgs});
			}
		}else if(typeof v.v == 'number' &&  $("#data_topcampamento_ [name='"+k+"']").length && $("#data_topcampamento_ [name='"+k+"']").val().length < v.v){
			mesgsToPrint.push({elemnt: v.slct, msgs: v.msgs});
		}
	});
	$(".content_data_clue[cd='1']").find('input:not(.select-dropdown), select:not(.datepicker-select)').each((k,v)=>{
		if(!$(v).val()){
			let typeDc = $(v).attr('name');
			if(typeDc.includes('fecha_inicio')){
				mesgsToPrint.push({elemnt: `.content_data_clue[cd='1'] .clues:nth-child(1)`, msgs: 'Debes ingresar la fecha en que inicia tu campamento'});
			}else if(typeDc.includes('fechas_final')){
				mesgsToPrint.push({elemnt: `.content_data_clue[cd='1'] .clues:nth-child(2)`, msgs: 'Debes ingresar la fecha en que culmina tu campamento'});
			}else if(typeDc.includes('precio')){
				mesgsToPrint.push({elemnt: `.content_data_clue[cd='1'] .clues:nth-child(3)`, msgs: 'Debes ingresar el precio de tu campamento'});
			}else if(typeDc.includes('mes-temporada')){
				mesgsToPrint.push({elemnt: `.content_data_clue[cd='1'] .clues:nth-child(4)`, msgs: 'Debes ingresar la temporada de tu campamento'});
			}else if(typeDc.includes('duracion')){
				mesgsToPrint.push({elemnt: `.content_data_clue[cd='1'] .clues:nth-child(5)`, msgs: 'Debes ingresar la duración de tu campamento'});
			}else if(typeDc.includes('edades')){
				mesgsToPrint.push({elemnt: `.content_data_clue[cd='1'] .clues:nth-child(6)`, msgs: 'Debes ingresar el rango de edad de tu campamento'});
			}else if(typeDc.includes('plazas_num')){
				mesgsToPrint.push({elemnt: `.content_data_clue[cd='1'] .clues:nth-child(7)`, msgs: 'Debes ingresar las plazas de tu campamento'});
			}
		}
	});
	let returnflds = '<div class="list_fields_requireds"><ul>';
	$.each(mesgsToPrint, (k,v)=>{
		let elemenScroll = '';
		if(v.elemnt == "instalaciones[]"){
			elemenScroll = '.media_slider_camps';
		}else if(v.elemnt == "foto"){
			elemenScroll = '.img_profile';
		}else{
			elemenScroll = `${v.elemnt}`;
		}
		returnflds += `<li scrl="${elemenScroll.trim()}"><span>${v.msgs}</span><div class="cnt">
		<svg version="1.0" xmlns="http://www.w3.org/2000/svg"
		width="512.000000pt" height="512.000000pt" viewBox="0 0 512.000000 512.000000"
		preserveAspectRatio="xMidYMid meet">
		<g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
		fill="#fff" stroke="none">
		<path d="M915 4529 c-181 -25 -381 -110 -522 -223 -488 -394 -524 -1116 -77
		-1560 105 -104 283 -216 344 -216 89 0 145 85 108 165 -11 24 -47 50 -151 109
		-111 63 -248 220 -308 352 -70 155 -93 363 -56 516 90 371 412 628 789 629
		148 0 237 -21 373 -89 153 -76 271 -194 360 -360 35 -64 71 -92 119 -92 62 0
		116 53 116 113 0 35 -71 170 -129 248 -105 138 -269 267 -419 330 -171 71
		-381 101 -547 78z"/>
		<path d="M3517 4170 c-128 -22 -262 -125 -318 -244 -17 -36 -33 -66 -36 -66
		-3 0 -17 9 -32 19 -109 78 -321 81 -452 7 -81 -46 -177 -160 -194 -228 -4 -16
		-9 -28 -12 -28 -2 0 -38 16 -80 36 -216 104 -486 12 -588 -201 -16 -33 -30
		-62 -32 -64 -2 -3 -108 99 -236 227 -257 255 -295 282 -427 301 -146 20 -275
		-25 -382 -133 -130 -131 -160 -331 -76 -506 28 -60 98 -133 847 -882 448 -450
		813 -818 809 -818 -16 0 -909 -142 -958 -152 -126 -26 -242 -100 -315 -201
		-85 -116 -121 -269 -91 -387 30 -116 117 -212 231 -251 55 -19 2391 -21 2501
		-2 194 34 404 123 554 234 91 67 412 377 546 527 128 144 211 279 269 440 155
		434 61 922 -244 1271 -102 118 -792 875 -864 949 -85 87 -152 128 -244 147
		-74 16 -104 17 -176 5z m185 -253 c40 -24 885 -948 975 -1065 190 -251 256
		-598 172 -903 -27 -97 -97 -244 -156 -328 -53 -75 -453 -484 -555 -567 -117
		-97 -265 -171 -415 -209 -127 -32 -304 -36 -1398 -33 -987 3 -1082 4 -1103 20
		-43 29 -56 58 -54 116 3 102 70 200 167 243 24 11 276 55 648 113 334 53 620
		102 636 111 39 20 63 82 51 126 -8 26 -228 253 -909 934 -964 965 -925 922
		-923 1023 0 60 39 130 90 166 54 38 149 48 203 21 19 -9 306 -289 639 -620
		640 -638 634 -633 705 -614 56 16 94 80 80 137 -4 17 -99 120 -265 287 -275
		276 -300 309 -300 395 0 146 155 250 288 194 24 -10 130 -107 302 -279 230
		-228 271 -264 304 -270 64 -12 131 32 136 90 6 58 -2 69 -148 219 -167 169
		-188 205 -180 299 8 102 88 178 194 185 88 6 125 -17 295 -184 144 -142 147
		-144 190 -144 51 0 83 18 105 62 23 44 12 90 -34 151 -46 61 -54 82 -54 147 2
		157 178 257 314 177z"/>
		</g>
		</svg></div>
		</li>`;
	});
	returnflds += '</ul></div>';
	$(".container_show_reqflds .body").empty();
	$(".container_show_reqflds .body").append(returnflds);
	$(".container_show_reqflds").addClass('focus');
}

const removeFieldsRequiredInfo = ()=>{
	let fieldsEmptyFn = {
		'instalaciones[]': {
			v: true,
			slct: '.media_slider_camps',
		},
		'foto': {
			v: true,
			slct: '.img_profile',
		},
		'camp_title': {
			v: 7,
			slct: '#title_u_camp',
		},
		'descripcion': {
			v: 250,
			slct: `.top_format_text_coe[taid='desc_camp']`,
		},
		'actividades': {
			v: true,
			slct: `label[for='actividades']`,
		},
		'region': {
			v: true,
			slct: `label[for='region']`,
		},
		'idioma[]': {
			v: true,
			slct: `label[for='idioma']`,
		},
		'instalaciones-descripcion': {
			v: 250,
			slct: `.top_format_text_coe[taid='desc_inst']`,
		},
		'actividades2[]': {
			v: true,
			slct: `label[for='actividades2']`,
		},
		'detalles_seguros': {
			v: 250,
			slct: `.top_format_text_coe[taid='det_seg']`,
		},
		'detalles_menu': {
			v: 250,
			slct: `.top_format_text_coe[taid='det_men']`,
		},
		'detalles_ubicacion': {
			v: 250,
			slct: `.top_format_text_coe[taid='det_ubi']`,

		},
		'detalles_cancelacion': {
			v: 250,
			slct: `.top_format_text_coe[taid='det_can']`,
		},
		'servicios_tipo_alojamiento': {
			v: true,
			slct: `label[for='servicios_tipo_alojamiento']`,
		},		
		'servicios_alojamiento': {
			v: true,
			slct: `label[for='servicios_alojamiento']`,
		},		
		'servicios_monitores': {
			v: true,
			slct: `label[for='servicios_monitores']`,
		},		
		'servicios_centro_salud': {
			v: true,
			slct: `label[for='servicios_centro_salud']`,
		},		
		'servicios_plazas': {
			v: true,
			slct: `label[for='servicios_plazas']`,
		},		
		'servicios_alimentacion': {
			v: true,
			slct: `label[for='servicios_alimentacion']`,
		},		
		'servicios_experiencia': {
			v: true,
			slct: `label[for='servicios_experiencia']`,
		},		
		'servicios_area_privada': {
			v: true,
			slct: `label[for='servicios_area_privada']`,
		},		
		'servicios_socorrista': {
			v: true,
			slct: `label[for='servicios_socorrista']`,
		},		
		'servicios_enfermero': {
			v: true,
			slct: `label[for='servicios_enfermero']`,
		},		
		'ubication_iframe': {
			v: 1,
			slct: `[name='ubication_iframe']`,
		},		
	};
	$.each(fieldsEmptyFn, (k,v)=>{
		if(typeof v.v == 'boolean'){
			if((k == 'instalaciones[]' && $("#data_topcampamento_ [name='instalaciones[]']").length >= 4) || (k != 'instalaciones[]' && $("#data_topcampamento_ [name='"+k+"']").val())){
				let lengthVal = $("#data_topcampamento_ [name='"+k+"']").val();
				if($(`.container_show_reqflds .body .list_fields_requireds ul li[scrl="${v.slct}"]`).length && lengthVal.length){
					$(`.container_show_reqflds .body .list_fields_requireds ul li[scrl="${v.slct}"]`).remove();
				} 
			}
		}else if(typeof v.v == 'number' &&  $("#data_topcampamento_ [name='"+k+"']").length && $("#data_topcampamento_ [name='"+k+"']").val().length >= v.v){
			if($(`.container_show_reqflds .body .list_fields_requireds ul li[scrl="${v.slct}"]`).length) $(`.container_show_reqflds .body .list_fields_requireds ul li[scrl="${v.slct}"]`).remove();
		}
	});
	$(".content_data_clue[cd='1']").find('input:not(.select-dropdown), select:not(.datepicker-select)').each((k,v)=>{
		if($(v).val()){
			let typeDc = $(v).attr('name');
			if(typeDc.includes('fecha_inicio')){
				if($(`.container_show_reqflds .body .list_fields_requireds ul li[scrl=".content_data_clue[cd='1'] .clues:nth-child(1)"]`).length) $(`.container_show_reqflds .body .list_fields_requireds ul li[scrl=".content_data_clue[cd='1'] .clues:nth-child(1)"]`).remove();
			}else if(typeDc.includes('fechas_final')){
				if($(`.container_show_reqflds .body .list_fields_requireds ul li[scrl=".content_data_clue[cd='1'] .clues:nth-child(2)"]`).length) $(`.container_show_reqflds .body .list_fields_requireds ul li[scrl=".content_data_clue[cd='1'] .clues:nth-child(2)"]`).remove();
			}else if(typeDc.includes('precio')){
				if($(`.container_show_reqflds .body .list_fields_requireds ul li[scrl=".content_data_clue[cd='1'] .clues:nth-child(3)"]`).length) $(`.container_show_reqflds .body .list_fields_requireds ul li[scrl=".content_data_clue[cd='1'] .clues:nth-child(3)"]`).remove();
			}else if(typeDc.includes('mes-temporada')){
				if($(`.container_show_reqflds .body .list_fields_requireds ul li[scrl=".content_data_clue[cd='1'] .clues:nth-child(4)"]`).length) $(`.container_show_reqflds .body .list_fields_requireds ul li[scrl=".content_data_clue[cd='1'] .clues:nth-child(4)"]`).remove();
			}else if(typeDc.includes('duracion')){
				if($(`.container_show_reqflds .body .list_fields_requireds ul li[scrl=".content_data_clue[cd='1'] .clues:nth-child(5)"]`).length) $(`.container_show_reqflds .body .list_fields_requireds ul li[scrl=".content_data_clue[cd='1'] .clues:nth-child(5)"]`).remove();
			}else if(typeDc.includes('edades')){
				if($(`.container_show_reqflds .body .list_fields_requireds ul li[scrl=".content_data_clue[cd='1'] .clues:nth-child(6)"]`).length) $(`.container_show_reqflds .body .list_fields_requireds ul li[scrl=".content_data_clue[cd='1'] .clues:nth-child(6)"]`).remove();
			}else if(typeDc.includes('plazas_num')){
				if($(`.container_show_reqflds .body .list_fields_requireds ul li[scrl=".content_data_clue[cd='1'] .clues:nth-child(7)"]`).length) $(`.container_show_reqflds .body .list_fields_requireds ul li[scrl=".content_data_clue[cd='1'] .clues:nth-child(7)"]`).remove();
			}
		}
	});
}

jQuery(document).ready( function($) {

	$(".login-form").on("submit", function(e){
		$(".exito-login").slideUp();
		if($("#username").val() == "" && $("#password").val() == ""){
			e.preventDefault();
			$(".error-login").html("Por favor ingrese su usuario y contraseña").slideDown().delay(2000).slideUp();
			return false;
		}
		if($("#username").val() == ""){
			e.preventDefault();
			$(".error-login").html("Por favor ingrese un usuario valido").slideDown().delay(2000).slideUp();
			return false;
		}
		if($("#password").val() == ""){
			e.preventDefault();
			$(".error-login").html("Por favor ingrese su contraseña").slideDown().delay(2000).slideUp();
			return false;
		}
	})

	$(".recovery-form").on("submit", function(e){
		$(".exito-login").slideUp();
		if($("#password-2").val() == "" && $("#password").val() == ""){
			e.preventDefault();
			$(".error-login").html("Por favor rellene todo los campos").slideDown().delay(2000).slideUp();
			return false;
		}
		if($("#password").val() != $("#password-2").val()){
			e.preventDefault();
			$(".error-login").html("Contraseñas no coinciden").slideDown().delay(2000).slideUp();
			return false;
		}
	})

	$("#user_select").change(function(e){
		if($("#oper_dates").length ){
			if($("#_user").length && $(this).val()){
				$("#_user").val($(this).val());
			}else if($("#_user").length && !$(this).val()){
				$("#_user").remove();
			}else if(!$("#_user").length && $(this).val()){
				$("#oper_dates").prepend("<input type='hidden' name='u' value='"+$(this).val()+"' />");
			}
			$("#oper_dates").submit()
		}else if($(this).val()){
			window.location.href = window.location.origin + window.location.pathname + "?u=" + $(this).val();
		}else{
			window.location.href = window.location.origin + window.location.pathname;
		}
		
	})

	$("#panel_user_search").click(function(e){
		$(".fond-charge").fadeIn();
	})

	$(".change_user").click(function(e){
		$(".modal-user").fadeIn();
	})

	$(".modal-user-cont span").click(function(e){
		$(".modal-user").fadeOut();
	})

	$(".register-form").on("submit", function(e){
		$(".exito-login").slideUp();
		if($("#password2").val() == "" || $("#password").val() == "" || $("#username").val() == ""){
			e.preventDefault();
			$(".error-login").html("Por favor rellene todo los campos").slideDown().delay(2000).slideUp();
			return false;
		}

		if($("#username").val() == "" || $("#username").val().length < 6){
			e.preventDefault();
			$(".error-login").html("Por favor ingrese un usuario valido de al menos 6 caracteres").slideDown().delay(2000).slideUp();
			return false;
		}
		if($("#password").val() == "" || $("#password").val().length < 6){
			e.preventDefault();
			$(".error-login").html("Por favor ingrese una contraseña valida de al menos 6 caracteres").slideDown().delay(2000).slideUp();
			return false;
		}

		if($("#password").val() != $("#password2").val()){
			e.preventDefault();
			$(".error-login").html("Contraseñas no coinciden").slideDown().delay(2000).slideUp();
			return false;
		}

		if(!$("#aceptar").prop("checked")){
			e.preventDefault();
			$(".error-login").html("Debe leer y aceptar nuestra políticas de privacidad").slideDown().delay(2000).slideUp();
			return false;
		}
	})

	$(".error-login, .exito-login").click(function(e){
		$(this).slideUp();
	});

	$(".date-input").datepicker({
		autoClose: true,
		format: "dd/mm/yyyy",
		setDefaultDate: true,
		onClose: ()=>{ percentBar() },
		'i18n': {
			'months': [
				'Enero',
				'Febrero',
				'Marzo',
				'Abril',
				'Mayo',
				'Junio',
				'Julio',
				'Agosto',
				'Septiembre',
				'Octubre',
				'Noviembre',
				'Diciembre'
			],
			'monthsShort': [
				'Ene',
				'Feb',
				'Mar',
				'Abr',
				'May',
				'Jun',
				'Jul',
				'Ago',
				'Sep',
				'Oct',
				'Nov',
				'Dic'
			],
			'weekdays': [
				'Domingo',
				'Lunes',
				'Martes',
				'Miércoles',
				'Jueves',
				'Viernes',
				'Sábado'
			],
			'weekdaysShort': [
				'Dom', 
				'Lun', 
				'Mar', 
				'Mié', 
				'Jue', 
				'Vie', 
				'Sáb'
			],
			'weekdaysAbbrev': [
				'D','L','M','M','J','V','S'
			]
		}
	});

	$("#registro_campamentos").DataTable({
		'responsive': true,
		"pageLength": 10,
		"order": [[ 0, "desc" ]],
      	"language": {
			"lengthMenu" : "Mostrando _MENU_ registros por página",
			"zeroRecords": "No hay registros por mostrar",
			"info"       : "Mostrando _PAGE_ de _PAGES_",
			"infoEmpty"  : "Sin registros en este momento",
			"search"     : "Buscar",
			"paginate": {
				"first":      "Primera",
				"last":       "Ultima",
				"next":       "Siguiente",
				"previous":   "Anterior"
			}
		}
    });

    $("#retirar").submit(function(e){
    	e.preventDefault();
    	var cant = $("#retirar_cant").val();
    	$("#retirar_btn").prop( "disabled", true );
    	$("#retirar_cant").prop( "disabled", true );
    	$.ajax({
		  type: "POST",
		  url: "#",
		  data: {
		  	Xsolc: cant
		  },
		  error: function(data){
		  	$("#retirar_btn").prop( "disabled", false );
    		$("#retirar_cant").prop( "disabled", false );
    		swal({title: "No completado intente mas tarde", icon: "error"});
		  },
		  success: function(data){
		  	window.location.reload();
		  }
		});
    })

	if($(".charts-blanc").length) Chart.defaults.global.defaultFontColor='#fff';

	$(".charts").each(function(k,v){
		var labels = JSON.parse($(v).attr("data-labels"));
		var datos = JSON.parse($(v).attr("data-datos"));
		var fondo = $(v).attr("data-fondo");
		var line = $(v).attr("data-line");
		var type = $(v).attr("data-type");
		var label = $(v).attr("data-label");
		var currency = $(v).attr("data-currency");
		var ctx = $(v)[0].getContext('2d');
		var myChart = new Chart(ctx, {
		    type: type,
		    data: {
		        labels: labels,
		        datasets: [{
		            label: label,
		            data: datos,
		            backgroundColor: fondo,
		            borderColor: line,
		            borderWidth: 1
		        }]
		    },
		    options: {
				responsive: true,
				maintainAspectRatio: false,
		        scales: {
		            y: {
		                beginAtZero: true,
		            },
		            yAxes: [{
			        	ticks: {
							beginAtZero: true,
							stepSize: 1,
			           		callback: function(value, index, values) {
			           			if(currency == 1) return value.toLocaleString("es-ES",{style:"currency", currency:"EUR"});
			           			return value;
			            	}
			         	}
			       	}]
		        }
		    }
		});
	})

	$(".botonr .dots").click(function(e){
		if(!$(this).hasClass('disable')){
			steps_form($(this))
		}
	})

	$('.dropify').dropify({
		messages: {
			'default': 'Arrastre y suelte un archivo aquí o haga click',
			'replace': 'Arrastra o haz clic para reemplazar',
			'remove':  'Remover',
			'error':   'Ooops, ha sucedido algo malo.'
		},

		error: {
			'fileSize': 'El tamaño del archivo es demasiado grande ({{ value }} max).',
		}
	});

	$("button[act='add_camp']").click(function(e){
		e.preventDefault()
		let topcamp = 'topcamp';
		window.location.href += '?'+topcamp+'=true&';
	})

	//array data camps//
	let imgDataCurrentTop = [];
	//array data camps//

	//detonator medias//
	let detonator = '';
	//detonator medias//

	$('[act="custom_dropify_ajax"]').click(function(e){
		e.preventDefault()
		detonator = $(this).attr('class');
		$(".overlay_custom_dropify").removeClass('disable');
		$("body").css({overflow: 'hidden'});
		loader($(".overlay_custom_dropify .content"), 'media_loader_panel');
		$.ajax({
			type: "POST",
			url: AjaxUrl,
			dataType: 'json',
			action: "admin_panel",
			data: {
				action: "admin_panel",
				getAttach: 2,
			},
			error: function(rsp){
				alert("Error en el servidor, intente más tarde");
			},
			success: function(rsp) {
				if(rsp.r){
					loaderEnd($(".overlay_custom_dropify .content"), 'media_loader_panel')
					if($(".overlay_custom_dropify .photos .content_photos").hasClass('empty')){
						$(".overlay_custom_dropify .photos .content_photos").removeClass('empty');
						$(".overlay_custom_dropify .photos .content_photos .message_error_content_photos").remove();
					}
					if(imgDataCurrentTop.length == 0){
						$.each(rsp.attach_id, (k,v)=>{
							imgDataCurrentTop[k] = v;
						})
						$.each(imgDataCurrentTop, (k, v)=>{
							printMediaCurrentUser(k, v);
						})
					}
					
				}else{
					loaderEnd($(".overlay_custom_dropify .content"), 'media_loader_panel')
					if(!$(".overlay_custom_dropify .photos .content_photos").hasClass('empty')){
						$(".overlay_custom_dropify .photos .content_photos").addClass('empty');
						$(".overlay_custom_dropify .photos .content_photos").append(`
							<div class="message_error_content_photos">
								<i class="material-icons icon-menu">error</i>
								<p>${rsp.m}</p>
							</div>`);
					}
				}
			}
		})
	})

	$(document).on('click', '.photos .content_photos .container_image_current_user_adpnsy', function(){
		let deton = detonator;
		let photo_select = `<div class="photo_select"><i class="material-icons icon-menu">done</i></div>`;
		if(deton == 'new_lilbrary_btn'){
			if(!$(this).find('.photo_select').length){
				$(this).append(photo_select);
			}else{
				$(this).find('.photo_select').remove()
			}
			if(!$(".container_image_current_user_adpnsy .photo_select").length){
				$(".add_photo button.select_medias").addClass('disabled');
			}else{
				$(".add_photo button.select_medias").removeClass('disabled');
			}
		}else{
			if($(this).find('.photo_select').length){
				$(this).find('.photo_select').remove();
				$(".add_photo button.select_medias").addClass('disabled');
			}else{
				$(".container_image_current_user_adpnsy .photo_select").remove();
				$(this).append(photo_select);
				$(".add_photo button.select_medias").removeClass('disabled');
			}
		}
	})

	$(".photos .add_photo .select_medias").click(function(e){
		e.preventDefault()
		if(!$(e.target).hasClass('disabled')){
			let url_crrnt_photo = '';
			let alt_crrnt_photo = '';
			let id_crrnt_photo = '';
			let deter_custom_dropify = detonator;
			let imgs_dorpi = '';
			let imgs_port = '';
			let imgs_dorpi_not = '';
			$(".container_image_current_user_adpnsy .photo_select").each((k, v)=>{
				url_crrnt_photo = $(v).siblings('img').attr('src');
				alt_crrnt_photo = $(v).siblings('img').attr('alt');
				id_crrnt_photo = $(v).siblings('img').attr('acgt');
				if(deter_custom_dropify == 'img_portada_camp'){
					imgs_dorpi = $(`<span class="content_dropify_custom_insert" iacgt="${id_crrnt_photo}">
								<img src="${url_crrnt_photo}" alt="${alt_crrnt_photo}" acgt="${id_crrnt_photo}">
		 						<input class="hidden_photo" type="hidden" name="foto" value="${id_crrnt_photo}">
		 						<i class="material-icons icon-menu quit_dropify_custom portrait" iacgt="${id_crrnt_photo}">close</i>
		 					</span>`);
					$(".img_portada_camp[act='custom_dropify_ajax']").append(imgs_dorpi);
					percentBar()
				}else if(deter_custom_dropify == 'field_portada'){
					imgs_port = $(`<span class="content_dropify_custom_insert" iacgt="${id_crrnt_photo}">
		 						<img src="${url_crrnt_photo}" alt="${alt_crrnt_photo}" acgt="${id_crrnt_photo}">
		 						<input class="hidden_photo" type="hidden" name="portada_camp" value="${id_crrnt_photo}">
		 						<i class="material-icons icon-menu quit_dropify_custom portrait" iacgt="${id_crrnt_photo}">close</i>
		 					</span>`);
					$(".field_portada[act='custom_dropify_ajax']").append(imgs_port);
				}else{
					let content_imgs_dropicustom = $('<div class="container_dropify_custom_insert"></div>');
					imgs_dorpi_not = $(`<span class="content_dropify_custom_insert" iacgt="${id_crrnt_photo}">
									 	<img src="${url_crrnt_photo}" alt="${alt_crrnt_photo}" acgt="${id_crrnt_photo}">
									 	<input class="hidden_photo" type="hidden" name="instalaciones[]" value="${id_crrnt_photo}">
									 	<i class="material-icons icon-menu quit_dropify_custom" iacgt="${id_crrnt_photo}">close</i>
									</span>`);
					if(!$(".container_dropify_custom_insert").length){
						$(".instalaciones_media .media_slider_camps").append(content_imgs_dropicustom);
						$(".container_dropify_custom_insert").append(imgs_dorpi_not);
						percentBar()
					}else{
						$(".container_dropify_custom_insert").append(imgs_dorpi_not);
						percentBar()
					}
				}
			})
			$(".container_image_current_user_adpnsy .photo_select").remove();
			$(".add_photo button.select_medias").addClass('disabled');
			$(".overlay_custom_dropify").addClass('disable');
			$("body").css({overflow: ''});
			$(".upload_images").hide();
			$(".photos").show();
		}
	})

	$('.img_portada_camp').on('click', '.quit_dropify_custom', function(e){
		e.stopPropagation();
		let parent = $(this).attr('iacgt');
		$(".img_portada_camp .content_dropify_custom_insert[iacgt='"+parent+"']").remove();
		percentBar()
	})

	$('.field_portada').on('click', '.quit_dropify_custom', function(e){
		e.stopPropagation();
		let parent = $(this).attr('iacgt');
		$(".field_portada .content_dropify_custom_insert[iacgt='"+parent+"']").remove();
	})

	$('.media_slider_camps').on('click', '.quit_dropify_custom', function(e){
		e.stopPropagation();
		let parent = $(this).attr('iacgt');
		$(".media_slider_camps .content_dropify_custom_insert[iacgt='"+parent+"']").remove();
		if(!$(".container_dropify_custom_insert .content_dropify_custom_insert").length) $(".container_dropify_custom_insert").remove()
		percentBar()
	})

	$(".min_modal_hyperUniKck, .min_modal_hyperUniKck .close_of_thishyperUniKck, .btnr_content_hyperUnicKck .btn_hyper_this.cancel").click(function(e){
		$(".min_modal_hyperUniKck").removeClass('active');
	})

	$('.content .close_custom_dropify').click(function(){
		$(".container_image_current_user_adpnsy .photo_select").remove();
		$(".add_photo button.select_medias").addClass('disabled');
		$(".overlay_custom_dropify").addClass('disable');
		$("body").css({overflow: ''});
		$(".upload_images").hide();
		$(".photos").show();
	})

	$("#custom_dropify_adpnsy .save_custom_dropify").click(function(e){
		e.preventDefault();
		let dropify_custom = $("#custom_dropify_adpnsy");
		let secs = dropify_custom.serializeObject();
		if(secs.nombre_img && $("#custom_dropify_adpnsy #img_custom_panel_camp").val()){
			let theData = new FormData(dropify_custom[0]);
			theData.append('action', 'admin_panel');
			theData.append('GET_IMAGEN', 1);
			loader($(".overlay_custom_dropify .content"), 'media_loader_panel');
			$.ajax({
				type: "POST",
				url: AjaxUrl,
				dataType: 'json',
				data: theData,
				cache: false,
				contentType: false,
				processData: false,
				error: function(rsp){
					alert("Error al llamar al API");
				},
				success: function(rsp) {
					if(rsp.r){
						loaderEnd($(".overlay_custom_dropify .content"), 'media_loader_panel');
						$("#custom_dropify_adpnsy").trigger('reset');
						$("#custom_dropify_adpnsy .dropify-clear").trigger('click');
						$(".container_image_current_user_adpnsy").remove();
						if($(".overlay_custom_dropify .photos .content_photos").hasClass('empty')) $(".overlay_custom_dropify .photos .content_photos").removeClass('empty');
						if($(".overlay_custom_dropify .photos .content_photos .message_error_content_photos").length) $(".overlay_custom_dropify .photos .content_photos .message_error_content_photos").remove();
						imgDataCurrentTop.unshift({
							'id': rsp.d,
							'url': rsp.url,
							'title': secs.nombre_img,
						})
						$.each(imgDataCurrentTop, (k, v)=>{
							printMediaCurrentUser(k, v);
						})
						$(".upload_images").hide();
						$(".photos").show();			
					}else{
						alert(rsp.m);
					}
				}
			})
		}else{
			$("#custom_dropify_adpnsy").find("input[required]").each((k,v)=>{
				if(!$(v).val()) $(v).addClass('invalid');
				if($(v).hasClass('dropify') && !$(v).val()) $("#custom_dropify_adpnsy").find('.dropify-wrapper').addClass('invalid')
			})
			setTimeout(()=>{
				alert('Por favor complete los campos requeridos');
			}, 250)
		}	
	})

	$("body").on('click', '.close_media_current_user', (e)=>{
		e.stopPropagation();
		let img_dlt = e.target;
		img_dlt = $(img_dlt).attr('dlt');
		let message_confirm = '¿Esta seguro de elimnar la imagen? (una vez eliminada, no se podra deshacer la acción)';
		alert_confirm(message_confirm, ()=>{
			loader($(".overlay_custom_dropify .content"), 'media_loader_panel');
			$(".container_image_current_user_adpnsy").remove();
			$.ajax({
				type: "POST",
				url: AjaxUrl,
				dataType: 'json',
				action: "admin_panel",
				data: {
					action: "admin_panel",
					dltAttach: 3,
					id_dlt: img_dlt,
				},
				error: function(rsp){
					alert("Error en el servidor, intente más tarde");
				},
				success: function(rsp) {
					if(rsp.r){
						loaderEnd($(".overlay_custom_dropify .content"), 'media_loader_panel')
						if(rsp.empty) {
							if(!$(".overlay_custom_dropify .photos .content_photos").hasClass('empty')){
								$(".overlay_custom_dropify .photos .content_photos").addClass('empty');
								$(".overlay_custom_dropify .photos .content_photos").append(`
									<div class="message_error_content_photos">
										<i class="material-icons icon-menu">error</i>
										<p>${rsp.m}</p>
									</div>`);
							}
						}else{
							$.each(rsp.attach_id , (k, v)=>{
								printMediaCurrentUser(k, v);
							})
						}
					}else{
						loaderEnd($(".overlay_custom_dropify .content"), 'media_loader_panel')
						alert(rsp.m);
					}
				}
			})
		})
	})

	$(".upload_images").hide();
	$(".add_photo [act='show_upload_image']").click(function(e){
		e.preventDefault();
		loader($(".overlay_custom_dropify .content"), 'media_loader_panel');
		$(".container_image_current_user_adpnsy .photo_select").remove();
		$(".add_photo button.select_medias").addClass('disabled');
		setTimeout(()=>{
			$(".photos").hide();
			loaderEnd($(".overlay_custom_dropify .content"), 'media_loader_panel')
			$(".upload_images").show();
		}, 1000);
	})

	$(".back_photos_upload[act='hide_upload_image']").click(function(e){
		e.preventDefault();
		loader($(".overlay_custom_dropify .content"), 'media_loader_panel');
		setTimeout(()=>{
			$(".upload_images").hide();
			loaderEnd($(".overlay_custom_dropify .content"), 'media_loader_panel')
			$(".photos").show();
		}, 1000);
	})

	$("#data_topcampamento_ .add_data_clue[act='add_data_clue_camp']").click(function(e){
		e.preventDefault();
		let cdId = $("#data_topcampamento_ .data_clue .container_data_clue_inside .content_data_clue:last").attr('cd');
		cdId = parseInt(cdId) + 1;
		let keyImplementJs = Date.now();
		keyImplementJs = keyImplementJs.toString();
		keyImplementJs = keyImplementJs.slice(-13);
		let EL = $(`<div class="content_data_clue" cd="${cdId}">
		<button class="quit_data_clue" act="dlt_data_clue" cd="${cdId}">
			<i class="material-icons icon-menu">close</i>
		</button>
		<div class="clues">
			<label for="cluecamp[${keyImplementJs}][fecha_inicio]">Fecha inicial de tu campamento *</label>
			<input type="text" class="date-input" name="cluecamp[${keyImplementJs}][fecha_inicio]" required placeholder="Fecha inicial de tu campamento *" >
		</div>
		<div class="clues">
			<label for="cluecamp[${keyImplementJs}][fechas_final]">Fecha final de tu campamento *</label>
			<input type="text" class="date-input" name="cluecamp[${keyImplementJs}][fechas_final]" required placeholder="Fecha final de tu campamento *" >
		</div>
		<div class="clues">
			<label for="cluecamp[${keyImplementJs}][precio]">Precio * (iva incl.)</label>
			<input type="number" min="1" class="price_clue_top" name="cluecamp[${keyImplementJs}][precio]" required placeholder="Precio * (iva incl.)" >
		</div>
		<div class="clues">
			<label for="cluecamp[${keyImplementJs}][mes-temporada]">Temporada</label>
			<select name="cluecamp[${keyImplementJs}][mes-temporada]" class="select_insert_dom_materialize" topval="mes-temporada" required>
				<option value="" selected disabled >Temporada</option>
			</select>                    
		</div>
		<div class="clues">
			<label for="cluecamp[${keyImplementJs}][duracion]">Duración</label>
			<select name="cluecamp[${keyImplementJs}][duracion]" class="select_insert_dom_materialize" topval="duracion" required>
				<option value="" selected disabled >Duración</option>
			</select>                    
		</div>
		<div class="clues">
			<label for="cluecamp[${keyImplementJs}][edades]">Edades</label>
			<select name="cluecamp[${keyImplementJs}][edades]" class="select_insert_dom_materialize" topval="edades" required>
				<option value="" selected disabled >Edades | </option>
			</select> 
		</div>
		<div class="clues">
			<label for="cluecamp[${keyImplementJs}][plazas_num]">Plazas a la venta por TOP Campamentos *</label>
			<input type="number" name="cluecamp[${keyImplementJs}][plazas_num]" required placeholder="Plazas a la venta por TOP Campamentos *" >                 
		</div>
					</div>`);
		$("#data_topcampamento_ .data_clue .container_data_clue_inside").append(EL);
		EL.find('.date-input').each(function(k, v) {
			$(v).datepicker({
				autoClose: true,
				format: "dd/mm/yyyy",
				setDefaultDate: true,
				'i18n': {
					'months': [
						'Enero',
						'Febrero',
						'Marzo',
						'Abril',
						'Mayo',
						'Junio',
						'Julio',
						'Agosto',
						'Septiembre',
						'Octubre',
						'Noviembre',
						'Diciembre'
					],
					'monthsShort': [
						'Ene',
						'Feb',
						'Mar',
						'Abr',
						'May',
						'Jun',
						'Jul',
						'Ago',
						'Sep',
						'Oct',
						'Nov',
						'Dic'
					],
					'weekdays': [
						'Domingo',
						'Lunes',
						'Martes',
						'Miércoles',
						'Jueves',
						'Viernes',
						'Sábado'
					],
					'weekdaysShort': [
						'Dom', 
						'Lun', 
						'Mar', 
						'Mié', 
						'Jue', 
						'Vie', 
						'Sáb'
					],
					'weekdaysAbbrev': [
						'D','L','M','M','J','V','S'
					]
				}
			});
		})
		EL.find('.select_insert_dom_materialize').each(function(k, v) {
			if($(v).attr("topval") == 'duracion'){
				$.each(duracion, function(nk,nv){
					$(v).append(`<option value='${nv.key}'>${nv.key}</option>`);
				})
			}

			if($(v).attr("topval") == 'mes-temporada'){
				$.each(temporada, function(nk,nv){
					$(v).append(`<option value='${nv.key}'>${nv.key}</option>`);
				})
			}

			if($(v).attr("topval") == 'edades'){
				$.each(edades, function(nk,nv){ 
					$(v).append(`<option value='${nv.key}'>${nv.key}</option>`);
				})
			}

			$(v).formSelect();
		})
	})

	$("#data_topcampamento_ .save_form button").click(function(e){
		e.preventDefault();
		let publyDraft = $(this);
		if(publyDraft.attr('dtrsv') == 'save_like_publy' && publyDraft.hasClass('no_publy')) return;
		let vaAjax = true;
		let theData = $("#data_topcampamento_");
		let formData = new FormData(theData[0]);
		let dates = $(".date-input");
		if(publyDraft.attr('dtrsv') == 'save_like_publy' && !publyDraft.hasClass('no_publy')){
			let datesComp = [];
			$.each(dates, (k,v)=>{
				if($(v).val().length){
					let vPast = $(v).val();
					vPast = vPast.split('/');
					vNew = `${vPast[1]}-${vPast[0]}-${vPast[2]}`;
					datesComp.push(vNew);
				}
			})
			if(datesComp.length){
				let parte = 2;
				let newDatesComp = [];
				for(i=0;i<datesComp.length;i+=parte){
					let part = datesComp.slice(i, i + 2);
					newDatesComp.push(part);
				}
				for(let dt of newDatesComp){
					let fdt = dt[0].split('-');
					let ldt = dt[1].split('-');
					fdt = `${fdt[2]}-${fdt[0]}-${fdt[1]}`;
					ldt = `${ldt[2]}-${ldt[0]}-${ldt[1]}`;
					let fecha1 = new Date(fdt);
					let fecha2 = new Date(ldt);
					let currentDate = new Date();
					if(fecha1.getTime() < currentDate.getTime() || fecha2.getTime() < currentDate.getTime()){
						alert('No se puede introducir ninguna fecha anterior al día actual. Por favor, introduce fechas válidas.');
						return;
					}
					if(fecha1.getTime() > fecha2.getTime()){
						alert('La fecha de finalización de tu campamento no puede ser posterior a la fecha de inicio. Por favor, introduce una fecha válida.');
						return;
					}
				}
			}
		}
		(publyDraft.attr('dtrsv') == 'save_like_publy' && !publyDraft.hasClass('no_publy')) ? formData.append('is_complete', true) : formData.append('is_complete', false);
		if($("input[name='camp_title']").val().length >= 7){
			$(".data_topcampamento_ textarea.materialize-textarea").each((k,v)=>{
				if($(v).val() && $(v).val().length < 250 && publyDraft.attr('dtrsv') == 'save_like_publy'){
					alert('La descripción que intrudujiste en el campo '+$(v).attr('ttlf')+' es muy corta, ten en cuenta que con una mayor información podras llamar la atención de futuros campistas. La descripción del campamento debe ser de al menos 250 caracteres');
					vaAjax = false;
				} 
			})
			$(".data_topcampamento_ .price_clue_top").each((k,v)=>{
				if($(v).val() == 0 && publyDraft.attr('dtrsv') == 'save_like_publy'){
					alert('No es posible establecer un precio de 0 para un campamento.');
					vaAjax = false;
				}
			})
			if(publyDraft.attr('dtrsv') == 'save_like_publy' && !$(".data_topcampamento_ select[topval='actividades2']").val().length){
				alert('No puedes publicar tu campamento sin al menos una actividad.');
				vaAjax = false;
			}

			if(vaAjax){
				$(".data_topcampamento_ textarea.top_format_text_coe_txt").each((k,v)=>{
					if($(v).attr('realval') && $(v).val()){
						let realval = $(v).attr('realval');
						let keyNameT = $(v).attr('name');
						formData.set(keyNameT, realval);
					}
				});
				loader($('body'), 'unick_load_global_ajax');
				$.ajax({
					type: "POST",
					url: AjaxUrl + '?action=admin_panel&GET_DATA_=5',
					dataType: 'json',
					cache: false,
					contentType: false,
					processData: false,
					data: formData,
					error: function(rsp){
						loaderEnd($('body'), 'unick_load_global_ajax')
						alert("Error en el servidor, intente más tarde");
					},
					success: function(rsp) {
						if(rsp.r){
							loaderEnd($('body'), 'unick_load_global_ajax')
							let cers = (rsp.ce) ? '¡Se ha creado de manera correcta el campamento!' : 'Cambios guardados';
							alert(cers, true); 
							if(rsp.ce) {
								let newUrl = window.location.origin + window.location.pathname;
								window.location.href = newUrl;
							}
						}else{
							loaderEnd($('body'), 'unick_load_global_ajax')
							$.each(rsp.m, (k, v) => {
								alert(v)
							})
						}
					}
				})	
			}

		}else{
			alert('El nombre de tu campamento debe tener al menos 7 caracteres')
		}	
	})

	$("#registro_campamentos").on("click", ".btns_acts_camps",function(e){
		e.preventDefault();
		let camp_edit = $(this).attr('act');
		let edit_camp = 'edit_campamento';
		let topcamp = 'topcamp';
		window.location.href += '?'+topcamp+'=true&'+edit_camp+'='+camp_edit;
	})

	$(document).on("click", ".quit_data_clue[act='dlt_data_clue']", function(e){
		e.preventDefault();
		let clue_dlt = $(this).attr('cd');
		$(".content_data_clue[cd='"+clue_dlt+"']").remove();
	})	

	move_save_progress_camps()

	$(window).on('resize', (e)=>{
		move_save_progress_camps()
	})

	$("#data_topcampamento_ input, #data_topcampamento_ textarea").on('keyup', (e) => {
		percentBar()
	})

	$("#data_topcampamento_ select").on('change', (e) => {
		percentBar()
	})

	$(window).scroll(()=>{
		move_save_progress_camps()
	})

	$('#data_topcampamento_ textarea, #data_topcampamento_ input[name="camp_title"]').characterCounter();

	if($("#data_topcampamento_").length){
		print_medias()
		percentBar()
	}

	if($("#reservas_campamentos").length){

		let datatable = $("#reservas_campamentos").DataTable({
			'responsive': true,
	        'pageLength': 25,
	        'processing': true,
	        'serverSide': true,
	        'serverMethod': 'post',
	        'ajax': {
	          'url': AjaxUrl + '?action=admin_panel&reserva=_look_',
	          "data": function (d) {
			      d.filter = {
					'camp': $('#select_fil_booking_camp').val(),
					'fecha1': $(".filter_booking_adpnsy_pg input.date-input[name='date1']").val(),
					'fecha2': $(".filter_booking_adpnsy_pg input.date-input[name='date2']").val(),
				};
			      return d;
				}
	        },
	        'columns': [
	          { data: 'id' },
	          { data: 'campamento' },
	          { data: 'fecha' },
	          { data: 'plazas' },
	          { data: 'correo' },
	          { data: 'usuario' },
	          { data: 'telefono' },
	          { data: 'dni' },
	          { data: 'total',
	          	render: function ( data, type, full, meta ) { 
	                return EUR(((parseFloat(full.precio)/parseFloat(full.comision))*100)-full.precio) 
	            } 
	      	  },
	          { data: 'acciones', 
	            orderable: false, 
	            render: function ( data, type, full, meta ) { 
	                return '<i class="material-icons icon-menu tbl_rs" dwn="'+full.id+'" title="Ver reserva">visibility</i>' 
	            } 
	          }
	        ],
			"order": [[1, 'desc']],
			"language": _data_sp
		});

		$(".filter_booking_adpnsy_pg .date-input").datepicker({
			'format': 'dd-mm-yyyy',
			'i18n': {
				'months': [
					'Enero',
					'Febrero',
					'Marzo',
					'Abril',
					'Mayo',
					'Junio',
					'Julio',
					'Agosto',
					'Septiembre',
					'Octubre',
					'Noviembre',
					'Diciembre'
				],
				'monthsShort': [
					'Ene',
					'Feb',
					'Mar',
					'Abr',
					'May',
					'Jun',
					'Jul',
					'Ago',
					'Sep',
					'Oct',
					'Nov',
					'Dic'
				],
				'weekdays': [
					'Domingo',
					'Lunes',
					'Martes',
					'Miércoles',
					'Jueves',
					'Viernes',
					'Sábado'
				],
				'weekdaysShort': [
					'Dom', 
					'Lun', 
					'Mar', 
					'Mié', 
					'Jue', 
					'Vie', 
					'Sáb'
				],
				'weekdaysAbbrev': [
					'D','L','M','M','J','V','S'
				]
			}
		});

		$(".filter_booking_adp .fil").click((e)=>{
			e.preventDefault();
			let title = $(".filter_booking_adpnsy_pg select#select_fil_booking_camp").val();
			let date1 = $(".filter_booking_adpnsy_pg input.date-input[name='date1']").val();
			let date2 = $(".filter_booking_adpnsy_pg input.date-input[name='date2']").val();
			let dataSend = {
				'id_camp': (title) ? title : '',
				'date1': (date1) ? date1 : '',
				'date2': (date2) ? date2 : '',
			};
			if(!dataSend.date1 && !dataSend.date2){
				datatable.ajax.reload();
			}else if(dataSend.date1 && dataSend.date2){
				let dt1 = date1.split('-');
				let dt2 = date2.split('-');
				dt1 = `${dt1[2]}-${dt1[1]}-${dt1[0]}`;
				dt2 = `${dt2[2]}-${dt2[1]}-${dt2[0]}`;
				dt1 = new Date(dt1);
				dt2 = new Date(dt2);
				if(dt1.getTime() > dt2.getTime()){
					alert("No es posible seleccionar una fecha de inicio que sea posterior a la fecha de finalización para filtrar.");
				}else{
					datatable.ajax.reload();
				}
			}else{
				alert('Para filtrar tus reservas, debes seleccionar una fecha de inicio y una fecha de finalización.');
			}
		})

		$(".csv_reservas").click(function(e){
			e.preventDefault();
			let title = $(".filter_booking_adpnsy_pg select#select_fil_booking_camp").val();
			let date1 = $(".filter_booking_adpnsy_pg input.date-input[name='date1']").val();
			let date2 = $(".filter_booking_adpnsy_pg input.date-input[name='date2']").val();
			let nonce = $(this).attr("vrf");
			let url = `${AjaxUrl}?action=admin_panel&date1=${date1}&date2=${date2}&id_camp=${title}&csv_reservas=${nonce}`;
			window.location.href = url;
		})

		$("body").on('click', '.tbl_rs', (e)=>{
			if(!$("[loader='admin_load']").length){
				loader($("body"), 'admin_load');
			}
			$(".content_modal_rs_pg").css({overflow: 'hidden'});
			let booking = $(e.target).attr('dwn');
			if(!booking.length){
				alert('No es posible visualizar la reserva, por favor intentelo más tarde.');
				return;
			}
			$("body").css({overflow: 'hidden'});
			$.ajax({
				type: "POST",
				url: AjaxUrl,
				dataType: 'json',
				action: "admin_panel",
				data: {
					action: "admin_panel",
					visBook: 4,
					booking: booking,
				},
				error: function(rsp){
					loaderEnd($("body"), 'admin_load');
					alert("Error en el servidor, intente más tarde");
				},
				success: function(rsp) {
					loaderEnd($("body"), 'admin_load');
					if(rsp.r){
						$("#modal_rs_info_pg").removeClass('disabled');
						$(".content_modal_rs_pg").css({overflow: ''});
						let sql = rsp.sql;
						let dates = sql.fechas_reserva;
						let dataKids = sql.info_campists;
						let headDataKids = Object.keys(dataKids);
						$("#modal_rs_info_pg table thead tr th").remove();
						$("#modal_rs_info_pg table thead tr").append(`
							<th>Nombre</th>
							<th>Correo</th>
							<th>Teléfono</th>
							<th>Campamento</th>
							<th>Fechas</th>
							<th>Plazas</th>
							<th>Precio</th>
						`);
						$.each(headDataKids, (k,v)=>{
							$("#modal_rs_info_pg table thead tr").append(`<th>${v}</th>`);
						})
						$("#modal_rs_info_pg table tbody tr td").remove();
						$("#modal_rs_info_pg h2 span").text(booking);
						$("#modal_rs_info_pg table tbody tr").append(`
							<td>${sql.fullname}</td>
							<td>${sql.correo}</td>
							<td>${sql.telefono}</td>
							<td>${sql.title_camp}</td>
							<td>${dates}</td>
							<td>${sql.plazas}</td>
							<td>${((sql.precio/15)*85).toFixed(2)} €</td>
						`);
						$.each(dataKids, (k,v)=>{
							$("#modal_rs_info_pg table tbody tr").append(`<td>${v}</td>`);
						});
						let alturaMax = 0;
						$("#modal_rs_info_pg table tbody tr td").each((k,v)=>{
							if($(v).outerHeight(true) > alturaMax){
								alturaMax = $(v).outerHeight(true);
							}
						})
						$("#modal_rs_info_pg table tbody tr td, #modal_rs_info_pg table thead tr th").css({height: alturaMax});
					}else{
						alert(rsp.m);
					}
				}
			})
		})

		$(".tbl_rs_close").click((e)=>{
			$("#modal_rs_info_pg").addClass('disabled');
			$("body").css({overflow: ''});
		})

	}

	if($("#message_camp").length){
		$("#message_camp").DataTable({
			'responsive': true,
			"pageLength": 10,
			"order": [[ 0, "desc" ]],
			  "language": {
				"lengthMenu" : "Mostrando _MENU_ registros por página",
				"zeroRecords": "No hay registros por mostrar",
				"info"       : "Mostrando _PAGE_ de _PAGES_",
				"infoEmpty"  : "Sin registros en este momento",
				"search"     : "Buscar",
				"paginate": {
					"first":      "Primera",
					"last":       "Ultima",
					"next":       "Siguiente",
					"previous":   "Anterior"
				}
			}
		});

	}

	if($("#mails_camps").length){
		$("#mails_camps").DataTable({
			'responsive': true,
			"pageLength": 10,
			"order": [[ 0, "desc" ]],
			  "language": {
				"lengthMenu" : "Mostrando _MENU_ registros por página",
				"zeroRecords": "No hay registros por mostrar",
				"info"       : "Mostrando _PAGE_ de _PAGES_",
				"infoEmpty"  : "Sin registros en este momento",
				"search"     : "Buscar",
				"paginate": {
					"first":      "Primera",
					"last":       "Ultima",
					"next":       "Siguiente",
					"previous":   "Anterior"
				}
			}
		});

		let quill = new Quill('#cusom_mails_adpnsy', {
			theme: 'snow',
			placeholder: 'Ejemplo: ¡Bienvenido al campamento {{nombre_campamento}}!, Nos complace que hayas elegido nuestro servicio. Si tienes alguna pregunta o inquietud, no dudes en ponerte en contacto con nosotros a través del siguiente enlace: {{campamento_enlace}}',
		});

		$("#mails_camps").on('click', ".btns_ml_camp", (e)=>{
			if(!$("[loader='admin_load']").length){
				loader($("body"), 'admin_load');
			}
			let post_id = ($(e.target).attr('mli')) ? $(e.target).attr('mli') : '';
			if(post_id){
				$("body").css({overflow: 'hidden'});
				$(".save_mail_custom_top_panel").attr('post_id', post_id);
				$.ajax({
					type: "POST",
					url: AjaxUrl,
					dataType: 'json',
					action: "admin_panel",
					data: {
						action: "admin_panel",
						mailBook: 2,
						post_id: post_id,
					},
					error: function(rsp){
						loaderEnd($("body"), 'admin_load');
						alert("Error en el servidor, intente más tarde");
					},
					success: function(rsp) {
						loaderEnd($("body"), 'admin_load');
						if(rsp.r){
							$("#modal_quill_mail").removeClass('disabled');
							quill.focus();
							let caretPosition = quill.getSelection(true);
							quill.insertText(caretPosition, rsp.ml);
						}else{
							alert(rsp.m);
						}
					}
				})
			}else{
				alert('Ha ocurrido un error al obtener la información. Por favor intentelo de nuevo más tarde.');
			}
			
		})

		$(".tbl_ml_close").click(()=>{
			$("#modal_quill_mail").addClass('disabled');
			$("body").css({overflow: ''});
		})

		$("#var_entr").change((e)=>{
			if($(e.target).val().length){
				const value = e.target.value;
    			quill.focus();
   				var caretPosition = quill.getSelection(true);
				quill.insertText(caretPosition, value);
			}
			let indexOption = $("#var_entr option:first").prop("index");
			$("#var_entr").prop("selectedIndex", indexOption);
			$("#var_entr").formSelect();
		})

		$(".save_mail_custom_top_panel").click((e)=>{
			loader($(".container_quill_content"), 'mail_load');
			let empty = quill.getLength();
			let post_id = $(e.target).attr('post_id');
			if(!post_id){
				alert('Ha ocurrido un error al obtener la información. Por favor, inténtelo de nuevo más tarde.');
				return;
			}
			if(empty){
				let text = quill.getText();
				$.ajax({
					type: "POST",
					url: AjaxUrl,
					dataType: 'json',
					action: "admin_panel",
					data: {
						action: "admin_panel",
						mailBook: 1,
						text: text,
						post_id: post_id,
					},
					error: function(rsp){
						loaderEnd($(".container_quill_content"), 'mail_load');
						alert("Error en el servidor, intente más tarde");
					},
					success: function(rsp) {
						if(rsp.r){
							loaderEnd($(".container_quill_content"), 'mail_load');
							alert(rsp.m, true);
						}else{
							loaderEnd($(".container_quill_content"), 'mail_load');
							alert(rsp.m);
						}
					}
				})
			}else{
				alert('No puedes guardar un mensaje vacío. Por favor, asegúrate de escribir algo en el campo de contenido antes de guardar el mensaje.');
			}
		})
	}

	if($("#fill_admin_data_dash").length || $("#fill_gest_data_dash").length){

		$("#fill_admin_data_dash").click((e)=>{
			if(!$("[loader='admin_load']").length){
				loader($("body"), 'admin_load');
			}
			let month = $("select[name='months_dash_admin_pnl']").val();
			$.ajax({
				type: "POST",
				url: AjaxUrl,
				dataType: 'json',
				action: "admin_panel",
				data: {
					action: "admin_panel",
					dashData: 1,
					month: (month) ? month : false,
				},
				error: function(rsp){
					loaderEnd($("body"), 'admin_load');
					alert("Error en el servidor, intente más tarde");
				},
				success: function(rsp) {
					loaderEnd($("body"), 'admin_load');
					if(rsp.r){
						let sql = rsp.sql[0];
						$(".adpnsy_dash_gains").text((sql.pr)?sql.pr+'€':0+'€');
						$(".adpnsy_dash_books").text(sql.bk);
						$(".op_all_camps").text(rsp.op);
					}else{
						alert(rsp.m);
					}
				}
			})
			
		});

		$("#fill_gest_data_dash").click((e)=>{
			if(!$("[loader='admin_load']").length){
				loader($("body"), 'admin_load');
			}
			let camp = $("select[name='camp_dash_gest_pnl']").val();
			let user = $(e.target).attr('usr');
			$.ajax({
				type: "POST",
				url: AjaxUrl,
				dataType: 'json',
				action: "admin_panel",
				data: {
					action: "admin_panel",
					dashData: 2,
					camp: (camp) ? camp : false,
					user: user,
				},
				error: function(rsp){
					loaderEnd($("body"), 'admin_load');
					alert("Error en el servidor, intente más tarde");
				},
				success: function(rsp) {
					loaderEnd($("body"), 'admin_load');
					if(rsp.r){
						let sql = rsp.sql[0];
						$(".booking_camp_pg_admin").text((sql.bk) ? sql.bk : 0);
						$(".op_gest_camps").text((rsp.op) ? rsp.op : 0);
						$(".gest_views_all").text((rsp.vw) ? rsp.vw: 0);
					}else{
						alert(rsp.m);
					}
				}
			})
		})
	
	}

	if($("#facutracion_admin").length){

		let facturacion = $("#facutracion_admin").DataTable({
			'responsive': true,
	        'pageLength': 25,
	        'processing': true,
	        'serverSide': true,
	        'serverMethod': 'post',
	        'ajax': {
	          'url': AjaxUrl + '?action=admin_panel&factura=_look_',
	          "data": function (d) {
			      d.filter = $('#select_fil_fact_booking_camp').val();
			      return d;
			    }
	        },
	        'columns': [
	          { data: 'id' },
	          { data: 'campamento' },
	          { data: 'fecha' },
	          { data: 'cliente' },
	          { data: 'plazas' },
	          { data: 'empresa' },
	          { data: 'comision',
	          	render: function ( data, type, full, meta ) { 
	                return EUR(full.precio) 
	            } 
	      	  },
	          { data: 'acciones', 
	            orderable: false, 
	            render: function ( data, type, full, meta ) { 
	                return '<i class="material-icons icon-menu" ord="'+full.id+'" title="Ver orden">visibility</i>' 
	            } 
	          }
	        ],
			"order": [[1, 'desc']],
			"language": _data_sp
		});

		$("#btn_fil_fact_booking_camp").click((e)=>{
			facturacion.ajax.reload();
		})

		$("#facutracion_admin").on('click', "[ord]", (e)=>{
			if(!$("[loader='admin_load']").length){
				loader($("body"), 'admin_load');
			}
			let order = $(e.target).attr('ord');
			$("body").css({overflow: 'hidden'});
			if(!order.length){
				alert('No es posible visualizar la reserva, por favor intentelo más tarde.');
				return;
			}
			$.ajax({
				type: "POST",
				url: AjaxUrl,
				dataType: 'json',
				action: "admin_panel",
				data: {
					action: "admin_panel",
					dashData: 4,
					order: order,
				},
				error: function(rsp){
					loaderEnd($("body"), 'admin_load');
					alert("Error en el servidor, intente más tarde");
				},
				success: function(rsp) {
					loaderEnd($("body"), 'admin_load');
					if(rsp.r){
						if($("#modal_fc_info_pg").hasClass('disabled')) $("#modal_fc_info_pg").removeClass('disabled');
						let sql = rsp.sql;
						let booking = sql.id_orden;
						let dates = sql.fechas_reserva;
						let info_campists = sql.info_campists;
						info_campists = (info_campists) ? info_campists: '';
						$("#modal_fc_info_pg table tbody tr td").remove();
						$("#modal_fc_info_pg h2 span").text(booking);
						$("#modal_fc_info_pg table tbody tr").append(`
							<td>${sql.fullname}</td>
							<td>${sql.correo}</td>
							<td>${sql.title_camp}</td>
							<td>${dates}</td>
							<td>${sql.plazas}</td>
							<td>${sql.precio} €</td>
						`);
						let alturaMax = 0;
						$("#modal_fc_info_pg table tbody tr td").each((k,v)=>{
							if($(v).outerHeight(true) > alturaMax){
								alturaMax = $(v).outerHeight(true);
							}
						})
						$("#modal_fc_info_pg table tbody tr td, #modal_fc_info_pg table thead tr th").css({height: alturaMax});
					}else{
						alert(rsp.m);
					}
				}
			})
		})

		$("#modal_fc_info_pg .tbl_fc_close").click((e)=>{
			if(!$("#modal_fc_info_pg").hasClass('disabled')) $("#modal_fc_info_pg").addClass('disabled');
			$("body").css({overflow: ''});
		})

	}

	if($("#campamentos_admin_panel").length){
		
		const campsAdmin = $("#campamentos_admin_panel").DataTable({
			'responsive': true,
			"pageLength": 10,
			"order": [[ 0, "desc" ]],
			  "language": {
				"lengthMenu" : "Mostrando _MENU_ registros por página",
				"zeroRecords": "No hay registros por mostrar",
				"info"       : "Mostrando _PAGE_ de _PAGES_",
				"infoEmpty"  : "Sin registros en este momento",
				"search"     : "Buscar",
				"paginate": {
					"first":      "Primera",
					"last":       "Ultima",
					"next":       "Siguiente",
					"previous":   "Anterior"
				}
			}
		});

		if(!emptyCamps){
			alert('Ha ocurrido un error al obtener la información. Por favor intentelo de nuevo más tarde.');
		}

		$("#campamentos_admin_panel").on('click', "[dlt]", (e)=>{
			let camp = $(e.target).attr('dlt');
			let title = $(".title_camp_dlt[nmdlt='"+camp+"']").text();
			alert_confirm(`¿Esta segura de eliminar el campamento ${title}?`, ()=>{
				if(!camp.length){
					alert('Ha ocurrido un error al intentar obtener la información para eliminar el campamento '+title+'. Por favor intentelo de nuevo más tarde');
					return;
				}
				loader($("body"), 'admin_load');
				$.ajax({
					type: "POST",
					url: AjaxUrl,
					dataType: 'json',
					action: "admin_panel",
					data: {
						action: "admin_panel",
						dltCamp: 1,
						camp : camp,
					},
					error: function(rsp){
						loaderEnd($("body"), 'admin_load');
						alert("Error en el servidor, intente más tarde");
					},
					success: function(rsp) {
						loaderEnd($("body"), 'admin_load');
						if(rsp.r){
							alert(rsp.m, true);
						}else{
							alert(rsp.m);
						}
					}
				})
			})
		})

	}

	if($("#comi_btn_option").length){

		$("#comi_btn_option").click((e)=>{
			$("body").css({overflow: 'hidden'});
			loader($("body"), 'admin_load');
			$.ajax({
				type: "POST",
				url: AjaxUrl,
				dataType: 'json',
				action: "admin_panel",
				data: {
					action: "admin_panel",
					dashData: 5,
				},
				error: function(rsp){
					loaderEnd($("body"), 'admin_load');
					alert("Error en el servidor, intente más tarde");
				},
				success: function(rsp) {
					loaderEnd($("body"), 'admin_load');
					if(rsp.r){
						$("#gest_comi_all").removeClass('disabled');
						$("input[name='comision']").val(rsp.cm);
					}else{
						alert(rsp.m);
					}
				}
			})
		})

		$("#gest_comi_all .comi_close").click((e)=>{
			$("#gest_comi_all").addClass('disabled');
			$("body").css({overflow: ''});
		})

		$("#gest_comi_all form button").click((e)=>{
			e.preventDefault();
			let comision = $("input[name='comision']").val();
			if(comision.length){
				loader($("body"), 'admin_load');
				$.ajax({
					type: "POST",
					url: AjaxUrl,
					dataType: 'json',
					action: "admin_panel",
					data: {
						action: "admin_panel",
						dashData: 6,
						comision: comision,
					},
					error: function(rsp){
						loaderEnd($("body"), 'admin_load');
						alert("Error en el servidor, intente más tarde");
					},
					success: function(rsp) {
						loaderEnd($("body"), 'admin_load');
						if(rsp.r){
							alert(rsp.m, true);
						}else{
							alert(rsp.m);
						}
					}
				})
			}else{
				alert('Para guardar la comisión, por favor ingresa la cantidad correspondiente en el campo designado.');
			}
		})

	}

	if($("#camp_select_visibility").length || $("#camp_select_certify").length){

		$(".btn_pq").click((e)=>{
			let difer = $(e.target).attr('tp');
			let camp = $("select[tp='"+difer+"']").val();
			if(!camp){
				alert('Escoge un campamento para continuar por favor.');
				return;
			}
			loader($("body"), 'admin_load');
			$.ajax({
				type: "POST",
				url: AjaxUrl,
				dataType: 'json',
				action: "admin_panel",
				data: {
					action: "admin_panel",
					buyPck: 1,
					camp : camp,
					difer: difer,
				},
				error: function(rsp){
					loaderEnd($("body"), 'admin_load');
					alert("Error en el servidor, intente más tarde");
				},
				success: function(rsp) {
					loaderEnd($("body"), 'admin_load');
					if(rsp.r){
						window.location.href = rsp.u;
					}else{
						alert(rsp.m);
					}
				}
			})

		})

	}

	if($("#tbl_pqts_cmps_certify").length){
		$("#tbl_pqts_cmps_certify").DataTable({
			'responsive': true,
			"pageLength": 10,
			"order": [[ 0, "desc" ]],
			  "language": {
				"lengthMenu" : "Mostrando _MENU_ registros por página",
				"zeroRecords": "No hay registros por mostrar",
				"info"       : "Mostrando _PAGE_ de _PAGES_",
				"infoEmpty"  : "Sin registros en este momento",
				"search"     : "Buscar",
				"paginate": {
					"first":      "Primera",
					"last":       "Ultima",
					"next":       "Siguiente",
					"previous":   "Anterior"
				}
			}
		});
	}

	if($("#tbl_pqts_cmps_visibility").length){
		$("#tbl_pqts_cmps_visibility").DataTable({
			'responsive': true,
			"pageLength": 10,
			"order": [[ 0, "desc" ]],
			  "language": {
				"lengthMenu" : "Mostrando _MENU_ registros por página",
				"zeroRecords": "No hay registros por mostrar",
				"info"       : "Mostrando _PAGE_ de _PAGES_",
				"infoEmpty"  : "Sin registros en este momento",
				"search"     : "Buscar",
				"paginate": {
					"first":      "Primera",
					"last":       "Ultima",
					"next":       "Siguiente",
					"previous":   "Anterior"
				}
			}
		});
	}

	if($("#data_topcampamento_").length){
		$("#data_topcampamento_ .activity_desc select[topval='actividades2']").select2();
	}

});

jQuery(document).ready(function($){

	$("#data_topcampamento_").on('input', '#ubication_iframe', (e)=>{
		if(!$(e.target).val()) if($("#valueApiPlacesSave").length) $("#valueApiPlacesSave").remove();
	})

	if($("#api_places_script_top").length){
		var input = $('#ubication_iframe')[0];
		var autocomplete = new google.maps.places.Autocomplete(input, {
			types: ['geocode'],
			componentRestrictions: { country: 'ES' }
		});
		autocomplete.addListener('place_changed', function() {
			var place = autocomplete.getPlace();
			if (!place.geometry) {
				if($("#valueApiPlacesSave").length) $("#valueApiPlacesSave").remove();
				return;
			}else{
				if($("#valueApiPlacesSave").length) $("#valueApiPlacesSave").remove();
				const valueApiPlacesSave = {
					lat: place.geometry.location.lat(),
					lng: place.geometry.location.lng(),
				};
				const inputPlacesSave = $(`<input id='valueApiPlacesSave' type='hidden' name='valueApiPlacesSave' value='${JSON.stringify(valueApiPlacesSave)}' />`);
				$("#data_topcampamento_ .ubicacion").append(inputPlacesSave);
			}
		});
	}

	$('.top_format_text_coe').each((k,v)=>{
		let container = $(v).attr('taid');
		let quillTextArea = new Quill(v, {
			modules: {
				toolbar: [
					['bold'],                               
				]
			},
			theme: 'snow'
		});

		if(container){
			let InEdit = ($("textarea[id='"+container+"']").val()) ? $("textarea[id='"+container+"']").val() : '';
			if(InEdit){
				quillTextArea.clipboard.dangerouslyPasteHTML(InEdit);
				$("textarea[id='"+container+"']").val(quillTextArea.getText());
				$("textarea[id='"+container+"']").attr('realval', InEdit);
			}
		}

		quillTextArea.on('text-change', (delta, oldDelta, source) => {
			let textInsertHtml = quillTextArea.root.innerHTML;
			let textInsert = quillTextArea.getText();
			if(container){
				$("textarea[id='"+container+"']").val(textInsert);
				$("textarea[id='"+container+"']").attr('realval', textInsertHtml);
				percentBar();
			}
		});
	});

	if($("#data_topcampamento_").length){
		showFieldsRequiredCamps();
		$("body").on('click', '.container_show_reqflds .head', function(e){	
			e.preventDefault();
			let widthThis = $(this).outerWidth(true);
			if(!$(this).attr('swidth')){
				$(this).attr('swidth', widthThis);
			}
			notifyFieldsRequiredInfo();
		});

		$("body").on('click', '.container_show_reqflds .list_fields_requireds ul li', function(e){
			let etscl = $(this).attr('scrl');
			if(etscl){
				let taid = etscl.includes('taid');
				let cord = $(etscl).offset().top;
				if(cord ){
					cord = cord - 78;
					if(taid) cord = cord - 120;
					window.scrollTo({
						top: cord,
						behavior: 'smooth'
					});
				}
			}
		});

		$("body").on('click', '.container_show_reqflds .head p', function(e){
			e.stopPropagation();
			e.preventDefault();
			$(".container_show_reqflds").removeClass('focus');
			let widthHer = $(".container_show_reqflds .head").attr('swidth');
			if(widthHer) $(".container_show_reqflds").css({width: widthHer});
		});
	}
})
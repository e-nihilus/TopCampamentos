const $ = jQuery;
const alert = function(text, ico = false){if(ico){var img = '<img alt="warning" class="spuser_alert_img" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNTAgNTAiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUwIDUwOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8Y2lyY2xlIHN0eWxlPSJmaWxsOiMyNUFFODg7IiBjeD0iMjUiIGN5PSIyNSIgcj0iMjUiLz4NCjxwb2x5bGluZSBzdHlsZT0iZmlsbDpub25lO3N0cm9rZTojRkZGRkZGO3N0cm9rZS13aWR0aDoyO3N0cm9rZS1saW5lY2FwOnJvdW5kO3N0cm9rZS1saW5lam9pbjpyb3VuZDtzdHJva2UtbWl0ZXJsaW1pdDoxMDsiIHBvaW50cz0iDQoJMzgsMTUgMjIsMzMgMTIsMjUgIi8+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8L3N2Zz4NCg==" />';}else{var img = '<img alt="warning" class="spuser_alert_img" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNTEyIDUxMiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTEyIDUxMjsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPHBhdGggc3R5bGU9ImZpbGw6IzNCNDE0NTsiIGQ9Ik0zMjIuOTM5LDYyLjY0MmwxNzguNzM3LDMwOS41ODNDNTA4LjIzMSwzODMuNTc4LDUxMiwzOTYuNzQsNTEyLDQxMC43OTENCgljMCw0Mi42Ny0zNC41OTIsNzcuMjY0LTc3LjI2NCw3Ny4yNjRIMjU2TDE5NC4xODksMjU2TDI1NiwyMy45NDZDMjg0LjYyLDIzLjk0NiwzMDkuNTg3LDM5LjUxOSwzMjIuOTM5LDYyLjY0MnoiLz4NCjxwYXRoIHN0eWxlPSJmaWxsOiM1MjVBNjE7IiBkPSJNMTg5LjA2MSw2Mi42NDJMMTAuMzIzLDM3Mi4yMjVDMy43NjksMzgzLjU3OCwwLDM5Ni43NCwwLDQxMC43OTENCgljMCw0Mi42NywzNC41OTIsNzcuMjY0LDc3LjI2NCw3Ny4yNjRIMjU2VjIzLjk0NkMyMjcuMzgsMjMuOTQ2LDIwMi40MTMsMzkuNTE5LDE4OS4wNjEsNjIuNjQyeiIvPg0KPHBhdGggc3R5bGU9ImZpbGw6I0ZGQjc1MTsiIGQ9Ik00NzQuOTEzLDM4Ny42NzhMMjk2LjE3Nyw3OC4wOThjLTguMDU2LTEzLjk1OS0yMi44NDktMjIuNzY3LTM4Ljg0OC0yMy4yMmwxNTIuODY5LDQwMi4yNzVoMjQuNTM5DQoJYzI1LjU1OSwwLDQ2LjM1OC0yMC43OTgsNDYuMzU4LTQ2LjM1OEM0ODEuMDk1LDQwMi42NzcsNDc4Ljk1MiwzOTQuNjgzLDQ3NC45MTMsMzg3LjY3OHoiLz4NCjxwYXRoIHN0eWxlPSJmaWxsOiNGRkQ3NjQ7IiBkPSJNNDQ0Ljg1MywzODcuNjc4YzMuNDkyLDcuMDA1LDUuMzM2LDE0Ljk5OSw1LjMzNiwyMy4xMTdjMCwyNS41NTktMTcuOTM1LDQ2LjM1OC0zOS45OTIsNDYuMzU4DQoJSDc3LjI2NGMtMjUuNTU5LDAtNDYuMzU4LTIwLjc5OS00Ni4zNTgtNDYuMzU4YzAtOC4xMTgsMi4xNDMtMTYuMTEyLDYuMTgxLTIzLjExN2wxNzguNzM2LTMwOS41OA0KCWM4LjI4My0xNC4zNCwyMy42NzQtMjMuMjUxLDQwLjE3Ny0yMy4yNTFjMC40NDMsMCwwLjg4NiwwLjAxLDEuMzI5LDAuMDMxYzEzLjczMiwwLjUzNiwyNi40MTQsOS4zMjMsMzMuMzI2LDIzLjIyTDQ0NC44NTMsMzg3LjY3OHoNCgkiLz4NCjxwYXRoIHN0eWxlPSJmaWxsOiMzQjQxNDU7IiBkPSJNMjU2LDM1NC4xMzF2NTEuNTA5YzE0LjIyNywwLDI1Ljc1NS0xMS41MjgsMjUuNzU1LTI1Ljc1NQ0KCUMyODEuNzU1LDM2NS42NTksMjcwLjIyNywzNTQuMTMxLDI1NiwzNTQuMTMxeiIvPg0KPHBhdGggc3R5bGU9ImZpbGw6IzUyNUE2MTsiIGQ9Ik0yNTYsMzU0LjEzMWMyLjg0MywwLDUuMTUxLDExLjUyOCw1LjE1MSwyNS43NTVjMCwxNC4yMjctMi4zMDgsMjUuNzU1LTUuMTUxLDI1Ljc1NQ0KCWMtMTQuMjI3LDAtMjUuNzU1LTExLjUyOC0yNS43NTUtMjUuNzU1QzIzMC4yNDUsMzY1LjY1OSwyNDEuNzczLDM1NC4xMzEsMjU2LDM1NC4xMzF6Ii8+DQo8cGF0aCBzdHlsZT0iZmlsbDojM0I0MTQ1OyIgZD0iTTI1NiwxMzIuNjQ2VjMyMy4yM2MxNC4yMjcsMCwyNS43NTUtMTEuNTM4LDI1Ljc1NS0yNS43NTVWMTU4LjQwMQ0KCUMyODEuNzU1LDE0NC4xNzQsMjcwLjIyNywxMzIuNjQ2LDI1NiwxMzIuNjQ2eiIvPg0KPHBhdGggc3R5bGU9ImZpbGw6IzUyNUE2MTsiIGQ9Ik0yNTYsMTMyLjY0NmMyLjg0MywwLDUuMTUxLDExLjUyOCw1LjE1MSwyNS43NTV2MTM5LjA3NGMwLDE0LjIxNi0yLjMwOCwyNS43NTUtNS4xNTEsMjUuNzU1DQoJYy0xNC4yMjcsMC0yNS43NTUtMTEuNTM4LTI1Ljc1NS0yNS43NTVWMTU4LjQwMUMyMzAuMjQ1LDE0NC4xNzQsMjQxLjc3MywxMzIuNjQ2LDI1NiwxMzIuNjQ2eiIvPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPC9zdmc+DQo=" />';}var el = $("<div />",{class: 'spuser_alert'});el.append($("<div />",{ class: 'spuser_alert_cont' }).append( $("<a />",{href:"#", class: 'spuser_alert_close', text: "x"}).on("click", function(e) { e.preventDefault(); el.removeClass("show"); setTimeout(function(){ el.remove() }, 600); }) ).append( img  ).append( $("<p />",{class: 'spuser_alert_text', text: text}) ));$("body").append(el);setTimeout(function(){ el.addClass("show"); }, 100);setTimeout(function(){ el.find(".spuser_alert_close").focus(); }, 110);return;}
const loading = function(text){var el = $("#spuser_loading");if(!el.length){el = $('<div class="spuser_modal" id="spuser_loading"><div class="spuser_modal_load"><p class="spuser_modal_load_title"><span id="load-msg">Cargando</span><span>.</span><span>.</span><span>.</span></p></div></div>')};el.find("#load-msg").text(text);$("body").append(el);el.fadeIn();}
const loading_end = function(time = 0){var el = $("#spuser_loading");if(el.length > 0){setTimeout(function(){el.fadeOut();setTimeout(function() { el.remove();}, 500);}, time);}}
const spuser_open = function(el){$("#spuser_back").fadeIn(); $("#spuser_back .spuser_cont:not("+el+")").removeClass("active"); $(el).show(); setTimeout(function(){$("#spuser_back .spuser_cont:not("+el+")").hide();$(el).addClass("active");},300);}
$.fn.serializeObject = function() {var o = {};var a = this.serializeArray();$.each(a, function() {if (o[this.name]) {if (!o[this.name].push) {o[this.name] = [o[this.name]];}o[this.name].push(this.value || '');} else {o[this.name] = this.value || '';}});return o;};

$(document).ready(function(){

	$(".spuser_logout").click(function(e){
		loading("Cerrando sesión");
		$.ajax({
           	type : "POST",
           	url : ajax.url,
           	dataType: 'json',
           	data : {
           		action: 'spuser',
                logout: ajax.nonce
           	},
           	error: function(rsp){
           		alert("Sistema no disponible intente más tarde!");
           		loading_end();
           	},
           	success: function(rsp) {
           		if(rsp.r){
           			window.location.reload();
           		}else{
           			loading_end();
           			alert(rsp.m);
           		}
			}
		})
	})

})
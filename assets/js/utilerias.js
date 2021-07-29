(function(){
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
})();
/*
|--------------------------------------------------------------------------
| FUNCIONES GENERALES
|--------------------------------------------------------------------------
*/
const notyf = new Notyf({
  position: {
      x: 'right',
      y: 'top',
  },
  types: [
    {
      type: 'warning',
      background: 'orange',
      icon: {
          className: 'fas fa-exclamation-circle',
          tagName: 'span',
          color: '#fff'
      },
      dismissible: true,
      duration: 5000
    },
    {
      type: 'danger',
      background: 'red',
      icon: {
          className: 'fas fa-exclamation-triangle',
          tagName: 'span',
          color: '#fff'
      },
      dismissible: true,
      duration: 5000
    },
    {
      type: 'info',
      background: 'black',
      icon: {
          className: 'fas fa-info-circle',
          tagName: 'span',
          color: '#fff'
      },
      dismissible: true,
      duration: 2500
    },
    {
      type: 'success',
      background: 'green',
      icon: {
          className: 'fas fa-check',
          tagName: 'span',
          color: '#fff'
      },
      dismissible: true,
      duration: 3500
    }
  ]
});

// Función de animación de carga del sistema
function loader(opcion = true){
  const loader = $("#loader");
  if ( opcion == true ){
    if ( loader.is(":visible") == false )
      loader.fadeIn('fast');
  }
  else 
    loader.fadeOut(850);  
}

// Función para reducir la llamada a la url base del sistema
function url(url = "", comodin = true, hash = true){
  url = (comodin)? "index.php/" + url : url;
  if ( hash )
    return $("#base_url").val() + url + fu_cache_buster();
  else
    return $("#base_url").val() + url;
}

// Activar opción de menú seleccionado
function fu_activa_menu(_opcion){
  if ( _opcion ){
    var opciones    = $('.sidebar-text'),
        desplegable;

    opciones.each(function(index, opcion) {
      if ( $(opcion).text() == _opcion ){
          $(opcion).parents('.nav-item').addClass('active');
          $(opcion).trigger('click');
      }
    });
  }
}

function fu_cache_buster(){
  var hash = ( new Date() ).getTime();
  return `?${hash}`;
}

/**
|   Función que muestra alertas si se incluye el apartado en el HTML
|     Parámetros:
|               @param mensaje    -   Contenido de la alerta
|               @param color      -   Color de la alerta
|               @param contenedor -   Padre del objeto alert
|               @param apilar     -   Activa/descativa el apilar de las alertas
*/
function fu_alerta(mensaje = '', color = '', contenedor = '', apilar = false){
  let alerta  = $(`${contenedor} #alertas`);
  color       = ( color == '' )? 'primary' : color;

  if ( mensaje == '' ){ // Eliminar alertas
    alerta.html('');
    return;
  }

  let html    = `
  <div tabindex="-1" class="alert alert-${color} alert-dismissible fade show" role="alert">
    ${mensaje}
    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  `;
  if ( apilar )
    alerta.append(html);
  else 
    alerta.html(html);
  
  // Scroll al alert
  $([document.documentElement, document.body]).animate({
      scrollTop: $(alerta).offset().top
  }, 300);
}

/**
|   Función que habilita las notificaciones tipo toast
|       Recibe:
|               Encabezado     -   Cabecera
|               Notificacion   -   Cuerpo
|               Tipo           -   Color
|               Duracion       -   3.5 segundos por defecto
|   Cambia el estilo si solo se ingresa la Cabecera
|   Apilable si se invoca más de 1 vez
*/
function fu_toast(encabezado = "", notificacion = "", tipo = "danger", duracion = 5){
  let notificaciones = $("#notificaciones");

  let color   = (tipo == "rojo")?   "fondo-rojo": 
                (tipo == "verde")?  "fondo-verde": 
                (tipo == "dorado")? "fondo-dorado": 
                "bg-" + tipo;
  let texto   = (tipo == "muted" || tipo == "light" || tipo == "white")? "texto-rojo" : 
                "text-white";

  let titulo  = "";

  if ( ( notificacion == "" || notificacion == null ) && encabezado != "" ){
    notificacion     = encabezado;
    encabezado  = "";
  }

  if ( encabezado != "" )
    titulo = `
      <div class="toast-header">
        <div class="`+ color +` rounded mr-2" style="width: 20px; height: 20px;"></div>
        <strong class="mr-auto">`+ encabezado +`</strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>`;

  var toast_html = `
    <div class="toast `+ color +`" role="alert" aria-live="assertive" aria-atomic="true" data-delay="`+ duracion * 1000 +`" style="min-width: 350px;">
      `+ titulo +`
      <div class="toast-body `+ texto +`">
      `+ notificacion +`
      </div>
    </div>
  `;
  notificaciones.append(toast_html);

  $(".toast").toast('show');

  setTimeout(function() {
      $('.toast').each(function(index, tostada) {
        if ( index > 0 )
          notificaciones.append(tostada);
        else 
          notificaciones.html('');
      });
  }, duracion * 1000);
}

function fu_notificacion(notificacion, tipo='info', duracion ){  
  notyf.open({
    type: tipo,
    message: notificacion,
    duration: duracion
  });
}

function fu_close_toast(){ $(this).hide(100); }

/*
|--------------------------------------------------------------------------
| FUNCIONES CONTROLLER
|--------------------------------------------------------------------------
*/

// Función que permite abrir/recargar una ventana de nombre único para evitar otras del mismo nombre
function fu_abrir_ventana(vUrl, nombre, opciones = "", objetoVentana){
  var ventana;
  if ( objetoVentana != null ){
    if ( ! objetoVentana.closed ){
      objetoVentana.focus();
      objetoVentana.location.href = vUrl;
      return objetoVentana;
    }
  }
  ventana = window.open( vUrl, nombre, opciones );
  return ventana;
}

// Función que dada un URL o propiedad data, carga una vista modo ajax
function fu_muestra_vista(vUrl, datos = [], async = false){
  vUrl = ( $(this).data("url") )? $(this).data("url") : vUrl;
  var html = "";
  if ( vUrl ){
  	$.ajax({
  		url:    vUrl,
  		type:   'POST',
  		cache:  true,
  		async:  async,
  		global: false,
  		data:   datos,
  		success: function(data, textStatus, xhr) {
  			try {
          data = JSON.parse(data);
          if ( data.exito )
            html = data.html;
          if ( data.error )
            fu_notificacion(data.error, 'danger', 5000);
          if ( data.mensaje )
            fu_notificacion(data.mensaje, 'info', 2500);
        } catch(e) {
          console.log(e);
          fu_toast('Falló el cargar la vista.');
        }
  		},
  		fail: function(xhr, textStatus, errorThrown){ 
  			fu_toast('Falló carga de la vista. Petición fallida.');
  		},
  		error: function(xhr, textStatus, errorThrown){ 
  			fu_toast('Ha ocurrido un problema al cargar la vista');
  		}
  	});
  }
  return html;
}

// Función de consulta con json, retornando un arreglo
function fu_json_query(vUrl, datos = []){
  vUrl = ( $(this).data("url") )? $(this).data("url") : vUrl;
  var json;
  if ( vUrl ){
    $.ajax({
      url:    vUrl,
      type:   'POST',
      cache:  true,
      async:  false,
      global: false,
      data:   datos,
      success: function(data, textStatus, xhr) {
        try {
          json = JSON.parse(data);
          if ( json.estatus == 'sess_expired' )
            fu_notificacion((json.mensaje)? json.mensaje : 'Sesión expirada.', 'danger');
        } catch(e) {
          fu_toast('Falló el cargar la vista.');
        }
      },
      fail: function(xhr, textStatus, errorThrown){ 
        fu_toast('Falló carga de la vista. Petición fallida.');
      },
      error: function(xhr, textStatus, errorThrown){ 
        fu_toast('Ha ocurrido un problema al cargar la vista');
      }
    });
  }
  return json;
}

function fu_form_controller(fUrl, formconf = [], inputs = [], contenedor = "main" ){
  if ( ! formconf || formconf == null )
    formconf = {
    	id:     `form-${contenedor}`,
    	name:   `form-${contenedor}`,
    	action: fUrl,
    	method: 'POST'
    }
  else {
    formconf.id     = ( formconf.id     ) ? formconf.id     : 
                      ( formconf.name   ) ? formconf.name   : `form-${contenedor}`;
    formconf.name   = ( formconf.name   ) ? formconf.name   : 
                      ( formconf.id     ) ? formconf.id     : `form-${contenedor}`;
    formconf.action = ( formconf.action ) ? formconf.action : fUrl;
    formconf.method = ( formconf.method ) ? formconf.method : `POST`;
  }

  if ( inputs == null || inputs == undefined )
    inputs = [];

  var form = $("<form/>", formconf );

  inputs.forEach( function(input, index) {
    form.append( 
      $("<input>", 
        {
          id:     ( input.id    ) ? input.id    :   
                  ( input.name  ) ? input.name  :   `input${index + 1}`,
          name:   ( input.name  ) ? input.name  :   
                  ( input.id    ) ? input.id    :   `input${index + 1}`,
          type:   ( input.type  ) ? input.type  :   `hidden`,
          value:  ( input.value ) ? input.value :  '',
        }
      )
    );
  });

  $(contenedor).html(form);
  return {'id': formconf.id, 'name': formconf.name};
}

/**
|   Función que habilita el modal
|       Recibe:
|               Titulo      -   Cabezara
|               Contenido   -   Cuerpo
|               Botones     -   Pie
|   Requiere un contenido para motrarse
|   Parametro html = true para insertar código HTML
 */
function fu_modal(titulo, contenido = "", botones = "", anchura = "xl", tipo = '', static = true){
  var contenedor  = $("#modales"),
      modal       = $("#modal");
      
  if ( !titulo || !contenido && ( titulo == '' && contenido == '') )
    modal.modal('hide');
      
  if ( titulo == "ERR"){
    titulo    = "ERROR NO CONTROLADO";
    contenido = (contenido != "")? contenido: "Ha ocurrido un error al intentar ingresar al sistema, por favor, comunique al administrador del sistema.";
    tipo      = 'notificacion';
    static    = false;
  }
  else if ( titulo == "CNX"){
    titulo    = "FALLÓ LA CONEXIÓN";
    contenido = "Falló la conexión con el servidor.<br>Por favor, verifique su conexión a internet.";
    tipo      = 'notificacion';
    static    = false;
  }
  else if ( titulo == "404"){
    titulo    = "404 - Página no encontrada";
    contenido = "La página no es accesible o no existe.";
    tipo      = 'notificacion';
    static    = false;
  }

  if( contenido == "" )
    return;

  contenedor.html(fu_muestra_vista( url('Home/modales', true, false), {tipo: tipo} ));

  contenedor  = $("#modales"),
  modal       = $("#modal");

  if ( titulo )
    $('.modal-header').prepend(titulo);
  else 
    $('.modal-header').hide();

  if ( contenedor ){
    if ( anchura == "lg" ){
      $("#modal .modal-dialog").removeClass('modal-xl');
      $("#modal .modal-dialog").addClass('modal-lg');
    } else if ( anchura == "xl" ){
      $("#modal .modal-dialog").removeClass('modal-lg');
      $("#modal .modal-dialog").addClass('modal-xl');
    } else {
      $("#modal .modal-dialog").removeClass('modal-xl');
      $("#modal .modal-dialog").removeClass('modal-lg');
    }

    $("#modal #modal-title-notification").html(titulo);
    $("#modal #modal-contenido").html(contenido);

    let color = (tipo != 'login' && tipo != 'notificacion' )? 'text-secondary' : 'text-primary';
    if ( botones == "" )
      $("#modal #modal-botones").html(`<button type="button" class="btn btn-link ${color} ms-auto" data-bs-dismiss="modal">Cerrar</button>`);
    else if ( botones == "salir" )
      $("#modal #modal-botones").html(`<a href="${ url() }" class="btn btn-secondary">Salir</a>`);
    else 
      $("#modal #modal-botones").html(botones);  

    if ( static )
      modal.modal({
        backdrop: 'static',
        keyboard: false
      });
    
    modal.modal('show');
  }
}

/*
|--------------------------------------------------------------------------
| FUNCIONES VALIDADORAS/RESTRICTORAS DE DATOS
|--------------------------------------------------------------------------
*/

// Función que valida que una CURP cumpla con el formato obligatorio
function fu_valida_curp(curp) {
  if ( curp.length < 18 )
    return false;

  var re = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0\d|1[0-2])(?:[0-2]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
      validado = curp.match(re);
  
  if (! validado )
    return false;

  if (validado[2] != digitoVerificador(validado[1])) 
    return false;
        
  return true; //Validado
}

// Dígito de validación de CURPS
function digitoVerificador(digito) {
  var diccionario  = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
      lngSuma      = 0.0,
      lngDigito    = 0.0;
  for(var i=0; i<17; i++)
      lngSuma= lngSuma + diccionario.indexOf(digito.charAt(i)) * (18 - i);
  lngDigito = 10 - lngSuma % 10;
  if(lngDigito == 10)
      return 0;
  return lngDigito;
}

// Functión que dado un evento transforma un diccionario de caracteres a un diccionario normalizado
function fu_normaliza_caracteres(){
    let cadena_normalizar = $(this).val();
    let cadena_normalizada = normalizar(cadena_normalizar);
    $(this).val(cadena_normalizada.trim().toUpperCase());
}

// Función que permite el ingreso de dígitos únicamente
function fu_solo_numeros( e ){
  if( e.keyCode < 48 || e.keyCode > 57 )
    return false;
}

// Función para validar estructura general de correos
function fu_validar_correo(email) {
  return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(email);
}

// Función para validar estructura general de correos V2
function fu_validar_correo_2(correo_electronico) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(correo_electronico);
}

// Función validadora de políticas de password
function fu_valida_password(usuario, password){
  let valoraciones    = [];
  valoraciones.exito  = true;

  if ( ! usuario.match(/^[0-9]{6}$/) )
    valoraciones.push(
      {
        campo         :   'usuario',
        resultado     :   false,
        valoracion    :   'numerico',
        mensaje       :   'El número de cuenta es inválido'
      }
    );
  else 
    valoraciones.push(
      {
        campo         :   'usuario',
        resultado     :   true,
        valoracion    :   'numerico',
      }
    );

  if ( password.length < 6 || password == '' ){
    valoraciones.exito = false;
    valoraciones.push(
      {
        campo       : 'password',
        resultado   : false,
        valoracion  : 'longitud',
        mensaje     : 'La contraseña no es válida'
      }
    );
  } else 
    valoraciones.push(
      {
        campo       : 'password',
        resultado   : true,
        valoracion  : 'longitud',
        mensaje     : 'Contraseña válida'
      }
    );
  return valoraciones;
}

function fu_valida_url( url ){
  var expression  = '^(http[s]?:\\/\\/(www\\.)?|ftp:\\/\\/(www\\.)?|www\\.){1}([0-9A-Za-z-\\.@:%_\+~#=]+)+((\\.[a-zA-Z]{2,3})+)(/(.)*)?(\\?(.)*)?';
  var regex       = new RegExp(expression);
  return regex.test(url);
}

function fu_valida_trimestre( trimestre ){
  var resultado;
  switch (trimestre) {
    case '1':
      resultado = {
        inicio: new Date( new Date().getFullYear(), 00, 01), // 1ro. enero
        termino: new Date( new Date().getFullYear(), 02, 31) // 31 de marzo
      };
      break;
    case '2':
      resultado = {
        inicio: new Date( new Date().getFullYear(), 03, 01), // 1ro. de abril
        termino: new Date( new Date().getFullYear(), 05, 30) // 30 de junio
      };
      break;
    case '3':
      resultado = {
        inicio: new Date( new Date().getFullYear(), 06, 01), // 1ro. de julio
        termino: new Date( new Date().getFullYear(), 08, 30) // 30 de septiembre
      };
      break;
    case '4':
      resultado = {
        inicio: new Date( new Date().getFullYear(), 09, 01), // 1ro. octubre
        termino: new Date( new Date().getFullYear(), 11, 31) // 31 de Diciembre
      };
      break;
    default:
      resultado = false;
      break;
  }
  return resultado;
}

// Codificar UTF-8
function codifica_utf8( cadena ){
  return window.btoa( unescape( encodeURIComponent( cadena ) ) );
}

// Decodificar UTF-8
function decodifica_utf8( cadena ){
  return decodeURIComponent( escape( window.atob( cadena ) ) );
}

// Funciones de formateo

function fu_formatMxn( cantidad ){
  return Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(cantidad);
}

function fu_formatNum( cantidad ){
  return Intl.NumberFormat('es-MX').format(cantidad);
}
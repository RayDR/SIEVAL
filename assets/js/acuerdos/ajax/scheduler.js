var scheduler = '#planificador_acuerdos',
    Registro  = 'Acuerdos/registrar';

$(document).off('click','.scheduler-event-content').on('click','.scheduler-event-content', function(event) {
});
$(document).ready(function($) {
  finiciar_scheduler();

  $('#nuevo_acuerdo').click(fmuestra_registro);
});

function finiciar_scheduler(){
  var datos = [];
  acuerdos.forEach( function(acuerdo, index) {
    let _endDate = ( acuerdo.estatus_seguimiento == 'Terminado')? acuerdo.fecha_actualizacion_seguimiento : moment(acuerdo.fecha_creacion_acuerdo).add(acuerdo.fecha_respuesta, 'days');
    datos.push({
      disabled  : false,
      content   : `${acuerdo.estatus_seguimiento}: ${acuerdo.asunto}`,
      startDate : new Date(acuerdo.fecha_creacion_acuerdo),
      endDate   : new Date(_endDate)
    });
  });
    
  YUI({lang: 'es-MX'}).use(
    'aui-scheduler',
    function(Y) {

      var agenda    = new Y.SchedulerAgendaView({
            isoTime   : true,
            strings: {
              noEvents  : 'No hay acuerdos registrados'
            }
          }),
          calDia    = new Y.SchedulerDayView({
            isoTime   : true,
            strings   : { allDay: 'Todo el día' }
          }),
          calSemana = new Y.SchedulerWeekView({
            isoTime   : true,
            strings   : { allDay: 'Todo el día' }
          }),
          calMes    = new Y.SchedulerMonthView({
            isoTime   : true,
            strings: {
              close   : 'Cerrar',
              show    : 'Mostrar',
              more    : 'más'
            }
          });

      new Y.Scheduler(
        {
          boundingBox : scheduler,
          activeView  : agenda,
          date        : new Date(),
          items       : datos,
          render      : true,
          strings: {
            agenda  : 'Agenda',
            day     : 'Día',
            month   : 'Mes',
            today   : 'HOY',
            week    : 'Semana',
            year    : 'Año'
          },
          views         : [ agenda, calMes, calSemana, calDia ]
        }
      );
    }
  );

}

function fmuestra_registro(e){
    if ( e == null || e == undefined )
        return;
    e.preventDefault();
    var vista = fu_muestra_vista( url(vRegistro, true, false) );
    if ( vista )
        $('#ajax-html').html(vista);
}
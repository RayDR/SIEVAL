CREATE OR REPLACE ALGORITHM = UNDEFINED DEFINER = `root`@`localhost` SQL SECURITY DEFINER VIEW `sipat`.`vw_proyecto_actividades` AS SELECT
   `act`.`actividad_id` AS `actividad_id`,
   `act`.`descripcion` AS `actividad`,
   `act`.`beneficiado_id` AS `beneficiado_id`,
   `act`.`fuente_financiamiento_id` AS `fuente_financiamiento_id`,
   `f`.`descripcion` AS `descripcion`,
   `b`.`descripcion` AS `beneficiados`,
   `act`.`cantidad_beneficiario` AS `cantidad_beneficiario`,
   `act`.`estatus` AS `estatus_actividad`,
   `act`.`fecha_creacion` AS `fecha_creacion_actividad`,
   `act`.`fecha_actualizacion` AS `fecha_actualizacion_actividad`,
   `act`.`medicion_id` AS `medicion_id`,
   `medic`.`descripcion` AS `medicion`,
   `act`.`unidad_medida_id` AS `unidad_medida_id`,
   `uni_med`.`descripcion` AS `unidad_medida`,
   `act`.`proyecto_id` AS `proyecto_id`,
   `proyectos`.`proyecto_nombre` AS `proyecto_nombre`,
   `proyectos`.`techo_financiero` AS `proyecto_techo_financiero`,
   `proyectos`.`ejercicio` AS `proyecto_ejercicio`,
   `act`.`descripcion` AS `actividad_general`,
   `act`.`linea_accion_id` AS `linea_accion_id`,
   `vla`.`linea_accion` AS `linea_accion`,
   `vla`.`cve_objetivo` AS `cve_objetivo`,
   `vla`.`objetivo_programa_id` AS `objetivo_programa_id`,
   `vla`.`objetivo_programa` AS `objetivo_programa`,
   `vla`.`estrategia_programa_id` AS `estrategia_programa_id`,
   `vla`.`estrategia_programa` AS `estrategia_programa`,
   concat_ws( '-', `act`.`proyecto_id`, `act`.`actividad_id` ) AS `folio`,
   `act`.`combinacion_area_id` AS `combinacion_area_id`,
   `combo_area`.`cve_direccion` AS `cve_direccion`,
   `combo_area`.`cve_subdireccion` AS `cve_subdireccion`,
   `combo_area`.`cve_departamento` AS `cve_departamento`,
   `combo_area`.`cve_area` AS `cve_area`,
   `combo_area`.`direccion` AS `direccion`,
   `combo_area`.`subdireccion` AS `subdireccion`,
   `combo_area`.`departamento` AS `departamento`,
   `combo_area`.`area` AS `area`,
   `act`.`programa_presupuestario_id` AS `programa_presupuestario_id`,
   `prog_presup`.`cve_programa` AS `cve_programa`,
   `prog_presup`.`descripcion` AS `programa_presupuestario`,
   concat_ws( ' ', `prog_presup`.`cve_programa`, `prog_presup`.`descripcion` ) AS `programa_presupuestario_clave`,
   `prog_presup`.`techo_financiero` AS `techo_financiero`,
   `prog_presup`.`objetivo` AS `objetio_programa_presupuestario`,(
   SELECT
      sum( `vw_seguimiento_actividades`.`programado_fisico` ) 
   FROM
      `vw_seguimiento_actividades` 
   WHERE
      ( `vw_seguimiento_actividades`.`actividad_id` = `act`.`actividad_id` )) AS `programado_fisico`,(
   SELECT
      sum( `vw_seguimiento_actividades`.`realizado_fisico` ) 
   FROM
      `vw_seguimiento_actividades` 
   WHERE
      ( `vw_seguimiento_actividades`.`actividad_id` = `act`.`actividad_id` )) AS `realizado_fisico`,(
   SELECT
      sum( `vw_seguimiento_actividades`.`programado_financiero` ) 
   FROM
      `vw_seguimiento_actividades` 
   WHERE
      ( `vw_seguimiento_actividades`.`actividad_id` = `act`.`actividad_id` )) AS `programado_financiero`,(
   SELECT
      sum( `vw_seguimiento_actividades`.`realizado_financiero` ) 
   FROM
      `vw_seguimiento_actividades` 
   WHERE
   ( `vw_seguimiento_actividades`.`actividad_id` = `act`.`actividad_id` )) AS `realizado_financiero` 
FROM
   (((((((((((
                                    `actividades` `act`
                                    JOIN `vw_proyectos` `proy` ON ((
                                          `act`.`proyecto_id` = `proy`.`proyecto_actividad_id` 
                                       )))
                                 JOIN `unidades_medida` `uni_med` ON ((
                                       `act`.`unidad_medida_id` = `uni_med`.`unidad_medida_id` 
                                    )))
                              JOIN `mediciones` `medic` ON ((
                                    `act`.`medicion_id` = `medic`.`medicion_id` 
                                 )))
                           JOIN `lineas_accion` `la` ON ((
                                 `la`.`linea_accion_id` = `act`.`linea_accion_id` 
                              )))
                        JOIN `beneficiados` `b` ON ((
                              `act`.`beneficiado_id` = `b`.`beneficiado_id` 
                           )))
                     JOIN `fuentes_financiamiento` `f` ON ((
                           `f`.`fuente_financiamiento_id` = `act`.`fuente_financiamiento_id` 
                        )))
                  JOIN `usuarios` `u` ON ((
                        `u`.`usuario_id` = `act`.`usuario_id` 
                     )))
               JOIN `vw_linea_accion` `vla` ON ((
                     `vla`.`linea_accion_id` = `act`.`linea_accion_id` 
                  )))
            JOIN `combinaciones_areas` `combo_area` ON ((
                  `combo_area`.`combinacion_area_id` = `act`.`combinacion_area_id` 
               )))
         JOIN `programas_presupuestarios` `prog_presup` ON ((
               `prog_presup`.`programa_presupuestario_id` = `act`.`programa_presupuestario_id` 
            )))
      JOIN `proyectos` ON ((
            `proyectos`.`proyecto_actividad_id` = `act`.`proyecto_id` 
         ))) 
ORDER BY
   `act`.`proyecto_id`,
   `act`.`actividad_id` DESC;
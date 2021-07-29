CREATE OR REPLACE ALGORITHM = UNDEFINED DEFINER = `root`@`localhost` SQL SECURITY DEFINER VIEW `sieval`.`vw_proyectos` AS SELECT
   `proyectos`.`proyecto_actividad_id` AS `proyecto_actividad_id`,
   `proyectos`.`proyecto_nombre` AS `proyecto_nombre`,
   `proyectos`.`techo_financiero` AS `techo_financiero`,
   `proyectos`.`fecha_creacion` AS `fecha_creacion`,
   `proyectos`.`fecha_actualizacion` AS `fecha_actualizacion`,
   `proyectos`.`ejercicio` AS `ejercicio`,
   `proyectos`.`estatus` AS `estatus`,
   `proyectos`.`usuario_id` AS `usuario_id`,
   `usuarios`.`nombres` AS `usuario_registro_nombres`,
   `usuarios`.`primer_apellido` AS `usuario_registro_primer_apellido`,
   `usuarios`.`segundo_apellido` AS `usuario_registro_segundo_apellido`,
   `usuarios`.`combinacion_area_id` AS `usuario_registro_combinación_area_id`,
   `proyectos`.`preproyecto` AS `preproyecto`,
   `proyectos`.`combinacion_area_id` AS `combinacion_area_id`,
   `combo_area`.`direccion_id` AS `direccion_id`,
   `direcciones`.`cve_direccion` AS `cve_direccion`,
   `direcciones`.`descripcion` AS `direccion`,
   `combo_area`.`subdireccion_id` AS `subdireccion_id`,
   `subdirecciones`.`cve_subdireccion` AS `cve_subdireccion`,
   `subdirecciones`.`descripcion` AS `subdireccion`,
   `combo_area`.`departamento_id` AS `departamento_id`,
   `departamentos`.`cve_departamento` AS `cve_departamento`,
   `departamentos`.`descripcion` AS `departamento`,
   `combo_area`.`area_id` AS `area_id`,
   `areas`.`cve_area` AS `cve_area`,
   `areas`.`descripcion` AS `area` 
FROM
   ((((((
                     `proyectos`
                     LEFT JOIN `combinaciones_areas` `combo_area` ON ((
                           `combo_area`.`combinacion_area_id` = `proyectos`.`combinacion_area_id` 
                        )))
                  LEFT JOIN `direcciones` ON ((
                        `direcciones`.`direccion_id` = `combo_area`.`direccion_id` 
                     )))
               LEFT JOIN `subdirecciones` ON ((
                     `subdirecciones`.`subdireccion_id` = `combo_area`.`subdireccion_id` 
                  )))
            LEFT JOIN `departamentos` ON ((
                  `departamentos`.`departamento_id` = `combo_area`.`departamento_id` 
               )))
         LEFT JOIN `areas` ON ((
               `areas`.`area_id` = `combo_area`.`area_id` 
            )))
      JOIN `usuarios` ON ((
         `usuarios`.`usuario_id` = `proyectos`.`usuario_id` 
   )));
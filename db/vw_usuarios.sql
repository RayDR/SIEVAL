CREATE OR REPLACE ALGORITHM = UNDEFINED DEFINER = `root`@`localhost` SQL SECURITY DEFINER VIEW `sieval`.`vw_usuarios` AS SELECT
   `u`.`usuario` AS `usuario`,
   `u`.`contrasena` AS `contrasena`,
   `u`.`telefono` AS `telefono`,
   `u`.`correo` AS `correo`,
   `dt`.`combinacion_area_id` AS `combinacion_area_usuario_id`,
   `dt`.`cve_direccion` AS `cve_direccion`,
   `dt`.`direccion` AS `direccion`,
   `dt`.`cve_subdireccion` AS `cve_subdireccion`,
   `dt`.`subdireccion` AS `subdireccion`,
   `dt`.`cve_departamento` AS `cve_departamento`,
   `dt`.`departamento` AS `departamento`,
   `dt`.`cve_area` AS `cve_area`,
   `dt`.`direccion_id` AS `direccion_id`,
   `dt`.`subdireccion_id` AS `subdireccion_id`,
   `dt`.`departamento_id` AS `departamento_id`,
   `dt`.`area_id` AS `area_id`,
   `dt`.`area` AS `area`,
   `u`.`nombres` AS `nombres`,
   `u`.`primer_apellido` AS `primer_apellido`,
   `u`.`segundo_apellido` AS `segundo_apellido`,
   `u`.`sexo` AS `sexo`,
   `u`.`tipo_usuario_id` AS `tipo_usuario_id`,
   `ctg`.`cve_categoria` AS `cve_categoria`,
   `ctg`.`descripcion` AS `categoria`,
   `u`.`cve_cuenta` AS `cve_cuenta`,
   `u`.`usuario_id` AS `usuario_id`,
   `ctg`.`categoria_id` AS `categoria_id`,
   `titulos`.`alias` AS `alias`,
   `titulos`.`descripcion` AS `titulo`,
   `u`.`estatus` AS `estatus` 
FROM
   (((
            `usuarios` `u`
            JOIN `combinaciones_areas` `dt` ON ((
                  `u`.`combinacion_area_id` = `dt`.`combinacion_area_id` 
               )))
         JOIN `categorias` `ctg` ON ((
               `u`.`categoria_id` = `ctg`.`categoria_id` 
            )))
      LEFT JOIN `titulos` ON ((
         `u`.`titulo_id` = `titulos`.`titulo_id` 
   )));
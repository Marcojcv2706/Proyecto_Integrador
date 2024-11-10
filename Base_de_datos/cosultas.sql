INSERT INTO rol(ID, descripcion_rol) 
VALUES (1, 'Asistente de eventos');

INSERT INTO usuario(username, Email, Contraseña)
VALUES ('Admin', 'admin@sumzone.com', '$2y$10$sd/hFnuhfGbM1egKZvp.Zekx88zx4z4c6//eIhh/h8F')/*la contraseña es 12345678*/;

INSERT INTO `evento`( `Nombre`, `Descripcion`, `Fecha`, `Frecuencia`, `Horario_inicio`, `Horario_fin`,`Tipo_evento`) 
VALUES ('Taller de Ejemplo','Taller de ejmplo para probar','2024-11-06','mar, mie, jue','16:00:00','18:00:00','1');

INSERT INTO `sumzone`.`consultas` (`ID`, `ID_usuario`, `tipo_consulta`, `texto_consulta`, `fecha_consulta`, `estado`, `texto_respuesta`, `ID_usuario_respuesta`) VALUES
(1, 1, 'sugerencia', 'hagan mas torneos de futbol', '2024-11-10 00:11:54', 'pendiente', NULL, NULL),
(2, 1, 'solicitud', 'quiero jugar basquet mañana con mis amigos', '2024-11-10 00:13:54', '', 'porque no funtiona', NULL),
(3, 1, 'pregunta', 'cuando habre el sum?', '2024-11-10 00:14:05', '', 'mañana', NULL),
(4, 1, 'pregunta', 'cuando habre el sum?', '2024-11-10 00:16:14', '', 'a', NULL),
(5, 1, 'sugerencia', 'asd', '2024-11-10 00:16:37', 'pendiente', NULL, NULL),
(6, 1, 'sugerencia', 'asd', '2024-11-10 00:18:39', '', 'a', NULL),
(7, 1, 'sugerencia', 'asd', '2024-11-10 00:20:15', '', 'muy mal', NULL),
(8, 1, 'solicitud', 'dddddd', '2024-11-10 00:20:19', 'pendiente', NULL, NULL);
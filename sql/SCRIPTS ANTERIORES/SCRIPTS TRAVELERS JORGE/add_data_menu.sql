/*EN LOCAL*/
USE bdmundipack;


INSERT INTO se_menu (MenuPadre, Nombre, Orden, Icono, URL, Estado) VALUES ('5', 'Consumos', '1', 'fa fa-money', '../travelers/consumos.php', 0);
INSERT INTO se_menu (MenuPadre, Nombre, Orden, Icono, URL, Estado) VALUES ('5', 'Pagos Realizados', '2', 'fa fa-money', '../travelers/pagos.php', 1);
INSERT INTO se_menu (Nombre, Orden, Icono, URL, Estado) VALUES ('Travelers Abiertos', '4', 'fa fa-user', '../travelers/traveler_abiertos.php', 1);
INSERT INTO se_menu (Nombre, Orden, Icono, Estado) VALUES ('Paquetes de Viajes', '4', 'fa fa-plane', 1);
INSERT INTO se_menu (MenuPadre, Nombre, Orden, Icono, URL, Estado) VALUES ('19', 'Paquetes Ofertados', '1', '', '../travelers/paquetes.php', 1);
INSERT INTO se_menu (MenuPadre, Nombre, Orden, Icono, URL, Estado) VALUES ('19', 'Paquetes Adquiridos', '2', '', '../travelers/paquetes_adquiridos.php', 1);


SELECT * FROM se_menu;
INSERT INTO se_menu (MenuPadre, Nombre, Orden, Icono, URL, Estado) VALUES ('5', 'Pagos Realizados', '2', 'fa fa-money', '../partners/pagos.php', 1);


INSERT INTO se_menu (MenuPadre, Nombre, Orden, Icono, URL, Estado) VALUES ('5', 'Pagos Travelers', '2', 'fa fa-money', '../partners/pagos.php', 1);
INSERT INTO se_menu (MenuPadre, Nombre, Orden, Icono, URL, Estado) VALUES ('5', 'Pagos Net Partners', '2', 'fa fa-money', '../partners/pagos.php', 1);


INSERT INTO se_permiso (Menu, Rol, Estado) VALUES ('5', '3', 1);
INSERT INTO se_permiso (Menu, Rol, Estado) VALUES ('16', '3', 1);
INSERT INTO se_permiso (Menu, Rol, Estado) VALUES ('17', '3', 1);
INSERT INTO se_permiso (Menu, Rol, Estado) VALUES ('18', '3', 1);

INSERT INTO se_permiso (Menu, Rol, Estado) VALUES ('19', '3', 1);
INSERT INTO se_permiso (Menu, Rol, Estado) VALUES ('20', '3', 1);
INSERT INTO se_permiso (Menu, Rol, Estado) VALUES ('21', '3', 1);

INSERT INTO se_permiso (Menu, Rol, Estado) VALUES ('5', '2', 1);
INSERT INTO se_permiso (Menu, Rol, Estado) VALUES ('22', '2', 1);

INSERT INTO se_permiso (Menu, Rol, Estado) VALUES ('23', '1', 1);
INSERT INTO se_permiso (Menu, Rol, Estado) VALUES ('24', '1', 1);


SELECT * FROM se_rol;





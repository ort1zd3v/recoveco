$(function() {
	//En móvil la barra de navegación inicia contraída y en las demás resoluciones inicia expandida
	if (isMobile)
		$('#navbar').removeClass("navbar-expanded").addClass("navbar-collapsed");
	else
		$('#navbar').removeClass("navbar-collapsed").addClass("navbar-expanded");

	//Al hacer cambiar tamaño de la ventana actualizar la variable que indica si estamos en móvil
	$(window).resize(function() {
		isMobile = $(window).width() < mobileWidth ? true : false;
	});

	/**
	 * [Al dar click en el botón para minimizar menú le agrega la clase collapsed a la barra de menú y llama a la función que cambia la visualización]
	 */
	$("#navbar-toggler").click(function(event) {
		var collapse = false;
		$.each($('#navbar').attr('class').split(' '), function(index, val) {
			if (val == "navbar-collapsed")
				collapse = false;
			else if (val == "navbar-expanded")
				collapse = true;
		});
		collapseMenu(collapse);
	});

	//Al dar clic sobre un submenú girar la flecha
	$(".nav-item > a.nav-submenu").click(function(e) {
		if ($(this).attr("aria-expanded") == "false") {
			$(this).find(".dropdown-icon").removeClass('icon-expanded').addClass('icon-collapsed');
		} else {
			$(this).find(".dropdown-icon").removeClass('icon-collapsed').addClass('icon-expanded');
		}
	});

	//Al dar clic en un item que no es submenú cierra el navbar para que no estorbe
	$(".nav-item > a.nav-item").click(function(e) {
		if(isMobile)
			collapseMenu(true);
	});

	/**
	 * [collapseMenu Contrae o expande la barra de navegación]
	 * @param  {[Boolean]} collapse [Booleando para indicar si el menú debe collapsarse o no]
	 */
	window.collapseMenu = function(collapse) {
		if (collapse) {
			if (isMobile) {
				$('#main').attr('style', 'display: flex!important');
			}
			$('#navbar').removeClass("navbar-expanded").addClass("navbar-collapsed");
			//$('#navbar i').css("font-size", "20px");
			//$(".navbar-submenu").removeClass('pl-sm-3');
			$(".nav-item > a > span").removeClass().addClass("d-none d-sm-none");
		} else {
			if (isMobile) {
				$('#main').attr('style', 'display: none!important');
			}
			$('#navbar').removeClass("navbar-collapsed").addClass("navbar-expanded");
			//$('#navbar i').css("font-size", "14px");
			//$(".navbar-submenu").addClass('pl-sm-3');
			$(".nav-item > a > span").removeClass().addClass("d-sm-inline d-sm-inline");
		}
		writeCookie("collapse", collapse, 1);

	}

	collapseMenu(readCookie("collapse") != "false");
});
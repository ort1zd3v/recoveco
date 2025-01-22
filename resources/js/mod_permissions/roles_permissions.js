$(function() {
	/** Funciones para seleccionar secciones de permisos */
	window.permissionsChecking = function() {
		$(".permissionsContainer input[type=checkbox]").change(function(event) {
			//Los checkbox que son secciones tienen hijos
			if($(this).attr("class") == "checkSection") {
				window.checkChild($(this).attr("id"), $(this).is(":checked"));
			}
			window.checkParent($(this).attr("data-parent"));
		});
	}

	/**
	 * [checkChild Busca elementos hijos de un id dado y los selecciona o deselecciona
	 * alguno de los elementos hijos es una sección se vuelve a llamar esta función]
	 * @param  {String}  currentId [Id del elemento actual que vamos a buscar si tiene hijos para seleccionar]
	 * @param  {Boolean} isChecked [Condición para ver si los hijos se van a seleccionar o deseleccionar]
	 */
	window.checkChild = function(currentId, isChecked) {
		$(".permissionsContainer input[data-parent="+currentId+"]").each(function(index, el) {
			if($(el).prop("disabled") != true) {
				$(el).prop("checked", isChecked);
				if($(el).attr("class") == "checkSection") {
					window.checkChild($(el).attr("id"), isChecked);
				}
			}
		});
	}

	/**
	 * [checkParent Si el elemento tiene padre intenta seleccionarlo.
	 * Si el padre seleccionado tiene un elemento padre se vuelve a llamar esta función]
	 * @param  {String} parentId [Id del elemento padre del elemento]
	 */
	window.checkParent = function(parentId) {
		if(parentId != "0") {
			//Verificar si voy a seleccionar la sección
			var isChecked = true;
			$(".permissionsContainer input[data-parent="+parentId+"]").each(function(index, el) {
				if(!$(el).is(":checked")) {
					isChecked = false;
				}
			});

			var section = $("#"+parentId);
			section.prop("checked", isChecked);
			//Si la sección que se seleccionó tiene parent, entonces vuelve a llamar esta función para evaluar si se seleccionará la sección padre
			if(section.attr("data-parent") != "0") {
				window.checkParent(section.attr("data-parent"));
			}
		}
	}

	$(".checkPermission").each(function(index, el) {
		if($(this).is(":checked")) {
			if($(this).attr("data-parent") != "0") {
				window.checkParent($(this).attr("data-parent"));
			}
		}
	});

	permissionsChecking();
});

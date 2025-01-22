/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

// require('./bootstrap');
// import Alpine from 'alpinejs';
// window.Alpine = Alpine;
// Alpine.start();
//Layout
__webpack_require__(/*! ./theme.js */ "./resources/js/theme.js");

__webpack_require__(/*! ./layout/cookie.js */ "./resources/js/layout/cookie.js");

__webpack_require__(/*! ./layout/image_preview.js */ "./resources/js/layout/image_preview.js");

__webpack_require__(/*! ./layout/sidebar */ "./resources/js/layout/sidebar.js");

__webpack_require__(/*! ./layout/var.js */ "./resources/js/layout/var.js"); //Auth


__webpack_require__(/*! ./auth/login.js */ "./resources/js/auth/login.js"); //Mod permissions


__webpack_require__(/*! ./mod_permissions/roles_permissions.js */ "./resources/js/mod_permissions/roles_permissions.js"); //Mod Crud maker


__webpack_require__(/*! ./crud_maker/functions.js */ "./resources/js/crud_maker/functions.js");

__webpack_require__(/*! ./crud_maker/filters_datatables.js */ "./resources/js/crud_maker/filters_datatables.js");

__webpack_require__(/*! ./crud_maker/input_autocomplete.js */ "./resources/js/crud_maker/input_autocomplete.js");

__webpack_require__(/*! ./crud_maker/input_datepicker.js */ "./resources/js/crud_maker/input_datepicker.js");

__webpack_require__(/*! ./crud_maker/multirow_functions.js */ "./resources/js/crud_maker/multirow_functions.js");

__webpack_require__(/*! ./crud_maker/dropdown_fill_child.js */ "./resources/js/crud_maker/dropdown_fill_child.js");

__webpack_require__(/*! ./crud_maker/modal_quick_add.js */ "./resources/js/crud_maker/modal_quick_add.js");

__webpack_require__(/*! ./crud_maker/modal_delete.js */ "./resources/js/crud_maker/modal_delete.js");

__webpack_require__(/*! ./crud_maker/datatables_customize.js */ "./resources/js/crud_maker/datatables_customize.js"); //Dashboard


__webpack_require__(/*! ./dashboard/collapse_functions.js */ "./resources/js/dashboard/collapse_functions.js"); //pos


__webpack_require__(/*! ./pos/products_functions.js */ "./resources/js/pos/products_functions.js");

__webpack_require__(/*! ./pos/cart_functions.js */ "./resources/js/pos/cart_functions.js");

__webpack_require__(/*! ./pos/payment_functions.js */ "./resources/js/pos/payment_functions.js");

__webpack_require__(/*! ./pos/client_functions.js */ "./resources/js/pos/client_functions.js");

__webpack_require__(/*! ./reports/export_excel_suppliers.js */ "./resources/js/reports/export_excel_suppliers.js");

__webpack_require__(/*! ./inventories/inventories_functions.js */ "./resources/js/inventories/inventories_functions.js");

__webpack_require__(/*! ./reports/export_excel_sellings.js */ "./resources/js/reports/export_excel_sellings.js"); //lang files


__webpack_require__(/*! ./lang.js */ "./resources/js/lang.js");

window.i18n.es = __webpack_require__(/*! ./../../lang/es.json */ "./lang/es.json");

/***/ }),

/***/ "./resources/js/auth/login.js":
/*!************************************!*\
  !*** ./resources/js/auth/login.js ***!
  \************************************/
/***/ (() => {

$(document).ready(function () {
  $("#passwordResetButton").click(function () {
    var form = $("#passwordResetForm").serializeArray();
    $.ajax({
      url: $("meta[name=app-url]").attr("content") + '/password/email',
      type: 'POST',
      dataType: 'json',
      data: form,
      success: function success(response) {
        console.log(response);
        $("#passwordResetForm #email").removeClass('is-invalid');
        $(".invalid-feedback").html('');
        $("#passwordResetModal").modal('hide');
        $(".alert-success").html(response.message).removeClass('d-none');
      },
      error: function error(response) {
        $("#passwordResetForm #email").addClass('is-invalid');
        $("#passwordResetModal .email-row .invalid-feedback").html('<strong>' + response.responseJSON.errors.email[0] + '</strong>');
      }
    });
  });
  $("#registerButton").click(function () {
    var form = $("#registerForm").serializeArray();
    $.ajax({
      url: $("meta[name=app-url]").attr("content") + '/register',
      type: 'POST',
      dataType: 'json',
      data: form,
      success: function success(response) {},
      error: function error(response) {
        console.log(response);

        if (response.status == 201) {
          $("#registerForm #name,#registerForm #email,#registerForm #password").removeClass('is-invalid');
          $("#registerForm .invalid-feedback").html('');
          $("#registerModal").modal('hide');
          window.location.href = $("meta[name=app-url]").attr("content");
        } else {
          if (response.responseJSON.errors.name[0] != undefined) {
            $("#registerForm #name").addClass('is-invalid');
            $("#registerForm .name-row .invalid-feedback").html('<strong>' + response.responseJSON.errors.name[0] + '</strong>');
          }

          if (response.responseJSON.errors.email[0] != undefined) {
            $("#registerForm #email").addClass('is-invalid');
            $("#registerForm .email-row .invalid-feedback").html('<strong>' + response.responseJSON.errors.email[0] + '</strong>');
          }

          if (response.responseJSON.errors.password[0] != undefined) {
            $("#registerForm #password").addClass('is-invalid');
            $("#registerForm .password-row .invalid-feedback").html('<strong>' + response.responseJSON.errors.password[0] + '</strong>');
          }
        }
      }
    });
  });
});

/***/ }),

/***/ "./resources/js/crud_maker/datatables_customize.js":
/*!*********************************************************!*\
  !*** ./resources/js/crud_maker/datatables_customize.js ***!
  \*********************************************************/
/***/ (() => {

$(function () {
  var entity = $("#entity").val();

  window.customizeDatatable = function () {
    var isModal = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;
    var buttonAdd = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
    var addInFilter = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : true;
    $(".dataTables_length").find('select').addClass("form-select mx-2"); //Change filter section

    var filter = $(".dataTables_wrapper .dataTables_filter");
    var dataLenght = $(".dataTables_length");
    filter.addClass('search-box me-2 mb-2 row');

    if (addInFilter) {
      if (filter.find('.button-add').length == 0) {
        if ($("#allowAdd").val() == "1" || buttonAdd) {
          filter.append(getAddButton(isModal, addInFilter));
        }
      }
    } else {
      if (dataLenght.find('.button-add').length == 0) {
        if ($("#allowAdd").val() == "1" || buttonAdd) {
          dataLenght.append(getAddButton(isModal, addInFilter));
        }
      }
    }

    filter.find("label").addClass('position-relative col-4').append("<i class=\"bx bx-search-alt search-icon\"></i>");
    filter.find("input[type=search]").addClass('form-control'); //Change pagination links

    var paginate = $(".dataTables_wrapper .dataTables_paginate");
    paginate.addClass('pagination pagination-rounded justify-content-end mb-2');
    paginate.find(".previous").html(addIcon('<i class="mdi mdi-chevron-left"></i>'));
    paginate.find(".next").html(addIcon('<i class="mdi mdi-chevron-right"></i>'));
    paginate.find("> span").css('display', 'inline-flex');
    paginate.find("span a").each(function (index, el) {
      if ($(el).find(".page-item").length == 0) {
        var classList = el.classList;
        var active = false;

        for (var key in classList) {
          if (classList[key] == 'current') {
            active = true;
          }
        }

        $(el).html(addIcon($(el).html(), active));
      }
    });
  };

  window.footerCustomize = function (cols, api, putCols) {
    var api = api;
    var totals = []; // Calcular el total de ventas

    $.each(cols, function (index, col) {
      var total = api.column(col).data().reduce(function (acc, val) {
        // Eliminar el símbolo $ y el punto de la cadena de valor
        var value = val.replace("$", "").replace(",", "");
        return acc + parseFloat(value);
      }, 0); // Formatear el total con el símbolo $

      var formattedTotal = "$" + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
      totals.push(formattedTotal);
    }); // Agregar una fila de pie de página para mostrar el total de ventas

    var tfoot = "<tfoot><tr><th colspan=\"".concat(putCols[0], "\" class=\"text-end\">") + "Total:" + "</th>";
    $.each(putCols, function (index, col) {
      var colspan = 1;

      if (index > 0) {
        colspan = putCols[index] - putCols[index - 1];
      }

      tfoot += "\n\t\t\t\t\t<th colspan=\"".concat(colspan, "\" class=\"text-end\">").concat(totals[index], "</th>\n\t\t\t\t");
    });
    tfoot += "</tr></tfoot>";
    var $table = $(api.table().node());
    $table.find('tfoot').remove();
    $table.append(tfoot);
  };

  window.getAddButton = function (isModal, addInFilter) {
    var result = '';
    var params = btoa(JSON.stringify({
      "entity_source": entity,
      "entity": entity,
      //Este es el nombre que se le dará al quick add modal que se creará
      "saveAditionals": 'reloadDatatable'
    }));
    var attr = isModal ? "onclick=\"showQuickAddModal('".concat(params, "')\"") : "href=\"".concat(entity, "/create\"");
    result = addInFilter ? "<div class=\"col-sm-8\">" : "<div>";
    result += "\n\t\t\t<div class=\"text-sm-end\">\n\t\t\t\t<a class=\"btn btn-default waves-effect mb-2 button-add\" ".concat(attr, ">\n\t\t\t\t\t<i class=\"mdi mdi-plus me-1\"></i>\n\t\t\t\t\t").concat(window.i18n.es.Add, "\n\t\t\t\t</a>\n\t\t\t</div>\n\t\t</div>");
    return result;
  };

  window.addIcon = function (p, a) {
    return "\n\t\t\t<span class='page-item " + (a ? 'active' : '') + "'>\n\t\t\t\t<span class='page-link'>".concat(p, "</span>\n\t\t\t</span>\n\t\t");
  };

  window.reloadDatatable = function (response) {
    window.LaravelDataTables[entity + "-table"].draw();
  };
});

/***/ }),

/***/ "./resources/js/crud_maker/dropdown_fill_child.js":
/*!********************************************************!*\
  !*** ./resources/js/crud_maker/dropdown_fill_child.js ***!
  \********************************************************/
/***/ (() => {

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

/**
 * [fillDropdownChild Esta función llena un combobox cuando se ejecuta una acción, el fin es filtrar por el parámetro seleccionado]
 * @param  {[type]} route          [Ruta a donde vamos a consultar los datos del hijo]
 * @param  {[type]} filterColumn   [Columna de por la que queremos filtrar]
 * @param  {[type]} param          [Valor del que vamos a partir]
 * @param  {[type]} target         [Combobox objetivo que se rellenará]
 */
window.fillDropdownChild = function (route, filterColumn, value, target) {
  $.ajax({
    url: $('meta[name="app-url"]').attr('content') + "/" + route,
    type: 'GET',
    data: _defineProperty({}, filterColumn, value),
    dataType: 'json',
    success: function success(response) {
      $("#" + target).html(getDropdownContent(response)).trigger('change');
    }
  });
};

window.getDropdownContent = function (response) {
  var result = '';
  result += '<option value=""></option>';
  $.each(response, function (index, val) {
    result += '<option value="' + index + '">' + val + '</option>';
  });
  return result;
};

/***/ }),

/***/ "./resources/js/crud_maker/filters_datatables.js":
/*!*******************************************************!*\
  !*** ./resources/js/crud_maker/filters_datatables.js ***!
  \*******************************************************/
/***/ (() => {

$(function () {
  var entity = $("#entity").val();

  window.filterData = function (type) {
    if (type == "datatable") {
      filterDatatable();
    } else {
      filterTable(type);
    }
  };

  window.clearFilters = function (type) {
    //Clear filter elements by type
    $('.' + type + '-filter').each(function (index, el) {
      switch ($(el)[0].nodeName.toLowerCase()) {
        case "input":
          $(el).val("");
          $(el).prop("checked", false);
          break;

        case "select":
          $(el).val("").trigger("change");
          break;

        default:
          $(el).val("");
          break;
      }
    });

    if (type == "datatable") {
      clearDatatable();
    } else {
      filterTable();
    }
  };
  /** Filter Table */


  window.filterTable = function (type) {
    var filterSource = $("#filterSource").val();
    var params = {};
    $('.' + type + '-filter').each(function (index, el) {
      if ($(el).attr('source') !== undefined) {
        var dataSource = $(el).attr('source').split(".");
        params[$(el).prop('name') + "[type]"] = "relation";
        params[$(el).prop('name') + "[table]"] = dataSource[0];
        params[$(el).prop('name') + "[field]"] = dataSource[1];
        params[$(el).prop('name') + "[value]"] = $(el).val();
      } else {
        params[$(el).prop('name')] = $(el).val();
      }
    });
    $.ajax({
      url: $('meta[name="app-url"]').attr('content') + "/" + filterSource,
      type: 'GET',
      data: params,
      dataType: 'json',
      success: function success(response) {
        $(".studies-body").html(response);

        if (typeof filterAditionals === "function") {
          filterAditionals(response);
        }
      }
    });
  };
  /** Filter Table */

  /** Filter Datatable */


  window.filterDatatable = function () {
    if (window.LaravelDataTables != undefined) {
      loadDatatable();
      window.LaravelDataTables[entity + "-table"].draw();
    }
  };

  window.clearDatatable = function () {
    if (window.LaravelDataTables != undefined) {
      window.LaravelDataTables[entity + "-table"].draw();
    }
  }; // Agrega los valores de los filtros a la request de ajax.


  window.loadDatatable = function () {
    if (window.LaravelDataTables != undefined) {
      window.LaravelDataTables[entity + "-table"].on('preXhr.dt', function (e, settings, data) {
        $('.datatable-filter').each(function (index, el) {
          data[$(el).prop('name')] = $(el).val();
        });
      });
    }
  };
  /** Filter Datatable */

});

/***/ }),

/***/ "./resources/js/crud_maker/functions.js":
/*!**********************************************!*\
  !*** ./resources/js/crud_maker/functions.js ***!
  \**********************************************/
/***/ (() => {

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

$(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  window.displayMessage = function (message) {
    var alertType = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "info";
    var el = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
    var content = getMessageAlert(message, alertType);

    if (content != "") {
      if (el == false) {
        el = $(".message-container");
      }

      el.html(content);
    }
  };

  window.getMessageAlert = function (message) {
    var alertType = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "info";
    var content = '';

    if (_typeof(message) === "object") {
      $.each(message, function (index, val) {
        content += "<div class=\"alert alert-".concat(alertType, " dismissible\">").concat(val[0], "</div>");
      });
    } else if (typeof message === "string") {
      content = "<div class=\"alert alert-".concat(alertType, " dismissible\">\n\t\t\t\t<button type=\"button\" class=\"btn btn-default\" data-bs-dismiss=\"alert\" aria-label=\"Close\">\n\t\t\t\t\t<i class=\"mdi mdi-window-close icon-edit font-size-18\"></i>\n\t\t\t\t</button>\n\t\t\t\t").concat(message, "\n\t\t\t</div>");
    }

    return content;
  };
  /**
   * [displayOther Muestra el campo otro cuando se selecciona la opción correspondiente]
   * @param  {[type]} param  [Elemento desde donde se seleciona]
   * @param  {[type]} option [Id que hará que se despliegue el campo otro]
   * @param  {[type]} target [id del elemento de destino]
   */


  window.displayOther = function (param, option, target) {
    console.log($(param).val());

    if ($(param).val() == option) {
      $(param).prop("required", true);
      $("." + target + "_container").show();
      $("#" + target).prop("required", true);
    } else {
      $(param).prop("required", false);
      $("." + target + "_container").hide();
      $("#" + target).prop("required", false);
    }
  };
});

/***/ }),

/***/ "./resources/js/crud_maker/input_autocomplete.js":
/*!*******************************************************!*\
  !*** ./resources/js/crud_maker/input_autocomplete.js ***!
  \*******************************************************/
/***/ (() => {

$(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  window.inputAutocomplete = function (input) {
    var inputId = $(input).attr("data-hidden-id");

    var _source = $(input).attr("data-source");

    var filter = $(input).attr("data-filter");
    var child = $(input).attr("child");
    var childHidden = $(input).attr("child-hidden");
    $(input).autocomplete({
      source: function source(request, response) {
        //Verificar si se agregará filtro de parent
        var data = new Object();

        if ($(input).attr("data-parent") !== undefined) {
          data[$(input).attr("data-parent")] = $("#" + $(input).attr("data-parent")).val(); //data.parent = $(input).attr("data-parent");
          //data.parent_value = $("#"+$(input).attr("data-parent")).val();
        } //var filters = [];


        if (filter != undefined) {
          $.each(filter.split(","), function (index, val) {
            data[val] = request.term;
          });
        }

        data['type'] = 'or'; //data[inputId] = request.term;

        $.ajax({
          url: $('meta[name="app-url"]').attr('content') + "/" + _source,
          type: 'GET',
          data: data,
          dataType: 'json',
          success: function success(data) {
            response(data);
          }
        });
      },
      minLength: 3,
      open: function open() {},
      close: function close() {},
      focus: function focus(event, ui) {},
      select: function select(event, ui) {
        $(input).parent().find("#" + inputId).val(ui.item.id);

        if (child) {
          var childSource = $("#".concat(child)).attr('data-source').replace(/[0-9]/g, "");
          $("#".concat(childHidden)).val("");
          $("#".concat(child)).val("");
          $("#".concat(child)).attr('data-source', childSource + ui.item.id);
          inputAutocomplete($("#".concat(child)));
        }

        if (typeof window[$(input).attr("data-aditionals")] === "function") {
          window[$(input).attr("data-aditionals")](ui.item);
        }
      }
    }).keyup(function () {
      if ($(this).val().length == 0) $(input).parent().find("#" + inputId).val("");
    });
  };

  window.loadAutocomplete = function () {
    $(".input-autocomplete").each(function (index, el) {
      inputAutocomplete($(el));
    });
  };

  loadAutocomplete();
});

/***/ }),

/***/ "./resources/js/crud_maker/input_datepicker.js":
/*!*****************************************************!*\
  !*** ./resources/js/crud_maker/input_datepicker.js ***!
  \*****************************************************/
/***/ (() => {

$(function () {
  window.loadDateTimePicker = function () {
    $('.datepicker2').datetimepicker({
      locale: 'es',
      format: 'DD-MM-YYYY'
    });
    $('.datetimepicker2').datetimepicker({
      locale: 'es',
      format: 'DD-MM-YYYY H:mm'
    });
  };

  window.loadDateTimePickerFilters = function () {
    $('.datepicker-start').datetimepicker({
      locale: 'es',
      format: 'DD-MM-YYYY',
      ignoreReadonly: true
    });
    $('.datepicker-end').datetimepicker({
      useCurrent: false,
      locale: 'es',
      format: 'DD-MM-YYYY',
      ignoreReadonly: true
    });
    $('.timepicker-start').datetimepicker({
      locale: 'es',
      format: 'HH:mm',
      ignoreReadonly: true
    });
    $('.timepicker-end').datetimepicker({
      useCurrent: false,
      locale: 'es',
      format: 'HH:mm',
      ignoreReadonly: true
    });
  };

  loadDateTimePicker();
  loadDateTimePickerFilters();
});

/***/ }),

/***/ "./resources/js/crud_maker/modal_delete.js":
/*!*************************************************!*\
  !*** ./resources/js/crud_maker/modal_delete.js ***!
  \*************************************************/
/***/ (() => {

$(function () {
  window.showDeleteModal = function (entity, id) {
    //$('#deleterowForm').attr('action', $('meta[name="app-url"]').attr('content')+"/"+entity+"/"+id);
    var title = '';
    var message = '';

    if (window.i18n[entity] !== undefined) {
      var _window$i18n$entity$t, _window$i18n$entity$c;

      title = (_window$i18n$entity$t = window.i18n[entity]['title_delete']) !== null && _window$i18n$entity$t !== void 0 ? _window$i18n$entity$t : '';
      message = (_window$i18n$entity$c = window.i18n[entity]['confirm_delete']) !== null && _window$i18n$entity$c !== void 0 ? _window$i18n$entity$c : '';
    }

    if (title != '') {
      $('#deleterowModal .modal-title').html();
    }

    if (message != '') {
      $('#deleterowModal .alert .alert-message').html(message);
    }

    $('#deleterowModal .button-delete').attr('onclick', "deleteRow('".concat(entity, "', ").concat(id, ")"));
    $('#deleterowModal').modal('show');
  };

  window.deleteRow = function (entity, id) {
    $.ajax({
      url: $('meta[name="app-url"]').attr('content') + '/' + entity + '/' + id,
      type: 'DELETE',
      dataType: 'json',
      success: function success(response) {
        console.log(response);
        $('#deleterowModal').modal('hide');
        displayMessage(response.message, response.status ? "success" : "danger");
        window.LaravelDataTables[entity + "-table"].draw();
      }
    }).fail(function (response) {
      //si hubo error en la validación
      if (typeof response.responseJSON.message !== "undefined") {
        var el = $(".message-container");
        displayMessage(response.responseJSON.errors, "danger", el);
      }
    });
  }; //eliminar venta


  window.showCancelSelling = function (id) {
    //$('#deleterowForm').attr('action', $('meta[name="app-url"]').attr('content')+"/"+entity+"/"+id);
    var title = 'Cancelar venta';
    var message = 'Seguro de cancelar la venta?';

    if (title != '') {
      $('#deleterowModal .modal-title').html();
    }

    if (message != '') {
      $('#deleterowModal .alert .alert-message').html(message);
    }

    $('#deleterowModal .button-delete').attr('onclick', "cancelSelling(".concat(id, ")"));
    $('#deleterowModal').modal('show');
  };

  window.cancelSelling = function (id) {
    $.ajax({
      url: $('meta[name="app-url"]').attr('content') + '/report_by_tickets/cancelSelling/' + id,
      type: 'DELETE',
      dataType: 'json',
      success: function success(response) {
        console.log(response);
        $('#deleterowModal').modal('hide');
        displayMessage(response.message, response.status ? "success" : "danger");
        window.LaravelDataTables["report_by_tickets-table"].draw();
      }
    }).fail(function (response) {
      //si hubo error en la validación
      if (typeof response.responseJSON.message !== "undefined") {
        var el = $(".message-container");
        displayMessage(response.responseJSON.errors, "danger", el);
      }
    });
  };
});

/***/ }),

/***/ "./resources/js/crud_maker/modal_quick_add.js":
/*!****************************************************!*\
  !*** ./resources/js/crud_maker/modal_quick_add.js ***!
  \****************************************************/
/***/ (() => {

function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

$(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  window.showQuickAddModal = function (params) {
    var params = JSON.parse(atob(params));
    var cRute = params.route !== undefined ? params.route : params.entity; //let entity = params.entity;
    //Esto solo se ejecuta si se pasó parent (que hará que se seleccione el valor correspondiente del select)

    var parentValue = "";

    if (params.parent !== undefined) {
      parentValue = $("#" + params.parent).val();
      params.parent_value = parentValue;
    } //Si se indicó un campo parent pero no se ha seleccionado una opción en ese parent no se lanzará el modal


    if (params.parent !== undefined && parentValue == "") {
      alert("Seleccione " + window.i18n[params.entity_source][params.parent]);
    } else {
      $.ajax({
        url: $('meta[name="app-url"]').attr('content') + "/" + cRute + "/getquickmodalcontent" + (params.id !== undefined ? "/" + params.id : ""),
        type: 'GET',
        data: {
          params: params
        },
        dataType: 'json',
        success: function success(response) {
          $("." + params.entity + "-modal").remove();
          $("body").append(response); //Esto solo se ejecuta si se pasó parent

          if (params.parent !== undefined) {
            switch (params.inputType) {
              case "autocomplete":
                //Con el id que tenemos buscamos el input que muestra el texto y lo ponemos como readonly y quitamos clase de atutocomplete
                $("." + params.entity + "-modal #" + params.parent).parent().find("input[type=text]").removeClass("input-autocomplete").attr("readonly", true);
                break;

              case "select":
                $("." + params.entity + "-modal #" + params.parent_target).val(parentValue);
                var textDisplay = $("." + params.entity + "-modal #" + params.parent_target + " option:selected").text();
                $("." + params.entity + "-modal #" + params.parent_target).parent().html("\n\t\t\t\t\t\t\t\t\t<input type=\"hidden\" name=\"" + params.parent_target + "\" id=\"" + params.parent_target + "\" value=\"" + parentValue + "\" />\n\t\t\t\t\t\t\t\t\t<input type=\"text\"  value=\"" + textDisplay + "\" class=\"form-control\" readonly />\n\t\t\t\t\t\t\t\t");
                break;

              default:
                break;
            }
          }

          $("." + params.entity + "-modal").css('z-index', getModalZIndex()).modal('show');
          loadAutocomplete();
        }
      });
    }
  };

  window.getModalZIndex = function () {
    var zindex = 1050;
    $(".modal").each(function (index, el) {
      if ($(el).hasClass('show')) zindex = $(el).css('z-index');
    });
    return parseFloat(zindex) + 10;
  };

  window.saveQuickAdd = function (params) {
    var params = JSON.parse(atob(params));
    var action = $("#" + params.entity + "-quickmodal").prop('action'); //Get form data and delete empty fields

    var data = new FormData(document.getElementById(params.entity + "-quickmodal"));

    var _iterator = _createForOfIteratorHelper(data.entries()),
        _step;

    try {
      for (_iterator.s(); !(_step = _iterator.n()).done;) {
        var value = _step.value;

        if (value[1] === "") {
          data["delete"](value[0]);
        }
      }
    } catch (err) {
      _iterator.e(err);
    } finally {
      _iterator.f();
    }

    $.ajax({
      url: action,
      type: 'POST',
      data: data,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function success(response) {
        if (response.data !== undefined) {
          switch (params.inputType) {
            case "autocomplete":
              $("#" + params.targetInputId).val(response.data.id);
              $("#" + params.targetInputDisplay).val(response.data[params.displayValue]);
              break;

            case "select":
              var result = '<option value="' + response.data.id + '">' + response.data[params.displayValue] + '</option>';
              $("#" + params.targetInputId).append(result);
              $("#" + params.targetInputId).val(response.data.id);
              $("#" + params.targetInputId).trigger('change');
              break;

            default:
              break;
          }

          $("#" + params.entity + "-quickadd").trigger("reset");
          $("." + params.entity + "-modal").modal('hide');
          $("." + params.entity + "-modal").remove();
          displayMessage(response.message, response.status ? "success" : "danger");

          if (typeof window[params.saveAditionals] === "function") {
            window[params.saveAditionals](response.data);
          }
        } else {
          alert(response.message);
        }
      }
    }).fail(function (response) {
      //si hubo error en la validación
      if (typeof response.responseJSON.message !== "undefined") {
        var el = $("#" + params.entity + "-quickmodal").find(".message-container");
        displayMessage(response.responseJSON.errors, "danger", el);
      }
    });
  };
});

/***/ }),

/***/ "./resources/js/crud_maker/multirow_functions.js":
/*!*******************************************************!*\
  !*** ./resources/js/crud_maker/multirow_functions.js ***!
  \*******************************************************/
/***/ (() => {

$(function () {
  var route = $("#route").val(); //region CRUD

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  window.addRow = function () {
    var amount = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
    var data = {
      "rowNumber": parseFloat($(".table-body .row").length) + 1,
      "amount": amount
    };
    $.ajax({
      url: $('meta[name="app-url"]').attr('content') + "/" + route + "/addrow",
      type: "GET",
      dataType: 'json',
      data: data,
      success: function success(result) {
        $(".table-body").append(result);
        $(".table-body input[type=text]").keyup(function () {
          validateRow($(this));
        });

        if (typeof inputAddSettings === "function") {
          inputAddSettings();
        }
      }
    });
  };

  window.saveAll = function () {
    $(".table-body .row").each(function (index, el) {
      if ($(el).find(".btn-unsaved").hasClass("d-inline")) {
        saveRow($(el).find(".btn-save"));
      }
    });
  };

  window.saveRow = function (param) {
    var row = $(param).closest(".table-row");
    var id = $(row).find("input[name=id]").val();
    var data = {};
    $(row).find(".row-input").each(function (index, el) {
      data[$(el).attr("name")] = $(el).val();
    });
    data["isAJAXRequest"] = "true";
    console.log(data);

    if (id == "") {
      $.ajax({
        url: $('meta[name="app-url"]').attr('content') + "/" + route,
        type: "POST",
        data: data,
        dataType: 'json',
        success: function success(result) {
          if (result["status"]) {
            console.log(result["data"]["id"]);
            $(row).find("input[name=id]").val(result["data"]["id"]);
            $(row).find(".btn-unsaved").removeClass("d-inline").addClass("d-none");
            $(row).find(".btn-saved").removeClass("d-none").addClass("d-inline");
            clearErrorMessages(row);
          }
        }
      }).fail(function (response) {
        //si hubo error en la validación
        if (typeof response.responseJSON.message !== "undefined") {
          showValidationError(response.responseJSON.errors, row);
        }
      });
    } else {
      $.ajax({
        url: $('meta[name="app-url"]').attr('content') + "/" + route + "/" + id,
        type: "PUT",
        data: data,
        dataType: 'json',
        success: function success(result) {
          if (result["status"]) {
            console.log(result["data"]["id"]);
            $(row).find("input[name=id]").val(result["data"]["id"]);
            $(row).find(".btn-unsaved").removeClass("d-inline").addClass("d-none");
            $(row).find(".btn-saved").removeClass("d-none").addClass("d-inline");
            clearErrorMessages(row);
          }
        }
      });
    }
  };

  window.deleteRow = function (param) {
    var row = $(param).closest(".table-row");
    var id = $(row).find("input[name=id]").val();

    if (id != "") {
      if (confirm("Este registro ya ha sido guardado, se borrará de la base de datos")) {
        $.ajax({
          url: $('meta[name="app-url"]').attr('content') + "/" + route + "/deleteAJAX/" + id,
          type: "DELETE",
          dataType: 'json',
          success: function success(result) {
            removeRowElement(param);
          }
        });
      }
    } else {
      //console.log("Tiene cambios no guardados");
      removeRowElement(param);
    }
  };

  window.removeRowElement = function (param) {
    $(param).closest(".table-row").remove();

    if (typeof deleteRowAditionals === "function") {
      deleteRowAditionals();
    }
  }; //endregion CRUD
  //region validations

  /**
   * [Evento que se ejecuta cuando se escribe algo en los input generales]
   */


  $(".table-body input[type=text]").keyup(function () {
    validateRow($(this));
  });
  /**
   * [autocompleteAditionals Función que se ejecuta cuando se selecciona una opción del dropdown]
   */

  window.autocompleteAditionals = function (param) {
    validateRow($(param));
  };
  /**
   * [datepickerSelect Función que se ejecuta cuando se selecciona una fecha del datepicker]
   */


  window.datepickerSelect = function () {
    $('.datetimepicker2').on("change.datetimepicker", function (e) {
      validateRow(e.currentTarget);
    });
  };
  /**
   * [validateRow Revisa cada campo en el row que se esté editando
   * y si al menos 1 tiene datos muestra el ícono de que no se ha guardado]
   */


  window.validateRow = function (param) {
    var row = $(param).closest(".table-row");
    var allEmpty = true;
    clearErrorMessages(row);
    $(row).find(".row-input").each(function (index, el) {
      if ($(el).val() != "") {
        allEmpty = false;
        return;
      }
    });

    if (!allEmpty) {
      $(row).find(".btn-unsaved").removeClass("d-none").addClass("d-inline");
      $(row).find(".btn-saved").removeClass("d-inline").addClass("d-none");
    } else {
      $(row).find(".btn-unsaved").removeClass("d-inline").addClass("d-none");
    }
  };
  /**
   * [showValidationError Muestra mensaje de error debajo del input correspondiente]
   */


  window.showValidationError = function (message, row) {
    $.each(message, function (index, val) {
      $(row).find("." + index + "-error").html(val);
    });
  };
  /**
   * [clearErrorMessages Quita todos los mensajes de error del row que se esté editando]
   */


  window.clearErrorMessages = function (row) {
    $(row).find(".validation-error").html("");
  }; //endregion validations

  /**
   * [autocompleteLoad Crea un componente autocomplete dropdown]
   */


  window.autocompleteLoad = function () {
    $(".input-autocomplete").comboboxUI();
    $("#toggle").on("click", function () {
      $(".input-autocomplete").toggle();
    });
  };
  /**
   * [inputAddSettings Esta función se encarga de cargar las funcionalidades de los input 
   * (datepicker, dropdown, etc)]
   * Se manda llamar también después de que se agrega un nuevo row
   */


  window.inputAddSettings = function () {
    loadDateTimePicker();
    datepickerSelect(); //autocompleteLoad();
  };

  inputAddSettings();
});

/***/ }),

/***/ "./resources/js/dashboard/collapse_functions.js":
/*!******************************************************!*\
  !*** ./resources/js/dashboard/collapse_functions.js ***!
  \******************************************************/
/***/ (() => {

$(function () {
  //On collapse section we alternate the arrow icon
  $('.card > a[data-bs-toggle="collapse"]').click(function () {
    if ($(this).attr('aria-expanded') == "true") $(this).find('i.fa-caret-left').removeClass('fa-caret-left').addClass('fa-caret-down');else $(this).find('i.fa-caret-down').removeClass('fa-caret-down').addClass('fa-caret-left');
  });
});

/***/ }),

/***/ "./resources/js/inventories/inventories_functions.js":
/*!***********************************************************!*\
  !*** ./resources/js/inventories/inventories_functions.js ***!
  \***********************************************************/
/***/ (() => {

function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

$(function () {
  $("#import_excel_inventories").on('click', function () {
    var result = true;
    $("#file-message").addClass('d-none'); //Get form data and delete empty fields

    var data = new FormData(document.getElementById("excel_file_inventories"));

    var _iterator = _createForOfIteratorHelper(data.entries()),
        _step;

    try {
      for (_iterator.s(); !(_step = _iterator.n()).done;) {
        var value = _step.value;

        if (value[0] == "file_input") {
          if (value[1]["type"] != "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
            $("#file-message").removeClass('d-none').find(".alert").html("El archivo seleccionado no es un archivo excel válido");
            result = false;
          }
        }
      }
    } catch (err) {
      _iterator.e(err);
    } finally {
      _iterator.f();
    }

    if (result) {
      $.ajax({
        url: $('meta[name="app-url"]').attr('content') + '/inventories/insertOrUpdateInventory',
        type: 'POST',
        data: data,
        contentType: false,
        processData: false,
        dataType: 'json',
        beforeSend: function beforeSend() {
          $('#modal-carga').modal('show');
          $("#modal-carga").removeClass("d-none");
        },
        success: function success(response) {
          $('#modal-carga').modal('hide');
          Swal.fire({
            title: response.message,
            html: "Porductos con inventario modificado: ".concat(response.inventories.updated, " <br>Productos agregados: ").concat(response.inventories.added),
            icon: response.icon
          });
        }
      });
    }

    return result;
  });
});

/***/ }),

/***/ "./resources/js/lang.js":
/*!******************************!*\
  !*** ./resources/js/lang.js ***!
  \******************************/
/***/ (() => {

window.i18n = {
  "add_inventories": {
    "title_index": "Agregar a inventario"
  },
  "auth": {
    "failed": "Estas credenciales no coinciden con nuestros registros.",
    "password": "Contrase\xF1a",
    "throttle": "Demasiados intentos de acceso. Por favor int\xE9ntelo de nuevo en :seconds segundos.",
    "unauthenticated": "Inicie sesi\xF3n para ver este recurso",
    "validation_error": "Error de validaci\xF3n",
    "user_not_found": "No se encontr\xF3 el usuario",
    "password_mismatch": "La contrase\xF1a es incorrecta",
    "logout_success": "La sesi\xF3n se cerr\xF3 correctamente",
    "email_sent": "Se ha enviado el correo de recuperaci\xF3n",
    "login_title": "Bienvenido\/a",
    "login_subtitle": "Inicie sesi\xF3n para continuar",
    "reset_password_title": "Recuperar contrase\xF1a",
    "register_title": "Registrarme",
    "name": "Nombre",
    "paternal_surname": "Apellido paterno",
    "maternal_surname": "Apellido materno",
    "email": "Correo",
    "password_confirmation": "Confirmar contrase\xF1a",
    "remember_me": "Recordarme",
    "login_button": "Iniciar sesi\xF3n",
    "password_recover": "\xBFOlvidaste tu contrase\xF1a?",
    "register_label": "\xBFNo tienes una cuenta?",
    "register_link": "Registrate aqu\xED",
    "button_password_reset": "Enviar correo",
    "button_reset_password": "Cambiar contrase\xF1a",
    "button_register": "Registrarme",
    "button_cancel": "Cancelar"
  },
  "categories": {
    "title_index": "Categor\xEDas",
    "title_add": "Agregar categor\xEDa",
    "title_show": "Ver categor\xEDa",
    "title_edit": "Modificar categor\xEDa",
    "title_delete": "Eliminar categor\xEDa",
    "id": "Id",
    "category_id": "Categor\xEDa",
    "name": "Nombre",
    "description": "Descripci\xF3n",
    "notes": "Notas",
    "is_visible": "Visible",
    "is_active": "Activo",
    "print_order": "Orden de impresi\xF3n",
    "created_by": "Creado por",
    "updated_by": "Modificado por",
    "created_at": "Fecha creado",
    "updated_at": "Fecha modificado",
    "confirm_delete": "Se borrar\xE1 la categor\xEDa de la base de datos. \xBFDesea continuar?",
    "Successfully created": "Categor\xEDa creada correctamente",
    "Successfully updated": "Categor\xEDa modificada correctamente",
    "Successfully deleted": "Categor\xEDa eliminada correctamente",
    "delete_error_message": "Error al intentar eliminar category de la base de datos",
    "delete_error_message_constraint": "No se puede eliminar category, hay tablas que dependen de este"
  },
  "clients": {
    "title_index": "Clientes",
    "title_add": "Agregar cliente",
    "title_show": "Ver cliente",
    "title_edit": "Modificar cliente",
    "title_delete": "Eliminar cliente",
    "id": "id",
    "name": "Nombre",
    "client_number": "N\xFAmero de cliente",
    "branch_id": "Sucursal",
    "notes": "Notas",
    "is_active": "is_active",
    "created_by": "Creado por",
    "updated_by": "Modificado por",
    "created_at": "Fecha creado",
    "updated_at": "Fecha modificado",
    "dynamic attribues": "Atributos din\xE1micos",
    "confirm_delete": "Se borrar\xE1 cliente de la base de datos. \xBFDesea continuar?",
    "Successfully created": "Cliente creado correctamente",
    "Successfully updated": "Cliente modificado correctamente",
    "Successfully deleted": "Cliente eliminado correctamente",
    "delete_error_message": "Error al intentar eliminar cliente de la base de datos",
    "delete_error_message_constraint": "No se puede eliminar cliente, hay tablas que dependen de este"
  },
  "config_carts": {
    "nr": "N.R",
    "pay": "Pagar",
    "name": "Nombre",
    "unit_price": "P.U",
    "amount": "Cantidad",
    "total": "Total",
    "cancel_sale": "Cancelar venta",
    "image": "Imagen",
    "pay_inline": "Pago en esta pantalla"
  },
  "config_general": {
    "title_index": "Temas",
    "general": "Generales",
    "datatables": "Datatables y botones",
    "header": "Encabezado",
    "logo": "Logo",
    "background_color": "Color de fondo",
    "font_color": "Color de fuente",
    "font_hover_color": "Color de hover",
    "font": "Fuente",
    "menu": "Men\xFA",
    "position": "Posici\xF3n",
    "left": "Izquierda",
    "top": "Arriba",
    "show_menu_icons": "Mostrar iconos del men\xFA",
    "body": "Cuerpo",
    "footer": "Pie de p\xE1gina",
    "data[general_header_font_id]": "Fuente",
    "data[general_menu_font_id]": "Fuente",
    "data[general_body_font_id]": "Fuente",
    "data[general_footer_font_id]": "Fuente"
  },
  "config_payments": {
    "frequent_customer": "Cliente frecuente:",
    "gift_card": "Tarjeta de regalo:",
    "amount": "Cantidad:",
    "type": "Tipo:",
    "pay": "Pagar",
    "total": "Total",
    "missing": "Faltante",
    "shift": "Cambio",
    "cancel_payment": "Limpiar pagos",
    "cancel_selling": "Cancelar venta"
  },
  "config_pos": {
    "title_index": "POS",
    "total_rows": "Filas",
    "total_columns": "Columnas",
    "num_section": "Secci\xF3n",
    "save": "Guardar",
    "add": "Agregar"
  },
  "config_products": {
    "with_tabs": "Con cajas",
    "with_filters": "Con filtros",
    "with_keyboard": "Con teclado",
    "type_box": "Tipo de caja",
    "num_cols": "Columnas (0 para ajustar automaticamente)"
  },
  "config_tickets": {
    "title_index": "Ticket",
    "id": "Id",
    "url_logo": "Logo",
    "header": "Encabezado",
    "footer": "Pi\xE9 de p\xE1gina",
    "footer2": "Pi\xE9 de p\xE1gina 2 (opcional)",
    "notes": "Notas",
    "is_active": "Activo",
    "created_by": "Creado por",
    "updated_by": "Modificado por",
    "created_at": "Fecha creado",
    "updated_at": "Fecha modificado"
  },
  "configuration": {
    "title_index": "Configuraci\xF3n"
  },
  "dashboard": {
    "title_index": "Dashboard",
    "title_add": "Agregar dashboard",
    "title_show": "Ver dashboard",
    "title_edit": "Modificar dashboard"
  },
  "ingredients": {
    "title_index": "Ingredientes",
    "title_add": "Agregar ingredient",
    "title_show": "Ver ingredient",
    "title_edit": "Modificar ingredient",
    "title_delete": "Eliminar ingredient",
    "id": "id",
    "product_id": "Producto",
    "ingredient_id": "Producto",
    "category_id": "Categor\xEDa",
    "amount": "Cantidad",
    "notes": "Notas",
    "is_active": "Activo",
    "created_by": "Creado por",
    "updated_by": "Modificado por",
    "created_at": "Fecha creado",
    "updated_at": "Fecha modificado",
    "confirm_delete": "Se borrar\xE1 Ingrediente de la base de datos. \xBFDesea continuar?",
    "Successfully created": "Ingrediente creado correctamente",
    "Successfully updated": "Ingrediente modificado correctamente",
    "Successfully deleted": "Ingrediente eliminado correctamente",
    "delete_error_message": "Error al intentar eliminar Ingrediente de la base de datos",
    "delete_error_message_constraint": "No se puede eliminar Ingrediente, hay tablas que dependen de este"
  },
  "inventories": {
    "title_index": "Inventario",
    "title_add": "Agregar inventario",
    "title_show": "Ver inventario",
    "title_edit": "Modificar inventario",
    "title_delete": "Eliminar inventario",
    "id": "Id",
    "supplier_id": "C\xF3digo",
    "product_id": "Producto",
    "amount": "Cantidad",
    "notes": "Notas",
    "is_active": "Activo",
    "created_by": "Creado por",
    "updated_by": "Modificado por",
    "created_at": "Fecha creado",
    "updated_at": "Fecha modificado",
    "supplier_name": "Recovequero",
    "inventory_does_not_exist": "No existe el producto :product en inventario, no se pude descontar",
    "inventory_empty": "El producto :product no tiene existencias en inventario",
    "inventory_decrease_error": "La cantidad de :product que desea descontar es mayor a la existencia en inventario",
    "file_read_error": "Error al leer el archivo",
    "file_request_empty": "Error. El archivo est\xE1 vac\xEDo",
    "confirm_delete": "Se borrar\xE1 el inventario de la base de datos. \xBFDesea continuar?",
    "Successfully created": "Inventario creado correctamente",
    "Successfully updated": "Inventario modificado correctamente",
    "Successfully deleted": "Inventario eliminado correctamente",
    "delete_error_message": "Error al intentar eliminar el inventario de la base de datos",
    "delete_error_message_constraint": "No se puede eliminar el inventario, hay tablas que dependen de este"
  },
  "inventory_movements": {
    "title_index": "Movimientos de inventario",
    "title_add": "Agregar movimiento",
    "title_show": "Ver movimiento",
    "title_edit": "Modificar movimiento",
    "title_delete": "Eliminar movimiento",
    "id": "Id",
    "product_id": "Producto",
    "inventory_movement_type_id": "Tipo de movimiento",
    "amount": "Cantidad",
    "notes": "Notas",
    "is_active": "Activo",
    "created_by": "Creado por",
    "updated_by": "Modificado por",
    "created_at": "Fecha creado",
    "updated_at": "Fecha modificado",
    "initial_date": "Fecha inicial",
    "final_date": "Fecha final",
    "product_name": "Producto",
    "barcode": "C\xF3digo de barras",
    "confirm_delete": "Se borrar\xE1 el movimiento de la base de datos. \xBFDesea continuar?",
    "Successfully created": "Movimiento creado correctamente",
    "Successfully updated": "Movimiento modificado correctamente",
    "Successfully deleted": "Movimiento eliminado correctamente",
    "delete_error_message": "Error al intentar eliminar el movimiento de la base de datos",
    "delete_error_message_constraint": "No se puede eliminar el movimiento, hay tablas que dependen de este"
  },
  "pagination": {
    "previous": "&laquo; Anterior",
    "next": "Siguiente &raquo;"
  },
  "passwords": {
    "password": "Las contrase\xF1as deben tener al menos seis caracteres y coincidir con la confirmaci\xF3n.",
    "reset": "\xA1Su contrase\xF1a ha sido restablecida!",
    "sent": "\xA1Recordatorio de contrase\xF1a enviado!",
    "throttled": "Por favor espere antes de volver a intentarlo.",
    "token": "Este token de restablecimiento de contrase\xF1a es inv\xE1lido.",
    "user": "No se ha encontrado un usuario con esa direcci\xF3n de correo."
  },
  "permissions": {
    "Users": "Usuarios",
    "Products": "Productos",
    "Pos": "POS",
    "Configuration": "Configuraci\xF3n",
    "Templates": "Temas",
    "Clients": "Clientes",
    "Reports": "Reportes",
    "inventories": "Inventarios",
    "index": "Listar",
    "show": "Ver",
    "create": "Vista guardar",
    "store": "Guardar",
    "edit": "Vista editar",
    "update": "Editar",
    "destroy": "Eliminar",
    "getbyparam": "Autocomplete",
    "getquickmodalcontent": "Modal agregar\/editar",
    "permissions": "Permisos",
    "savePermissions": "Guardar permisos",
    "getAll": "Obtener listado",
    "getDetailsData": "Detalles",
    "editAJAX": "Editar via ajax",
    "deleteAJAX": "Eliminar via ajax",
    "addrow": "Agregar row (tabla multirow)",
    "updateTheme": "Actualizar tema",
    "getPartOfPreview": "Ver preview",
    "getViews": "Obtener vistas",
    "getView": "Obtener vista",
    "getConfigView": "Vista configuraci\xF3n",
    "saveConfigView": "Guardar configuraci\xF3n",
    "getTicket": "Obtener ticket",
    "jsonproducts": "Obtener Json",
    "getproducttableview": "Tabla productos",
    "getproducttableajax": "Tabla productos ajax",
    "getdatatable": "Obtener Datatable",
    "saveSale": "Hacer venta",
    "addcartproduct": "A\xF1adir a carrito",
    "getingredientsmodal": "Ver modal ingredientes",
    "closeDay": "Cerrar d\xEDa",
    "initDay": "Iniciar d\xEDa",
    "getByMonth": "Ver por mes",
    "getByDay": "Ver por d\xEDa",
    "getDayDetail": "Ver venta detallada del d\xEDa",
    "getMonthDetail": "Ver venta detallada del mes",
    "getYearDetail": "Ver venta detallada del a\xF1o",
    "getSupplierDetail": "Ver ventas por proveedor",
    "searchProduct": "Buscar productos",
    "getTicketDetail": "Ver detalle de ticket",
    "cancelSelling": "Cancelar venta",
    "saveInventory": "A\xF1adir (guardar) inventario",
    "addCartInventory": "A\xF1adir a precarga de inventario"
  },
  "pos": {
    "title_index": "POS",
    "remaining_ingredients": "Sabores restantes",
    "select_from_category": "Seleccione categor\xEDa",
    "ingredients": "Ingredientes",
    "restart": "Reiniciar",
    "next_product": "Siguiente producto",
    "finish": "Finalizar",
    "client": "Cliente frecuente",
    "gift_card": "Tarjeta de regalo",
    "amount": "Cantidad",
    "selected_client": "Cliente"
  },
  "products": {
    "title_index": "Productos",
    "title_add": "Agregar producto",
    "title_show": "Ver producto",
    "title_edit": "Modificar producto",
    "title_delete": "Eliminar producto",
    "id": "Id",
    "unit_type_id": "Unidad",
    "category_id": "Categor\xEDa",
    "supplier_id": "Recovequero",
    "name": "Nombre",
    "display_name": "Nombre mostrable (recortado)",
    "barcode": "C\xF3digo de barras",
    "color": "Color de fondo de imagen",
    "url_image": "Imagen (80x80 sugerido)",
    "print_order": "Orden de impresi\xF3n",
    "iva": "IVA",
    "cost_base": "Costo base",
    "cost_min": "Costo m\xEDnimo",
    "cost_max": "Costo m\xE1ximo",
    "price_base": "Precio base",
    "price_min": "Precio m\xEDnimo",
    "price_max": "Precio m\xE1ximo",
    "is_saleable": "Es vendible",
    "is_ticketable": "Aparece en el ticket",
    "is_discountable": "Descontable de inventario",
    "is_favorite": "Es favorito",
    "is_consigment": "Es de consignaci\xF3n",
    "is_product": "Es producto",
    "notes": "Notas",
    "is_active": "Activo",
    "created_by": "Creado por",
    "updated_by": "Modificado por",
    "created_at": "Fecha creado",
    "updated_at": "Fecha modificado",
    "overprice": "Sobreprecio",
    "product": "Producto",
    "amount": "Cantidad",
    "search-input": "Buscar",
    "search": "Producto",
    "supplier_key": "Clave de recovequero",
    "supplier_name": "Nombre de recovequero",
    "product_name": "Producto o c\xF3digo de barras",
    "confirm_delete": "Se borrar\xE1 el producto de la base de datos. \xBFDesea continuar?",
    "Successfully created": "Producto creado correctamente",
    "Successfully updated": "Producto modificado correctamente",
    "Successfully deleted": "Producto eliminado correctamente",
    "delete_error_message": "Error al intentar eliminar el producto de la base de datos",
    "delete_error_message_constraint": "No se puede eliminar el producto, hay tablas que dependen de este"
  },
  "report_by_days": {
    "title_index": "Reporte por d\xEDas",
    "supplier_name": "Recovequero"
  },
  "report_by_months": {
    "title_index": "Reporte por meses"
  },
  "report_by_payment_types": {
    "title_index": "Reporte por tipos de pago",
    "created_at": "Fecha",
    "total_cash": "Efectivo",
    "total_credit": "Tarjeta de C.",
    "total_deposit": "Dep\xF3sito"
  },
  "report_by_suppliers": {
    "title_index": "Reporte por recovequeros",
    "supplier_name": "Recovequero"
  },
  "report_by_tickets": {
    "title_index": "Reporte por tickets",
    "selling_id": "Ticket",
    "created_by": "Vendido",
    "initial_date": "Fecha inicial",
    "final_date": "Fecha final",
    "is_active": "Mostrar",
    "status": "Estatus",
    "payment_types": "Tipo de pago"
  },
  "report_by_years": {
    "title_index": "Reporte por a\xF1os",
    "initial_date": "Desde a\xF1o",
    "final_date": "Hasta a\xF1o"
  },
  "report_day_details": {
    "title_index": "Reporte por d\xEDas"
  },
  "reports": {
    "title_index": "Reportes",
    "id": "id",
    "name": "Nombre",
    "description": "Descripci\xF3n",
    "created_at": "Fecha de venta",
    "updated_at": "Fecha modificado",
    "year": "A\xF1o",
    "monthname": "Mes",
    "day": "D\xEDa",
    "total": "Ventas",
    "product_id": "Producto",
    "total_amount": "Cantidad",
    "total_product_amount": "Importe",
    "initial_date": "Fecha inicial",
    "final_date": "Fecha final",
    "supplier_name": "Recovequero",
    "is_active": "Solo activos",
    "total_price": "Total",
    "Successfully created": "Creado correctamente",
    "Successfully updated": "Modificado correctamente",
    "Successfully deleted": "Eliminado correctamente",
    "constraint_error_delete_message": "Error al intentar eliminar de la base de datos",
    "Successfully saved permissions": "Permisos guardados correctamente"
  },
  "roles": {
    "title_index": "Roles de usuario",
    "title_add": "Agregar rol de usuario",
    "title_show": "Ver rol de usuario",
    "title_edit": "Modificar rol de usuario",
    "permissions": "Permisos de rol de usuario",
    "id": "id",
    "name": "Nombre",
    "description": "Descripci\xF3n",
    "created_at": "Fecha creado",
    "updated_at": "Fecha modificado",
    "Successfully created": "Creado correctamente",
    "Successfully updated": "Modificado correctamente",
    "Successfully deleted": "Eliminado correctamente",
    "constraint_error_delete_message": "Error al intentar eliminar de la base de datos",
    "Successfully saved permissions": "Permisos guardados correctamente"
  },
  "sellings": {
    "title_index": "Ventas",
    "title_add": "Agregar venta",
    "title_show": "Ver venta",
    "title_edit": "Modificar venta",
    "title_delete": "Eliminar venta",
    "id": "Id",
    "client_id": "client_id",
    "nr": "N.R",
    "subtotal": "subtotal",
    "iva": "IVA",
    "total": "Total",
    "notes": "Notas",
    "is_active": "Activo",
    "created_by": "Creado por",
    "updated_by": "Modificado por",
    "created_at": "Fecha creado",
    "updated_at": "Fecha modificado",
    "ticket_number": "Ticket",
    "cashier_name": "Atendi\xF3",
    "ticket_date": "Fecha",
    "description": "Descripci\xF3n",
    "amount": "Cantidad",
    "total_ticket": "Importe",
    "payment_type": "Pago en",
    "change": "Cambio",
    "total_points": "Puntos despu\xE9s de la compra",
    "confirm_delete": "Se borrar\xE1 venta de la base de datos. \xBFDesea continuar?",
    "Successfully created": "venta creado correctamente",
    "Successfully updated": "venta modificado correctamente",
    "Successfully deleted": "Venta cancelada correctamente",
    "delete_error_message": "Error al intentar eliminar venta de la base de datos",
    "delete_error_message_constraint": "No se puede eliminar venta, hay tablas que dependen de este"
  },
  "starting_founds": {
    "title_index": "Cierres de caja",
    "title_add": "Agregar fondos iniciales",
    "title_show": "Informaci\xF3n de d\xEDa",
    "title_edit": "Modificar fondos iniciales",
    "title_delete": "Eliminar fondos iniciales",
    "id": "id",
    "initial_date": "Fecha de inicio",
    "final_date": "Fecha de cierre",
    "initial_user_id": "Quien inici\xF3",
    "final_user_id": "Quien cerr\xF3",
    "amount": "Fondos iniciales.",
    "quantity": "Cantidad",
    "import": "Importe",
    "description": "Descripci\xF3n",
    "close_day": "Cerrar d\xEDa",
    "selling_product": "Venta de cada art\xEDculo",
    "starting_found": "Fondo de caja",
    "notes": "Notas",
    "is_active": "Activo",
    "created_by": "Creado por",
    "updated_by": "Modificado por",
    "created_at": "Fecha creado",
    "updated_at": "Fecha modificado",
    "confirm_delete": "Se borrar\xE1 fondos iniciales de la base de datos. \xBFDesea continuar?",
    "Successfully created": "Fondo inicial creado correctamente",
    "Successfully updated": "Fondo inicial modificado correctamente",
    "Successfully deleted": "Fondo inicial eliminado correctamente",
    "delete_error_message": "Error al intentar eliminar Fondo inicial de la base de datos",
    "delete_error_message_constraint": "No se puede eliminar Fondo inicial, hay tablas que dependen de este"
  },
  "suppliers": {
    "title_index": "Recovequeros",
    "title_add": "Agregar recovequero",
    "title_show": "Ver recovequero",
    "title_edit": "Modificar recovequero",
    "title_delete": "Eliminar recovequero",
    "id": "C\xF3digo",
    "name": "Nombre",
    "key": "Clave",
    "description": "Descripci\xF3n",
    "commission_percentage": "Porcentaje",
    "commission_supplier": "Sobre",
    "commission_shop": "El recoveco",
    "notes": "Notas",
    "is_active": "Activo",
    "search": "Recovequero",
    "created_by": "Creado por",
    "updated_by": "Modificado por",
    "created_at": "Fecha creado",
    "updated_at": "Fecha modificado",
    "confirm_delete": "Se borrar\xE1 recovequero de la base de datos. \xBFDesea continuar?",
    "Successfully created": "recovequero creado correctamente",
    "Successfully updated": "recovequero modificado correctamente",
    "Successfully deleted": "recovequero eliminado correctamente",
    "delete_error_message": "Error al intentar eliminar recovequero de la base de datos",
    "delete_error_message_constraint": "No se puede eliminar recovequero, hay tablas que dependen de este"
  },
  "templates": {
    "data[id]": "Tema",
    "title_index": "Temas"
  },
  "translation": {
    "Menu": "Men\xFA",
    "Dashboards": "Cuadros de mando",
    "Default": "Defecto",
    "Saas": "Saas",
    "Crypto": "Cripto",
    "Blog": "Blog",
    "Layouts": "Dise\xF1os",
    "Vertical": "Vertical",
    "Light_Sidebar": "Barra lateral ligera",
    "Compact_Sidebar": "Barra lateral compacta",
    "Icon_Sidebar": "Barra lateral de iconos",
    "Boxed_Width": "Ancho en caja",
    "Preloader": "Precargador",
    "Colored_Sidebar": "Barra lateral coloreada",
    "Scrollable": "Desplazable",
    "Horizontal": "Horizontal",
    "Topbar_Light": "Luz de barra superior",
    "Colored_Header": "Encabezado de color",
    "Apps": "Aplicaciones",
    "Calendars": "Calendarios",
    "TUI_Calendar": "Calendario TUI",
    "Full_Calendar": "Calendario completo",
    "Chat": "Charla",
    "New": "Nuevo",
    "File_Manager": "Administrador de archivos",
    "Ecommerce": "Comercio electr\xF3nico",
    "Products": "Productos",
    "Product_Detail": "Detalle del producto",
    "Orders": "Pedidos",
    "Customers": "Clientes",
    "Cart": "Carro",
    "Checkout": "Revisa",
    "Shops": "Tiendas",
    "Add_Product": "Agregar producto",
    "Wallet": "Billetera",
    "Buy_Sell": "Compra venta",
    "Exchange": "Intercambiar",
    "Lending": "Pr\xE9stamo",
    "KYC_Application": "Aplicaci\xF3n KYC",
    "ICO_Landing": "Aterrizaje de ICO",
    "Email": "Email",
    "Inbox": "Bandeja de entrada",
    "Read_Email": "Leer el correo electr\xF3nico",
    "Templates": "Plantillas",
    "Basic_Action": "Acci\xF3n b\xE1sica",
    "Alert_Email": "Correo electr\xF3nico de alerta",
    "Billing_Email": "Correo Electr\xF3nico de Facturas",
    "Invoices": "Facturas",
    "Invoice_List": "Lista de facturas",
    "Invoice_Detail": "Detalle de la factura",
    "Projects": "Proyectos",
    "Projects_Grid": "Cuadr\xEDcula de proyectos",
    "Projects_List": "Lista de proyectos",
    "Project_Overview": "Descripci\xF3n del proyecto",
    "Create_New": "Crear nuevo",
    "Tasks": "Tareas",
    "Task_List": "Lista de tareas",
    "Kanban_Board": "Tablero Kanban",
    "Create_Task": "Crear tarea",
    "Contacts": "Contactos",
    "User_Grid": "Cuadr\xEDcula de usuario",
    "User_List": "Lista de usuarios",
    "Profile": "Perfil",
    "Blog_List": "Lista de blogs",
    "Blog_Grid": "Blog Grid",
    "Blog_Details": "Detalles del blog",
    "Pages": "P\xE1ginas",
    "Authentication": "Autenticaci\xF3n",
    "Login": "Iniciar sesi\xF3n",
    "Register": "Registrarse",
    "Recover_Password": "Recuperar contrase\xF1a",
    "Lock_Screen": "Bloquear pantalla",
    "Confirm_Mail": "Confirmar correo",
    "Email_verification": "Verificacion de email",
    "Two_step_verification": "Verificaci\xF3n de dos pasos",
    "Utility": "Utilidad",
    "Starter_Page": "P\xE1gina de inicio",
    "Maintenance": "Mantenimiento",
    "Coming_Soon": "Pr\xF3ximamente",
    "Timeline": "Cronolog\xEDa",
    "FAQs": "Preguntas frecuentes",
    "Pricing": "Precios",
    "Error_404": "error 404",
    "Error_500": "Error 500",
    "Components": "Componentes",
    "UI_Elements": "Elementos de la interfaz de usuario",
    "Alerts": "Alertas",
    "Buttons": "Botones",
    "Cards": "Tarjetas",
    "Carousel": "Carrusel",
    "Dropdowns": "Listas deplegables",
    "Grid": "Cuadr\xEDcula",
    "Images": "Imagenes",
    "Lightbox": "Caja ligera",
    "Modals": "Modales",
    "Offcanvas": "Fuera del lienzo",
    "Range_Slider": "Control deslizante de rango",
    "Session_Timeout": "Hora de t\xE9rmino de la sesi\xF3n",
    "Progress_Bars": "Barras de progreso",
    "Sweet_Alert": "Alerta dulce",
    "Tabs_&_Accordions": "Pesta\xF1as y acordeones",
    "Typography": "Tipograf\xEDa",
    "Video": "V\xEDdeo",
    "General": "General",
    "Colors": "Colores",
    "Rating": "Clasificaci\xF3n",
    "Notifications": "Notificaciones",
    "Forms": "Formularios",
    "Form_Elements": "Elementos de formulario",
    "Form_Layouts": "Dise\xF1os de formulario",
    "Form_Validation": "Validaci\xF3n de formulario",
    "Form_Advanced": "Formulario avanzado",
    "Form_Editors": "Editores de formularios",
    "Form_File_Upload": "Carga de archivo de formulario",
    "Form_Xeditable": "Formulario Xeditable",
    "Form_Repeater": "Repetidor de formulario",
    "Form_Wizard": "Asistente de formulario",
    "Form_Mask": "M\xE1scara de forma",
    "Tables": "Mesas",
    "Basic_Tables": "Tablas b\xE1sicas",
    "Data_Tables": "Tablas de datos",
    "Responsive_Table": "Tabla receptiva",
    "Editable_Table": "Tabla editable",
    "Charts": "Gr\xE1ficos",
    "Apex_Charts": "Gr\xE1ficos de Apex",
    "E_Charts": "Gr\xE1ficos E",
    "Chartjs_Charts": "Gr\xE1ficos de Chartjs",
    "Flot_Charts": "Gr\xE1ficos de Flot",
    "Toast_UI_Charts": "Gr\xE1ficos de interfaz de usuario de Toast",
    "Jquery_Knob_Charts": "Gr\xE1ficos de perillas de Jquery",
    "Sparkline_Charts": "Minigr\xE1ficos",
    "Icons": "Iconos",
    "Boxicons": "Boxicones",
    "Material_Design": "Dise\xF1o de materiales",
    "Dripicons": "Dripicons",
    "Font_awesome": "Fuente impresionante",
    "Maps": "Mapas",
    "Google_Maps": "mapas de Google",
    "Vector_Maps": "Mapas vectoriales",
    "Leaflet_Maps": "Mapas de folletos",
    "Multi_Level": "Multi nivel",
    "Level_1.1": "Nivel 1.1",
    "Level_1.2": "Nivel 1.2",
    "Level_2.1": "Nivel 2.1",
    "Level_2.2": "Nivel 2.2",
    "Search": "Buscar...",
    "Mega_Menu": "Mega men\xFA",
    "UI_Components": "Componentes de UI",
    "Applications": "Aplicaciones",
    "Extra_Pages": "P\xE1ginas extra",
    "Horizontal_layout": "Disposici\xF3n horizontal",
    "View_All": "Ver todo",
    "Your_order_is_placed": "Se realiza tu pedido",
    "If_several_languages_coalesce_the_grammar": "Si varios idiomas fusionan la gram\xE1tica",
    "3_min_ago": "Hace 3 minutos",
    "James_Lemire": "James Lemire",
    "It_will_seem_like_simplified_English": "Parecer\xE1 un ingl\xE9s simplificado.",
    "1_hours_ago": "Hace 1 hora",
    "Your_item_is_shipped": "Tu art\xEDculo es enviado",
    "Salena_Layfield": "Salena Layfield",
    "As_a_skeptical_Cambridge_friend_of_mine_occidental": "Como esc\xE9ptico amigo m\xEDo occidental de Cambridge.",
    "View_More": "Ver m\xE1s..",
    "My_Wallet": "Mi billetera",
    "Settings": "Configuraciones",
    "Lock_screen": "Bloquear pantalla",
    "Logout": "Cerrar sesi\xF3n",
    "Edit_Details": "Editar detalles",
    "Placeholders": "Marcadores de posici\xF3n",
    "Toasts": "Tostadas"
  },
  "unit_types": {
    "title_index": "Tipos de unidad",
    "title_add": "Agregar tipo de unidad",
    "title_show": "Ver tipo de unidad",
    "title_edit": "Modificar tipo de unidad",
    "title_delete": "Eliminar tipo de unidad",
    "id": "id",
    "name": "Nombre",
    "description": "Descripci\xF3n",
    "notes": "Notas",
    "is_active": "Activo",
    "created_by": "Creado por",
    "updated_by": "Modificado por",
    "created_at": "Fecha creado",
    "updated_at": "Fecha modificado",
    "confirm_delete": "Se borrar\xE1 unit_type de la base de datos. \xBFDesea continuar?",
    "Successfully created": "unit_type creado correctamente",
    "Successfully updated": "unit_type modificado correctamente",
    "Successfully deleted": "unit_type eliminado correctamente",
    "delete_error_message": "Error al intentar eliminar unit_type de la base de datos",
    "delete_error_message_constraint": "No se puede eliminar unit_type, hay tablas que dependen de este"
  },
  "users": {
    "title_index": "Usuarios",
    "title_add": "Agregar usuario",
    "title_show": "Ver usuario",
    "title_edit": "Modificar usuario",
    "id": "Id",
    "role_id": "Rol",
    "name": "Nombre",
    "paternal_surname": "Apellido paterno",
    "maternal_surname": "Apellido materno",
    "picture": "Foto",
    "email": "Correo electr\xF3nico",
    "email_verified_at": "Correo verificado a",
    "password": "Contrase\xF1a",
    "remember_token": "Token",
    "created_at": "Fecha creado",
    "updated_at": "Fecha modificado",
    "Successfully created": "Creado correctamente",
    "Successfully updated": "Modificado correctamente",
    "Successfully deleted": "Eliminado correctamente",
    "constraint_error_delete_message": "Error al intentar eliminar de la base de datos",
    "Successfully saved permissions": "Permisos guardados correctamente"
  },
  "validation": {
    "accepted": "El campo :attribute debe ser aceptado.",
    "accepted_if": "El campo :attribute debe ser aceptado cuando :other es :value.",
    "active_url": "El campo :attribute no es una URL v\xE1lida.",
    "after": "El campo :attribute debe ser una fecha posterior a :date.",
    "after_or_equal": "El campo :attribute debe ser una fecha posterior o igual a :date.",
    "alpha": "El campo :attribute solo puede contener letras.",
    "alpha_dash": "El campo :attribute solo puede contener letras, n\xFAmeros, guiones y guiones bajos.",
    "alpha_num": "El campo :attribute solo puede contener letras y n\xFAmeros.",
    "array": "El campo :attribute debe ser un array.",
    "before": "El campo :attribute debe ser una fecha anterior a :date.",
    "before_or_equal": "El campo :attribute debe ser una fecha anterior o igual a :date.",
    "between": {
      "array": "El campo :attribute debe contener entre :min y :max elementos.",
      "file": "El archivo :attribute debe pesar entre :min y :max kilobytes.",
      "numeric": "El campo :attribute debe ser un valor entre :min y :max.",
      "string": "El campo :attribute debe contener entre :min y :max caracteres."
    },
    "boolean": "El campo :attribute debe ser verdadero o falso.",
    "confirmed": "El campo confirmaci\xF3n de :attribute no coincide.",
    "current_password": "La contrase\xF1a es incorrecta.",
    "date": "El campo :attribute no corresponde con una fecha v\xE1lida.",
    "date_equals": "El campo :attribute debe ser una fecha igual a :date.",
    "date_format": "El campo :attribute no corresponde con el formato de fecha :format.",
    "declined": "El campo :attribute debe ser rechazado.",
    "declined_if": "El campo :attribute debe ser rechazado cuando :other es :value.",
    "different": "Los campos :attribute y :other deben ser diferentes.",
    "digits": "El campo :attribute debe ser un n\xFAmero de :digits d\xEDgitos.",
    "digits_between": "El campo :attribute debe contener entre :min y :max d\xEDgitos.",
    "dimensions": "El campo :attribute tiene dimensiones de imagen inv\xE1lidas.",
    "distinct": "El campo :attribute tiene un valor duplicado.",
    "email": "El campo :attribute debe ser una direcci\xF3n de correo v\xE1lida.",
    "ends_with": "El campo :attribute debe finalizar con alguno de los siguientes valores: :values",
    "enum": "The selected :attribute is invalid.",
    "exists": "El campo :attribute seleccionado no existe.",
    "file": "El campo :attribute debe ser un archivo.",
    "filled": "El campo :attribute debe tener un valor.",
    "gt": {
      "array": "El campo :attribute debe contener m\xE1s de :value elementos.",
      "file": "El archivo :attribute debe pesar m\xE1s de :value kilobytes.",
      "numeric": "El campo :attribute debe ser mayor a :value.",
      "string": "El campo :attribute debe contener m\xE1s de :value caracteres."
    },
    "gte": {
      "array": "El campo :attribute debe contener :value o m\xE1s elementos.",
      "file": "El archivo :attribute debe pesar :value o m\xE1s kilobytes.",
      "numeric": "El campo :attribute debe ser mayor o igual a :value.",
      "string": "El campo :attribute debe contener :value o m\xE1s caracteres."
    },
    "image": "El campo :attribute debe ser una imagen.",
    "in": "El campo :attribute es inv\xE1lido.",
    "in_array": "El campo :attribute no existe en :other.",
    "integer": "El campo :attribute debe ser un n\xFAmero entero.",
    "ip": "El campo :attribute debe ser una direcci\xF3n IP v\xE1lida.",
    "ipv4": "El campo :attribute debe ser una direcci\xF3n IPv4 v\xE1lida.",
    "ipv6": "El campo :attribute debe ser una direcci\xF3n IPv6 v\xE1lida.",
    "json": "El campo :attribute debe ser una cadena de texto JSON v\xE1lida.",
    "lt": {
      "array": "El campo :attribute debe contener menos de :value elementos.",
      "file": "El archivo :attribute debe pesar menos de :value kilobytes.",
      "numeric": "El campo :attribute debe ser menor a :value.",
      "string": "El campo :attribute debe contener menos de :value caracteres."
    },
    "lte": {
      "array": "El campo :attribute debe contener :value o menos elementos.",
      "file": "El archivo :attribute debe pesar :value o menos kilobytes.",
      "numeric": "El campo :attribute debe ser menor o igual a :value.",
      "string": "El campo :attribute debe contener :value o menos caracteres."
    },
    "mac_address": "El campo :attribute debe ser una direcci\xF3n MAC v\xE1lida.",
    "max": {
      "array": "El campo :attribute no debe contener m\xE1s de :max elementos.",
      "file": "El archivo :attribute no debe pesar m\xE1s de :max kilobytes.",
      "numeric": "El campo :attribute no debe ser mayor a :max.",
      "string": "El campo :attribute no debe contener m\xE1s de :max caracteres."
    },
    "mimes": "El campo :attribute debe ser un archivo de tipo: :values.",
    "mimetypes": "El campo :attribute debe ser un archivo de tipo: :values.",
    "min": {
      "array": "El campo :attribute debe contener al menos :min elementos.",
      "file": "El archivo :attribute debe pesar al menos :min kilobytes.",
      "numeric": "El campo :attribute debe ser al menos :min.",
      "string": "El campo :attribute debe contener al menos :min caracteres."
    },
    "multiple_of": "The :attribute must be a multiple of :value.",
    "not_in": "El campo :attribute seleccionado es inv\xE1lido.",
    "not_regex": "El formato del campo :attribute es inv\xE1lido.",
    "numeric": "El campo :attribute debe ser un n\xFAmero.",
    "password": "La contrase\xF1a es incorrecta.",
    "present": "El campo :attribute debe estar presente.",
    "prohibited": "El campo :attribute no es admitido.",
    "prohibited_if": "El campo :attribute no es admitido cuando :other es :value.",
    "prohibited_unless": "El campo :attribute no es admitido hasta que :other es :values.",
    "prohibits": "El campo :attribute no admite :other.",
    "regex": "El formato del campo :attribute es inv\xE1lido.",
    "required": "El campo :attribute es obligatorio.",
    "required_array_keys": "The :attribute field must contain entries for: :values.",
    "required_if": "El campo :attribute es obligatorio cuando el campo :other es :value.",
    "required_unless": "El campo :attribute es requerido a menos que :other se encuentre en :values.",
    "required_with": "El campo :attribute es obligatorio cuando :values est\xE1 presente.",
    "required_with_all": "El campo :attribute es obligatorio cuando :values est\xE1n presentes.",
    "required_without": "El campo :attribute es obligatorio cuando :values no est\xE1 presente.",
    "required_without_all": "El campo :attribute es obligatorio cuando ninguno de los campos :values est\xE1n presentes.",
    "same": "Los campos :attribute y :other deben ser iguales.",
    "size": {
      "array": "El campo :attribute debe contener :size elementos.",
      "file": "El archivo :attribute debe pesar :size kilobytes.",
      "numeric": "El campo :attribute debe ser :size.",
      "string": "El campo :attribute debe contener :size caracteres."
    },
    "starts_with": "El campo :attribute debe comenzar con uno de los siguientes valores: :values",
    "string": "El campo :attribute debe ser una cadena de caracteres.",
    "timezone": "El campo :attribute debe ser una zona horaria v\xE1lida.",
    "unique": "El valor del campo :attribute ya est\xE1 en uso.",
    "uploaded": "El campo :attribute no se pudo subir.",
    "url": "El formato del campo :attribute es inv\xE1lido.",
    "uuid": "El campo :attribute debe ser un UUID v\xE1lido.",
    "custom": {
      "attribute-name": {
        "rule-name": "custom-message"
      },
      "user_id": {
        "gt": "El campo :attribute debe tener un valor v\xE1lido"
      }
    },
    "attributes": []
  },
  "views": {
    "views": "Pantalla"
  }
};

/***/ }),

/***/ "./resources/js/layout/cookie.js":
/*!***************************************!*\
  !*** ./resources/js/layout/cookie.js ***!
  \***************************************/
/***/ (() => {

$(document).ready(function () {
  //store a cookie
  window.writeCookie = function (name, value, days) {
    var date, expires;

    if (days) {
      date = new Date();
      date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
      expires = "; expires=" + date.toGMTString();
    } else {
      expires = "";
    }

    document.cookie = name + "=" + value + expires + "; path=/";
  }; //retrive a cookie


  window.readCookie = function (name) {
    var i,
        c,
        ca,
        nameEQ = name + "=";
    ca = document.cookie.split(';');

    for (i = 0; i < ca.length; i++) {
      c = ca[i];

      while (c.charAt(0) == ' ') {
        c = c.substring(1, c.length);
      }

      if (c.indexOf(nameEQ) == 0) {
        return c.substring(nameEQ.length, c.length);
      }
    }

    return '';
  };
});

/***/ }),

/***/ "./resources/js/layout/image_preview.js":
/*!**********************************************!*\
  !*** ./resources/js/layout/image_preview.js ***!
  \**********************************************/
/***/ (() => {

$(document).ready(function () {
  // Cuando se suba una imagen...
  $("#imageInput").change(function () {
    // Llama la función que muestra el preview.
    readURL(this);
  });
});

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $('#imagePreview').attr('src', e.target.result);
    };

    reader.readAsDataURL(input.files[0]); // convert to base64 string
  }
}

/***/ }),

/***/ "./resources/js/layout/sidebar.js":
/*!****************************************!*\
  !*** ./resources/js/layout/sidebar.js ***!
  \****************************************/
/***/ (() => {

$(function () {
  //En móvil la barra de navegación inicia contraída y en las demás resoluciones inicia expandida
  if (isMobile) $('#navbar').removeClass("navbar-expanded").addClass("navbar-collapsed");else $('#navbar').removeClass("navbar-collapsed").addClass("navbar-expanded"); //Al hacer cambiar tamaño de la ventana actualizar la variable que indica si estamos en móvil

  $(window).resize(function () {
    isMobile = $(window).width() < mobileWidth ? true : false;
  });
  /**
   * [Al dar click en el botón para minimizar menú le agrega la clase collapsed a la barra de menú y llama a la función que cambia la visualización]
   */

  $("#navbar-toggler").click(function (event) {
    var collapse = false;
    $.each($('#navbar').attr('class').split(' '), function (index, val) {
      if (val == "navbar-collapsed") collapse = false;else if (val == "navbar-expanded") collapse = true;
    });
    collapseMenu(collapse);
  }); //Al dar clic sobre un submenú girar la flecha

  $(".nav-item > a.nav-submenu").click(function (e) {
    if ($(this).attr("aria-expanded") == "false") {
      $(this).find(".dropdown-icon").removeClass('icon-expanded').addClass('icon-collapsed');
    } else {
      $(this).find(".dropdown-icon").removeClass('icon-collapsed').addClass('icon-expanded');
    }
  }); //Al dar clic en un item que no es submenú cierra el navbar para que no estorbe

  $(".nav-item > a.nav-item").click(function (e) {
    if (isMobile) collapseMenu(true);
  });
  /**
   * [collapseMenu Contrae o expande la barra de navegación]
   * @param  {[Boolean]} collapse [Booleando para indicar si el menú debe collapsarse o no]
   */

  window.collapseMenu = function (collapse) {
    if (collapse) {
      if (isMobile) {
        $('#main').attr('style', 'display: flex!important');
      }

      $('#navbar').removeClass("navbar-expanded").addClass("navbar-collapsed"); //$('#navbar i').css("font-size", "20px");
      //$(".navbar-submenu").removeClass('pl-sm-3');

      $(".nav-item > a > span").removeClass().addClass("d-none d-sm-none");
    } else {
      if (isMobile) {
        $('#main').attr('style', 'display: none!important');
      }

      $('#navbar').removeClass("navbar-collapsed").addClass("navbar-expanded"); //$('#navbar i').css("font-size", "14px");
      //$(".navbar-submenu").addClass('pl-sm-3');

      $(".nav-item > a > span").removeClass().addClass("d-sm-inline d-sm-inline");
    }

    writeCookie("collapse", collapse, 1);
  };

  collapseMenu(readCookie("collapse") != "false");
});

/***/ }),

/***/ "./resources/js/layout/var.js":
/*!************************************!*\
  !*** ./resources/js/layout/var.js ***!
  \************************************/
/***/ (() => {

//En este apartado declaramos el tamaño de lo que será la pantalla de móvil.
window.mobileWidth = 578;
window.isMobile = $(window).width() < mobileWidth ? true : false;

/***/ }),

/***/ "./resources/js/mod_permissions/roles_permissions.js":
/*!***********************************************************!*\
  !*** ./resources/js/mod_permissions/roles_permissions.js ***!
  \***********************************************************/
/***/ (() => {

$(function () {
  /** Funciones para seleccionar secciones de permisos */
  window.permissionsChecking = function () {
    $(".permissionsContainer input[type=checkbox]").change(function (event) {
      //Los checkbox que son secciones tienen hijos
      if ($(this).attr("class") == "checkSection") {
        window.checkChild($(this).attr("id"), $(this).is(":checked"));
      }

      window.checkParent($(this).attr("data-parent"));
    });
  };
  /**
   * [checkChild Busca elementos hijos de un id dado y los selecciona o deselecciona
   * alguno de los elementos hijos es una sección se vuelve a llamar esta función]
   * @param  {String}  currentId [Id del elemento actual que vamos a buscar si tiene hijos para seleccionar]
   * @param  {Boolean} isChecked [Condición para ver si los hijos se van a seleccionar o deseleccionar]
   */


  window.checkChild = function (currentId, isChecked) {
    $(".permissionsContainer input[data-parent=" + currentId + "]").each(function (index, el) {
      if ($(el).prop("disabled") != true) {
        $(el).prop("checked", isChecked);

        if ($(el).attr("class") == "checkSection") {
          window.checkChild($(el).attr("id"), isChecked);
        }
      }
    });
  };
  /**
   * [checkParent Si el elemento tiene padre intenta seleccionarlo.
   * Si el padre seleccionado tiene un elemento padre se vuelve a llamar esta función]
   * @param  {String} parentId [Id del elemento padre del elemento]
   */


  window.checkParent = function (parentId) {
    if (parentId != "0") {
      //Verificar si voy a seleccionar la sección
      var isChecked = true;
      $(".permissionsContainer input[data-parent=" + parentId + "]").each(function (index, el) {
        if (!$(el).is(":checked")) {
          isChecked = false;
        }
      });
      var section = $("#" + parentId);
      section.prop("checked", isChecked); //Si la sección que se seleccionó tiene parent, entonces vuelve a llamar esta función para evaluar si se seleccionará la sección padre

      if (section.attr("data-parent") != "0") {
        window.checkParent(section.attr("data-parent"));
      }
    }
  };

  $(".checkPermission").each(function (index, el) {
    if ($(this).is(":checked")) {
      if ($(this).attr("data-parent") != "0") {
        window.checkParent($(this).attr("data-parent"));
      }
    }
  });
  permissionsChecking();
});

/***/ }),

/***/ "./resources/js/pos/cart_functions.js":
/*!********************************************!*\
  !*** ./resources/js/pos/cart_functions.js ***!
  \********************************************/
/***/ (() => {

$(function () {
  window.existProductInCart = function (product_id) {
    var result = {
      status: false,
      row: null
    };
    $("#section-carrito #table-cart tbody tr").each(function (index, el) {
      if ($(this).attr("data-id") == product_id) {
        result.status = true;
        result.row = $(this);
        return false;
      }
    });
    return result;
  };

  window.increaseAmount = function (param) {
    var amount = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 1;
    var input = $(param).closest(".cart-row").find(".amount");
    amount = parseInt(input.val()) + parseInt(amount);
    input.val(amount);
    updateRowTotal(param);
  };

  window.decreaseAmount = function (param) {
    var input = $(param).closest(".cart-row").find(".amount");
    var amount = parseInt(input.val()) - 1;
    input.val(amount >= 1 ? amount : 1);
    updateRowTotal(param);
  };

  window.updateRowTotal = function (param) {
    var row = $(param).closest(".cart-row");
    var amount = $(row).find(".amount");
    var pu = $(row).find(".price input");
    var subtotalInput = $(row).find(".subtotal input");
    var subtotal = $(row).find(".subtotal span");
    var total = parseInt(amount.val()) * parseFloat(pu.val()); //si la siguiente fila tiene ingredientes multiplica el valor *mayormente será 0* por el amount de la fila padre

    if ($(row).next().hasClass("ingredients")) {
      var ingredients = $(row).next();
      var overpriceIngredients = 0;
      $(ingredients).find(".ingredient").each(function (index, el) {
        overpriceIngredients += parseFloat($(el).find("#overprice").val());
      });
      $(ingredients).find(".total-overprice-input").val(overpriceIngredients * parseInt(amount.val()));
      $(ingredients).find(".total-overprice").text("$".concat((overpriceIngredients * parseInt(amount.val())).toFixed(2)));
    }

    subtotalInput.val(total);
    subtotal.text("$".concat(total.toFixed(2)));
    setTotal();
  };

  window.deleteProduct = function (param) {
    var id = $(param).closest("tr").attr("data-unique-id");
    $(param).closest("tbody").find("tr[data-parent-id=".concat(id, "]")).remove();
    $(param).closest("tr").remove();
    setTotal();
  };

  window.setTotal = function () {
    var total = 0;
    $("#section-carrito #table-cart tbody tr:not(.ingredients)").each(function (index, el) {
      total += parseFloat($(this).find(".subtotal input").val());
    });
    $("#section-carrito #table-cart tbody tr.ingredients").each(function (index, el) {
      total += parseFloat($(this).find(".total-overprice-input").val());
    });
    $("#section-carrito .total").val("$".concat(total.toFixed(2)));
    $("#section-carrito #total_value").val(total.toFixed(2));
    $("#payment_total").val(total.toFixed(2));
    calculateMissing(); // $("#payment_amount").val(total - getTotalPayment().toFixed(2));

    selectPayment(1, "Efectivo");
  };

  window.cancel = function () {
    $("#section-carrito #table-cart tbody").empty();
    $("#table-payments tbody").empty();
    setTotal();
  };

  window.cancelPayments = function () {
    $("#table-payments tbody").empty();
    calculateMissing();
  };

  window.showPaymentModal = function () {
    if ($("#table-cart tbody").has(".cart-row").length > 0) {
      var total = parseFloat($("#section-carrito #total_value").val()).toFixed(2);
      $("#paymentModal #payment_total").val(total);
      calculateMissing(); // $(".payment-buttons #payment-1").trigger("click");

      $("#paymentModal").modal("show");
    } else {
      Swal.fire("Sin productos.", "Es necesario seleccionar mínimo un producto.", "warning");
    }
  };

  window.getSaleProducts = function () {
    var result = [];
    $("#table-cart tbody tr:not(.ingredients)").each(function () {
      var prod = JSON.parse(window.atob($(this).data("product")));
      var unique_id = $(this).data("unique-id");
      result.push({
        product_id: prod.id,
        amount: $(this).find("input").val(),
        unique_id: $(this).data("unique-id")
      });
    });
    $("#table-cart tbody tr.ingredients").each(function () {
      //let ingredients = [];
      var parentId = $(this).data("parent-id");
      var productAmount = $(this).closest("tbody").find("tr[data-unique-id=".concat(parentId, "]")).find(".amount").val();
      $(this).find(".ingredients .detail-item").each(function () {
        var _ingredient$amount;

        var ingredient = {};
        $(this).find("input[type=hidden]").each(function (index, el) {
          ingredient[$(el).attr("id")] = $(el).val();
        });

        if ((_ingredient$amount = ingredient.amount) !== null && _ingredient$amount !== void 0 ? _ingredient$amount : false) {
          ingredient.amount = parseFloat(ingredient.amount) * parseFloat(productAmount);
        } //ingredients.push(ingredient);


        $.each(result, function (index, value) {
          if (value.unique_id == parentId) {
            var _value$ingredients;

            value.ingredients = (_value$ingredients = value.ingredients) !== null && _value$ingredients !== void 0 ? _value$ingredients : [];
            value.ingredients.push(ingredient);
          }
        });
      });
    });
    return result;
  };

  window.saveSale = function () {
    var data = {
      rows: getSaleProducts(),
      payments: getSalePayments(),
      client_id: $("#container_points #client_id").val()
    };

    if ($("#missing_total_value").val() == 0) {
      $("#pay").attr("disabled", true);
      $.ajax({
        url: $('meta[name="app-url"]').attr("content") + "/pos/saveSale",
        type: "POST",
        data: data,
        dataType: "json",
        success: function success(response) {
          if (response.status) {
            $("body").html(response.data);
            Swal.fire({
              title: "Venta exitosa.",
              text: "Se realizó la venta correctamente.",
              icon: "success",
              allowOutsideClick: false,
              allowEscapeKey: false,
              allowEnterKey: true,
              focusConfirm: true,
              timer: 500
            }).then(function () {
              setTimeout(function () {
                window.print();
                location.reload();
              }, 500);
            });
          } else {
            Swal.fire({
              title: "Error en la venta.",
              text: response.message,
              icon: "error",
              allowOutsideClick: false,
              allowEscapeKey: false,
              allowEnterKey: true,
              focusConfirm: true
            });
          }
        },
        error: function error(response) {
          console.log("error");
        }
      });
    } else {
      Swal.fire("Dinero insuficiente.", "Falta dinero.", "warning");
    }
  }; //Funcion para abrir la tabla de metodo de pago 


  var tablaVisible = false; // Variable para controlar el estado de la tabla
  // Función para mostrar u ocultar la tabla

  function toggleTabla() {
    var tabla = document.getElementById("table-payment-container");

    if (tablaVisible) {
      tabla.style.position = "absolute";
      tabla.style.left = "-9999px";
      document.getElementById("toggleTabla").textContent = "Mostrar Tabla";
    } else {
      tabla.style.position = "static";
      tabla.style.left = "auto";
      document.getElementById("toggleTabla").textContent = "Ocultar Tabla";
    }

    tablaVisible = !tablaVisible; // Cambiar el estado de la tabla
  } // Asignar evento de clic al botón


  document.getElementById("toggleTabla").addEventListener("click", toggleTabla); // const filter = $(".dataTables_wrapper .dataTables_filter").find("input[type=search]");
  // filter.keypress(function(e) {
  // 	var code = (e.keyCode ? e.keyCode : e.which);
  // 	if(code==13){
  // 		$('#products-table .product-table-row').first().trigger('click')
  // 		fil.val("")
  // 	}
  // });
});

/***/ }),

/***/ "./resources/js/pos/client_functions.js":
/*!**********************************************!*\
  !*** ./resources/js/pos/client_functions.js ***!
  \**********************************************/
/***/ (() => {

$(function () {
  window.setClientData = function (data) {
    $("#container_points #client_points").val(data.points);
    $("#container_points .selected-client").removeClass("d-none");
    $("#container_points .selected-client .client-label").html(data.value);
    $("#container_points .selected-client .client-points").html(data.points);
  };

  window.resetClient = function () {
    $("#container_points #client_id").val("");
    $("#container_points #client_input").val("");
    $("#container_points #client_points").val("");
    $("#container_points .selected-client").addClass("d-none");
    $("#container_points .selected-client .client-label").html("");
    $("#container_points .selected-client .client-points").html("");
  };
});

/***/ }),

/***/ "./resources/js/pos/payment_functions.js":
/*!***********************************************!*\
  !*** ./resources/js/pos/payment_functions.js ***!
  \***********************************************/
/***/ (() => {

$(function () {
  //$('#container_points').hide();
  $('#container_giftcard').hide();

  window.addNumberPayment = function (number) {
    $("#payment_amount").val($("#payment_amount").val() + number);
  };

  window.offNumberPayment = function () {
    $("#payment_amount").val($("#payment_amount").val().slice(0, -1));
  };

  window.selectPayment = function (id, type) {
    $("#id_payment_type").val(id);
    $("#payment_type").val(type);
    $('#container_giftcard').hide('fast'); //$('#container_points').hide('fast')

    if (id == 3) {// $('#container_giftcard').show('slow')
    }

    if (id == 4) {//$('#container_points').show('slow')
    }
  };

  window.showAlert = function (title, message) {
    var type = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 'warning';
    Swal.fire(title, message, type);
  };

  window.addPayment = function () {
    var total = parseFloat($("#payment_amount").val());
    var payment_type = $("#payment_type").val();
    var payment_type_type_id = $("#id_payment_type").val();
    var paymentTotal = parseFloat($("#payment_total").val());
    var missingTotal = parseFloat($("#missing_total_value").val());
    total = isNaN(total) ? 0 : total;
    var isValid = true; //#region validations

    if ($("#payment_type").val() == "") {
      showAlert('Error', 'Seleccione el tipo de pago.');
      isValid = false;
    }

    if (total == 0 && isValid) {
      showAlert('Cantidad no válida', 'La cantidad a pagar no puede ser cero.');
      isValid = false;
    }

    if (payment_type_type_id == 4 && isValid) {
      var client_points = parseFloat($("#container_points #client_points").val());
      var min_required = parseFloat($("#container_points #min_required").val());
      client_points = isNaN(client_points) ? 0 : client_points;
      min_required = isNaN(min_required) ? 0 : min_required;

      if ($("#container_points #client_id").val() == "") {
        showAlert('Cliente no válido', 'No ha seleccionado un cliente válido.');
        isValid = false;
      }

      if (total > client_points && isValid) {
        showAlert('Puntos insuficientes', 'La cantidad de puntos a gastar no es válida.');
        isValid = false;
      }

      if (total < min_required && isValid) {
        showAlert('Cantidad no válida', 'La cantidad de puntos a gastar no puede ser menor a ' + min_required + '.');
        isValid = false;
      }
    }

    if (payment_type_type_id != 1 && total > missingTotal && isValid) {
      showAlert('Cantidad no válida', 'No se puede usar más del dinero faltante.');
      isValid = false;
    } //#endregion


    if (isValid) {
      var existCash = false;
      $("#table-payments tbody tr .paymentValues").each(function () {
        if ($(this).find('.payment_type_value').val() == 1 && payment_type_type_id == 1) {
          existCash = true;
          var amount = $(this).find('.payment_amount_value');
          amount.val(parseFloat(total) + parseFloat(amount.val()));
          var paymentAmount = $(this).parent().find('.payment_amount');
          paymentAmount.text("$".concat(parseFloat(amount.val()).toFixed(2)));
        }
      });

      if (!existCash) {
        $("#table-payments").append("<tr class='font-size-18' style=\"vertical-align: middle\">\n\t\t\t\t\t\t<td class=\"d-none paymentValues\">\n\t\t\t\t\t\t\t<input class=\"payment_type_value\" type=\"hidden\" value=\"".concat(payment_type_type_id, "\">\n\t\t\t\t\t\t\t<input class=\"payment_amount_value\" type=\"hidden\" value=\"").concat(total, "\">\n\t\t\t\t\t\t</td>\n\t\t\t\t\t\t<td>").concat(payment_type, "</td>\n\t\t\t\t\t\t<td class=\"payment_amount text-end\">$").concat(total.toFixed(2), "</td>\n\t\t\t\t\t\t<td><button type=\"button\" class=\"btn btn-danger btn-sm delete-payment p-2\"><i class=\"fas fa-times font-size-22\"></i></button></td>\n\t\t\t\t\t</tr>"));
      }

      calculateMissing(); //$("#payment_amount").val("");
      //$("#payment_type").val("");
    }
  };

  window.calculateMissing = function () {
    var total = parseFloat($("#payment_total").val());
    var mTotal = parseFloat(total) - getTotalPayment();
    $("#payment_total_text").val("$".concat(total.toFixed(2)));
    $("#missing_total").val("$".concat(mTotal >= 0 ? mTotal.toFixed(2) : 0));
    $("#missing_total_value").val(mTotal >= 0 ? mTotal.toFixed(2) : 0);
    $("#shift").val("$".concat(mTotal * -1 >= 0 ? (mTotal * -1).toFixed(2) : 0));
    $("#payment_amount").val('');
    selectPayment(1, 'Efectivo');
  };

  window.getTotalPayment = function () {
    var result = 0;
    $("#table-payments tr .payment_amount_value").each(function () {
      result += parseFloat($(this).val());
    });
    return result;
  };

  window.getSalePayments = function () {
    var result = [];
    $("#table-payments tbody tr").each(function () {
      var paymentType = $(this).find('.payment_type_value').val();
      var paymentAmount = $(this).find('.payment_amount_value').val();
      result.push({
        "payment_type_id": paymentType,
        "amount": paymentAmount
      });
    });
    return result;
  }; //de ser posible mejor cambiarlo a una función al onclick del elemento


  $("body").on('click', '.delete-payment', function () {
    $(this).closest('tr').remove();
    calculateMissing();
  });
  $("#confirm_payment").on("click", function () {
    addPayment();
  });
  $("#pay").on("click", function () {
    saveSale();
  });
  selectPayment(1, 'Efectivo');
});

/***/ }),

/***/ "./resources/js/pos/products_functions.js":
/*!************************************************!*\
  !*** ./resources/js/pos/products_functions.js ***!
  \************************************************/
/***/ (() => {

$(function () {
  var _this = this;

  var dtLang = '';
  var isEnter = false;
  fetch($('meta[name="app-url"]').attr('content') + "/js/datatables/datatables_Spanish.json").then(function (json) {
    return dtLang = json;
  }); //Set every tab table as datatable

  $(".table-products").each(function (index, el) {
    var _window$productDatata;

    var currentTab = $(this).closest(".tab-pane").attr("id");
    window.productDatatables = (_window$productDatata = window.productDatatables) !== null && _window$productDatata !== void 0 ? _window$productDatata : {};
    window.productDatatables[currentTab] = $(this).DataTable({
      "pageLength": 16,
      "dom": "rtip",
      "responsive": "true",
      "language": dtLang,
      "drawCallback": function drawCallback() {
        customizeDatatable(false);
      },
      "columns": [{
        "name": "id",
        "visible": false
      }, {
        "name": "key"
      }, {
        "name": "name"
      }, {
        "name": "price"
      }]
    });
  }); //Retrieve the active category in products

  window.getActiveCategory = function () {
    var r = $("#section-productos .nav-item > button.active").attr("data-bs-target");
    return r.substring(1, r.length);
  }; //When user writes down in filter input filter the active table


  $('#section-productos #filter').on("keyup", function () {
    if (!$("#Todos-tab").hasClass("active")) {
      $("#Todos-tab").trigger("click");
    }

    var table = window.productDatatables[getActiveCategory()];
    table.search($(this).val()).draw();
    var filtered = table.rows({
      filter: 'applied'
    }).data();

    if (filtered["length"] > 0) {
      $(".productsGrid .product").addClass("d-none").removeClass('d-inline-block');

      for (var i = 0; i < filtered["length"]; i++) {
        $(".productsGrid .p-grid-".concat(filtered[i][0])).removeClass("d-none").addClass('d-inline-block');
      }
    }
  });
  /** Calculator section */
  //Writhe the given number

  window.addNumber = function (target, number) {
    $(target).val($(target).val() + number);
  }; //Backspace


  window.offNumber = function (target) {
    $(target).val($(target).val().slice(0, -1));
  };
  /**
   * selectProduct: When user adds a product to the sale. 
   * -If product have ingredients display modal to select ingredients
   * -Else check if product is already in sale to add a new row or only update the amount field
   * @param Object product 
   * @param Boolean hasIngredients 
   */


  window.selectProduct = function (param, product) {
    var hasIngredients = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;

    if (!$(param).attr('disabled')) {
      $(param).attr('disabled', true);
      product = JSON.parse(window.atob(product));
      var amount = $('#section-productos #amount').val() != "" ? $('#section-productos #amount').val() : 1;

      if (!hasIngredients) {
        //CART FUNCTION: existProductInCart 
        //Check if product is already in cart
        var exist = existProductInCart(product.id);

        if (!exist.status) {
          $.ajax({
            url: $('meta[name="app-url"]').attr('content') + "/pos/".concat(product.id, "/addcartproduct"),
            type: 'POST',
            data: {
              amount: amount
            },
            dataType: 'json',
            success: function success(response) {
              $("#table-cart tbody").append(response); //CART FUNCTION: setTotal

              $(param).attr('disabled', false);
              setTotal();
            }
          });
        } else {
          //CART FUNCTION: increaseAmount
          $(param).attr('disabled', false);
          increaseAmount($(exist.row).find("input.amount"), amount);
        }
      } else {
        $.ajax({
          url: $('meta[name="app-url"]').attr('content') + "/pos/".concat(product.id, "/getingredientsmodal"),
          type: 'GET',
          dataType: 'json',
          success: function success(response) {
            $(".ingredients-modal").remove();
            $("#selected_product").val(response.product.id);
            $("body").append(response.content);
            $(".ingredients-modal").first().css('z-index', getModalZIndex()).modal('show');
            $(param).attr('disabled', false);
          }
        });
      }

      $("#amount").val('');
    }
  };
  /**
   * selectIngredient: When user Select an ingredient from ingredients modal. 
   * -If product have ingredients display modal to select ingredients
   * -Else check if product is already in sale to add a new row or only update the amount field
   * @param DOM object param Ingredient clicked
   * @param Object product Selected ingredient
   */


  window.selectIngredient = function (param, product) {
    product = JSON.parse(window.atob(product));
    var id = $(param).closest(".tab-pane").find(".id").val();
    var category_id = $(param).closest(".tab-pane").find(".category_id").val();
    var amount = $(param).closest(".tab-pane").find(".amount").val();
    var pos = $("body").find(".ingredients-modal:first").find("button.active").attr("data-name");
    var val = product.id;
    selectedTab = $(param).closest(".ingredients-modal").find(".ingredients-selected > .active").append("\n\t\t<div onclick=\"deleteSelectedIngredient(this)\" class=\"ingredient\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"".concat(product.name, "\">\n\t\t\t<span>x</span>\n\t\t\t<img class=\"img-fluid w-100\" src=\"").concat(product.url_image == 'no-image.png' ? $('meta[name="app-url"]').attr('content') + "/images/no-image.png" : product.url_image, "\" style=\"background-color: ").concat(product.color == "" ? "#26a9e1" : product.color, "; aspect-ratio: 1/1\">\n\t\t\t<input type=\"hidden\" class=\"id\" value=\"").concat(id, "\">\n\t\t\t<input type=\"hidden\" class=\"category_id\" value=\"").concat(category_id, "\">\n\t\t\t<input type=\"hidden\" class=\"amount\" value=\"").concat(amount, "\">\n\t\t\t<input type=\"hidden\" class=\"product_id\" value=\"").concat(product.id, "\">\n\t\t\t<input type=\"hidden\" class=\"product_name\" value=\"").concat(product.name, "\">\n\t\t\t<input type=\"hidden\" class=\"overprice\" value=\"").concat(product.overprice, "\">\n\t\t\t<input type=\"hidden\" class=\"pos\" value=\"").concat(pos, "\">\n\t\t\t<p class=\"m-0 mt-1 product-text\">").concat(product.name, "</p>\n\t\t</div>"));
    console.log(selectedTab);
    updateAmountIngredients(param); //Hide current category and show next

    $(param).closest(".tab-pane").removeClass("active").addClass("selected");
    var el = getNextElement($(param).closest(".tab-pane"));

    if (el != null) {
      $(el).addClass("active");
    } else {
      //addPackToSale();
      showNextProductModal(param);
    }
  };

  window.updateAmountIngredients = function (param) {
    var isDelete = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
    var modal = $(param).closest(".ingredients-modal");
    var tIng = $(modal).find(".ingredients-content #product_ingredients").val();
    var sIng = $(modal).find(".ingredients-content .ingredients-selected .ingredient").length;
    var rIng = parseFloat(tIng) - parseFloat(sIng);
    $(modal).find(".ingredients-content .r-ingredients").html(isDelete ? rIng + 1 : rIng);
  };

  window.getNextElement = function (el) {
    var result = null;
    var next = $(el).next();

    if ($(next).length > 0) {
      if (!$(next).hasClass("selected")) {
        result = next;
      } else {
        result = getNextElement(next);
      }
    }

    return result;
  };
  /**
   * Remove item from selected list and make active the list to select ingredient again
   * @param {*} param Selected ingredient to delete
   */


  window.deleteSelectedIngredient = function (param) {
    updateAmountIngredients(param, true);
    var id = $(param).closest(".ingredient").find(".id").val();
    $(param).closest(".ingredient").remove(); //Remove from selected list
    //Make the ingredient we just removed be able to select again
    //and set the first ingredient pane as active

    var cont = $(".ingredients-content .tab-content");
    $(cont).find(".tab-pane").removeClass("active");
    $(cont).find("#ingredient-".concat(id)).removeClass("selected");
    $(cont).find("> div:not(.selected)").first().removeClass("active").addClass("active");
  };

  window.showNextProductModal = function (param) {
    var modal = $(param).closest(".ingredients-modal");
    $(modal).modal('hide');

    if ($(modal).next().hasClass("ingredients-modal")) {
      $(modal).next().modal('show');
    } else {
      addPackToSale(param);
    }
  };

  window.addPackToSale = function (param) {
    var product_id = $("#selected_product").val();
    var amount = $('#section-productos #amount').val() != "" ? $('#section-productos #amount').val() : 1;
    var uniqueId = $(".modal-body #product_unique_id").val();
    var allIngredients = [];
    $(".ingredients-modal").each(function (index, element) {
      var ingredients = [];
      $(this).find(".ingredients-selected .ingredient").each(function (index, row) {
        var item = {};
        $(this).find("input[type=hidden]").each(function (index, el) {
          item[$(this).attr("class")] = $(this).val();
        });
        ingredients.push(item);
      });
      allIngredients.push({
        product_id: $(this).find("#product_id").val(),
        product_name: $(this).find("#product_name").val(),
        product_ingredients: $(this).find("#product_ingredients").val(),
        ingredients: ingredients
      });
    });
    var url, data;

    if (uniqueId != false) {
      url = "".concat(product_id, "/").concat(uniqueId, "/addIngredientProduct");
      amount = $(_this).find("#product_amount").val();
      data = {
        amount: amount,
        allIngredients: allIngredients
      };
    } else {
      url = "".concat(product_id, "/addcartproduct");
      data = {
        amount: amount,
        allIngredients: allIngredients
      };
    }

    $.ajax({
      url: $('meta[name="app-url"]').attr('content') + "/pos/".concat(url),
      type: 'POST',
      data: data,
      dataType: 'json',
      success: function success(response) {
        //en caso de que uniqueId sea diferente de false quiere decir que se está llamando desde el edit
        if (uniqueId != false) {
          var buttonId = $("#button_edit_id").val();
          $("#table-cart tbody").find("button[data-id=\"".concat(buttonId, "\"]")).closest("tr[data-parent-id=".concat(uniqueId, "]")).remove();
          $("#table-cart tbody tr[data-unique-id=".concat(uniqueId, "]")).after(response);
        } else {
          $("#table-cart tbody").append(response);
        }

        setTotal();
        $(".ingredients-modal").remove();
        $(".modal-backdrop").remove();
      }
    });
  };

  window.editProduct = function (param, buttonId) {
    var ingredients = [];
    var product_id = $(param).closest(".cart-row").data("product-id");
    var product_unique_id = $(param).closest(".cart-row").data("parent-id");
    var amount = $("#table-cart-content tbody").find("tr[data-unique-id=".concat(product_unique_id, "]")).find(".amount").val();
    $(param).closest('.cart-row').find(".ingredients").find(".detail-item").each(function () {
      var item = {};
      $(this).find("input[type=hidden]").each(function (index, el) {
        item[$(this).attr("id")] = $(this).val();
      });
      ingredients.push(item);
    });
    var data = {
      product_id: product_id,
      amount: parseInt(amount),
      ingredients: {
        bottom: ingredients.filter(function (item) {
          return item.pos == "Abajo";
        }),
        middle: ingredients.filter(function (item) {
          return item.pos == "En medio";
        }),
        top: ingredients.filter(function (item) {
          return item.pos == "Arriba";
        })
      }
    };
    $.ajax({
      url: $('meta[name="app-url"]').attr('content') + "/pos/".concat(product_unique_id, "/").concat(buttonId, "/updateingredientsmodal"),
      type: 'GET',
      data: data,
      dataType: 'json',
      success: function success(response) {
        $(".ingredients-modal").remove();
        $("#selected_product").val(response.product.id);
        $("body").append(response.content);
        $(".ingredients-modal").first().css('z-index', getModalZIndex()).modal('show');
        $(param).attr('disabled', false);
      }
    });
  };

  window.resetIngredients = function (param) {
    var modal = $(param).closest(".ingredients-modal");
    $(modal).find(".ingredients-selected .ingredient").each(function (index, row) {
      $(this).trigger('click');
    });
    $(modal).find('#myTab .nav-link').first().trigger('click');
    selectTab('Abajo-tab');
  };

  window.selectTab = function (tabId) {
    var tab = $("#".concat(tabId));
    tab.trigger("click");
    $(".ingredients-selected").find('.tab-ingredients').each(function () {
      $(this).removeClass('active');
    });
    $(".tab-ingredients[data-tab=".concat(tabId, "]")).addClass("active");
  }; //Busca por codigo de barras o nombre de producto via ajax


  window.searchProducts = function (param) {
    var addFirstProduct = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
    $.ajax({
      url: $('meta[name="app-url"]').attr('content') + "/pos/search/".concat(param),
      type: 'GET',
      dataType: 'json',
      success: function success(response) {
        console.log(response);

        if (response) {
          var counter = 0;
          $("#message-search-scan").addClass('d-none').removeClass('d-block');
          $("#pos-products-table-body").html('');
          response.forEach(function (element, index) {
            if ($("#with_inventory").prop('checked')) {
              if (element.amount > 0) {
                addProduct(element, counter, addFirstProduct);
                counter++;
              }
            } else {
              addProduct(element, index, addFirstProduct);
            }
          });
        }
      }
    });
  };

  $("#with_inventory").on('change', function () {
    var filter = $("#filter").val();
    searchProducts(filter);
  });

  function addProduct(element, index, addFirstProduct) {
    var rowClass = index % 2 === 0 ? 'product-table-row even' : 'product-table-row odd';
    $("#pos-products-table-body").append("\n\t\t<tr class=\"".concat(rowClass, "\" data-id=\"").concat(element.id, "\" onclick=\"selectProduct(this, '").concat(btoa(JSON.stringify(element)), "')\">\n\t\t\t<td>").concat(element.supplier_name, " - ").concat(element.barcode, "</td>\n\t\t\t<td>").concat(element.amount, "</td>\n\t\t\t<td>").concat(element.name, "</td>\n\t\t\t<td class='text-end'>$").concat(element.price_base.toFixed(2).toLocaleString(), "</td>\n\t\t</tr>\n\t\t"));

    if (index == 0 && addFirstProduct) {
      $("#pos-products-table-body tr").first().trigger('click');
      $("#filter").val('');
    }
  } //Evento para detectar cuando pulsa enter


  $('#filter').off('keyup').on('keyup', function (event) {
    var filter = $("#filter").val();

    if (event.keyCode === 13) {
      searchProducts(filter, true);
    }
  });
  $("#btnSearch").on('click', function () {
    var filter = $("#filter").val();
    searchProducts(filter);
  });
  $("#btnClearSearch").on('click', function () {
    $("#pos-products-table-body").html('');
    $("#filter").val('');
    $("#message-search-scan").removeClass('d-none').addClass('d-block');
  }); //Products: Select first tab

  $("#section-productos .nav-tabs .nav-link").first().trigger("click");
});

/***/ }),

/***/ "./resources/js/reports/export_excel_sellings.js":
/*!*******************************************************!*\
  !*** ./resources/js/reports/export_excel_sellings.js ***!
  \*******************************************************/
/***/ (() => {

$(function () {
  $("#export_excel_sellings").on('click', function () {
    data = {
      'initial_date': $("#initial_date").val(),
      'final_date': $("#final_date").val(),
      'supplier_name': $("#supplier_name").val(),
      'product_name': $("#product_name").val(),
      'selling_id': $("#selling_id").val()
    };
    $.ajax({
      url: $('meta[name="app-url"]').attr('content') + "/report_by_sellings/exportExcel",
      method: 'GET',
      data: data,
      xhrFields: {
        responseType: 'blob' // Indicar que la respuesta es un archivo binario

      },
      beforeSend: function beforeSend() {
        //Mostrar el spinner antes de mandar la petición 
        $('#modal-carga').modal('show');
        $("#modal-carga").removeClass("d-none");
      },
      success: function success(data) {
        // Crear un enlace temporal para descargar el archivo
        var url = window.URL.createObjectURL(data);
        var a = document.createElement('a');
        a.href = url;
        a.download = 'reporte_ventas.xlsx'; // Nombre del archivo

        document.body.appendChild(a);
        a.click();
        $('#modal-carga').modal('hide');
      }
    });
  });
});

/***/ }),

/***/ "./resources/js/reports/export_excel_suppliers.js":
/*!********************************************************!*\
  !*** ./resources/js/reports/export_excel_suppliers.js ***!
  \********************************************************/
/***/ (() => {

$(function () {
  $("#export_excel_suppliers").on('click', function () {
    data = {
      'initial_date': $("#initial_date").val(),
      'final_date': $("#final_date").val(),
      'supplier_name': $("#supplier_name").val(),
      'is_active': $("#is_active").val()
    };
    $.ajax({
      url: $('meta[name="app-url"]').attr('content') + "/report_by_suppliers/exportExcel",
      method: 'GET',
      data: data,
      xhrFields: {
        responseType: 'blob' // Indicar que la respuesta es un archivo binario

      },
      beforeSend: function beforeSend() {
        //Mostrar el spinner antes de mandar la petición 
        $('#modal-carga').modal('show');
        $("#modal-carga").removeClass("d-none");
      },
      success: function success(data) {
        // Crear un enlace temporal para descargar el archivo
        var url = window.URL.createObjectURL(data);
        var a = document.createElement('a');
        a.href = url;
        a.download = 'reporte_provedores.xlsx'; // Nombre del archivo

        document.body.appendChild(a);
        a.click();
        $('#modal-carga').modal('hide');
      }
    });
  });
});

/***/ }),

/***/ "./resources/js/theme.js":
/*!*******************************!*\
  !*** ./resources/js/theme.js ***!
  \*******************************/
/***/ (() => {

/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Version: 3.3.0.
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Main Js File
*/
(function ($) {
  'use strict';

  function initMetisMenu() {
    //metis menu
    $("#side-menu").metisMenu();
  }

  function initLeftMenuCollapse() {
    $('#vertical-menu-btn').on('click', function (event) {
      event.preventDefault();
      $('body').toggleClass('sidebar-enable');

      if ($(window).width() >= 992) {
        $('body').toggleClass('vertical-collpsed');
      } else {
        $('body').removeClass('vertical-collpsed');
      }
    });
  }

  function initActiveMenu() {
    // === following js will activate the menu in left side bar based on url ====
    $("#sidebar-menu a").each(function () {
      var pageUrl = window.location.href.split(/[?#]/)[0];

      if (this.href == pageUrl) {
        $(this).addClass("active");
        $(this).parent().addClass("mm-active"); // add active to li of the current link

        $(this).parent().parent().addClass("mm-show");
        $(this).parent().parent().prev().addClass("mm-active"); // add active class to an anchor

        $(this).parent().parent().parent().addClass("mm-active");
        $(this).parent().parent().parent().parent().addClass("mm-show"); // add active to li of the current link

        $(this).parent().parent().parent().parent().parent().addClass("mm-active");
      }
    });
  }

  function initMenuItemScroll() {
    // focus active menu in left sidebar
    $(document).ready(function () {
      if ($("#sidebar-menu").length > 0 && $("#sidebar-menu .mm-active .active").length > 0) {
        var activeMenu = $("#sidebar-menu .mm-active .active").offset().top;

        if (activeMenu > 300) {
          activeMenu = activeMenu - 300;
          $(".vertical-menu .simplebar-content-wrapper").animate({
            scrollTop: activeMenu
          }, "slow");
        }
      }
    });
  }

  function initHoriMenuActive() {
    $(".navbar-nav a").each(function () {
      var pageUrl = window.location.href.split(/[?#]/)[0];

      if (this.href == pageUrl) {
        $(this).addClass("active");
        $(this).parent().addClass("active");
        $(this).parent().parent().addClass("active");
        $(this).parent().parent().parent().addClass("active");
        $(this).parent().parent().parent().parent().addClass("active");
        $(this).parent().parent().parent().parent().parent().addClass("active");
        $(this).parent().parent().parent().parent().parent().parent().addClass("active");
      }
    });
  }

  function initFullScreen() {
    $('[data-bs-toggle="fullscreen"]').on("click", function (e) {
      e.preventDefault();
      $('body').toggleClass('fullscreen-enable');

      if (!document.fullscreenElement &&
      /* alternative standard method */
      !document.mozFullScreenElement && !document.webkitFullscreenElement) {
        // current working methods
        if (document.documentElement.requestFullscreen) {
          document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
          document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
          document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
      } else {
        if (document.cancelFullScreen) {
          document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
          document.webkitCancelFullScreen();
        }
      }
    });
    document.addEventListener('fullscreenchange', exitHandler);
    document.addEventListener("webkitfullscreenchange", exitHandler);
    document.addEventListener("mozfullscreenchange", exitHandler);

    function exitHandler() {
      if (!document.webkitIsFullScreen && !document.mozFullScreen && !document.msFullscreenElement) {
        console.log('pressed');
        $('body').removeClass('fullscreen-enable');
      }
    }
  }

  function initRightSidebar() {
    // right side-bar toggle
    $('.right-bar-toggle').on('click', function (e) {
      $('body').toggleClass('right-bar-enabled');
    });
    $(document).on('click', 'body', function (e) {
      if ($(e.target).closest('.right-bar-toggle, .right-bar').length > 0) {
        return;
      }

      $('body').removeClass('right-bar-enabled');
      return;
    });
  }

  function initDropdownMenu() {
    if (document.getElementById("topnav-menu-content")) {
      var elements = document.getElementById("topnav-menu-content").getElementsByTagName("a");

      for (var i = 0, len = elements.length; i < len; i++) {
        elements[i].onclick = function (elem) {
          if (elem.target.getAttribute("href") === "#") {
            elem.target.parentElement.classList.toggle("active");
            elem.target.nextElementSibling.classList.toggle("show");
          }
        };
      }

      window.addEventListener("resize", updateMenu);
    }
  }

  function updateMenu() {
    var elements = document.getElementById("topnav-menu-content").getElementsByTagName("a");

    for (var i = 0, len = elements.length; i < len; i++) {
      if (elements[i].parentElement.getAttribute("class") === "nav-item dropdown active") {
        elements[i].parentElement.classList.remove("active");

        if (elements[i].nextElementSibling !== null) {
          elements[i].nextElementSibling.classList.remove("show");
        }
      }
    }
  }

  function initComponents() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
      return new bootstrap.Popover(popoverTriggerEl);
    });
    var offcanvasElementList = [].slice.call(document.querySelectorAll('.offcanvas'));
    var offcanvasList = offcanvasElementList.map(function (offcanvasEl) {
      return new bootstrap.Offcanvas(offcanvasEl);
    });
  }

  function initPreloader() {
    $(window).on('load', function () {
      $('#status').fadeOut();
      $('#preloader').delay(350).fadeOut('slow');
    });
  }

  function initSettings() {
    if (window.sessionStorage) {
      var alreadyVisited = sessionStorage.getItem("is_visited");

      if (!alreadyVisited) {
        sessionStorage.setItem("is_visited", "light-mode-switch");
      } else {
        $(".right-bar input:checkbox").prop('checked', false);
        $("#" + alreadyVisited).prop('checked', true);
        updateThemeSetting(alreadyVisited);
      }
    }

    $("#light-mode-switch, #dark-mode-switch, #rtl-mode-switch, #dark-rtl-mode-switch").on("change", function (e) {
      updateThemeSetting(e.target.id);
    }); // show password input value

    $("#password-addon").on('click', function () {
      if ($(this).siblings('input').length > 0) {
        $(this).siblings('input').attr('type') == "password" ? $(this).siblings('input').attr('type', 'input') : $(this).siblings('input').attr('type', 'password');
      }
    });
  }

  function updateThemeSetting(id) {
    if ($("#light-mode-switch").prop("checked") == true && id === "light-mode-switch") {
      $("html").removeAttr("dir");
      $("#dark-mode-switch").prop("checked", false);
      $("#rtl-mode-switch").prop("checked", false);
      $("#dark-rtl-mode-switch").prop("checked", false);
      $("#bootstrap-style").attr('href', 'assets/css/bootstrap.min.css');
      $("#app-style").attr('href', 'assets/css/app.min.css');
      sessionStorage.setItem("is_visited", "light-mode-switch");
    } else if ($("#dark-mode-switch").prop("checked") == true && id === "dark-mode-switch") {
      $("html").removeAttr("dir");
      $("#light-mode-switch").prop("checked", false);
      $("#rtl-mode-switch").prop("checked", false);
      $("#dark-rtl-mode-switch").prop("checked", false);
      $("#bootstrap-style").attr('href', 'assets/css/bootstrap-dark.min.css');
      $("#app-style").attr('href', 'assets/css/app-dark.min.css');
      sessionStorage.setItem("is_visited", "dark-mode-switch");
    } else if ($("#rtl-mode-switch").prop("checked") == true && id === "rtl-mode-switch") {
      $("#light-mode-switch").prop("checked", false);
      $("#dark-mode-switch").prop("checked", false);
      $("#dark-rtl-mode-switch").prop("checked", false);
      $("#bootstrap-style").attr('href', 'assets/css/bootstrap.rtl.css');
      $("#app-style").attr('href', 'assets/css/app.rtl.css');
      $("html").attr("dir", 'rtl');
      sessionStorage.setItem("is_visited", "rtl-mode-switch");
    } else if ($("#dark-rtl-mode-switch").prop("checked") == true && id === "dark-rtl-mode-switch") {
      $("#light-mode-switch").prop("checked", false);
      $("#rtl-mode-switch").prop("checked", false);
      $("#dark-mode-switch").prop("checked", false);
      $("#bootstrap-style").attr('href', 'assets/css/bootstrap-dark.rtl.css');
      $("#app-style").attr('href', 'assets/css/app-dark.rtl.css');
      $("html").attr("dir", 'rtl');
      sessionStorage.setItem("is_visited", "dark-rtl-mode-switch");
    }
  }

  function initCheckAll() {
    $('#checkAll').on('change', function () {
      $('.table-check .form-check-input').prop('checked', $(this).prop("checked"));
    });
    $('.table-check .form-check-input').change(function () {
      if ($('.table-check .form-check-input:checked').length == $('.table-check .form-check-input').length) {
        $('#checkAll').prop('checked', true);
      } else {
        $('#checkAll').prop('checked', false);
      }
    });
  }

  function init() {
    initMetisMenu();
    initLeftMenuCollapse();
    initActiveMenu();
    initMenuItemScroll();
    initHoriMenuActive();
    initFullScreen();
    initRightSidebar();
    initDropdownMenu();
    initComponents();
    initSettings();
    initPreloader();
    Waves.init();
    initCheckAll();
  }

  init();
})(jQuery);

/***/ }),

/***/ "./resources/scss/bootstrap.scss":
/*!***************************************!*\
  !*** ./resources/scss/bootstrap.scss ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/scss/icons.scss":
/*!***********************************!*\
  !*** ./resources/scss/icons.scss ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./resources/scss/app.scss":
/*!*********************************!*\
  !*** ./resources/scss/app.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./lang/es.json":
/*!**********************!*\
  !*** ./lang/es.json ***!
  \**********************/
/***/ ((module) => {

"use strict";
module.exports = JSON.parse('{"The :attribute must contain at least one letter.":"El campo :attribute debe contener al menos una letra.","The :attribute must contain at least one number.":"El campo :attribute debe contener al menos un número.","The :attribute must contain at least one symbol.":"El campo :attribute debe contener al menos un símbolo.","The :attribute must contain at least one uppercase and one lowercase letter.":"El campo :attribute debe contener al menos una mayuscula y una minúscula.","The given :attribute has appeared in a data leak. Please choose a different :attribute.":"El campo :attribute está en la lista de datos no seguros. Por favor selecione un :attribute diferente.","Write your E-Mail Address":"Escribe tu correo electrónico","E-Mail Address":"Correo electrónico","Password":"Contraseña","Remember Me":"Recuérdame","Login":"Iniciar sesión","Forgot Your Password?":"¿Olvidaste tu contraseña?","Register":"Registro","Name":"Nombre","Confirm Password":"Confirmar contraseña","Reset Password":"Recuperar contraseña","Reset Password Notification":"Aviso para restablecer contraseña","You are receiving this email because we received a password reset request for your account.":"Estás recibiendo este email porque se ha solicitado un cambio de contraseña para tu cuenta.","This password reset link will expire in :count minutes.":"Este enlace para restablecer la contraseña caduca en :count minutos.","If you did not request a password reset, no further action is required.":"Si no has solicitado un cambio de contraseña, puedes ignorar o eliminar este e-mail.","Please confirm your password before continuing.":"Por favor confirme su contraseña antes de continuar.","Regards":"Saludos","Whoops!":"¡Ups!","Hello!":"¡Hola!","If you’re having trouble clicking the :actionText button, copy and paste the URL below\\ninto your web browser: [:actionURL](:actionURL)":"Si tienes problemas haciendo click en el botón :actionText, copia y pega el siguiente\\nenlace en tu navegador: [:actionURL](:actionURL)","If you’re having trouble clicking the :actionText button, copy and paste the URL below\\ninto your web browser: [:displayableActionUrl](:actionURL)":"Si tienes problemas haciendo click en el botón :actionText, copia y pega el siguiente\\nenlace en tu navegador: [:displayableActionUrl](:actionURL)","If you’re having trouble clicking the :actionText button, copy and paste the URL below\\ninto your web browser:":"Si tienes problemas haciendo click en el botón :actionText, copia y pega el siguiente\\nenlace en tu navegador:","Are you sure you want to delete this row?":"¿Estás seguro que quieres eliminar este registro?","Send Password Reset Link":"Enviar correo de recuperación","Logout":"Cerrar sesión","Sign in":"Registrate","Verify Email Address":"Confirmar correo electrónico","Please click the button below to verify your email address.":"Por favor pulsa el siguiente botón para confirmar tu correo electrónico.","Please select":"Selecciona una opción.","Select":"Seleccione","If you did not create an account, no further action is required.":"Si no has creado ninguna cuenta, puedes ignorar o eliminar este e-mail.","Verify Your Email Address":"Confirma tu correo electrónico","A fresh verification link has been sent to your email address.":"Se ha enviado un nuevo enlace de verificación a tu correo electrónico.","Before proceeding, please check your email for a verification link.":"Antes de poder continuar, por favor, confirma tu correo electrónico con el enlace que te hemos enviado.","If you did not receive the email":"Si no has recibido el email","click here to request another":"pulsa aquí para que te enviemos otro","All rights reserved.":"Todos los derechos reservados.","actions":"Acciones","action":"Acciones","generate":"Generar","Save":"Guardar","delete":"Eliminar","close":"Cerrar","Yes":"Si","load":"Cargar","description":"Descripción","id":"Id","Table":"Tabla","Grid":"Cuadricula","constraint_error_delete_message":"No se puede eliminar este registro porque hay entidades que dependen de el","Cancel":"Regresar","Save all":"Guardar todo","Search":"Buscar","Clear filters":"Limpiar filtros","Check out":"Salida","The given data was invalid.":"Datos incorrectos","Show details":"Mostrar detalles","Show all":"Mostrar todo","Add":"Agregar","print":"Imprimir","preview":"Vista Previa"}');

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/app": 0,
/******/ 			"css/app": 0,
/******/ 			"css/icons": 0,
/******/ 			"css/bootstrap/bootstrap": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/app","css/icons","css/bootstrap/bootstrap"], () => (__webpack_require__("./resources/js/app.js")))
/******/ 	__webpack_require__.O(undefined, ["css/app","css/icons","css/bootstrap/bootstrap"], () => (__webpack_require__("./resources/scss/bootstrap.scss")))
/******/ 	__webpack_require__.O(undefined, ["css/app","css/icons","css/bootstrap/bootstrap"], () => (__webpack_require__("./resources/scss/icons.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app","css/icons","css/bootstrap/bootstrap"], () => (__webpack_require__("./resources/scss/app.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
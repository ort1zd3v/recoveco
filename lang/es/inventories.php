<?php
return [
	//Titles
	"title_index" => "Inventario",
	"title_add" => "Agregar inventario",
	"title_show" => "Ver inventario",
	"title_edit" => "Modificar inventario",
	"title_delete" => "Eliminar inventario",

	//Fields
	"id" => "Id",
	"supplier_id" => "Recovequero",
	"amount" => "Cantidad",
	"notes" => "Notas",
	"is_active" => "Activo",
	"created_by" => "Creado por",
	"updated_by" => "Modificado por",
	"created_at" => "Fecha creado",
	"updated_at" => "Fecha modificado",
	"supplier_name" => "Recovequero",
	"product_name" => "Producto",

	"inventory_does_not_exist" => "No existe el producto :product en inventario, no se pude descontar",
	"inventory_empty" => "El producto :product no tiene existencias en inventario",
	"inventory_decrease_error" => "La cantidad de :product que desea descontar es mayor a la existencia en inventario",


	"file_read_error" => "Error al leer el archivo",
	"file_request_empty" => "Error. El archivo está vacío",

	//Action messages
	"confirm_delete" => "Se borrará el inventario de la base de datos. ¿Desea continuar?",
	"Successfully created" => "Inventario creado correctamente",
	"Successfully updated" => "Inventario modificado correctamente",
	"Successfully deleted" => "Inventario eliminado correctamente",
	"delete_error_message" => "Error al intentar eliminar el inventario de la base de datos",
	"delete_error_message_constraint" => "No se puede eliminar el inventario, hay tablas que dependen de este",
];
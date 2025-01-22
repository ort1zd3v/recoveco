@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "role_id",
		"id" => "role_id",
		"class" => "form-select",
		"entity" => "users",
		"type" => "select",
		"elements" => $roles,
		"defaultValue" => $user->role_id ?? "",
		"required" => "true",
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "name",
		"id" => "name",
		"class" => "form-control",
		"entity" => "users",
		"type" => "text",
		"elements" => "",
		"defaultValue" => $user->name ?? "",
		"required" => "true",
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "paternal_surname",
		"id" => "paternal_surname",
		"class" => "form-control",
		"entity" => "users",
		"type" => "text",
		"elements" => "",
		"defaultValue" => $user->paternal_surname ?? "",
		"required" => "true",
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "maternal_surname",
		"id" => "maternal_surname",
		"class" => "form-control",
		"entity" => "users",
		"type" => "text",
		"elements" => "",
		"defaultValue" => $user->maternal_surname ?? "",
		"required" => "true",
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "email",
		"id" => "email",
		"class" => "form-control",
		"entity" => "users",
		"type" => "text",
		"elements" => "",
		"defaultValue" => $user->email ?? "",
		"required" => "true",
	]
]])
@include("crud-maker.components.form-row", ["params" => [
	[
		"name" => "password",
		"id" => "password",
		"class" => "form-control",
		"entity" => "users",
		"type" => "password",
		"elements" => "",
		"defaultValue" => "",
		"required" => !isset($user) ? true : false,
	]
]])

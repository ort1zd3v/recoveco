<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Template;

use App\Traits\UploadTrait;

class TemplateSeeder extends Seeder
{
	use UploadTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Template::create([
            "name" => "Light Theme", 
            "data" => json_encode([
                "id" => "1",
				"name" => "Light Theme",
                "logo" => "",
                "general_header_background_color" => "#FFFFFF", 
                "general_header_font_color" => "#74788D", 
                "general_header_font" => "Arial, Helvetica, sans-serif",
                "general_menu_position" => "left",
                "general_menu_background_color" => "#005691", 
                "general_menu_font_color" => "#A6B0CF", 
				"general_menu_font_hover_color" => "#ffffff", 
                "general_menu_font" => "Arial, Helvetica, sans-serif",
                "general_menu_icons" => "on",
                "general_body_background_color" => "#F8F8FB",
                "general_body_font_color" => "#495057",
                "general_body_font" => "Arial, Helvetica, sans-serif",
                "general_footer_background_color" => "#F2F2F5",
                "general_footer_font_color" => "#74788D",
                "general_footer_font" => "Arial, Helvetica, sans-serif",
				"general_header_font_id" => "3",
				"general_menu_font_id" => "2",
				"general_body_font_id" => "2",
				"general_footer_font_id" => "4",
				"datatables_header_backround_color"=>  "122,122,122",
				"datatables_header_font_color"=>  "#1a1a1a",
				"datatables_edit_font_color"=>  "#1a1a1a",
				"datatables_delete_font_color"=>  "#1a1a1a",
				"datatables_add_background_color"=>  "#74788d",
				"datatables_add_font_color"=>  "#1a1a1a"
			])
        ]);
		Template::create([
            "name" => "Dark Theme", 
            "data" => json_encode([
                "id" => "2",
				"name" => "Dark Theme",
				"logo" => "images\/logos\/qlxqgKvX6DTWfwejyOzsnzcIlb0ehyQALu692Ty3.png",
				"general_header_background_color" => "#ffffff",
				"general_header_font_color" => "#74788d",
				"general_header_font" => "'Times New Roman', Times, serif",
				"general_menu_position" => "left",
				"general_menu_background_color" => "#1a1a1a",
				"general_menu_font_color" => "#a6b0cf",
				"general_menu_font" => "Arial, Helvetica, sans-serif",
				"general_menu_icons" => "on",
				"general_body_background_color" => "#ebebeb",
				"general_body_font_color" => "#303030",
				"general_body_font" => "Arial, Helvetica, sans-serif",
				"general_footer_background_color" => "#d9d9d9",
				"general_footer_font_color" => "#5c0000",
				"general_footer_font" => "'Courier New', Courier, monospace",
				"general_menu_font_hover_color" => "#ffffff",
				"general_header_font_id" => "3",
				"general_menu_font_id" => "2",
				"general_body_font_id" => "2",
				"general_footer_font_id" => "4",
				"datatables_header_backround_color"=>  "122,122,122",
				"datatables_header_font_color"=>  "#1a1a1a",
				"datatables_edit_font_color"=>  "#1a1a1a",
				"datatables_delete_font_color"=>  "#1a1a1a",
				"datatables_add_background_color"=>  "#74788d",
				"datatables_add_font_color"=>  "#1a1a1a"
            ])
        ]);

		Template::create([
            "name" => "POS3 Theme", 
            "data" => json_encode([
				"id" => "3",
				"name" => "Dark Theme",
				"logo" => "images\/logos\/gr4kU075336llBvOa0l1bHau4rxwZitVhjtDxhBd.png",
				"general_header_background_color" => "#ffffff",
				"general_header_font_color" => "#74788d",
				"general_header_font" => "'Times New Roman', Times, serif",
				"general_menu_position" => "left",
				"general_menu_background_color" => "#3c2a21",
				"general_menu_font_color" => "#d1d1d1",
				"general_menu_font" => "Arial, Helvetica, sans-serif",
				"general_menu_icons" => "on",
				"general_body_background_color" => "#ebebeb",
				"general_body_font_color" => "#303030",
				"general_body_font" => "Arial, Helvetica, sans-serif",
				"general_footer_background_color" => "#d9d9d9",
				"general_footer_font_color" => "#5c0000",
				"general_footer_font" => "'Courier New', Courier, monospace",
				"general_menu_font_hover_color" => "#ffffff",
				"general_header_font_id" => "3",
				"general_menu_font_id" => "2",
				"general_body_font_id" => "2",
				"general_footer_font_id" => "4",
				"datatables_header_backround_color" => "60, 42, 33",
				"datatables_header_font_color" => "#ffffff",
				"datatables_edit_font_color" => "#35a02d",
				"datatables_delete_font_color" => "#f56b61",
				"datatables_add_background_color" => "#3c2a21",
				"datatables_add_font_color" => "#ffffff"
			])
        ]);

		Template::create([
            "name" => "Recovecos", 
            "data" => json_encode([
				"id" => "4",
				"name" => "Recovecos",
				"logo" => "images\/logos\/Cq1plaow2wNTGhomoHCzFbQpjc9FAT8iivQGSSap.png",
				"general_header_background_color" => "#ffffff",
				"general_header_font_color" => "#2b2b2b",
				"general_header_font" => "'Poppins', sans-serif",
				"general_menu_position" => "left",
				"general_menu_background_color" => "#811224",
				"general_menu_font_color" => "#ebebeb",
				"general_menu_font" => "'Poppins', sans-serif",
				"general_menu_icons" => "on",
				"general_body_background_color" => "#f0f0f0",
				"general_body_font_color" => "#1c1c1c",
				"general_body_font" => "'Poppins', sans-serif",
				"general_footer_background_color" => "#ffffff",
				"general_footer_font_color" => "#474747",
				"general_footer_font" => "'Poppins', sans-serif",
				"general_menu_font_hover_color" => "#ffffff",
				"general_header_font_id" => "3",
				"general_menu_font_id" => "2",
				"general_body_font_id" => "2",
				"general_footer_font_id" => "4",
				"datatables_header_backround_color" => "138, 18, 36",
				"datatables_header_font_color" => "#ffffff",
				"datatables_edit_font_color" => "#42ae5d",
				"datatables_delete_font_color" => "#f56b61",
				"datatables_add_background_color" => "#ae7351",
				"datatables_add_font_color" => "#ffffff"
			])
        ]);
			

        $this->addFirstTemplateJson();
    }

    private function addFirstTemplateJson()
    {
        $template = Template::first();
        $this->uploadJson(json_decode($template->data), "uploads/templates/template");
    }
}

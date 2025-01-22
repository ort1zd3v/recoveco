<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		/* `elrecove_posrecovecos`.`table_supplier` */
$table_supplier = array(
	array('id' => '7','description' => 'Alma Rosa González','notes' => 'MARY KAY
  18 diciembre 237 col. El Roble 
  8115110016'),
	array('id' => '9','description' => 'baja Martha Ofelia Taméz','notes' => 'RV7 8115883777'),
	array('id' => '40','description' => 'ILEANA HINOJOSA','notes' => 'ORGANIZADORES Y COSTURA
  CEL: 8116004633'),
	array('id' => '41','description' => 'ERIKA TAPIA','notes' => 'TARJETAS
  8183621510
  FACE: MONINO_MONE'),
	array('id' => '52','description' => 'ANA GAONA','notes' => 'ARGANIA
  8117990517'),
	array('id' => '59','description' => 'MARISOL ALVARADO TELLEZ','notes' => 'SHAHAMA Y BOLSAS ANASTASIA
  8119240631'),
	array('id' => '69','description' => 'KIKI GONZÁLEZ','notes' => 'CHEF
  Villa Real 225 Villas de Anahuac 
  8110438399
  FACE: KIKI´S CAKE & PASTRY'),
	array('id' => '71','description' => 'ODENSA','notes' => NULL),
	array('id' => '72','description' => 'LETICIA ESCAMILLA','notes' => 'ROPA AGUASCALIENTES
  VALLE DE AGUAYO #336 COL. VALLE DEL CONTRY 
  8183965916'),
	array('id' => '86','description' => 'OFELIA PRIMA','notes' => 'PLANTITAS
  8116028065'),
	array('id' => '98','description' => 'BAJA MYRNA GUAJARDO','notes' => 'CASES PARA iPHONE
  8118003349'),
	array('id' => '109','description' => 'MASULI','notes' => 'MASULI MESA CENTRO Y MESA DE REGALOS'),
	array('id' => '123','description' => 'ROSALINDA CERDA CRUZ','notes' => 'PERFUMERIA
  8115326423'),
	array('id' => '129','description' => 'JAVIER DE LA GARZA ESCAMILLA','notes' => 'TRAJES DE BAÑO
  A TRAVEZ DE LETY ESCAMILLA
  CEL: 8183965916'),
	array('id' => '151','description' => 'Carmelina Alanis de Ceballos','notes' => 'MOÑOS 83768763'),
	array('id' => '152','description' => 'CLAUDIA ELIZONDO','notes' => 'HIELERAS DE MADERA
  NO PAGA RENTA. PAGA COMISIÓN
  8182595512'),
	array('id' => '181','description' => 'BAJA RAQUEL LEZAMA','notes' => 'JOYERIA RODIO
  CEL 8126452940
  INICIO 9-12-16 FIN 9-06-17'),
	array('id' => '182','description' => 'Reclusas','notes' => 'ADA BELLA MORENO
  8180203930'),
	array('id' => '189','description' => 'Luz Esthela Marin Mortera','notes' => 'CARTA Sandwichones 
  8110761922
  FACE: FACTORY LUNCH'),
	array('id' => '197','description' => 'SHAMPOO YEGUADA','notes' => NULL),
	array('id' => '198','description' => 'RELOJES MASULI','notes' => 'RECOVECO'),
	array('id' => '200','description' => 'BOLSAS/CARTERAS RV','notes' => 'RECOVECO'),
	array('id' => '201','description' => 'PERFUMES RV','notes' => 'RECOVECO'),
	array('id' => '209','description' => 'VOLAR FASHION RV','notes' => 'RECOVECO'),
	array('id' => '212','description' => 'lentes RV','notes' => 'RECOVECO'),
	array('id' => '215','description' => 'JULIETA DEL ROSARIO LOERA','notes' => 'LLAMADORES /MALAS/QUANTUM
  CEL 8115311408
  FACE: BENESSERI'),
	array('id' => '221','description' => 'ADRIANA BEATRIZ LLANOS HINOJOSA','notes' => 'FEROMONAS
  CEL 8115442811
  INICIO 17 DE JUNIO DEL 2017
  VENCE 17 DE DICIEMBRE DEL 2017
  PLEASURESXY'),
	array('id' => '224','description' => 'erika calderon ropa','notes' => NULL),
	array('id' => '226','description' => 'Alejandra Jimenes','notes' => 'RENTA: CARTA
  PRODUCTO: TARJETITAS
  8121100330'),
	array('id' => '234','description' => 'MARIZA TREVIÑO','notes' => 'BYD'),
	array('id' => '239','description' => 'ROCIO Y BLANCA HURTADO RAMIREZ','notes' => 'JOYERIA MESA
  TELEFONO 17758258'),
	array('id' => '244','description' => 'BAJA GILDA DE LA GARZA','notes' => 'DIFUSORES
  CEL: 8180109859'),
	array('id' => '245','description' => 'huseim & cittlali','notes' => 'IDEAS PARA LONCHES
  8110723491'),
	array('id' => '246','description' => 'BAJA Elba Dinorah Cabello Flores','notes' => 'Bolsas Michoacan
  8183351321
  (903)2837294'),
	array('id' => '247','description' => 'BAJA PAULA DANIEL','notes' => 'Joyería'),
	array('id' => '249','description' => 'REGALOS RV','notes' => 'BOLSAS, CAJAS, EMPLALLADOS, MOÑOS, ENVOLTURA, ETC.'),
	array('id' => '256','description' => 'HECTOR CHAVARRIA GALLEGOS','notes' => 'ARTICULOS SHELO  Y JAFRA
  TEL 83713011 
  8120631671'),
	array('id' => '258','description' => 'HECTOR CHAVARRIA GALLEGOS jafra','notes' => 'PRODUCTOS JAFRA 8371301
  8120631671'),
	array('id' => '259','description' => 'Evelyn Escamilla','notes' => '8120301939
  Just
  Pulseras de sanacion
  cuadros de sanacion angelicales'),
	array('id' => '262','description' => 'Humanizate Aprende de un perro','notes' => 'CEL 8114138478 TERMOS DE ASOCIACION Y ARTICULOS PARA MASCOTA'),
	array('id' => '264','description' => 'Evelyn E Geometrias','notes' => '81 20301939'),
	array('id' => '265','description' => 'Barbara y Daniel   TEMPORADA','notes' => 'BARBARA Y DANIEL'),
	array('id' => '266','description' => 'Barbara y Daniel ROPA','notes' => 'BARBARA Y DANIEL'),
	array('id' => '269','description' => 'Bissu','notes' => 'Barbara y Daniel'),
	array('id' => '270','description' => 'REMATE','notes' => 'PRODUCTOS EN REMATE BARBARA DANIEL'),
	array('id' => '271','description' => 'BAJA MARIA ELENA FAJAS Y DETALLES','notes' => 'FAJAS, TAZAS, ES NUMERO CLIENTE 243'),
	array('id' => '274','description' => 'MARTHA CALDERON','notes' => 'CARTERAS, CINTOS, LLAVEROS'),
	array('id' => '275','description' => 'DANBAR DULCES AMARANTO','notes' => 'DULCES AMARANTO'),
	array('id' => '277','description' => 'BAJA SERGIO HUMBERTO GARZA GONZALEZ','notes' => 'SALSA GOURMET 8122170269'),
	array('id' => '278','description' => 'DANIELA RODRIGUEZ','notes' => 'ACCESORIAS'),
	array('id' => '280','description' => 'PROYECTO LAVANDA','notes' => 'BARBARA Y DANIEL JABONES Y PRODUCTOS DE LAVANDA'),
	array('id' => '281','description' => 'ROPA ARTESANAL','notes' => 'BARBARA Y DANIEL 
  ZAPATOS, ROPA Y ACCESORIOS'),
	array('id' => '282','description' => 'DECORACION HOGAR','notes' => 'BARBARA Y DANIEL'),
	array('id' => '283','description' => 'NANCI DEL ROCIO CONTRERAS DORANTES','notes' => 'DERMACOL CEL: 8120749393'),
	array('id' => '284','description' => 'BAJA MERARY REVENGE','notes' => 'COCO ORGANICO PRODUCTO ESTETICA CEL:8126663867'),
	array('id' => '286','description' => 'ROPA MACY´S','notes' => 'BARBARA Y DANIEL'),
	array('id' => '287','description' => 'BELLEZA ESPAÑOLA','notes' => 'CERA ESPAÑOLA'),
	array('id' => '288','description' => 'BAJA RUTH ARREDONDO','notes' => 'SKINNY TEATOX8116952661 WHATS 8180134137'),
	array('id' => '289','description' => 'BAJA PAULA DANIEL OLVEDA','notes' => 'TERRAMAR'),
	array('id' => '290','description' => 'BAJA R ARREDONDO','notes' => 'CREMAS REDUCTIVAS Y  ROSTRO'),
	array('id' => '291','description' => '291 R. Accesorios','notes' => 'ruth arredondo'),
	array('id' => '292','description' => 'COSMETICA NATURAL','notes' => 'PRODUCTOS NATURA'),
	array('id' => '293','description' => 'VIANEY BRIONES','notes' => 'COJINES DE SEMILLAS'),
	array('id' => '294','description' => 'HECHO A MANO','notes' => 'PRODUCTOS SANGRE DE DRAGO'),
	array('id' => '295','description' => 'ANABEL CANALES','notes' => 'PRODUCTOS NATURALES'),
	array('id' => '296','description' => 'ART SUPPLY','notes' => 'SOBRES'),
	array('id' => '297','description' => 'AMERICA CASTANEDO','notes' => 'SPRAYS FLORES DE BACH'),
	array('id' => '298','description' => 'SS ACCESORIOS','notes' => 'JOYERIA DE ACERO INOXIDABLE'),
	array('id' => '300','description' => 'RAFAEL LEYVA','notes' => 'SALSA PICANTE MULILLA'),
	array('id' => '301','description' => 'BAJA ALICIA GUTIERREZ','notes' => 'VARIOS'),
	array('id' => '302','description' => 'ALEJANDRA JASPE','notes' => 'ARTE TIFFANY (RECUERDOS)'),
	array('id' => '304','description' => 'BAJA ADRIANA OROZCO','notes' => 'POCIMA RAPUNZEL'),
	array('id' => '305','description' => 'SS JOYERIA','notes' => 'JOYERIA ACERO INOXIDABLE'),
	array('id' => '306','description' => 'NOSTALGIC ART','notes' => 'BARBARA Y DANIEL'),
	array('id' => '307','description' => 'CIRCULO DE MUJERES','notes' => 'TALLER MIERCOLES BARBARA'),
	array('id' => '309','description' => 'RECOVECO','notes' => 'MENSUALIDADES DE RECOVEQUEROS'),
	array('id' => '312','description' => 'WENDY LIRA','notes' => 'SERIGRAFIA 8127699383'),
	array('id' => '313','description' => 'YAYA ROJAS','notes' => 'ARTE EN MODA, PRENDAS PINTADAS A MANO'),
	array('id' => '314','description' => 'ENVOLTURAS','notes' => 'ENVOLTURAS PARA REGALOS'),
	array('id' => '315','description' => 'JUGUETERIA','notes' => NULL),
	array('id' => '317','description' => 'BAJA ISABEL ZETINA','notes' => 'ZAPATOS PORTATILES'),
	array('id' => '318','description' => 'OSCAR EDUARDO MORALES VILLLARREAL','notes' => 'MICHELADA 8110270302'),
	array('id' => '319','description' => 'ALE FRAGA','notes' => 'POPOTES INOXIDABLE'),
	array('id' => '320','description' => 'GINA RAMIREZ','notes' => 'JABONES'),
	array('id' => '321','description' => 'AIDA FERNANDEZ','notes' => 'VELAS'),
	array('id' => '323','description' => 'NUNN CARE','notes' => NULL),
	array('id' => '324','description' => 'COSMETICOS','notes' => NULL),
	array('id' => '325','description' => 'MB MILAGROS Y BENDICIONES','notes' => 'HOLISTICO'),
	array('id' => '326','description' => 'TRAJES DE BAÑO','notes' => NULL),
	array('id' => '327','description' => 'ENVIOS','notes' => NULL),
	array('id' => '328','description' => 'BAJA BLANCA ESTHELA TRUJILLO','notes' => 'VESTIDOS DE MATERNIDAD 
  8116008309'),
	array('id' => '329','description' => 'PARIS 2020','notes' => NULL),
	array('id' => '330','description' => 'BAJA KIKE MILLAN','notes' => 'PULSERAS REIKI'),
	array('id' => '331','description' => 'JULIA LEYVA','notes' => NULL),
	array('id' => '332','description' => 'BAJA PATRICIA CARRILLO','notes' => 'SUJETA LENTES'),
	array('id' => '333','description' => 'IMPORTADOS MODA','notes' => 'BARBARA Y DANIEL VARIOS'),
	array('id' => '335','description' => 'SELENE CANTU','notes' => NULL),
	array('id' => '336','description' => 'ALFONSINA IBARRA','notes' => 'ARTE EN RESINAS
  8126212671'),
	array('id' => '337','description' => 'BAJA ARAM CAMPOS','notes' => 'SYROPE DE VINO TINTO'),
	array('id' => '338','description' => 'RUBEN DARIO AVILA','notes' => 'CORRECTOR DE POSTURA'),
	array('id' => '339','description' => 'ROSARIO SERNA','notes' => 'SCOB-A-LAX'),
	array('id' => '340','description' => 'BAJA ABIGAIL OLMEDO','notes' => 'MAGIC BRA'),
	array('id' => '341','description' => 'BAJA LETICIA MENDOZA','notes' => 'TEZ CANELA'),
	array('id' => '342','description' => 'BAJA GEORGIA ELIZONDO','notes' => 'PRODUCTOS GRABADOS'),
	array('id' => '343','description' => 'BAJA MERCEDES SANCHEZ','notes' => 'RODILLO JADE, PRODUCTOS PARA PERROS'),
	array('id' => '344','description' => 'RECOVECO CAFE','notes' => NULL),
	array('id' => '345','description' => 'KIKI CAFE','notes' => NULL),
	array('id' => '346','description' => 'BAJA CONSUELO HEREDIA','notes' => 'Artículos para bebé'),
	array('id' => '347','description' => 'BAJA ANGELA MARTINEZ','notes' => 'ROPA'),
	array('id' => '348','description' => 'BAJA SELENE OVALLE','notes' => 'CALZADO'),
	array('id' => '349','description' => 'MUJERES LIDERES','notes' => NULL),
	array('id' => '350','description' => 'CLAUDIA CANDANOSA','notes' => 'FORJA'),
	array('id' => '351','description' => 'CABALLERO','notes' => NULL),
	array('id' => '352','description' => 'LAURA IBARRA','notes' => 'PRACTI TOALLA'),
	array('id' => '353','description' => 'SELENE ARMONIZADORES','notes' => NULL),
	array('id' => '354','description' => 'ALMA ROSA BETTERWARE','notes' => NULL),
	array('id' => '355','description' => 'BAJA LIDIA LIZETHE','notes' => 'CALZADO DAMA'),
	array('id' => '356','description' => 'BAJA GABY GALVAN','notes' => 'IVES ROCHER'),
	array('id' => '357','description' => 'HOME DECOR','notes' => NULL),
	array('id' => '358','description' => 'BAJA MARGARITA GARZA','notes' => 'JABONES ARTESANALES'),
	array('id' => '359','description' => 'LETICIA ESCAMILLA 2020','notes' => NULL),
	array('id' => '360','description' => 'BAJA YESSICA LÓPEZ','notes' => 'Ángeles'),
	array('id' => '361','description' => 'Natural Dry Desodorante','notes' => NULL),
	array('id' => '362','description' => 'Antibacterial','notes' => NULL),
	array('id' => '363','description' => 'PRISCILA LOPEZ','notes' => 'ARTESANIAS
  
  81 2605 2260'),
	array('id' => '364','description' => 'VELAS CON INTENCIÓN','notes' => NULL),
	array('id' => '365','description' => 'CREMA ORGANIC BEAUTY','notes' => NULL),
	array('id' => '366','description' => 'BAJA Patricia Castillo','notes' => 'Chamoy'),
	array('id' => '367','description' => 'BAJA Janeth Castillo','notes' => NULL),
	array('id' => '368','description' => 'Abigail Galindo Sosa','notes' => 'Caretas'),
	array('id' => '369','description' => 'BAJA CLAUDIA CHAVEZ','notes' => 'BIBERONES'),
	array('id' => '370','description' => 'BAJA GABY BUSTAMANTE','notes' => 'ROPA'),
	array('id' => '371','description' => 'LAURA ESCALANTE','notes' => 'BLEN CATÁLOGO'),
	array('id' => '372','description' => 'DULCES RECOVECO','notes' => NULL),
	array('id' => '373','description' => 'ACCESORIOS CELULAR RECOVECO','notes' => NULL),
	array('id' => '374','description' => 'BAJA GABRIELA ZAMORA','notes' => 'ROPA DAMA, CABALLERO, JUVENIL, INFANTIL'),
	array('id' => '375','description' => 'BOLSAS 2020','notes' => NULL),
	array('id' => '376','description' => 'BAJA Rubi Munoz Guerrero','notes' => NULL),
	array('id' => '377','description' => 'MABEL SANCHEZ MTZ','notes' => 'PRODUCTOS CUIDADO CABELLO'),
	array('id' => '378','description' => 'SKINNY TEA TOX','notes' => NULL),
	array('id' => '379','description' => 'DIANA SEPULVEDA','notes' => 'STYWAVES
  8110443269'),
	array('id' => '380','description' => 'BAJA LUZ AYALA Y ARAM RODRIGUEZ','notes' => 'ARCILLA ROJA NATURAL'),
	array('id' => '381','description' => 'BAJA JORGE CANTU','notes' => 'CANUC ART 81 1518 5195'),
	array('id' => '382','description' => 'VELAS MIEL','notes' => NULL),
	array('id' => '383','description' => 'BAJA RUBÍ CALLEJAS','notes' => 'NATURA 8118530350'),
	array('id' => '384','description' => 'BAJA MA MAGADELANA GARZA','notes' => 'KITCHE FAIR 81 8254 4571'),
	array('id' => '385','description' => 'ROPA Y CALZADO','notes' => NULL),
	array('id' => '386','description' => 'BAJA ADRIANA ZAVALA','notes' => 'GEL CRYOACTIVE'),
	array('id' => '387','description' => 'LIZ FERNANDEZ','notes' => 'LENTES'),
	array('id' => '388','description' => 'SANDRA AGUILERA','notes' => 'SALSA MACHA, CAJETA, MIEL, ACEITUNAS'),
	array('id' => '389','description' => 'YARELY SIAS','notes' => 'SHAMPOO Y ACONDICIONADOR'),
	array('id' => '390','description' => 'BAJA CLAUDIA DE LEON','notes' => 'VASOS'),
	array('id' => '391','description' => 'BAJA LIZZA CÁRDENAS','notes' => 'ESFERAS DE VIDRIO'),
	array('id' => '392','description' => 'KARLA REYES','notes' => 'HOMEOPATIA'),
	array('id' => '393','description' => 'SR FERNÁNDEZ','notes' => 'PAPÁ DE BÁRBARA, ENCENDEDORES'),
	array('id' => '394','description' => 'BAJA GONZALO ANAYA','notes' => 'SANDWICHON'),
	array('id' => '395','description' => 'ISA LUNA','notes' => 'ROPA DEPORTIVA'),
	array('id' => '396','description' => 'BRENDA PLATA','notes' => 'TAZAS TALAVERA
  8131990014'),
	array('id' => '397','description' => 'BAJA LILY MARTINEZ ACCESORIOS','notes' => NULL),
	array('id' => '398','description' => 'BAJA LILY MARTINEZ COCINA','notes' => NULL),
	array('id' => '399','description' => 'FRAGANCIAS','notes' => NULL),
	array('id' => '400','description' => 'Paletas Hielati','notes' => NULL),
	array('id' => '401','description' => 'Judith Luna','notes' => 'FARMASI'),
	array('id' => '402','description' => 'COCINA RECOVECO','notes' => NULL),
	array('id' => '403','description' => 'YESSICA MORENO','notes' => 'Máquinas para cortar cabello'),
	array('id' => '404','description' => 'GERARDO GARCÍA','notes' => 'LLAVEROS'),
	array('id' => '405','description' => 'EN FORMA','notes' => 'PRODUCTOS PARA HACER EJERCICIO'),
	array('id' => '406','description' => 'DULCE CALVILLO ALVARADO','notes' => 'TUPPERWARE'),
	array('id' => '407','description' => 'ENVOLTURAS 2023','notes' => NULL),
	array('id' => '408','description' => 'SEXY SEXY','notes' => NULL),
	array('id' => '409','description' => 'NANCI CAPILAR','notes' => NULL),
	array('id' => '410','description' => 'KIKI SABADOS','notes' => NULL),
	array('id' => '411','description' => 'YVES ROCHER','notes' => NULL),
	array('id' => '412','description' => 'SHEIN','notes' => NULL)
  );

		Supplier::create(["name" => "N/A"]);
		
		foreach ($table_supplier as $supplier){
			Supplier::create([
				"id" => $supplier['id'],
				"name" => $supplier['description'],
				"description" => $supplier['notes'] ?? null,
			]);
		}

    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ingredient;
use App\Models\Product;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$table_ingredient = array(
			array('id' => '3','idProduct' => '4327','idProductingredient' => '0','idCategory' => '0','amount' => '1'),
			array('id' => '4','idProduct' => '4327','idProductingredient' => '4327','idCategory' => '0','amount' => '1'),
			array('id' => '6','idProduct' => '16356','idProductingredient' => '16333','idCategory' => '0','amount' => '1'),
			array('id' => '7','idProduct' => '16356','idProductingredient' => '16337','idCategory' => '0','amount' => '1'),
			array('id' => '14','idProduct' => '18831','idProductingredient' => '16333','idCategory' => '0','amount' => '1'),
			array('id' => '15','idProduct' => '18831','idProductingredient' => '16337','idCategory' => '0','amount' => '1'),
			array('id' => '16','idProduct' => '18831','idProductingredient' => '18677','idCategory' => '0','amount' => '1'),
			array('id' => '17','idProduct' => '18850','idProductingredient' => '14258','idCategory' => '0','amount' => '1'),
			array('id' => '18','idProduct' => '18850','idProductingredient' => '16120','idCategory' => '0','amount' => '1'),
			array('id' => '19','idProduct' => '20365','idProductingredient' => '19960','idCategory' => '0','amount' => '2'),
			array('id' => '20','idProduct' => '20396','idProductingredient' => '20395','idCategory' => '0','amount' => '2'),
			array('id' => '21','idProduct' => '20430','idProductingredient' => '2173','idCategory' => '0','amount' => '2'),
			array('id' => '22','idProduct' => '18458','idProductingredient' => '17074','idCategory' => '0','amount' => '1'),
			array('id' => '23','idProduct' => '18458','idProductingredient' => '17077','idCategory' => '0','amount' => '1'),
			array('id' => '24','idProduct' => '18458','idProductingredient' => '17184','idCategory' => '0','amount' => '1'),
			array('id' => '25','idProduct' => '1407','idProductingredient' => '1397','idCategory' => '0','amount' => '1'),
			array('id' => '26','idProduct' => '1407','idProductingredient' => '1398','idCategory' => '0','amount' => '1'),
			array('id' => '27','idProduct' => '20573','idProductingredient' => '19657','idCategory' => '0','amount' => '1'),
			array('id' => '28','idProduct' => '20573','idProductingredient' => '19374','idCategory' => '0','amount' => '1'),
			array('id' => '29','idProduct' => '20574','idProductingredient' => '19374','idCategory' => '0','amount' => '2'),
			array('id' => '30','idProduct' => '20575','idProductingredient' => '19657','idCategory' => '0','amount' => '2'),
			array('id' => '31','idProduct' => '20688','idProductingredient' => '20555','idCategory' => '0','amount' => '2'),
			array('id' => '32','idProduct' => '20725','idProductingredient' => '20722','idCategory' => '0','amount' => '1'),
			array('id' => '33','idProduct' => '20725','idProductingredient' => '20724','idCategory' => '0','amount' => '1'),
			array('id' => '34','idProduct' => '20735','idProductingredient' => '16333','idCategory' => '0','amount' => '2'),
			array('id' => '35','idProduct' => '20735','idProductingredient' => '16338','idCategory' => '0','amount' => '1'),
			array('id' => '36','idProduct' => '17378','idProductingredient' => '20874','idCategory' => '0','amount' => '1'),
			array('id' => '37','idProduct' => '17378','idProductingredient' => '20860','idCategory' => '0','amount' => '1'),
			array('id' => '38','idProduct' => '17378','idProductingredient' => '20875','idCategory' => '0','amount' => '1'),
			array('id' => '39','idProduct' => '21169','idProductingredient' => '21169','idCategory' => '0','amount' => '2'),
			array('id' => '40','idProduct' => '21177','idProductingredient' => '14258','idCategory' => '0','amount' => '2'),
			array('id' => '41','idProduct' => '21177','idProductingredient' => '16120','idCategory' => '0','amount' => '2'),
			array('id' => '42','idProduct' => '21189','idProductingredient' => '21057','idCategory' => '0','amount' => '2'),
			array('id' => '43','idProduct' => '21190','idProductingredient' => '21057','idCategory' => '0','amount' => '3'),
			array('id' => '44','idProduct' => '21202','idProductingredient' => '21194','idCategory' => '0','amount' => '1'),
			array('id' => '45','idProduct' => '21202','idProductingredient' => '21195','idCategory' => '0','amount' => '1'),
			array('id' => '46','idProduct' => '21202','idProductingredient' => '21196','idCategory' => '0','amount' => '1'),
			array('id' => '47','idProduct' => '21202','idProductingredient' => '21193','idCategory' => '0','amount' => '1'),
			array('id' => '48','idProduct' => '21203','idProductingredient' => '21198','idCategory' => '0','amount' => '1'),
			array('id' => '49','idProduct' => '21203','idProductingredient' => '21057','idCategory' => '0','amount' => '1'),
			array('id' => '50','idProduct' => '21204','idProductingredient' => '21057','idCategory' => '0','amount' => '1'),
			array('id' => '51','idProduct' => '21204','idProductingredient' => '21199','idCategory' => '0','amount' => '1'),
			array('id' => '52','idProduct' => '21205','idProductingredient' => '21057','idCategory' => '0','amount' => '1'),
			array('id' => '53','idProduct' => '21205','idProductingredient' => '21198','idCategory' => '0','amount' => '1'),
			array('id' => '54','idProduct' => '21205','idProductingredient' => '21199','idCategory' => '0','amount' => '1'),
			array('id' => '55','idProduct' => '21223','idProductingredient' => '21057','idCategory' => '0','amount' => '1'),
			array('id' => '57','idProduct' => '21259','idProductingredient' => '21222','idCategory' => '0','amount' => '2'),
			array('id' => '58','idProduct' => '21259','idProductingredient' => '21201','idCategory' => '0','amount' => '1'),
			array('id' => '59','idProduct' => '21649','idProductingredient' => '21648','idCategory' => '0','amount' => '3'),
			array('id' => '60','idProduct' => '21650','idProductingredient' => '17610','idCategory' => '0','amount' => '1'),
			array('id' => '61','idProduct' => '21650','idProductingredient' => '21648','idCategory' => '0','amount' => '1'),
			array('id' => '64','idProduct' => '22427','idProductingredient' => '16333','idCategory' => '0','amount' => '1'),
			array('id' => '65','idProduct' => '22427','idProductingredient' => '22431','idCategory' => '0','amount' => '1'),
			array('id' => '66','idProduct' => '22428','idProductingredient' => '16335','idCategory' => '0','amount' => '1'),
			array('id' => '67','idProduct' => '22428','idProductingredient' => '22431','idCategory' => '0','amount' => '1'),
			array('id' => '68','idProduct' => '22429','idProductingredient' => '16334','idCategory' => '0','amount' => '1'),
			array('id' => '69','idProduct' => '22429','idProductingredient' => '22431','idCategory' => '0','amount' => '1'),
			array('id' => '70','idProduct' => '22430','idProductingredient' => '16336','idCategory' => '0','amount' => '1'),
			array('id' => '71','idProduct' => '22430','idProductingredient' => '22431','idCategory' => '0','amount' => '1'),
			array('id' => '72','idProduct' => '22985','idProductingredient' => '16333','idCategory' => '0','amount' => '1'),
			array('id' => '73','idProduct' => '22985','idProductingredient' => '16337','idCategory' => '0','amount' => '1'),
			array('id' => '74','idProduct' => '22985','idProductingredient' => '16341','idCategory' => '0','amount' => '1'),
			array('id' => '75','idProduct' => '22985','idProductingredient' => '22431','idCategory' => '0','amount' => '1'),
			array('id' => '76','idProduct' => '22990','idProductingredient' => '22989','idCategory' => '0','amount' => '1'),
			array('id' => '77','idProduct' => '22990','idProductingredient' => '18574','idCategory' => '0','amount' => '1'),
			array('id' => '78','idProduct' => '22990','idProductingredient' => '16968','idCategory' => '0','amount' => '1'),
			array('id' => '79','idProduct' => '22991','idProductingredient' => '22989','idCategory' => '0','amount' => '1'),
			array('id' => '80','idProduct' => '22991','idProductingredient' => '18574','idCategory' => '0','amount' => '1'),
			array('id' => '81','idProduct' => '22991','idProductingredient' => '16969','idCategory' => '0','amount' => '1'),
			array('id' => '82','idProduct' => '22999','idProductingredient' => '16333','idCategory' => '0','amount' => '1'),
			array('id' => '85','idProduct' => '23000','idProductingredient' => '16333','idCategory' => '0','amount' => '1'),
			array('id' => '86','idProduct' => '23000','idProductingredient' => '16337','idCategory' => '0','amount' => '1'),
			array('id' => '87','idProduct' => '23000','idProductingredient' => '22431','idCategory' => '0','amount' => '1'),
			array('id' => '88','idProduct' => '22999','idProductingredient' => '16338','idCategory' => '0','amount' => '1'),
			array('id' => '89','idProduct' => '22999','idProductingredient' => '22431','idCategory' => '0','amount' => '1'),
			array('id' => '90','idProduct' => '23084','idProductingredient' => '2173','idCategory' => '0','amount' => '1'),
			array('id' => '91','idProduct' => '23084','idProductingredient' => '22411','idCategory' => '0','amount' => '1'),
			array('id' => '92','idProduct' => '23125','idProductingredient' => '2173','idCategory' => '0','amount' => '1'),
			array('id' => '93','idProduct' => '23125','idProductingredient' => '22458','idCategory' => '0','amount' => '1'),
			array('id' => '94','idProduct' => '23140','idProductingredient' => '23141','idCategory' => '0','amount' => '1'),
			array('id' => '95','idProduct' => '23140','idProductingredient' => '23142','idCategory' => '0','amount' => '1'),
			array('id' => '96','idProduct' => '23169','idProductingredient' => '2164','idCategory' => '0','amount' => '1'),
			array('id' => '97','idProduct' => '23169','idProductingredient' => '2166','idCategory' => '0','amount' => '1'),
			array('id' => '98','idProduct' => '23170','idProductingredient' => '2165','idCategory' => '0','amount' => '1'),
			array('id' => '99','idProduct' => '23170','idProductingredient' => '2170','idCategory' => '0','amount' => '1'),
			array('id' => '100','idProduct' => '23171','idProductingredient' => '2165','idCategory' => '0','amount' => '1'),
			array('id' => '101','idProduct' => '23171','idProductingredient' => '17180','idCategory' => '0','amount' => '1'),
			array('id' => '102','idProduct' => '23235','idProductingredient' => '23121','idCategory' => '0','amount' => '3'),
			array('id' => '103','idProduct' => '18314','idProductingredient' => '16333','idCategory' => '0','amount' => '1'),
			array('id' => '104','idProduct' => '18314','idProductingredient' => '23014','idCategory' => '0','amount' => '1'),
			array('id' => '107','idProduct' => '23309','idProductingredient' => '16333','idCategory' => '0','amount' => '1'),
			array('id' => '108','idProduct' => '23309','idProductingredient' => '23305','idCategory' => '0','amount' => '1'),
			array('id' => '110','idProduct' => '23324','idProductingredient' => '7248','idCategory' => '0','amount' => '1'),
			array('id' => '111','idProduct' => '23328','idProductingredient' => '23327','idCategory' => '0','amount' => '3'),
			array('id' => '112','idProduct' => '23329','idProductingredient' => '16850','idCategory' => '0','amount' => '1'),
			array('id' => '113','idProduct' => '23330','idProductingredient' => '16848','idCategory' => '0','amount' => '1'),
			array('id' => '114','idProduct' => '23331','idProductingredient' => '17624','idCategory' => '0','amount' => '1'),
			array('id' => '115','idProduct' => '23332','idProductingredient' => '17625','idCategory' => '0','amount' => '1'),
			array('id' => '116','idProduct' => '23333','idProductingredient' => '18021','idCategory' => '0','amount' => '1'),
			array('id' => '117','idProduct' => '23334','idProductingredient' => '19605','idCategory' => '0','amount' => '1'),
			array('id' => '118','idProduct' => '23335','idProductingredient' => '19606','idCategory' => '0','amount' => '1'),
			array('id' => '119','idProduct' => '23336','idProductingredient' => '19609','idCategory' => '0','amount' => '1'),
			array('id' => '120','idProduct' => '23337','idProductingredient' => '19548','idCategory' => '0','amount' => '1'),
			array('id' => '121','idProduct' => '23395','idProductingredient' => '23394','idCategory' => '0','amount' => '4'),
			array('id' => '122','idProduct' => '23569','idProductingredient' => '23045','idCategory' => '0','amount' => '2'),
			array('id' => '123','idProduct' => '23705','idProductingredient' => '23650','idCategory' => '0','amount' => '3'),
			array('id' => '125','idProduct' => '24109','idProductingredient' => '24082','idCategory' => '0','amount' => '1'),
			array('id' => '126','idProduct' => '24110','idProductingredient' => '24083','idCategory' => '0','amount' => '1'),
			array('id' => '127','idProduct' => '24111','idProductingredient' => '24084','idCategory' => '0','amount' => '1'),
			array('id' => '128','idProduct' => '24112','idProductingredient' => '24085','idCategory' => '0','amount' => '1'),
			array('id' => '129','idProduct' => '24113','idProductingredient' => '24086','idCategory' => '0','amount' => '1'),
			array('id' => '130','idProduct' => '24115','idProductingredient' => '24088','idCategory' => '0','amount' => '1'),
			array('id' => '131','idProduct' => '24116','idProductingredient' => '24089','idCategory' => '0','amount' => '1'),
			array('id' => '132','idProduct' => '24117','idProductingredient' => '24090','idCategory' => '0','amount' => '1'),
			array('id' => '133','idProduct' => '24119','idProductingredient' => '24079','idCategory' => '0','amount' => '1'),
			array('id' => '134','idProduct' => '24120','idProductingredient' => '24081','idCategory' => '0','amount' => '1'),
			array('id' => '135','idProduct' => '24121','idProductingredient' => '24082','idCategory' => '0','amount' => '1'),
			array('id' => '136','idProduct' => '24122','idProductingredient' => '24083','idCategory' => '0','amount' => '1'),
			array('id' => '137','idProduct' => '24123','idProductingredient' => '24084','idCategory' => '0','amount' => '1'),
			array('id' => '138','idProduct' => '24124','idProductingredient' => '24085','idCategory' => '0','amount' => '1'),
			array('id' => '139','idProduct' => '24125','idProductingredient' => '24086','idCategory' => '0','amount' => '1'),
			array('id' => '140','idProduct' => '24126','idProductingredient' => '24087','idCategory' => '0','amount' => '1'),
			array('id' => '141','idProduct' => '24127','idProductingredient' => '24088','idCategory' => '0','amount' => '1'),
			array('id' => '142','idProduct' => '24128','idProductingredient' => '24089','idCategory' => '0','amount' => '1'),
			array('id' => '143','idProduct' => '24129','idProductingredient' => '24090','idCategory' => '0','amount' => '1'),
			array('id' => '144','idProduct' => '24118','idProductingredient' => '24091','idCategory' => '0','amount' => '1'),
			array('id' => '145','idProduct' => '24130','idProductingredient' => '24091','idCategory' => '0','amount' => '1'),
			array('id' => '146','idProduct' => '24107','idProductingredient' => '24079','idCategory' => '0','amount' => '1'),
			array('id' => '147','idProduct' => '24108','idProductingredient' => '24081','idCategory' => '0','amount' => '1'),
			array('id' => '148','idProduct' => '24114','idProductingredient' => '24087','idCategory' => '0','amount' => '1'),
			array('id' => '149','idProduct' => '23165','idProductingredient' => '19179','idCategory' => '0','amount' => '3'),
			array('id' => '150','idProduct' => '24315','idProductingredient' => '24249','idCategory' => '0','amount' => '1'),
			array('id' => '151','idProduct' => '24343','idProductingredient' => '24250','idCategory' => '0','amount' => '3'),
			array('id' => '152','idProduct' => '24348','idProductingredient' => '23394','idCategory' => '0','amount' => '1'),
			array('id' => '153','idProduct' => '24703','idProductingredient' => '24702','idCategory' => '0','amount' => '3'),
			array('id' => '154','idProduct' => '24729','idProductingredient' => '24702','idCategory' => '0','amount' => '1'),
			array('id' => '155','idProduct' => '25072','idProductingredient' => '25064','idCategory' => '0','amount' => '1'),
			array('id' => '156','idProduct' => '25071','idProductingredient' => '25064','idCategory' => '0','amount' => '1'),
			array('id' => '157','idProduct' => '25066','idProductingredient' => '24082','idCategory' => '0','amount' => '1'),
			array('id' => '158','idProduct' => '25070','idProductingredient' => '24082','idCategory' => '0','amount' => '1'),
			array('id' => '159','idProduct' => '25069','idProductingredient' => '24081','idCategory' => '0','amount' => '1'),
			array('id' => '160','idProduct' => '25068','idProductingredient' => '24083','idCategory' => '0','amount' => '1'),
			array('id' => '161','idProduct' => '25065','idProductingredient' => '24081','idCategory' => '0','amount' => '1'),
			array('id' => '162','idProduct' => '25067','idProductingredient' => '24083','idCategory' => '0','amount' => '1'),
			array('id' => '165','idProduct' => '25156','idProductingredient' => '25155','idCategory' => '0','amount' => '1'),
			array('id' => '166','idProduct' => '25230','idProductingredient' => '25231','idCategory' => '0','amount' => '1'),
			array('id' => '167','idProduct' => '25230','idProductingredient' => '25232','idCategory' => '0','amount' => '1'),
			array('id' => '168','idProduct' => '25230','idProductingredient' => '25233','idCategory' => '0','amount' => '1'),
			array('id' => '169','idProduct' => '25230','idProductingredient' => '25234','idCategory' => '0','amount' => '1'),
			array('id' => '170','idProduct' => '25230','idProductingredient' => '25235','idCategory' => '0','amount' => '1'),
			array('id' => '171','idProduct' => '25230','idProductingredient' => '25236','idCategory' => '0','amount' => '1'),
			array('id' => '172','idProduct' => '25230','idProductingredient' => '25237','idCategory' => '0','amount' => '1'),
			array('id' => '173','idProduct' => '16378','idProductingredient' => '16334','idCategory' => '0','amount' => '1'),
			array('id' => '174','idProduct' => '16378','idProductingredient' => '16337','idCategory' => '0','amount' => '1'),
			array('id' => '175','idProduct' => '16379','idProductingredient' => '16335','idCategory' => '0','amount' => '1'),
			array('id' => '176','idProduct' => '16379','idProductingredient' => '16337','idCategory' => '0','amount' => '1'),
			array('id' => '177','idProduct' => '16341','idProductingredient' => '16335','idCategory' => '0','amount' => '1'),
			array('id' => '178','idProduct' => '16341','idProductingredient' => '16338','idCategory' => '0','amount' => '1'),
			array('id' => '179','idProduct' => '16340','idProductingredient' => '16334','idCategory' => '0','amount' => '1'),
			array('id' => '180','idProduct' => '16340','idProductingredient' => '16338','idCategory' => '0','amount' => '1'),
			array('id' => '181','idProduct' => '16339','idProductingredient' => '16333','idCategory' => '0','amount' => '1'),
			array('id' => '182','idProduct' => '16339','idProductingredient' => '16338','idCategory' => '0','amount' => '1'),
			array('id' => '183','idProduct' => '25340','idProductingredient' => '23394','idCategory' => '0','amount' => '1'),
			array('id' => '184','idProduct' => '25341','idProductingredient' => '23394','idCategory' => '0','amount' => '1'),
			array('id' => '185','idProduct' => '25389','idProductingredient' => '25382','idCategory' => '0','amount' => '1'),
			array('id' => '186','idProduct' => '25389','idProductingredient' => '25383','idCategory' => '0','amount' => '1'),
			array('id' => '187','idProduct' => '25101','idProductingredient' => '21016','idCategory' => '0','amount' => '2'),
			array('id' => '188','idProduct' => '14515','idProductingredient' => '6732','idCategory' => '0','amount' => '2'),
			array('id' => '189','idProduct' => '21781','idProductingredient' => '21595','idCategory' => '0','amount' => '2'),
			array('id' => '190','idProduct' => '25682','idProductingredient' => '24720','idCategory' => '0','amount' => '1'),
			array('id' => '191','idProduct' => '25682','idProductingredient' => '25296','idCategory' => '0','amount' => '1'),
			array('id' => '192','idProduct' => '25089','idProductingredient' => '21364','idCategory' => '0','amount' => '1'),
			array('id' => '193','idProduct' => '25089','idProductingredient' => '24193','idCategory' => '0','amount' => '1'),
			array('id' => '194','idProduct' => '25089','idProductingredient' => '25088','idCategory' => '0','amount' => '1'),
			array('id' => '195','idProduct' => '25089','idProductingredient' => '25061','idCategory' => '0','amount' => '1'),
			array('id' => '196','idProduct' => '25089','idProductingredient' => '22156','idCategory' => '0','amount' => '1'),
			array('id' => '199','idProduct' => '1404','idProductingredient' => '1403','idCategory' => '0','amount' => '1'),
			array('id' => '200','idProduct' => '1404','idProductingredient' => '1398','idCategory' => '0','amount' => '1'),
			array('id' => '209','idProduct' => '25102','idProductingredient' => '22157','idCategory' => '0','amount' => '1'),
			array('id' => '210','idProduct' => '25102','idProductingredient' => '25061','idCategory' => '0','amount' => '1'),
			array('id' => '211','idProduct' => '25102','idProductingredient' => '21364','idCategory' => '0','amount' => '1'),
			array('id' => '212','idProduct' => '25102','idProductingredient' => '24193','idCategory' => '0','amount' => '1'),
			array('id' => '213','idProduct' => '25102','idProductingredient' => '25088','idCategory' => '0','amount' => '1'),
			array('id' => '214','idProduct' => '25103','idProductingredient' => '22158','idCategory' => '0','amount' => '1'),
			array('id' => '215','idProduct' => '25103','idProductingredient' => '25061','idCategory' => '0','amount' => '1'),
			array('id' => '216','idProduct' => '25103','idProductingredient' => '21364','idCategory' => '0','amount' => '1'),
			array('id' => '217','idProduct' => '25103','idProductingredient' => '24193','idCategory' => '0','amount' => '1'),
			array('id' => '218','idProduct' => '25103','idProductingredient' => '25088','idCategory' => '0','amount' => '1'),
			array('id' => '220','idProduct' => '25694','idProductingredient' => '25690','idCategory' => '0','amount' => '2'),
			array('id' => '221','idProduct' => '25693','idProductingredient' => '25689','idCategory' => '0','amount' => '2'),
			array('id' => '222','idProduct' => '9023','idProductingredient' => '21219','idCategory' => '0','amount' => '3'),
			array('id' => '223','idProduct' => '9023','idProductingredient' => '1819','idCategory' => '0','amount' => '2'),
			array('id' => '224','idProduct' => '9023','idProductingredient' => '2175','idCategory' => '0','amount' => '2'),
			array('id' => '225','idProduct' => '9023','idProductingredient' => '21220','idCategory' => '0','amount' => '3'),
			array('id' => '226','idProduct' => '25754','idProductingredient' => '25758','idCategory' => '0','amount' => '1'),
			array('id' => '227','idProduct' => '25754','idProductingredient' => '25759','idCategory' => '0','amount' => '1'),
			array('id' => '228','idProduct' => '25802','idProductingredient' => '25802','idCategory' => '0','amount' => '3'),
			array('id' => '229','idProduct' => '25813','idProductingredient' => '25812','idCategory' => '0','amount' => '4'),
			array('id' => '231','idProduct' => '21592','idProductingredient' => '21363','idCategory' => '0','amount' => '4'),
			array('id' => '238','idProduct' => '25938','idProductingredient' => '25937','idCategory' => '0','amount' => '2'),
			array('id' => '239','idProduct' => '26001','idProductingredient' => '25922','idCategory' => '0','amount' => '1'),
			array('id' => '242','idProduct' => '25106','idProductingredient' => '21616','idCategory' => '0','amount' => '1'),
			array('id' => '243','idProduct' => '25104','idProductingredient' => '21616','idCategory' => '0','amount' => '1'),
			array('id' => '245','idProduct' => '26044','idProductingredient' => '26045','idCategory' => '0','amount' => '2'),
			array('id' => '246','idProduct' => '22276','idProductingredient' => '21616','idCategory' => '0','amount' => '1'),
			array('id' => '247','idProduct' => '26114','idProductingredient' => '26045','idCategory' => '0','amount' => '1'),
			array('id' => '254','idProduct' => '1817','idProductingredient' => '1812','idCategory' => '0','amount' => '2'),
			array('id' => '255','idProduct' => '26168','idProductingredient' => '26099','idCategory' => '0','amount' => '1'),
			array('id' => '262','idProduct' => '7836','idProductingredient' => '17003','idCategory' => '0','amount' => '1'),
			array('id' => '264','idProduct' => '26406','idProductingredient' => '26405','idCategory' => '0','amount' => '1'),
			array('id' => '266','idProduct' => '26001','idProductingredient' => '25359','idCategory' => '0','amount' => '1'),
			array('id' => '268','idProduct' => '24506','idProductingredient' => '1813','idCategory' => '0','amount' => '1'),
			array('id' => '269','idProduct' => '25420','idProductingredient' => '25417','idCategory' => '0','amount' => '2'),
			array('id' => '270','idProduct' => '26678','idProductingredient' => '26609','idCategory' => '0','amount' => '2'),
			array('id' => '271','idProduct' => '25295','idProductingredient' => '20397','idCategory' => '0','amount' => '10'),
			array('id' => '273','idProduct' => '23400','idProductingredient' => '23399','idCategory' => '0','amount' => '1'),
			array('id' => '274','idProduct' => '24506','idProductingredient' => '24198','idCategory' => '0','amount' => '1'),
			array('id' => '275','idProduct' => '26771','idProductingredient' => '26770','idCategory' => '0','amount' => '3')
		);
		
		  
		
		foreach ($table_ingredient as $ingredient){
			$category_id = null;

			if ($ingredient['idCategory'] == 0) {
				$product = Product::find($ingredient['idProductingredient']);
				$category_id = $product->category->id ?? 1;
			}else{
				$category_id = $ingredient['idCategory'];
			}


			if (Product::find($ingredient['idProduct'])->id ?? false) {
				Ingredient::create([
					"product_id" => $ingredient['idProduct'],
					"ingredient_id" => $ingredient['idProductingredient'] == 0 ? null : $ingredient['idProductingredient'],
					"category_id" => $category_id,
					"amount" => $ingredient['amount']
				]);
			}
		
		}
	}
}

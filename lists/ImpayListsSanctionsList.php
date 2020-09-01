<?php



    class ImpayListsSanctionsList extends ImpayLists
    {


        protected function getListAll(){
            if (empty($this->search)){
                $sql = "
                     SELECT `sdn`.*, sc.comment FROM `sdn`
                     LEFT JOIN sdn_comments sc on sdn.ent_num = sc.ent_num          
                     ORDER BY `sdn`.`ent_num` ASC 
                     LIMIT {$this->from_sdn} , 10
                ";
            }else {
                $sql = "(
                     SELECT DISTINCT `sdn`.*, sc.comment FROM `sdn`
                     LEFT JOIN sdn_comments sc on sdn.ent_num = sc.ent_num
                     WHERE {$this->search}
                     )
                     UNION DISTINCT
                     (
                     SELECT DISTINCT  sdn.*, sc.comment FROM `sdn_alt`
                     LEFT JOIN `sdn`  on sdn_alt.ent_num = sdn.ent_num
                     LEFT JOIN sdn_comments sc on sc.ent_num = sdn.ent_num
                     WHERE ( {$this->search_alt} ) 
                     )
                     LIMIT {$this->from_sdn} , 10
                ";
            }


            $data = ImpayListsDb::getDB()->getAllStdClass($sql, $this->antiInjection);


            if (empty($data)){$this->count = 0;return;}

            $ent_num = [];

            foreach ($data as $std)
                $ent_num[] = $std->ent_num;


            $add = $this->getAddAlt('sdn_add', $ent_num);
            $alt = $this->getAddAlt('sdn_alt', $ent_num);

            foreach ($data as &$std_data){
                foreach ($alt as $std_alt)
                    if ($std_data->ent_num === $std_alt->ent_num)
                        $std_data->alt[] = $std_alt;
                foreach ($add as $std_add) {
                    if ($std_data->ent_num === $std_add->ent_num) {
                        if (is_null($std_add->address) and is_null($std_add->address) and is_null($std_add->address) and is_null($std_add->address)) continue;
                        $std_data->add[] = $std_add;
                    }
                }
            }

            $this->data = $data;
        }

        private function getAddAlt($table, array $data){
            return ImpayListsDb::getDB()->getAllStdClass("
                SELECT * FROM `$table` WHERE `ent_num` = ".implode(" OR `ent_num` = ", $data)."
            ");
        }


        protected function count(){
            if (empty($this->search))
                 $this->count = ImpayListsDb::getDB()->queryFetchColumn("SELECT COUNT(*) FROM `sdn`");
            else {
                $this->count = ImpayListsDb::getDB()->queryFetchColumn("
                SELECT COUNT(*) FROM (
                     SELECT DISTINCT `sdn`.*, sc.comment FROM `sdn`
                     LEFT JOIN sdn_comments sc on sdn.ent_num = sc.ent_num
                     WHERE {$this->search}
                     UNION DISTINCT
                     SELECT DISTINCT  sdn.*, sc.comment FROM `sdn_alt`
                     LEFT JOIN `sdn`  on sdn_alt.ent_num = sdn.ent_num
                     LEFT JOIN sdn_comments sc on sc.ent_num = sdn.ent_num
                     WHERE ( {$this->search_alt} ) 
                     ) t
                ", $this->antiInjection);
            }

        }


        protected function search(){
            $search = filter_var(trim($_POST['search']),FILTER_SANITIZE_STRING);
            $search_array = preg_split("/[\s,-]+/", $search);
            if (!is_array($search_array)) return;
            $i = 1;
            foreach ($search_array as $str) {
                $str = strtoupper(preg_replace("/[^\p{L}]/u","", $str));
                $this->search .= " LOWER(`sdn`.`sdn_name`) LIKE :str$i OR ";
                $this->search_alt .= " LOWER(`sdn_alt`.`alt_name`) LIKE :str$i OR ";
                $this->antiInjection[":str$i"] = "%$str%";
                $i++;
            }
            $this->search = substr($this->search, 0 , -3);
            $this->search_alt = substr($this->search_alt, 0 , -3);
        }


    }
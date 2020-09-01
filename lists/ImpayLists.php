<?php





	abstract class ImpayLists {

		protected $data = [];
		protected $from_sdn = 0;
		protected $until_sdn = 10;
		protected $count;
		protected $search = '';
		protected $search_alt = '';
		protected $antiInjection = [];


        public function __construct()
        {
            $this->getPost();
            $this->count();
            $this->getListAll();
        }


		public function getData()
		{
			return $this->data;
		}

		public function getFrom()
		{
			return $this->from_sdn;
		}

		public function getUntil()
		{
			return $this->until_sdn;
		}

		public function getCount()
		{
			return $this->count;
		}

		abstract protected function search();
        abstract protected function getListAll();
        abstract protected function count();


		protected function getPost(){
			if (!empty($_POST['search'])){
				$this->search();
			}if (!empty($_POST['until'])){
				$until_sdn = (int)filter_var(($_POST['until']), FILTER_SANITIZE_NUMBER_INT);
				$this->until_sdn = $until_sdn + 10;
				$this->from_sdn = $until_sdn;
			}elseif (!empty($_POST['from'])){
				$from_sdn = (int)filter_var(($_POST['from']), FILTER_SANITIZE_NUMBER_INT);
				$this->until_sdn = $from_sdn;
				$this->from_sdn = $from_sdn - 10;
			}
		}


	}
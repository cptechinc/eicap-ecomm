<?php 
	class Family {
        use ThrowErrorTrait;
		use MagicMethodTraits;
		use CreateFromObjectArrayTraits;
		use CreateClassArrayTraits;
        
		protected $famID;
		protected $name1;
		protected $name2;
		protected $name3;
		protected $longdesc;
		protected $image;
		protected $speca;
		protected $specb;
		protected $specc;
		protected $specd;
		protected $spece;
		protected $specf;
		protected $specg;
		protected $spech;
		protected $shortdesc;
		protected $catid;
		protected $tview;
		protected $ftype;
		protected $recno;
		protected $schempic;
		protected $width;
		protected $height;
		protected $name4;
		protected $name5;
		protected $dummy;
        
		/**
		 * Imports a family record from the database and makes a page in Processwire
		 * @param  string $parentcode Code to be parsed for parent page
		 * @return bool               Was Family Created / Updated
		 */
        public function import_family($parentcode = '') {
            
        }
	}

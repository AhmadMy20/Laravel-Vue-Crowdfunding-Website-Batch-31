<?php 
    trait Hewan 
    {
        public $nama;
        public $darah = 50;
        public $jumlahKaki;
        public $keahlian;

        public function atraksi() {
            echo "$this->nama sedang $this->keahlian";
        }
    }
      
    trait Fight 
    {
        public $attackPower;
        public $defencePower;

        public function serang($serang) 
        {
            self::diserang($serang);
            echo "$serang->nama sedang menyerang $this->nama";
        }

        public function diserang($diserang)
        {
            return $this->darah = $this->darah - ($diserang->attackPower / $this->deffencePower);
            
        }

    }



      class Harimau 
      {
        use Hewan, Fight;

        public function __construct()
        {
            $this->nama = "Harimau";
            $this->darah;
            $this->jumlahKaki = 4;
            $this->keahlian = "lari cepat";
            $this->attackPower = 7;
            $this->deffencePower  = 8;
        }

        public function getInfoHewan()
        {
            echo "Jenis Hewan = " . $this->nama . PHP_EOL;
            echo "Darah = " . $this->darah . PHP_EOL;
            echo "Jumlah Kaki = " . $this->jumlahKaki . PHP_EOL;
            echo "Keahlian = " . $this->keahlian . PHP_EOL;
            echo "attackPower = " . $this->attackPower . PHP_EOL;
            echo "deffencePower = " . $this->deffencePower;
        }
        
      }

      class Elang 
      {
        use Hewan, Fight;

        public function __construct()
        {
            $this->nama = "Elang";
            $this->darah;
            $this->jumlahKaki = 2;
            $this->keahlian = "Terbang Tinggi";
            $this->attackPower = 10;
            $this->deffencePower  = 5;
        }

        public function getInfoHewan()
        {
            echo "Jenis Hewan = " . $this->nama . PHP_EOL;
            echo "Darah = " . $this->darah . PHP_EOL;
            echo "Jumlah Kaki = " . $this->jumlahKaki . PHP_EOL;
            echo "Keahlian = " . $this->keahlian . PHP_EOL;
            echo "attackPower = " . $this->attackPower . PHP_EOL;
            echo "deffencePower = " . $this->deffencePower;
        }
        
      }


      $elang = new Elang();
      $harimau = new Harimau();

      echo PHP_EOL; 
      $harimau->serang($elang);
      echo PHP_EOL;
      $harimau->atraksi();
      echo PHP_EOL; 
      $harimau->getInfoHewan();

      echo PHP_EOL . PHP_EOL;
      echo "=========================================";
      echo PHP_EOL . PHP_EOL;

      $elang->serang($harimau);
      echo PHP_EOL; 
      $elang->atraksi();
      echo PHP_EOL; 
      $elang->getInfoHewan();
      echo PHP_EOL; 

?>
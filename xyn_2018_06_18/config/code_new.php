<?php
    include_once "db_configa.php";
    include_once "get_time.php";
    class code_new{
        private $get_time;
        private $connect;
        private $conn;

        function __construct(){
		    $this -> get_time=new get_time();
		    $this -> connect = new connect();
		    $this -> conn = $this -> connect -> connect_bdb();
	    }

        public function bill_code_new($type){
                $code=$type.'-'.$this ->get_time -> get_now_format_d().'-';
                $sql = "select max(right(bill_code,5)) from t_bill where bill_code like '$code%'";
                $rs=$this -> conn -> query($sql);
                $row=$rs -> fetch_row();
                if($row[0]){
                    $new_num=intval($row[0])+1;
                    $len=strlen(strval($new_num));
                    $bu_0='';
                    for($i=0;$i<(5-$len);$i++){
                        $bu_0.='0';
                    };
                    return $code.$bu_0.strval($new_num);
                }else{
                    return $code.'00001';
                };
        }
    }
    unset ($connect);
    unset ($get_time);
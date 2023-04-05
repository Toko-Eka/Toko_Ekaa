<?php
class TransaksiBeliModel extends CI_Model
{
	

    var $table = 'dbo.xTransak';
      var $column_order = array('tr.NOTA','TOTAL','JMLBRG'); //set column field database for datatable orderable
     var $column_search = array('tr.NOTA','tr.KODETRN','tr.PAID','tr.KASIR'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('tr.NOTA' => 'desc'); // default order 
   
    var $tableDet = 'dbo.xTransakDetil';
    var $tableDetToday = 'dbo.TransakDetil';
    var $column_orderDet = array('MIN(det.NOTA)','det.KDBRG','MIN(det.NAMABRG)','MIN(det.KDSUP)','SUM(det.JMLBRG)','SUM(det.HARGA)','SUM(det.TOTAL)','MIN(tr.TGL)'); //set column field database for datatable orderable
    var $orderDet = array('MIN(det.KDSUP)' => 'asc'); // default order 
    var $column_searchDet = array('det.NOTA','det.TGL','det.NAMABRG','det.KDSUP'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
        if($this->input->post('min')){
         
            
            $this->db->where('tr.TGL >=', $this->input->post('min'));
            $this->db->where('tr.TGL <=', $this->input->post('max'));
            
        }
        if($this->input->post('PAID'))
        {
            $this->db->where('PAID', $this->input->post('tr.PAID'));
        }
        if ($this->input->post('NOTA')) {
            $this->db->like('tr.NOTA', $this->input->post('NOTA'), 'both');
        }
 $this->db->select('tr.NOTA')

 ->select_min('tr.TGL')
 ->select_min('(tr.PAID+0)','PAID')
 ->select_min('tr.KODETRN')
 ->select_min('tr.KASIR')
        ->select_sum('det.JMLBRG')
        ->select('SUM(det.HBT * det.JMLBRG) AS TOTAL')
   
        ->from('xTransak as tr')
        ->join('xTransakDetil as det', 'tr.NOTA = det.NOTA', 'inner')
        ->where('tr.KODETRN','B')
        ->where('det.FLAG is NULL', NULL, FALSE)
        ->group_by('tr.NOTA');
 

//  $query = $this->db->get();
//     //    $query= $this->db->query(' SELECT MIN(tr.TGL) as TGLL, tr.NOTA,SUM(det.JMLBRG) as TotalQTY, SUM(det.TOTAL) as Total FROM Transak as tr  LEFT JOIN TransakDetil as det ON tr.NOTA = det.NOTA GROUP BY tr.NOTA ORDER BY tr.NOTA;');
//        return $query->result_array();


 
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function getMaster($id){
        $query = "
      SELECT * FROM xTransak WHERE NOTA =$id
        ";
        return $this->db->query($query)->result();
    }
    function getDetailn($id){
        $query = "
        SELECT * FROM xTransakDetil WHERE NOTA =$id
          ";
          return $this->db->query($query)->result();
    }
 function sum(){
    $this->db->select('tr.NOTA');

   
    $this->db->select_sum('det.JMLBRG');
    $this->db->select_sum('det.TOTAL');
      
    $this->db ->from('xTransak as tr');
    $this->db->join('xTransakDetil as det', 'tr.NOTA = det.NOTA', 'inner');
    $this->db->where('tr.KODETRN','B');
    $this->db->where('det.FLAG is NULL', NULL, FALSE);
    $this->db->group_by('tr.NOTA');
    
    // $this->db->get();
           
      
        $query = $this->db->get();  
       return $query->result();
 
        // $sum = array();
        // foreach ($result as $row) 
        // {
        //     $sum[] = $row->JMLBRG;
        //     $sum[] = $row->TOTAL;
        // }
        // return $sum;
 }
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
 
    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('NOTA',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
    public function save($data)
    {
        $this->db->insert('TrPO', $data);
      
    }
    public function delete_by_id($id)
    {
        $this->db->where('NOTA', $id);
        $this->db->delete($this->table);
    }
    public function getStatPaid()
    {
        $this->db->select('PAID');
        $this->db->from($this->table);
        $this->db->order_by('PAID','asc');
        $query = $this->db->get();
        $result = $query->result();
 
        $paid = array();
        foreach ($result as $row) 
        {
            $paid[] = $row->PAID;
        }
        return $paid;
    }
 
    public function getTransJualDetil($id)
	{
		$query = "
		SELECT * FROM xTransakDetil  WHERE NOTA='$id'  ORDER BY NOTA ASC
		";

		return $this->db->query($query)->result();
	}
    public function getDetail($tgl_awal, $tgl_akhir){
        $query = "
		SELECT * FROM xTransak INNER JOIN xTransakDetil ON xTransak.NOTA=xTransakDetil.NOTA WHERE xTransak.TGL BETWEEN '$tgl_awal' AND '$tgl_akhir'AND det.FLAG IS NULL ORDER BY xTransak.NOTA ASC
		";
        return $this->db->query($query)->result();
        // $tgl_awal = $this->db->escape($tgl_awal);
    }
    public function view_by_date($tgl_awal, $tgl_akhir,$notaaa){
        $query = "
		SELECT MIN(tr.KODETRN) as trn, MIN(tr.TGL) AS tgll, MIN(tr.NOTA) AS notaa, MIN(tr.PAID+0) as paidd, MIN(tr.KASIR) as kasirr, SUM(det.JMLBRG) as qty, SUM(det.HBT * det.JMLBRG) as subtotal FROM xTransak as tr RIGHT JOIN xTransakDetil as det ON tr.NOTA=det.NOTA WHERE tr.TGL BETWEEN '$tgl_awal' AND '$tgl_akhir' AND tr.KODETRN= 'B' AND tr.NOTA LIKE '%$notaaa%' AND det.FLAG IS NULL GROUP BY tr.NOTA 
		";
        return $this->db->query($query)->result();
   }
   //DETAIL
   private function _get_datatables_queryDet($master,$detil)
   {
       if($this->input->post('min')){
        
     $awal = $this->input->post('min');
     $akhir = $this->input->post('max');
     $a="'$awal'";
     $b="'$akhir'";
           $this->db->where('tr.TGL BETWEEN '.$a.' AND '.$b);
     
           
       }
       if($this->input->post('KDSUP'))
        {
            $this->db->where('KDSUP', $this->input->post('KDSUP'));
        }
        if($this->input->post('NAMABRG'))
        {
            $this->db->like('NAMABRG', $this->input->post('NAMABRG'), 'both'); 
        }
        $this->db->select_sum('JMLBRG','JMLBRG')
        ->select_sum('TOTAL','TOTAL')
        ->select_sum('HARGA','HARGA')
        ->select_min('det.NOTA','NOTA')
        ->select('KDBRG')
               ->select_min('tr.TGL','TGLL')
        ->select_min('NAMABRG','NAMABRG')
                ->select_min('KDSUP','KDSUP')
                        ->select_min('KODETRN','KODETRN')
        ->from($detil.' as det')
        ->join($master.' as tr', 'tr.NOTA = det.NOTA', 'inner')
        ->where('det.FLAG is NULL', NULL, FALSE)

        ->where('tr.KODETRN', 'B')
        ->group_by('KDBRG');


//  $query = $this->db->get();
//     //    $query= $this->db->query(' SELECT MIN(tr.TGL) as TGLL, tr.NOTA,SUM(det.JMLBRG) as TotalQTY, SUM(det.TOTAL) as Total FROM Transak as tr  LEFT JOIN TransakDetil as det ON tr.NOTA = det.NOTA GROUP BY tr.NOTA ORDER BY tr.NOTA;');
//        return $query->result_array();



       $i = 0;
    
       foreach ($this->column_searchDet as $item) // loop column 
       {
           if($_POST['search']['value']) // if datatable send POST for search
           {
                
               if($i===0) // first loop
               {
                   $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                   $this->db->like($item, $_POST['search']['value']);
               }
               else
               {
                   $this->db->or_like($item, $_POST['search']['value']);
               }

               if(count($this->column_searchDet) - 1 == $i) //last loop
                   $this->db->group_end(); //close bracket
           }
           $i++;
       }
        
       if(isset($_POST['order'])) // here order processing
       {
           $this->db->order_by($this->column_orderDet[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
       } 
       else if(isset($this->orderDet))
       {
           $orderDet = $this->orderDet;
           $this->db->order_by(key($orderDet), $orderDet[key($orderDet)]);
       }
   }

   function get_datatablesDet($master,$detil)
   {
       $this->_get_datatables_queryDet($master,$detil);
       if($_POST['length'] != -1)
       $this->db->limit($_POST['length'], $_POST['start']);
       $query = $this->db->get();
       return $query->result();
   }

   function count_filteredDet($master,$detil)
   {
       $this->_get_datatables_queryDet($master,$detil);
       $query = $this->db->get();
       return $query->num_rows();
   }

   public function count_allDet($master,$detil)
   {
       $this->db->from($this->tableDet);
       return $this->db->count_all_results();
   }

   public function get_by_idDet($id)
   {
       $this->db->from($this->table);
       $this->db->where('NOTA',$id);
       $query = $this->db->get();

       return $query->row();
   }
   public function fetchSumMaster($tgl_awal, $tgl_akhir, $notaa)
   {
    $this->db->select('tr.NOTA')

    ->select_min('tr.TGL')
    ->select_min('(tr.PAID+0)','PAID')
    ->select_min('tr.KODETRN')
    ->select_min('tr.KASIR')
           ->select_sum('det.JMLBRG')
           ->select('SUM(det.HBT * det.JMLBRG) AS TOTAL')
      
           ->from('xTransak as tr')
           ->join('xTransakDetil as det', 'tr.NOTA = det.NOTA', 'inner')
           ->where('tr.KODETRN','B')
        
           ->like('tr.NOTA', $notaa, 'both')

           ->where('tr.TGL >=', $tgl_awal)
           ->where('tr.TGL <=', $tgl_akhir)
           ->where('det.FLAG is NULL', NULL, FALSE)
           ->group_by('tr.NOTA');
           $res = $this->db->get();
       if ($res->num_rows() > 0) {
           $sumqty = 0;
           $sum = 0;
           foreach ($res->result() as $data) {
               $hasil = array(


                   $sum += $data->TOTAL,
                   $sumqty += $data->JMLBRG,
                   'GRANDTOTAL' => $sum,
                   'JML' => $sumqty
               );
           }
       }
       return $hasil;
   }
   public function fetchSum($tgl_awal, $tgl_akhir,$kdsupp,$brg,$master,$detil){
 
    
    $query=$this->db->query("SELECT SUM(det.TOTAL) as TOTAL,SUM(det.JMLBRG) AS JML FROM $detil as det INNER JOIN $master as tr ON tr.NOTA = det.NOTA WHERE det.FLAG IS NULL AND tr.KODETRN='B' AND det.KDSUP ='$kdsupp'AND det.NAMABRG LIKE '%$brg%'  AND tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY det.NOTA;");
 
    if($query->num_rows()>0){
        $sum=0;
        $sumqty=0;
        foreach ($query->result() as $data) {
            $hasil=array(
             
          
                $sum+= $data->TOTAL,
                $sumqty+= $data->JML,
                'GRANDTOTAL' => $sum,
                'JML' => $sumqty
                );
        }
    }
    return $hasil;
}
public function fetchSumWOBoth($tgl_awal, $tgl_akhir,$master,$detil){
 
    
    $query=$this->db->query(" SELECT SUM(det.TOTAL) as TOTAL,SUM(det.JMLBRG) AS JML FROM $detil as det INNER JOIN $master as tr ON tr.NOTA = det.NOTA WHERE det.FLAG IS NULL AND tr.KODETRN='B' AND tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir'   GROUP BY det.NOTA;
    ");
 
    if($query->num_rows()>0){
        $sum=0;
        $sumqty=0;
        foreach ($query->result() as $data) {
            $hasil=array(
             
          
                $sum+= $data->TOTAL,
                $sumqty+= $data->JML,
                'GRANDTOTAL' => $sum,
                'JML' => $sumqty
                );
        }
    }
    return $hasil;
}
public function fetchSumWOBrg($tgl_awal, $tgl_akhir,$supp,$master,$detil){
 
    $query=$this->db->query("SELECT SUM(det.TOTAL) as TOTAL,SUM(det.JMLBRG) AS JML FROM $detil as det INNER JOIN $master as tr ON tr.NOTA = det.NOTA WHERE det.FLAG IS NULL AND tr.KODETRN='B' AND det.KDSUP ='$supp'  AND tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY det.NOTA;");
  
    if($query->num_rows()>0){
        $sum=0;
        $sumqty=0;
        foreach ($query->result() as $data) {
            $hasil=array(
             
                $sum+= $data->TOTAL,
                $sumqty+= $data->JML,
                'GRANDTOTAL' => $sum,
                'JML' => $sumqty
                );
        }
    }
    return $hasil;

}
public function fetchSumWoSupp($tgl_awal, $tgl_akhir,$brg,$master,$detil){
 
    
    $query=$this->db->query("SELECT SUM(det.TOTAL) as TOTAL,SUM(det.JMLBRG) AS JML FROM $detil as det INNER JOIN $master as tr ON tr.NOTA = det.NOTA WHERE det.FLAG IS NULL AND tr.KODETRN='B' AND det.NAMABRG LIKE '%$brg%' ESCAPE '!'AND tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY det.NOTA;");
  
    if($query->num_rows()>0){
        $sum=0;
        $sumqty=0;
        foreach ($query->result() as $data) {
            $hasil=array(
             
                $sum+= $data->TOTAL,
                $sumqty+= $data->JML,
                'GRANDTOTAL' => $sum,
                'JML' => $sumqty
                );
        }
    }
    return $hasil;
}
public function view_by_dateDetWithBrg($tgl_awal, $tgl_akhir,$brg,$master,$detil){
    $query = "
    SELECT SUM(JMLBRG) AS JMLBRG ,SUM(TOTAL) AS TOTAL, SUM(HARGA) AS HARGA, MIN(det.NOTA) AS NOTA,KDBRG,MIN(NAMABRG) AS NAMABRG, MIN(KDSUP) AS KDSUP,MIN(tr.KODETRN) AS KODETRN  FROM $detil AS det INNER JOIN $master as tr ON tr.NOTA = det.NOTA WHERE det.NAMABRG LIKE '%$brg%' AND tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'B'  AND det.FLAG IS NULL GROUP BY det.KDBRG ORDER BY MIN(det.KDSUP);
    ";
    return $this->db->query($query)->result();
}
public function view_by_dateDetWithSupp($tgl_awal, $tgl_akhir,$supp,$master,$detil){
    $query = "
    SELECT SUM(JMLBRG) AS JMLBRG ,SUM(TOTAL) AS TOTAL, SUM(HARGA) AS HARGA, MIN(det.NOTA) AS NOTA,KDBRG,MIN(NAMABRG) AS NAMABRG, MIN(KDSUP) AS KDSUP,MIN(tr.KODETRN) AS KODETRN  FROM $detil AS det INNER JOIN $master as tr ON tr.NOTA = det.NOTA WHERE det.KDSUP ='$supp' AND tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'B' AND det.FLAG IS NULL GROUP BY det.KDBRG ORDER BY MIN(det.KDSUP);
    ";
    return $this->db->query($query)->result();
}

public function view_by_dateDetWithOutBoth($tgl_awal, $tgl_akhir,$master,$detil){
    $query = "
    SELECT SUM(JMLBRG) AS JMLBRG ,SUM(TOTAL) AS TOTAL, SUM(HARGA) AS HARGA, MIN(det.NOTA) AS NOTA,KDBRG,MIN(NAMABRG) AS NAMABRG, MIN(KDSUP) AS KDSUP,MIN(tr.KODETRN) AS KODETRN  FROM $detil AS det INNER JOIN $master as tr ON tr.NOTA = det.NOTA WHERE tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'B'  AND det.FLAG IS NULL GROUP BY det.KDBRG ORDER BY MIN(det.KDSUP);
    ";
// var_dump($query);die;
    return $this->db->query($query)->result();
}
  public function view_by_dateDet($tgl_awal, $tgl_akhir,$supp,$brg,$master,$detil){
  
      $query = "
      SELECT    SELECT SUM(JMLBRG) AS JMLBRG ,SUM(TOTAL) AS TOTAL, SUM(HARGA) AS HARGA, MIN(det.NOTA) AS NOTA,KDBRG,MIN(NAMABRG) AS NAMABRG, MIN(KDSUP) AS KDSUP,MIN(tr.KODETRN) AS KODETRN  FROM $detil AS det INNER JOIN $master as tr ON tr.NOTA = det.NOTA WHERE det.KDSUP ='$supp' AND det.NAMABRG LIKE'%$brg%' AND tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'B'  AND det.FLAG IS NULL GROUP BY det.KDBRG ORDER BY MIN(det.KDSUP);
      ";
    // }
      return $this->db->query($query)->result();
 
  }
public function getBrg()
{
    $this->db->select('NAMABRG');
    $this->db->from($this->tableDet);
    $this->db->order_by('NAMABRG','asc');
    $query = $this->db->get();
    $result = $query->result();

    $brg = array();
    foreach ($result as $row) 
    {
        $brg[] = $row->NAMABRG;
    }
    return $brg;
}

function getAll($id)
{
   
     
             
         
             $this->db->select('*')
       ->from('MASTER')
          ->where_in('KDBRG',$id);
          $query = $this->db->get();
    
          $result = $query->result();
   
          $paid = array();
          foreach ($result as $row) 
          {
              $paid[] = $row->KDBRG;
              $paid[] = $row->NAMABRG;
              $paid[] = $row->HET;
              $paid[] = $row->HBT;
              $paid[] = round((float)$row->RLABA * 1 ) . '%';
              $paid[] =$row->RLABA;
          }
        
          return $paid;
       echo json_encode($paid);
      

      
            
            

     
        
 
}

function generateNota($stat){
    $cd = $this->db->query("SELECT MAX(flag2) as flag  FROM TrPO ");
    $kd = "";
    if($cd->num_rows()>0){
        foreach($cd->result() as $k){
            
            $kd = ((int)$k->flag)+1;
          
        }
    }else{
        $kd = "1";
    }


$d =  $kd;
return $d;
  
}
function generateCode($stat){
    $cd = $this->db->query("SELECT MAX(nopo) as flag  FROM TrPO ");
    $kd = "";
    if($cd->num_rows()>0){
        foreach($cd->result() as $k){
            
            $kd = ((int)$k->flag)+1;
          
        }
    }else{
        $kd = "1";
    }


$d =  $kd;
return $d;
  
}
// public function save_batchPO($data2){
//     return $this->db->insert_batch('Trpodetil', $data2);
//   }
}
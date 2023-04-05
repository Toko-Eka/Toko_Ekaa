<?php
class TransaksiBeliModel extends CI_Model
{
	

    var $table = 'dbo.Transak';
      var $column_order = array('tr.NOTA','TOTAL','JMLBRG'); //set column field database for datatable orderable
     var $column_search = array('tr.NOTA','tr.KODETRN','tr.PAID','tr.KASIR'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('tr.NOTA' => 'desc'); // default order 
   
    var $tableDet = 'dbo.TransakDetil';
    var $column_orderDet = array('det.NOTA','det.KDBRG','det.NAMABRG','det.KDSUP','det.JMLBRG','det.HARGA','det.TOTAL','det.TGL'); //set column field database for datatable orderable
    var $orderDet = array('det.NOTA' => 'desc'); // default order 
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
    
 $this->db->select('tr.NOTA')

 ->select_min('tr.TGL')
 ->select_min('tr.PAID')
 ->select_min('tr.KODETRN')
 ->select_min('tr.KASIR')
        ->select_sum('det.JMLBRG')
        ->select_sum('det.TOTAL')
   
        ->from('Transak as tr')
        ->join('TransakDetil as det', 'tr.NOTA = det.NOTA', 'inner')
        ->where('tr.KODETRN','B')
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
        $this->db->insert($this->table, $data);
      
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
		SELECT * FROM TransakDetil  WHERE NOTA='$id'  ORDER BY NOTA ASC
		";

		return $this->db->query($query)->result();
	}
    public function getDetail($tgl_awal, $tgl_akhir){
        $query = "
		SELECT * FROM Transak INNER JOIN TransakDetil ON Transak.NOTA=TransakDetil.NOTA WHERE Transak.TGL BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY Transak.NOTA ASC
		";
        return $this->db->query($query)->result();
        // $tgl_awal = $this->db->escape($tgl_awal);
    }
    public function getDataMast($tgl_awal, $tgl_akhir){
     
        $query = "
		SELECT MIN(tr.KODETRN) as trn, MIN(tr.TGL) AS tgll, MIN(tr.NOTA) AS notaa, MIN(tr.PAID) as paidd, MIN(tr.KASIR) as kasirr, SUM(det.JMLBRG) as qty, SUM(det.TOTAL) as subtotal FROM Transak as tr RIGHT JOIN TransakDetil as det ON tr.NOTA=det.NOTA WHERE tr.TGL BETWEEN '$tgl_awal' AND '$tgl_akhir' AND tr.KODETRN= 'B' GROUP BY tr.NOTA 
		";
        return $this->db->query($query)->result();
    //     $tgl_awal = $this->db->escape($tgl_awal);
    //     $tgl_akhir = $this->db->escape($tgl_akhir);
    //     $this->db->where('TGL BETWEEN '.$tgl_awal.' AND '.$tgl_akhir); // Tambahkan where tanggal nya
    // return $this->db->get('dbo.Transak')->result();// Tampilkan data transaksi sesuai tanggal yang diinput oleh user pada filter
   }
   public function getDataDet($tgl_awal, $tgl_akhir){
     
    $query = "
    SELECT * FROM Transak RIGHT JOIN TransakDetil ON Transak.NOTA=TransakDetil.NOTA WHERE Transak.TGL BETWEEN '$tgl_awal' AND '$tgl_akhir' AND KODETRN= 'B' ORDER BY Transak.NOTA ASC
    ";
    return $this->db->query($query)->result();
//     $tgl_awal = $this->db->escape($tgl_awal);
//     $tgl_akhir = $this->db->escape($tgl_akhir);
//     $this->db->where('TGL BETWEEN '.$tgl_awal.' AND '.$tgl_akhir); // Tambahkan where tanggal nya
// return $this->db->get('dbo.Transak')->result();// Tampilkan data transaksi sesuai tanggal yang diinput oleh user pada filter
}
   //DETAIL
   private function _get_datatables_queryDet()
   {
       if($this->input->post('min')){
        
           
           $this->db->where('det.TGL >=', $this->input->post('min'));
           $this->db->where('det.TGL <=', $this->input->post('max'));
           
       }
       if($this->input->post('KDSUP'))
        {
            $this->db->where('KDSUP', $this->input->post('KDSUP'));
        }
        if($this->input->post('NAMABRG'))
        {
            $this->db->where('NAMABRG', $this->input->post('NAMABRG'));
        }
       $this->db->select('det.*,tr.KODETRN')
       ->from('TransakDetil as det')
       ->join('Transak as tr', 'tr.NOTA = det.NOTA', 'inner')
       ->where('tr.KODETRN','B');
       


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

   function get_datatablesDet()
   {
       $this->_get_datatables_queryDet();
       if($_POST['length'] != -1)
       $this->db->limit($_POST['length'], $_POST['start']);
       $query = $this->db->get();
       return $query->result();
   }

   function count_filteredDet()
   {
       $this->_get_datatables_queryDet();
       $query = $this->db->get();
       return $query->num_rows();
   }

   public function count_allDet()
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
   public function fetchSum($tgl_awal, $tgl_akhir,$supp,$brg){
 
    
    $query = "
    SELECT TOP 1 SUM(det.TOTAL) as SUBTOTAL FROM TransakDetil AS det INNER JOIN Transak as tr ON tr.NOTA = det.NOTA WHERE det.KDSUP ='$supp' AND det.NAMABRG ='$brg' AND det.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'B';
    ";
  
    return $this->db->query($query)->result();
//     $tgl_awal = $this->db->escape($tgl_awal);
//     $tgl_akhir = $this->db->escape($tgl_akhir);
//     $this->db->where('TGL BETWEEN '.$tgl_awal.' AND '.$tgl_akhir); // Tambahkan where tanggal nya
// return $this->db->get('dbo.Transak')->result();// Tampilkan data transaksi sesuai tanggal yang diinput oleh user pada filter
}
public function fetchSumWOBoth($tgl_awal, $tgl_akhir){
 
    
    $query = "
    SELECT TOP 1 SUM(det.TOTAL) as SUBTOTAL FROM TransakDetil AS det INNER JOIN Transak as tr ON tr.NOTA = det.NOTA WHERE det.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'B';
    ";
  
    return $this->db->query($query)->result();
//     $tgl_awal = $this->db->escape($tgl_awal);
//     $tgl_akhir = $this->db->escape($tgl_akhir);
//     $this->db->where('TGL BETWEEN '.$tgl_awal.' AND '.$tgl_akhir); // Tambahkan where tanggal nya
// return $this->db->get('dbo.Transak')->result();// Tampilkan data transaksi sesuai tanggal yang diinput oleh user pada filter
}
public function fetchSumWOBrg($tgl_awal, $tgl_akhir,$supp){
 
    
    $query = "
    SELECT TOP 1 SUM(det.TOTAL) as SUBTOTAL FROM TransakDetil AS det INNER JOIN Transak as tr ON tr.NOTA = det.NOTA WHERE  det.KDSUP ='$supp' AND  det.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'B';
    ";
  
    return $this->db->query($query)->result();
//     $tgl_awal = $this->db->escape($tgl_awal);
//     $tgl_akhir = $this->db->escape($tgl_akhir);
//     $this->db->where('TGL BETWEEN '.$tgl_awal.' AND '.$tgl_akhir); // Tambahkan where tanggal nya
// return $this->db->get('dbo.Transak')->result();// Tampilkan data transaksi sesuai tanggal yang diinput oleh user pada filter
}
public function fetchSumWOSupp($tgl_awal, $tgl_akhir,$brg){
 
    
    $query = "
    SELECT TOP 1 SUM(det.TOTAL) as SUBTOTAL FROM TransakDetil AS det INNER JOIN Transak as tr ON tr.NOTA = det.NOTA WHERE  det.NAMABRG ='$brg' AND  det.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'B';
    ";
  
    return $this->db->query($query)->result();
//     $tgl_awal = $this->db->escape($tgl_awal);
//     $tgl_akhir = $this->db->escape($tgl_akhir);
//     $this->db->where('TGL BETWEEN '.$tgl_awal.' AND '.$tgl_akhir); // Tambahkan where tanggal nya
// return $this->db->get('dbo.Transak')->result();// Tampilkan data transaksi sesuai tanggal yang diinput oleh user pada filter
}
public function view_by_dateDetWithBrg($tgl_awal, $tgl_akhir,$brg){
    $query = "
    SELECT det.*, tr.KODETRN FROM TransakDetil AS det INNER JOIN Transak as tr ON tr.NOTA = det.NOTA WHERE det.NAMABRG ='$brg' AND det.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'B' ORDER BY det.NOTA;
    ";
    return $this->db->query($query)->result();
}
public function view_by_dateDetWithSupp($tgl_awal, $tgl_akhir,$supp){
    $query = "
    SELECT det.*, tr.KODETRN FROM TransakDetil AS det INNER JOIN Transak as tr ON tr.NOTA = det.NOTA WHERE det.KDSUP ='$supp' AND det.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'B' ORDER BY det.NOTA;
    ";
    return $this->db->query($query)->result();
}
public function view_by_dateDetWithOutBoth($tgl_awal, $tgl_akhir){
    $query = "
    SELECT det.*, tr.KODETRN FROM TransakDetil AS det INNER JOIN Transak as tr ON tr.NOTA = det.NOTA WHERE det.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'B' ORDER BY det.NOTA;
    ";
    return $this->db->query($query)->result();
}
  public function view_by_dateDet($tgl_awal, $tgl_akhir,$supp,$brg){
  
      $query = "
      SELECT det.*, tr.KODETRN FROM TransakDetil AS det INNER JOIN Transak as tr ON tr.NOTA = det.NOTA WHERE det.KDSUP ='$supp' AND det.NAMABRG ='$brg' AND det.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'B' ORDER BY det.NOTA;
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
}
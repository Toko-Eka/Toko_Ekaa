<?php
class KartuStokModel extends CI_Model
{
	

    var $table = 'dbo.xTransakDetil';
    var $column_order = array('det.tgl','det.tgl','det.JMLBRG','det.NOTA');
    var $order = array('tr.TGL' => 'asc'); // default order 
    var $column_search = array('det.tgl','det.JMLBRG','det.NOTA'); //set column field database for datatable searchable just firstname , lastname , address are searchable
  
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
        if($this->input->post('KDBRG'))
        {
            $this->db->where('KDBRG', $this->input->post('KDBRG'));
        }
        if ($this->input->post('min')) {


            $this->db->where('tr.TGL >=', $this->input->post('min'));
            $this->db->where('tr.TGL <=', $this->input->post('max'));
        }
    
   


    $this->db->select('det.*')
    ->select('tr.*')
    

      
      
     
        ->from('xtransakDetil as det')
        ->join('xTransak as tr', 'det.NOTA = tr.NOTA', 'inner')
    
        ->where('det.FLAG is NULL', NULL, FALSE);
    
      
 
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
        $this->db->where('KDBRG',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
    public function getKartuStokMast($id){
        $query = " 
        SELECT * FROM MASTER WHERE KDBRG='$id'
      
            ";
            return $this->db->query($query)->result();
         }
         public function getStokAwal($id,$awal,$akhir){
            $query = " 
            SELECT TOP(1) min(det.AKHIR) + sum(det.JMLBRG) as AKHIIR FROM  xtransakdetil as det INNER JOIN xtransak as tr on det.NOTA = tr.NOTA  WHERE det. KDBRG = '$id' AND det.FLAG IS NULL AND  tr.TGL BETWEEN'$awal' AND '$akhir'  GROUP BY tr.NOTA ORDER BY MIN(tr.TGL) ASC

          
          
                ";
                // var_dump($query);
                return $this->db->query($query)->result();
             }
     public function getKartuStok($id,$awal,$akhir){
    $query = " 
    
    SELECT det.*, tr.* FROM xtransakdetil as det INNER JOIN xtransak as tr on det.NOTA = tr.NOTA  WHERE det.KDBRG= '$id' AND tr.TGL BETWEEN '$awal' AND '$akhir' AND det.FLAG IS NULL ORDER BY tr.TGL ASC
    
        ";
        // var_dump($query);die;
        return $this->db->query($query)->result();
     }
     public function getStokAwaal($tgl_awal, $tgl_akhir, $brg)
     {
 
         error_reporting(0);
         $query = $this->db->query("SELECT top(1) min(det.AKHIR) + sum(det.JMLBRG) as Awal  FROM  xtransakdetil as det INNER JOIN xtransak as tr on det.NOTA = tr.NOTA  WHERE det.KDBRG= '$brg' AND det.FLAG IS NULL AND  tr.TGL BETWEEN '$tgl_awal' AND '$tgl_akhir' GROUP BY tr.NOTA ORDER BY MIN(tr.TGL) ASC
        ");
 
         if ($query->num_rows() > 0) {
           
             foreach ($query->result() as $data) {
                 $hasil = array(
 
 
             //AWAL DULU BARU AKHIR
                     'STOK' => $data->Awal,
       
                 );
             }
         }
         return $hasil;
       
     }
     public function getStokAkhiir($tgl_awal, $tgl_akhir, $brg)
    {

        error_reporting(0);
        $query = $this->db->query("SELECT TOP(1) AKHIR FROM xtransakdetil as det INNER JOIN xtransak as tr on det.NOTA = tr.NOTA  WHERE det.KDBRG= '$brg' AND tr.TGL BETWEEN '$tgl_awal' AND '$tgl_akhir' AND det.FLAG IS NULL ORDER BY TRECNO DESC");

        if ($query->num_rows() > 0) {
          
            foreach ($query->result() as $data) {
                $hasil = array(


            //AWAL DULU BARU AKHIR
                    'STOK' => $data->AKHIR,
      
                );
            }
        }
        return $hasil;
      
    }
    public function getKelMasuk($tgl_awal, $tgl_akhir, $brg)
    {

        error_reporting(0);
        $query = $this->db->query("SELECT SUM(CASE WHEN tr.kodetrn in ( 'J','k') AND ( tr.TGL  BETWEEN '$tgl_awal' AND '$tgl_akhir')    THEN det.JMLBRG ELSE 0 END) AS Keluar,SUM(CASE WHEN tr.kodetrn in ( 'b','m') AND ( tr.TGL  BETWEEN '$tgl_awal' AND '$tgl_akhir')    THEN det.JMLBRG ELSE 0 END) AS MASUK  FROM xtransakdetil as det INNER JOIN xtransak as tr on det.NOTA = tr.NOTA  WHERE det.KDBRG= '$brg' AND det.FLAG IS NULL GROUP BY tr.NOTA ORDER BY MIN(tr.TGL) ASC");

        if ($query->num_rows() > 0) {
            $sumK = 0;
            $sumM = 0;
            foreach ($query->result() as $data) {
                $hasil = array(


                    $sumK += $data->Keluar,
                    $sumM += $data->MASUK,
                    'Keluar' => $sumK,
                    'Masuk' => $sumM
                );
            }
        }
        return $hasil;
    }
}

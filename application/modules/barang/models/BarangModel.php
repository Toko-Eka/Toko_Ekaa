<?php
class BarangModel extends CI_Model
{
	

    var $table = 'dbo.MASTER';
    var $column_order = array('KDBRG','JENIS','NAMABRG','KDSUP','AKHIR'); //set column field database for datatable orderable
    var $column_search = array('KDBRG','JENIS','NAMABRG','KDSUP'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('KDBRG' => 'desc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
        if($this->input->post('KDSUP'))
        {
            $this->db->where('KDSUP', $this->input->post('KDSUP'));
        }
        if($this->input->post('JENIS'))
        {
            $this->db->where('JENIS', $this->input->post('JENIS'));
        }
        if($this->input->post('AKHIR'))
        {
          
            $operator = $this->input->post('MORELESS'); 
            if($operator == '<'){
            $this->db->where('AKHIR <', $this->input->post('AKHIR'));
            }
            else  if($operator == '>'){
                $this->db->where('AKHIR >', $this->input->post('AKHIR'));
        }
        else  if($operator == '1'){
            $this->db->where('AKHIR <', $this->input->post('MORELESS'));
    }
                 else   $this->db->where('AKHIR', $this->input->post('AKHIR')); 
    }
  
        $this->db->from($this->table);
 
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
    public function save($data)
    {
        $this->db->insert($this->table, $data);

    }
    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
    
    public function delete_by_id($id)
    {
        $this->db->where('KDBRG', $id);
        $this->db->delete($this->table);
    }
 
    public function search($postData)
    {
    $response = array();

    if(isset($postData['search']) ){
      // Select record
      $this->db->select('TOP (10)*');
      $this->db->where("KDSUP like '%".$postData['search']."%' ");

      $records = $this->db->get('SUPL')->result();

      foreach($records as $row ){
         $response[] = array("label"=>$row->KDSUP,"val"=>$row->NAMA);
     
      }

    }

    return $response;
 }
 public function fetchJen($postJen)
    {
    $response = array();

    if(isset($postJen['search2']) ){
      // Select record
      $this->db->select('TOP (10) JENIS');
      $this->db->where("JENIS like '%".$postJen['search2']."%' ");

      $records = $this->db->get('MASTER')->result();

      foreach($records as $row ){
         $response[] = array("value"=>$row->JENIS);
      }

    }

    return $response;
 }
 public function fetchBrg($postBrg)
    {
    $response = array();

    if(isset($postBrg['searchBar']) ){
      // Select record
      $this->db->select('TOP (10) NAMABRG,HET,KDSUP');
      $this->db->where("NAMABRG like '%".$postBrg['searchBar']."%' ");

      $records = $this->db->get('MASTER')->result();

      foreach($records as $row ){
         $response[] = array("label"=>$row->NAMABRG);
         $response[] = array("harga"=>$row->HET);
         $response[] = array("supplier"=>$row->KDSUP);
      }

    }

    return $response;
 }
 

 public function fetchSum($tgl_awal, $tgl_akhir, $barr, $kdsupp)
    {


        $query = $this->db->query(" SELECT (det.HBT * det.JMLBRG) as TOTAL, det.JMLBRG FROM xTransakDetil as det INNER JOIN xTransak as tr ON tr.NOTA = det.NOTA WHERE det.FLAG IS NULL AND tr.KODETRN='B' AND det.NAMABRG LIKE '%$barr%' AND det.KDSUP ='$kdsupp'AND tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'B' AND det.FLAG IS NULL ORDER BY det.KDSUP;");

        if ($query->num_rows() > 0) {
            $sum = 0;
            $sumqty = 0;
            foreach ($query->result() as $data) {
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
   
   
    public function fetchSumWOBoth($tgl_awal, $tgl_akhir)
    {


        $query = $this->db->query("    SELECT (det.HBT * det.JMLBRG) as TOTAL, det.JMLBRG FROM xTransakDetil AS det INNER JOIN xTransak as tr ON tr.NOTA = det.NOTA WHERE tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'B' AND det.FLAG IS NULL ORDER BY det.KDSUP");

        if ($query->num_rows() > 0) {
            $sum = 0;
            $sumqty = 0;
            foreach ($query->result() as $data) {
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
    public function fetchSumWOBrg($tgl_awal, $tgl_akhir, $kdsupp)
    {


        $query = $this->db->query("      SELECT (det.HBT * det.JMLBRG) as TOTAL, det.JMLBRG FROM xTransakDetil AS det INNER JOIN xTransak as tr ON tr.NOTA = det.NOTA WHERE det.KDSUP ='$kdsupp' AND  tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'B' AND det.FLAG IS NULL ORDER BY det.KDSUP;");

        if ($query->num_rows() > 0) {
            $sum = 0;
            $sumqty = 0;
            foreach ($query->result() as $data) {
                $hasil = array(


                    $sum += $data->TOTAL,
                    $sumqty += $data->JMLBRG,
                    'GRANDTOTAL' => $sum,
                    'JML' => $sumqty
                );
            }
        }
        return $hasil;
        //     $tgl_awal = $this->db->escape($tgl_awal);
        //     $tgl_akhir = $this->db->escape($tgl_akhir);
        //     $this->db->where('TGL BETWEEN '.$tgl_awal.' AND '.$tgl_akhir); // Tambahkan where tanggal nya
        // return $this->db->get('dbo.Transak')->result();// Tampilkan data transaksi sesuai tanggal yang diinput oleh user pada filter
    }
    public function fetchSumWoSupp($tgl_awal, $tgl_akhir, $barr)
    {


        $query = $this->db->query("  SELECT (det.HBT * det.JMLBRG) as TOTAL, det.JMLBRG FROM xTransakDetil AS det INNER JOIN xTransak as tr ON tr.NOTA = det.NOTA WHERE det.NAMABRG LIKE '%$barr%'  AND  tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'B' AND det.FLAG IS NULL ORDER BY det.KDSUP;");

        if ($query->num_rows() > 0) {
            $sumqty = 0;
            $sum = 0;
            foreach ($query->result() as $data) {
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
}

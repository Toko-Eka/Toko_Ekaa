<?php
class ReturModel extends CI_Model
{
	

  var $table = 'dbo.xTransakDetil';

  var $column_orderDet =array('tr.TGL','det.tgl','NAMABRG','JMLBRG','KET1'); //set column field database for datatable orderable
  var $column_search =array('tr.TGL','det.tgl','NAMABRG','JMLBRG','KET1'); //set column field database for datatable searchable just firstname , lastname , address are searchable
  var $order = array('tr.NOTA' => 'asc'); // default order 


  public function __construct()
  {
      parent::__construct();
      $this->load->database();
  }
  //RETUR MASUK
  private function _get_datatables_query()
  {
      if ($this->input->post('min')) {


          $this->db->where('tr.TGL >=', $this->input->post('min'));
          $this->db->where('tr.TGL <=', $this->input->post('max'));
      }
      if($this->input->post('KDSUP'))
        {
            $this->db->where('KDSUP', $this->input->post('KDSUP'));
        }
      if ($this->input->post('NAMABRG')) {
          $this->db->like('NAMABRG', $this->input->post('NAMABRG'), 'both'); 
    
      }

      $this->db->select('det.*,tr.KODETRN')
      ->select('tr.TGL')
      ->select('tr.KET1')
          ->from('xTransakDetil as det')
          ->join('xTransak as tr', 'tr.NOTA = det.NOTA', 'inner')
          ->where('det.FLAG is NULL', NULL, FALSE)

          ->where('tr.KODETRN', 'M');




      //  $query = $this->db->get();
      //     //    $query= $this->db->query(' SELECT MIN(tr.TGL) as TGLL, tr.NOTA,SUM(det.JMLBRG) as TotalQTY, SUM(det.TOTAL) as Total FROM Transak as tr  LEFT JOIN TransakDetil as det ON tr.NOTA = det.NOTA GROUP BY tr.NOTA ORDER BY tr.NOTA;');
      //        return $query->result_array();



      $i = 0;

      foreach ($this->column_search as $item) // loop column 
      {
          if ($_POST['search']['value']) // if datatable send POST for search
          {

              if ($i === 0) // first loop
              {
                  $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                  $this->db->like($item, $_POST['search']['value']);
              } else {
                  $this->db->or_like($item, $_POST['search']['value']);
              }

              if (count($this->column_search) - 1 == $i) //last loop
                  $this->db->group_end(); //close bracket
          }
          $i++;
      }

      if (isset($_POST['order'])) // here order processing
      {
          $this->db->order_by($this->column_orderDet[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
      } else if (isset($this->order)) {
          $order = $this->order;
          $this->db->order_by(key($order), $order[key($order)]);
      }
  }

  function get_datatables()
  {
      $this->_get_datatables_query();
      if ($_POST['length'] != -1)
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
  //RETUR KELUAR
  private function _get_datatables_queryK()
  {
      if ($this->input->post('min')) {


          $this->db->where('tr.TGL >=', $this->input->post('min'));
          $this->db->where('tr.TGL <=', $this->input->post('max'));
      }
      if($this->input->post('KDSUP'))
        {
            $this->db->where('KDSUP', $this->input->post('KDSUP'));
        }
      if ($this->input->post('NAMABRG')) {
          $this->db->like('NAMABRG', $this->input->post('NAMABRG'), 'both'); 
    
      }

      $this->db->select('det.*,tr.KODETRN')
      ->select('tr.TGL')
      ->select('tr.KET1')
          ->from('xTransakDetil as det')
          ->join('xTransak as tr', 'tr.NOTA = det.NOTA', 'inner')
          ->where('det.FLAG is NULL', NULL, FALSE)

          ->where('tr.KODETRN', 'K');




      //  $query = $this->db->get();
      //     //    $query= $this->db->query(' SELECT MIN(tr.TGL) as TGLL, tr.NOTA,SUM(det.JMLBRG) as TotalQTY, SUM(det.TOTAL) as Total FROM Transak as tr  LEFT JOIN TransakDetil as det ON tr.NOTA = det.NOTA GROUP BY tr.NOTA ORDER BY tr.NOTA;');
      //        return $query->result_array();



      $i = 0;

      foreach ($this->column_search as $item) // loop column 
      {
          if ($_POST['search']['value']) // if datatable send POST for search
          {

              if ($i === 0) // first loop
              {
                  $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                  $this->db->like($item, $_POST['search']['value']);
              } else {
                  $this->db->or_like($item, $_POST['search']['value']);
              }

              if (count($this->column_search) - 1 == $i) //last loop
                  $this->db->group_end(); //close bracket
          }
          $i++;
      }

      if (isset($_POST['order'])) // here order processing
      {
          $this->db->order_by($this->column_orderDet[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
      } else if (isset($this->order)) {
          $order = $this->order;
          $this->db->order_by(key($order), $order[key($order)]);
      }
  }

  function get_datatablesK()
  {
      $this->_get_datatables_queryK();
      if ($_POST['length'] != -1)
          $this->db->limit($_POST['length'], $_POST['start']);
      $query = $this->db->get();
      return $query->result();
  }

  function count_filteredK()
  {
      $this->_get_datatables_queryK();
      $query = $this->db->get();
      return $query->num_rows();
  }
    public function returMasuk($tgl_awal, $tgl_akhir){
  
        $query = "
        SELECT det.*, tr.KODETRN, tr.TGL AS TGLENTRY FROM xTransakDetil AS det INNER JOIN xTransak as tr ON tr.NOTA = det.NOTA WHERE  tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'M' ORDER BY tr.TGL ASC;
        ";
      // }
        return $this->db->query($query)->result();
        // var_dump($query);die;
    }
    
    public function returMasukWithSupp($tgl_awal, $tgl_akhir,$supp){
  
      $query = "
      SELECT det.*, tr.KODETRN, tr.TGL AS TGLENTRY FROM xTransakDetil AS det INNER JOIN xTransak as tr ON tr.NOTA = det.NOTA WHERE  tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'M' AND det.KDSUP='$supp' ORDER BY tr.TGL ASC;
      ";
    // }
      return $this->db->query($query)->result();
      // var_dump($query);die;
  }
    public function returKeluar($tgl_awal, $tgl_akhir){
  
        $query = "
        SELECT det.*, tr.KODETRN, tr.TGL AS TGLENTRY FROM xTransakDetil AS det INNER JOIN xTransak as tr ON tr.NOTA = det.NOTA WHERE  tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'K' ORDER BY tr.TGL ASC;
        ";
      // }
      // var_dump($query);die;
        return $this->db->query($query)->result();

    }
    public function returKeluarWithSupp($tgl_awal, $tgl_akhir,$supp){
  
      $query = "
      SELECT det.*, tr.KODETRN, tr.TGL AS TGLENTRY FROM xTransakDetil AS det INNER JOIN xTransak as tr ON tr.NOTA = det.NOTA WHERE  tr.tgl BETWEEN '$tgl_awal' AND '$tgl_akhir' AND  tr.KODETRN= 'K' AND det.KDSUP='$supp' ORDER BY tr.TGL ASC;
      ";
    // }
      return $this->db->query($query)->result();
//    var_dump($query);die;
  }
	

}

/* End of file Auth_model.php */
/* Location: ./application/models/Auth_model.php */

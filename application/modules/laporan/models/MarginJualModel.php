    <?php
    class MarginJualModel extends CI_Model
    {
        var $table = 'dbo.xTransakDetil';
        var $column_orderDet = array('MIN(det.NAMABRG)', 'SUM(det.JMLBRG)', 'brg.HBT', '(SUM((brg.HBT) * det.JMLBRG))', 'SUM(det.TOTAL)', '(SUM(det.TOTAL - brg.HBT * det.JMLBRG))'); //set column field database for datatable orderable
        var $column_search = array('det.TGL', 'det.NAMABRG', 'det.KDSUP'); //set column field database for datatable searchable just firstname , lastname , address are searchable
        var $order = array('det.KDSUP' => 'asc'); // default order 
        public function __construct()
        {
            parent::__construct();
            $this->load->database();
        }
        private function _get_datatables_query($master, $detil)
        {
            if ($this->input->post('min')) {
                $this->db->where('det.TGL >=', $this->input->post('min'));
                $this->db->where('det.TGL <=', $this->input->post('max'));
            }

            if ($this->input->post('NAMABRG')) {
                $this->db->like('brg.NAMABRG', $this->input->post('NAMABRG'), 'both');
            }
            if ($this->input->post('KDSUP')) {
                $this->db->where('det.KDSUP', $this->input->post('KDSUP'));
            }

            $this->db->select_max('brg.NAMABRG')
                ->select_sum('det.JMLBRG')
                ->select('ROUND((brg.HBT),0,1) as HBT', FALSE)
                ->select_sum('ROUND((brg.HBT),0,1) * det.JMLBRG', 'MODAL')
                ->select_sum('det.TOTAL')
                ->select('round(SUM(det.TOTAL - round(brg.HBT,0,1) * det.JMLBRG),0,1) AS MARGIN ')
                ->select('det.KDSUP')
                ->from($detil . ' as det')
                ->join('SUPL as sup', 'det.KDSUP = sup.KDSUP', 'left outer')
                ->join('MASTER as brg', 'det.KDBRG = brg.KDBRG', 'left outer')
                ->join($master . ' as tr', 'det.NOTA = tr.NOTA', 'left outer')
                ->where('tr.KODETRN', 'J')
                ->where('det.FLAG is NULL', NULL, FALSE)
                ->where('sup.FAKTUR', '1')
                ->group_by('det.JENIS, brg.HBT, det.KDSUP ');


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

        function get_datatables($master, $detil)
        {
            $this->_get_datatables_query($master, $detil);
            if ($_POST['length'] != -1)
                $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }

        function count_filtered($master, $detil)
        {
            $this->_get_datatables_query($master, $detil);
            $query = $this->db->get();
            return $query->num_rows();
        }
        public function repMargin($tgl_awal, $tgl_akhir, $barr, $master, $detil)
        {
            $query = "
 
        SELECT      MAX(brg.NAMABRG) AS NAMABRG, SUM(det.JMLBRG) AS JMLBRG,round(brg.HBT,0,1) AS HBT, SUM(round(brg.HBT,0,1) * det.JMLBRG) AS modal, 
        SUM(det.TOTAL) AS TOTAL, round(SUM(det.TOTAL - round(brg.HBT,0,1) * det.JMLBRG),0,1) AS margin, det.JENIS, 
        det.KDSUP
        FROM  $detil as det LEFT OUTER JOIN
        SUPL as sup ON det.KDSUP = sup.KDSUP LEFT OUTER JOIN
        MASTER as brg ON det.KDBRG = brg.KDBRG LEFT OUTER JOIN
        $master as tr ON det.NOTA = tr.NOTA
        WHERE  (tr.KODETRN='J') AND   ( tr.TGL BETWEEN '$tgl_awal' AND '$tgl_akhir')  AND (sup.FAKTUR = 1)  AND (det.NAMABRG LIKE '%$barr%')  AND 
        (det.FLAG IS NULL)
        GROUP BY det.JENIS, brg.HBT, det.KDSUP ORDER BY det.KDSUP
    ";
        // var_dump($query);die;
            return $this->db->query($query)->result();
        }
        public function repMarginSupp($tgl_awal, $tgl_akhir, $supp, $barr, $master, $detil)
        {
            $query = "
 
        SELECT      MAX(brg.NAMABRG) AS NAMABRG, SUM(det.JMLBRG) AS JMLBRG,round(brg.HBT,0,1) AS HBT, SUM(round(brg.HBT,0,1) * det.JMLBRG) AS modal, 
        SUM(det.TOTAL) AS TOTAL, round(SUM(det.TOTAL - round(brg.HBT,0,1) * det.JMLBRG),0,1) AS margin, det.JENIS, 
        det.KDSUP
FROM         $detil as det LEFT OUTER JOIN
        SUPL as sup ON det.KDSUP = sup.KDSUP LEFT OUTER JOIN
        MASTER as brg ON det.KDBRG = brg.KDBRG LEFT OUTER JOIN
        $master as tr ON det.NOTA = tr.NOTA
        WHERE  (tr.KODETRN='J') AND   ( tr.TGL BETWEEN '$tgl_awal' AND '$tgl_akhir')  AND (det.KDSUP = '$supp')  AND (sup.FAKTUR = 1) AND (det.NAMABRG LIKE '%$barr%') AND 
        (det.FLAG IS NULL)
GROUP BY det.JENIS, brg.HBT, det.KDSUP ORDER BY det.KDSUP
    ";
            return $this->db->query($query)->result();
        }
        public function fetchSumBoth($tgl_awal, $tgl_akhir, $brg, $supp, $master, $detil)
        {


            $query = $this->db->query(" SELECT      MAX(brg.NAMABRG) AS NAMABRG, SUM(det.JMLBRG) AS JMLBRG,round(brg.HBT,0,1) AS HBT, SUM(round(brg.HBT,0,1) * det.JMLBRG) AS modal, 
        SUM(det.TOTAL) AS TOTAL, round(SUM(det.TOTAL - round(brg.HBT,0,1) * det.JMLBRG),0,1) AS margin, det.JENIS, 
        det.KDSUP
FROM         $detil as det LEFT OUTER JOIN
        SUPL as sup ON det.KDSUP = sup.KDSUP LEFT OUTER JOIN
        MASTER as brg ON det.KDBRG = brg.KDBRG LEFT OUTER JOIN
        $master as tr ON det.NOTA = tr.NOTA
        WHERE  (tr.KODETRN='J') AND   ( tr.TGL BETWEEN '$tgl_awal' AND '$tgl_akhir')     AND (sup.FAKTUR = 1) AND (det.NAMABRG LIKE '%$brg%' escape '!')  AND (det.KDSUP = '$supp')  AND 
        (det.FLAG IS NULL)
        GROUP BY det.JENIS, brg.HBT, det.KDSUP ORDER BY det.KDSUP");
            if ($query->num_rows() > 0) {
                $sum = 0;
                $sumqty = 0;
                foreach ($query->result() as $data) {
                    $hasil = array(


                        $sum += $data->margin,

                        'GRANDTOTAL' => $sum,

                    );
                }
            }
            return $hasil;
        }
        public function fetchSum($tgl_awal, $tgl_akhir, $brg, $master, $detil)
        {

            error_reporting(0);
            $query = $this->db->query(" SELECT      MAX(brg.NAMABRG) AS NAMABRG, SUM(det.JMLBRG) AS JMLBRG,round(brg.HBT,0,1) AS HBT, SUM(round(brg.HBT,0,1) * det.JMLBRG) AS modal, 
        SUM(det.TOTAL) AS TOTAL, round(SUM(det.TOTAL - round(brg.HBT,0,1) * det.JMLBRG),0,1) AS margin, det.JENIS, 
        det.KDSUP
        FROM    $detil as det LEFT OUTER JOIN
        SUPL as sup ON det.KDSUP = sup.KDSUP LEFT OUTER JOIN
        MASTER as brg ON det.KDBRG = brg.KDBRG LEFT OUTER JOIN
        $master as tr ON det.NOTA = tr.NOTA
        WHERE  (tr.KODETRN='J') AND   ( tr.TGL BETWEEN '$tgl_awal' AND '$tgl_akhir')     AND (sup.FAKTUR = 1) AND (det.NAMABRG LIKE '%$brg%' escape '!') AND 
        (det.FLAG IS NULL)
        GROUP BY det.JENIS, brg.HBT, det.KDSUP ORDER BY det.KDSUP");

            if ($query->num_rows() > 0) {
                $sum = 0;
                $sumqty = 0;
                foreach ($query->result() as $data) {
                    $hasil = array(


                        $sum += $data->margin,

                        'GRANDTOTAL' => $sum,

                    );
                }
            }
            return $hasil;
        }
    }

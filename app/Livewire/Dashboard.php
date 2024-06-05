<?php

namespace App\Livewire;

use App\Models\Estate;
use App\Models\Logsampling;
use App\Models\Mill;
use App\Models\Regional;
use App\Models\Wilayah;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $date;
    public $regional;
    public $wil = [];
    public $mil = [];
    public $plat = [];
    public $driverarr = [];
    public $statusarr = [];
    public $tables = [];
    public $charts = [];
    public $wilayah;
    public $mill;
    public $no_plat;
    public $driver;
    public $status;
    public array $dataset = [];
    public array $labels = [];

    public function resetdata()
    {
        $this->wil = [];
        $this->mil = [];
        $this->plat = [];
        $this->driverarr = [];
        $this->statusarr = [];
        $this->tables = [];
        $this->charts = [];
    }

    public function updatedDate()
    {
        $this->resetdata();
        $this->regional = null;
        $this->wilayah = null;
        $this->mill = null;
        $this->no_plat = null;
        $this->driver = null;
        $this->status = null;
    }

    public function updatedRegional()
    {
        $this->wilayah = null;
        $this->mill = null;
        $this->no_plat = null;
        $this->driver = null;
        $this->status = null;
        $this->getwil();
    }

    public function updatedWilayah()
    {
        $this->mill = null;
        $this->no_plat = null;
        $this->driver = null;
        $this->status = null;
        $this->getmill();
    }

    public function updatedMill()
    {
        $this->no_plat = null;
        $this->driver = null;
        $this->status = null;
        $this->getplat();
    }

    public function updatedNoPlat()
    {
        $this->driver = null;
        $this->status = null;
        $this->getdriver();
    }

    public function updatedDriver()
    {
        $this->status = null;
        $this->getstatus();
    }

    public function getwil()
    {
        if ($this->regional) {
            $this->wil = Wilayah::where('regional', $this->regional)->get()->toArray();
        } else {
            $this->wil = [];
        }
        $this->mil = [];
        $this->tables = [];
        $this->charts = [];
    }

    public function getmill()
    {
        if ($this->wilayah) {
            $this->mil = Mill::where('wil', $this->wilayah)->get()->toArray();
        } else {
            $this->mil = [];
        }
        $this->plat = [];
        $this->tables = [];
        $this->charts = [];
    }

    public function getplat()
    {
        if ($this->date && $this->mill) {
            $this->plat = Logsampling::where('mill_id', $this->mill)
                ->where('waktu_mulai', 'like', '%' . $this->date . '%')
                ->get()
                ->toArray();
        } else {
            $this->plat = [];
        }
        $this->driverarr = [];
        $this->tables = [];
        $this->charts = [];
    }

    public function getdriver()
    {
        if ($this->no_plat === 'no_set') {
            $this->driverarr = Logsampling::where('no_plat', '')
                ->where('mill_id', $this->mill)
                ->where('waktu_mulai', 'like', '%' . $this->date . '%')
                ->get()->toArray();
        } else if ($this->no_plat !== 'no_set') {
            $this->driverarr = Logsampling::where('no_plat', $this->no_plat)
                ->where('mill_id', $this->mill)
                ->where('waktu_mulai', 'like', '%' . $this->date . '%')
                ->get()->toArray();
        } else {
            $this->driverarr = [];
        }
        $this->tables = [];
        $this->charts = [];
    }

    public function getstatus()
    {
        if ($this->driver === 'no_set') {
            $this->statusarr = Logsampling::where('nama_driver', '')
                ->where('mill_id', $this->mill)
                ->where('waktu_mulai', 'like', '%' . $this->date . '%')
                ->get()->toArray();
        } else if ($this->no_plat !== 'no_set') {
            $this->statusarr = Logsampling::where('nama_driver', $this->driver)
                ->where('mill_id', $this->mill)
                ->where('no_plat', $this->no_plat)
                ->where('waktu_mulai', 'like', '%' . $this->date . '%')
                ->get()->toArray();
        } else {
            $this->statusarr = [];
        }
        $this->tables = [];
        $this->charts = [];
    }
    public function save()
    {
        // Your save logic here

        $req_tgl = $this->date;
        $mill = $this->mill;
        $no_plat = ($this->no_plat !== 'not_set') ? null : $this->no_plat;
        $driver = ($this->driver !== 'not_set') ? null :  $this->driver;
        $driverStatus = $this->status;

        $log = DB::table('log_sampling')
            ->join('list_mill', 'log_sampling.mill_id', '=', 'list_mill.id')
            ->select(
                'log_sampling.*',
                'list_mill.mill',
                DB::raw("DATE_FORMAT(log_sampling.waktu_selesai, '%d %M %Y') as waktu_selesai_formed"),
                DB::raw("(log_sampling.unripe + log_sampling.ripe + log_sampling.overripe + log_sampling.empty_bunch + log_sampling.abnormal + log_sampling.kastrasi ) as janjang"),
                DB::raw("CASE WHEN (log_sampling.unripe + log_sampling.ripe + log_sampling.overripe + log_sampling.empty_bunch + log_sampling.abnormal) > 0 THEN (ripe / (log_sampling.unripe + log_sampling.ripe + log_sampling.overripe + log_sampling.empty_bunch + log_sampling.abnormal + log_sampling.kastrasi )) * 100 ELSE 0 END as ripeness")
            )
            ->where('log_sampling.waktu_mulai', 'like', '%' . $req_tgl . '%');

        // Add conditional filters
        if (!is_null($mill)) {
            $log->where('log_sampling.mill_id', '=', $mill);
        }

        if (!is_null($no_plat)) {
            $log->where('log_sampling.no_plat', '=', $no_plat);
        }

        if (!is_null($driver)) {
            $log->where('log_sampling.nama_driver', '=', $driver);
        }

        if (!is_null($driverStatus)) {
            $log->where('log_sampling.status', '=', $driverStatus);
        }

        $data = $log->get();
        $this->tables = $data;

        // dd($data);

        // dd($data, $req_tgl, $mill, $no_plat, $driver, $driverStatus);

        $querychart = DB::table('log_sampling')
            ->select([
                DB::raw("SUM(tp) as total_tp"),
                DB::raw("SUM(kastrasi) as total_kastrasi"),
                DB::raw("SUM(ripe) as total_ripe"),
                DB::raw("SUM(unripe) as total_unripe"),
                DB::raw("SUM(overripe) as total_overripe"),
                DB::raw("SUM(empty_bunch) as total_bunch"),
                DB::raw("SUM(abnormal) as total_abnormal"),
                DB::raw("MAX(log_sampling.waktu_selesai) as date"), // Use MAX as an example
                DB::raw("MAX(log_sampling.bisnis_unit) as est"),   // Use MAX as an example

            ])
            ->where('log_sampling.waktu_mulai', 'like', '%' . $req_tgl . '%');
        if (!is_null($mill)) {
            $querychart->where('log_sampling.mill_id', '=', $mill); // Correct query
        }

        $Chart = $querychart->get();

        $total_tp = $Chart->sum('total_tp');
        $total_kastrasi = $Chart->sum('total_kastrasi');
        $total_ripe = $Chart->sum('total_ripe');
        $total_unripe = $Chart->sum('total_unripe');
        $total_overripe = $Chart->sum('total_overripe');
        $total_bunch = $Chart->sum('total_bunch');
        $total_abnormal = $Chart->sum('total_abnormal');
        $est = $Chart[0]->est;
        $date = date('Y-m-d', strtotime($Chart[0]->date));

        $total_janjang = $total_tp + $total_kastrasi + $total_ripe + $total_unripe + $total_overripe + $total_bunch + $total_abnormal;
        $datachart = [
            $total_kastrasi,
            $total_ripe,
            $total_unripe,
            $total_overripe,
            $total_bunch,
            $total_abnormal,
            $total_janjang,
        ];
        $dataset = [
            [
                'label' => 'Line Chart',
                'backgroundColor' => 'rgba(15,64,97,255)',
                'borderColor' => 'rgba(15,64,97,255)',
                'data' => $datachart,
            ],
        ];
        $datasetdonuts = [
            [
                'label' => 'Pie Chart',
                'backgroundColor' =>  ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)', 'rgb(25,255,102)', 'rgb(255,191,128)', 'rgb(102,68,0)'],
                'hoverOffset' => 4,
                'data' => $datachart,

            ],
        ];
        $labels = $this->getLabels();
        $this->dispatch('updateChart', [
            'datasets' => $dataset,
            'labels' => $labels,
        ]);
        $this->dispatch('updateChartdonus', [
            'datasets' => $datasetdonuts,
            'labels' => ['Total Kastrasi', 'Total Ripe', 'Total Unripe', 'Total Overripe', 'Total Empty Bunch', 'Total Abnormal'],
        ]);
    }

    private function getLabels()
    {
        return ['Total Kastrasi', 'Total Ripe', 'Total Unripe', 'Total Overripe', 'Total Empty Bunch', 'Total Abnormal'];
    }

    private function getRandomData()
    {
        $data = [];
        for ($i = 0; $i < count($this->getLabels()); $i++) {
            $data[] = rand(10, 100);
        }
        return $data;
    }
    public function mount()
    {
        $this->labels = $this->getLabels();

        $this->dataset = [
            [
                'label' => 'Line Chart',
                'backgroundColor' => 'rgba(15,64,97,255)',
                'borderColor' => 'rgba(15,64,97,255)',
                'data' => $this->getRandomData(),
            ],
        ];
    }
    public function render()
    {
        $reg = Regional::query()->where('id', '!=', 5)->get()->toArray();
        return view('livewire.dashboard', ['reg' => $reg]);
    }
}

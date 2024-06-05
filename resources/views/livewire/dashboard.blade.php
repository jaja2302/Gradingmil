<div>
    <form wire:submit.prevent="save" class="p-6 bg-white rounded-lg shadow-md">
        <div class="grid gap-6 mb-6 md:grid-cols-3">
            <!-- Date Picker -->
            <div>
                <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Tanggal</label>
                <input wire:model="date" type="date" wire:change="resetdata" id="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
            </div>

            <!-- Regional Dropdown -->
            <div>
                <label for="regional" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Regional</label>
                <select wire:model="regional" wire:change="getwil" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" {{ !$date ? 'disabled' : '' }}>
                    <option selected>Select Reg</option>
                    @foreach ($reg as $item)
                    <option value="{{$item['id']}}">{{$item['nama']}}</option>
                    @endforeach
                </select>
            </div>

            <!-- Wilayah Dropdown -->
            <div>
                <label for="wilayah" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Wilayah</label>
                <select id="wilayah" wire:model="wilayah" wire:change="getmill" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" {{ !$regional ? 'disabled' : '' }}>
                    <option selected>Select Wil</option>
                    @foreach ($wil ?? [] as $item)
                    <option value="{{$item['id']}}">{{$item['nama']}}</option>
                    @endforeach
                </select>
            </div>

            <!-- Mill Dropdown -->
            <div>
                <label for="mill" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mill</label>
                <select id="mill" wire:model="mill" wire:change="getplat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" {{ !$wilayah ? 'disabled' : '' }}>
                    <option selected>Select Mil</option>
                    @foreach ($mil ?? [] as $item)
                    <option value="{{$item['id']}}">{{$item['nama_mill']}}</option>
                    @endforeach
                </select>
            </div>

            <!-- No Plat Dropdown -->
            <div>
                <label for="no_plat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No Plat</label>
                <select id="no_plat" wire:model="no_plat" wire:change="getdriver" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" {{ !$mill ? 'disabled' : '' }}>
                    <option selected>Select No Plat</option>
                    @php
                    $inc = 1;
                    @endphp
                    @foreach ($plat ?? [] as $item)
                    @if ($item['no_plat'] === '')
                    <option value="no_set">Plat Kosong {{$inc++}}</option>
                    @else
                    <option value="{{$item['no_plat']}}">{{$item['no_plat']}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mb-6">
            <label for="driver" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Driver</label>
            <select id="driver" wire:model="driver" wire:change="getstatus" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Select Driver</option>
                @php
                $inc = 1;
                @endphp
                @foreach ($driverarr ?? [] as $item)
                @if ($item['no_plat'] === '')
                <option value="no_set">Driver Kosong {{$inc++}}</option>
                @else
                <option value="{{$item['nama_driver']}}">{{$item['nama_driver']}}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="mb-6">
            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
            <select id="status" wire:model="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected>Select Status</option>
                @foreach ($statusarr ?? [] as $item)
                <option value="{{$item['status']}}">{{$item['status']}}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="text-white bg-blue-700 hover:bg-green-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-green-500 dark:focus:ring-blue-800 !important">
            Submit
        </button>


    </form>


    <div class="p-6 bg-white rounded-lg overflow-x-auto shadow-md">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Waktu Selesai
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Ripeness
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Janjang
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Ripe
                    </th>

                    <th scope="col" class="px-6 py-3">
                        Unripe
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Overripe
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Empty
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Abnormal
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Kastrasi
                    </th>
                    <th scope="col" class="px-6 py-3">
                        TP
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Mill
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Bisnis Unit
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Devisi
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Blok
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nomor Plat
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama Driver
                    </th>
                </tr>
            </thead>
            <tbody>
                @if(empty($tables) || $tables->isEmpty())
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td colspan="17" class="px-6 py-4 text-center">
                        NO DATA FOUND
                    </td>
                </tr>
                @else
                @foreach($tables as $items)

                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <td class="px-6 py-4">
                        {{$items->waktu_selesai}}
                    </td>
                    <td class="px-6 py-4">
                        {{$items->ripeness}}
                    </td>
                    <td class="px-6 py-4">
                        {{$items->janjang}}
                    </td>
                    <td class="px-6 py-4">
                        {{$items->ripe}}
                    </td>
                    <td class="px-6 py-4">
                        {{$items->unripe}}
                    </td>
                    <td class="px-6 py-4">
                        {{$items->overripe}}
                    </td>
                    <td class="px-6 py-4">
                        {{$items->empty_bunch}}
                    </td>
                    <td class="px-6 py-4">
                        {{$items->abnormal}}
                    </td>
                    <td class="px-6 py-4">
                        {{$items->kastrasi}}
                    </td>
                    <td class="px-6 py-4">
                        {{$items->tp}}
                    </td>
                    <td class="px-6 py-4">
                        {{$items->mill}}
                    </td>
                    <td class="px-6 py-4">
                        {{$items->bisnis_unit}}
                    </td>
                    <td class="px-6 py-4">
                        {{$items->divisi}}
                    </td>
                    <td class="px-6 py-4">
                        {{$items->blok}}
                    </td>
                    <td class="px-6 py-4">
                        {{$items->status}}
                    </td>
                    <td class="px-6 py-4">
                        {{$items->no_plat}}
                    </td>
                    <td class="px-6 py-4">
                        {{$items->nama_driver}}
                    </td>
                </tr>
                @endforeach
                @endif

            </tbody>
        </table>
    </div>


    <canvas id="donust-line" class="p-6 bg-white rounded-lg shadow-md w-full max-h-96"></canvas>
    <canvas id="chart-line" class=" p-6 bg-white rounded-lg shadow-md w-full h-full"></canvas>




    <script type="module">
        const chart = new Chart(
            document.getElementById('chart-line'), {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: @json($dataset)
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    responsive: true,
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true
                        }
                    }
                }
            }
        );

        Livewire.on('updateChart', data => {

            // console.log(data);
            chart.data = data[0];
            chart.update();
        });
        // const data = {
        //     labels: [
        //         'Red',
        //         'Blue',
        //         'Yellow'
        //     ],
        //     datasets: [{
        //         label: 'My First Dataset',
        //         data: [300, 50, 100],
        //         backgroundColor: [
        //             'rgb(255, 99, 132)',
        //             'rgb(54, 162, 235)',
        //             'rgb(255, 205, 86)'
        //         ],
        //         hoverOffset: 4
        //     }]
        // };
        const Donuts = new Chart(
            document.getElementById('donust-line'), {
                type: 'doughnut',
                data: {
                    labels: @json($labels),
                    datasets: @json($dataset)
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    responsive: true,
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true
                        }
                    }
                }
            }
        );

        Livewire.on('updateChartdonus', data => {

            // console.log(data);
            Donuts.data = data[0];
            Donuts.update();
        });
    </script>

</div>
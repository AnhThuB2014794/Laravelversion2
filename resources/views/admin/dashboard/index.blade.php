@extends('admin.layouts.app')

@section('content')
<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
        <div class="card-header p-3 pt-2">
            <div
                class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">weekend</i>
            </div>
            <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Vai trò</p>
                <h4 class="mb-0">{{$roleCount}}</h4>
            </div>
        </div>
        <hr class="dark horizontal my-0">

    </div>
</div>
<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
        <div class="card-header p-3 pt-2">
            <div
                class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">person</i>
            </div>
            <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Người dùng</p>
                <h4 class="mb-0">{{$userCount}}</h4>
            </div>
        </div>
        <hr class="dark horizontal my-0">

    </div>
</div>
<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
        <div class="card-header p-3 pt-2">
            <div
                class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">person</i>
            </div>
            <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Danh mục</p>
                <h4 class="mb-0">{{$categoryCount}}</h4>
            </div>
        </div>
        <hr class="dark horizontal my-0">

    </div>
</div>
<div class="col-xl-3 col-sm-6">
    <div class="card">
        <div class="card-header p-3 pt-2">
            <div
                class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">weekend</i>
            </div>
            <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Sản phẩm</p>
                <h4 class="mb-0">{{$productCount}}</h4>
            </div>
        </div>
        <hr class="dark horizontal my-0">

    </div>
</div>

<div class="col-xl-3 col-sm-6 mt-4">
    <div class="card">
        <div class="card-header p-3 pt-2">
            <div
                class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">weekend</i>
            </div>
            <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Đơn hàng</p>
                <h4 class="mb-0">{{$orderCount}}</h4>
            </div>
        </div>
        <hr class="dark horizontal my-0">

    </div>
</div>
<div class="container">
    <h3>Thống kê lợi nhuận theo tháng</h3>
  
    <form method="get">
        <label for="selected_month">Chọn tháng:</label>
        <select name="selected_month" id="selected_month" style="    width: 150px;height: 50px;margin: 10px;padding:10px">
            @for ($month = 1; $month <= 12; $month++)
                <option value="{{ $month }}" {{ $selectedMonth == $month ? 'selected' : '' }}>
                    {{ Carbon\Carbon::createFromDate(null, $month)->locale('vi')->monthName }}
                </option>
            @endfor
        </select>
        <button type="submit" class="btn btn-primary">Hiện thống kê</button>
    </form>
  
    {{-- @if ($totalInputCost !== null && $totalExportCost !== null) --}}
     
      <div class="row"  style="margin-top: 20px">
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-header p-3 pt-2">
            
            <div class="text-end pt-1">
              <p class="text-sm mb-0 text-capitalize">Tổng giá trị nhập hàng</p>
              <h4 class="mb-0">{{ number_format($totalImport) }} VNĐ</h4>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-3">
            <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span></p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-header p-3 pt-2">
            
            <div class="text-end pt-1">
              <p class="text-sm mb-0 text-capitalize">Tổng giá trị bán ra </p>
              <h4 class="mb-0">{{ number_format($totalOrderPrice) }} VNĐ</h4>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-3">
            <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span></p>
          </div>
        </div>
      </div>
      
      <div class="col-xl-3 col-sm-6">
        <div class="card">
          <div class="card-header p-3 pt-2">
            
            <div class="text-end pt-1">
              <p class="text-sm mb-0 text-capitalize">Tổng Lợi nhuận</p>
              <h4 class="mb-0">{{ number_format($totalOrderPrice - $totalImport) }} VNĐ</h4>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-3">
            <p class="mb-0"><span class="text-success text-sm font-weight-bolder"></span></p>
          </div>
        </div>
      </div>
    </div>
  </div>
          {{-- @else
              <p>No data available for the selected month.</p>
          @endif --}}
  </div>
</div>
<div class="container">
    <h3>Thống kê doanh thu theo hóa đơn</h3>
  
    <form method="get">
        <label for="start_date">Ngày bắt đầu:</label>
        <input type="date" name="start_date" value="{{ $startDate }}" style="width: 150px;height: 50px;margin: 10px;padding:10px">
  
        <label for="end_date">Ngày kết thúc:</label>
        <input type="date" name="end_date" value="{{ $endDate }}" style="width: 150px;height: 50px;margin: 10px;padding:10px">
  
        <button type="submit" class="btn btn-primary">Hiện thống kê</button>
    </form>
  
    @if ($statisticData->isEmpty())
        <p>Không có dữ liệu để thống kê!</p>
    @else
        {{-- Example: Display data in a table --}}
        <table class="table table-hover table-dark" >
            <thead >
                <tr >
                    <th style="text-align: center">Ngày </th>
                    <th style="text-align: center">Số đơn hàng</th>
                    <th style="text-align: center">Tổng doanh thu trong ngày</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($statisticData as $data)
                    <tr >
                        <td style="text-align: center">{{ $data->date }}</td>
                        <td style="text-align: center">{{ number_format($data->order_count) }}</td>
                        <td style="text-align: center">{{ number_format($data->total_revenue) }} VNĐ</td>
                    </tr>
                @endforeach
            </tbody>
            
              <tr>
                  <th>Tổng cộng</th>
                  <th style="text-align: center">{{ number_format($totalOrder) }}</th>
                  <th style="text-align: center">{{ number_format($totalRevenue) }} VNĐ</th>
              </tr>
          
        </table>
  
        {{-- Example: Display data in a chart (using Chart.js) --}}
        <canvas id="statisticChart" width="400" height="200"></canvas>
  
        <script>
            var ctx = document.getElementById('statisticChart').getContext('2d');
            var labels = @json($statisticData->pluck('date'));
            var orderCountData = @json($statisticData->pluck('order_count'));
            var totalRevenueData = @json($statisticData->pluck('total_revenue'));
  
            var statisticChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Order Count',
                        data: orderCountData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Total Revenue',
                        data: totalRevenueData,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endif
</div>
 
@endsection
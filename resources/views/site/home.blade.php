<?php
use App\Models\Transaction;
use App\Helpers\GeneralHelper;
$title = 'Welcome';
$breadcrumbs = [
  ['url' => '#', 'label' => 'Home'],
];
?>

@extends('layouts.main')
@section('content')
<div class="container-fluid">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <!-- Info Box (Income) -->
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill-wave"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Income</span>
          <span class="info-box-number">{{ GeneralHelper::formatMoney($total_income) }}</span>
        </div>
      </div>
    </div>
    <!-- End of Info box -->

    <!-- Info box (Expense) -->
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-dollar-sign"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Expense</span>
          <span class="info-box-number">{{ GeneralHelper::formatMoney($total_expense) }}</span>
        </div>
      </div>
    </div>
    <!-- End of Info box -->
  </div>
  <!-- End of Small boxes (Stat box) -->

  <!-- Main row -->
  <div class="row">
    <!-- Pie Chart (Income) -->
    <div class="col-lg-6">
      <div class="card">
          <div class="card-body">
            <p class="d-flex flex-column">
              <?php
                if ($income_diff > 0) $icon = 'fa-arrow-up';
                elseif ($income_diff < 0) $icon = 'fa-arrow-down';
                else $icon = 'fa-circle';

                if ($income_diff > 0) $text_color = 'text-success';
                elseif ($income_diff < 0) $text_color = 'text-danger';
                else $text_color = 'text-secondary'; ?>

              <span class="{{ $text_color }}">
                <i class="fas {{ $icon }}"></i>
                {{ GeneralHelper::formatMoney($income_diff) }}
              </span>
              <span>Income Detail</span>
            </p>
              <div class="chartjs-size-monitor">
              <div class="chartjs-size-monitor-expand">
                <div class=""></div>
              </div>
              <div class="chartjs-size-monitor-shrink">
                <div class=""></div></div>
              </div>
              @if (!empty($income_pie))
                <canvas id="pie-chart-income" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 535px;" width="936" height="437" class="chartjs-render-monitor"></canvas>
              @else
                <div style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: flex; justify-content: center; align-items: center; text-align: center;">
                  <i class="text-secondary">Data Not Available</i>
                </div>
              @endif
          </div>
      </div>
    </div>
    <!-- End of pie chart (income) -->

    <!-- Pie Chart (Expense) -->
    <div class="col-lg-6">
      <div class="card">
          <div class="card-body">
            <p class="d-flex flex-column">
              <?php
                if ($expense_diff > 0) $icon = 'fa-arrow-up';
                elseif ($expense_diff < 0) $icon = 'fa-arrow-down';
                else $icon = 'fa-circle';

                if ($expense_diff > 0) $text_color = 'text-danger';
                elseif ($expense_diff < 0) $text_color = 'text-success';
                else $text_color = 'text-secondary';
                ?>

              <span class="{{ $text_color }}">
                <i class="fas {{ $icon }}"></i>
                {{ GeneralHelper::formatMoney($expense_diff) }}
              </span>
              <span>Expense Detail</span>
            </p>
              <div class="chartjs-size-monitor">
              <div class="chartjs-size-monitor-expand">
                <div class=""></div>
              </div>
              <div class="chartjs-size-monitor-shrink">
                <div class=""></div></div>
              </div>
              @if (!empty($expense_pie))
                <canvas id="pie-chart-expense" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 535px;" width="936" height="437" class="chartjs-render-monitor"></canvas>
              @else
                <div style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: flex; justify-content: center; align-items: center; text-align: center;">
                  <i class="text-secondary">Data Not Available</i>
                </div>
              @endif
          </div>
      </div>
    </div>
    <!-- End of pie chart (expense) -->
  </div>
  <!-- /.row (main row) -->
</div><!-- /.container-fluid -->
@endsection

@section('scripts')
<script>
  // Generate random colors for the chart
  const backgroundColors = [];
  const borderColors = [];
  const numColors = @json($income_label).length > @json($expense_label).length ? @json($income_label).length : @json($expense_label).length;
  for (let i = 0; i < numColors; i++) {
    backgroundColors.push(getRandomColor());
    borderColors.push(getRandomColor());
  }

  const pieChartIncome = document.getElementById('pie-chart-income');
  if (pieChartIncome) {
    pieChartIncome.getContext('2d');
    const setPieChart = new Chart(pieChartIncome, {
      type: 'pie',
      data: {
          labels: @json($income_label),
          datasets: [{
              label: 'Income',
              data: @json($income_pie),
              backgroundColor: @json($income_label).map(() => getRandomColor()),
              borderColor: borderColors,
              borderWidth: 1
          }]
      },
    });
  }

  const pieChartExpense = document.getElementById('pie-chart-expense');
  if (pieChartExpense) {
    pieChartExpense.getContext('2d');
    const setPieChartExpense = new Chart(pieChartExpense, {
      type: 'pie',
      data: {
        labels: @json($expense_label),
        datasets: [{
          label: 'Expense',
          data: @json($expense_pie),
          backgroundColor: backgroundColors,
          borderColor: borderColors,
          borderWidth: 1,
        }]
      }
    })
  }

  function getRandomColor() {
    const randomColor = Math.floor(Math.random()*16777215).toString(16);
    return `#${randomColor.padStart(6, '0')}`;
  }
</script>

@endsection
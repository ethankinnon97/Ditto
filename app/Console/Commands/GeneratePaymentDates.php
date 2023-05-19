<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class GeneratePaymentDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment-dates:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate payment schedules for sales staff';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $header = ['Month', 'Salary Payment Date', 'Bonus Payment Date'];
        $rows = [];

        // Generate payment dates for the next twelve months
        for ($i = 1; $i <= 12; $i++) {
            // Calculate the current month
            $currentMonth = Carbon::now()->startOfMonth()->addMonths($i - 1);
            // Format the current month as the month name
            $month = $currentMonth->format('F');
            // Calculate the salary payment date for the current month
            $salaryPaymentDate = $this->calculateSalaryPaymentDate($currentMonth);
            // Calculate the bonus payment date for the current month
            $bonusPaymentDate = $this->calculateBonusPaymentDate($currentMonth);
            // Add the month, salary payment date, and bonus payment date to the rows array
            $rows[] = [$month, $salaryPaymentDate, $bonusPaymentDate];
            // Move to the next month
            $currentMonth->addMonth();
        }


        try {
      // Get the current year
      $currentYear = Carbon::now()->year;
      // Create the filename for the CSV file by appending the current year
      $filename = 'payment_dates_' . $currentYear . '.csv';
      // Get the full path to the CSV file using the 'local' storage disk
      $path = Storage::disk('local')->path($filename);
      // Open the file in write mode and get the file handle
      $file = fopen($path, 'w');

      if (!$file) {
          throw new Exception('Failed to open file for writing.');
      }

      // Write the header row to the CSV file
      fputcsv($file, $header);

      // Iterate over each row in the rows array
      foreach ($rows as $row) {
          // Write each row of data to the CSV file
          fputcsv($file, $row);
      }
      // Close the file handle
      fclose($file);
      $this->info('Payment dates generated successfully. File saved at: ' . $path);
  } catch (Exception $e) {
      $this->error('Failed to generate payment dates: ' . $e->getMessage());
  }
    }

    /**
     * Calculate the salary payment date for the given month.
     *
     * @param  \Carbon\Carbon  $month
     * @return string
     */
    private function calculateSalaryPaymentDate($month)
    {
        // Get the last day of the month
        $lastDayOfMonth = $month->endOfMonth();

        // Adjust the salary payment date if it falls on a weekend
        if ($lastDayOfMonth->isWeekend()) {
            $lastDayOfMonth = $lastDayOfMonth->previous(Carbon::FRIDAY);
        }

        return $lastDayOfMonth->format('Y-m-d');
    }

    /**
     * Calculate the bonus payment date for the given month.
     *
     * @param  \Carbon\Carbon  $month
     * @return string
     */
    private function calculateBonusPaymentDate($month)
    {
        // Set the bonus payment date to the 15th of the month
        $bonusPaymentDate = $month->setDay(15);

        // Adjust the bonus payment date if it falls on a weekend
        if ($bonusPaymentDate->isWeekend()) {
            $bonusPaymentDate = $bonusPaymentDate->next(Carbon::WEDNESDAY);
        }

        return $bonusPaymentDate->format('Y-m-d');
    }
}

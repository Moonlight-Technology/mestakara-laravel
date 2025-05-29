<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;

class BookingsExport implements FromCollection, WithEvents
{
    protected $bookings;
    protected $startDate;
    protected $endDate;
    protected $date;

    public function __construct($bookings, $startDate, $endDate)
    {
        $this->bookings = $bookings;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->date = "";
    }

    /**
     * Mengambil data untuk diekspor
     */
    public function collection()
{
    $sortedBookings = $this->bookings->sortBy(function($booking) {
        return Carbon::parse($booking->updated_at);
    });

    $currentDate = null;
    $counter = 0;

    return $sortedBookings->map(function($booking) use (&$currentDate, &$counter) {
        $bookingDate = Carbon::parse($booking->updated_at)->format('d-m-Y');

        // Reset counter if it's a new day
        if ($bookingDate !== $currentDate) {
            $currentDate = $bookingDate;
            $counter = 1;
        } else {
            $counter++;
        }
        
        // Calculate tax and set admin fee
        $tax = $booking->total_before_discount * 0.10;
        $admin = 45000;

        return [
            'updated_at'  => $booking->updated_at ? Carbon::parse($booking->updated_at)->format('d-m-Y') : null,
            'no'          => $counter, // Reset and increment counter per day
            'code'        => $booking->code,
            'name'        => $booking->first_name . ' ' . $booking->last_name,
            'address'     => $booking->address,
            'service'     => $booking->service->title,
            'kamar'     => $booking->service->title,
            'qty'     => '',
            'total_before_discount' => $booking->total_before_discount,
            'discount'    => $booking->coupon_amount,
            'tax'    => $tax,
            'admin'    => $admin,
            'total'       => $booking->paid,
            'payment'     => $booking->gateway,
            'start_date'  => $booking->start_date ? Carbon::parse($booking->start_date)->format('d-m-Y') : null,
            'end_date'    => $booking->end_date ? Carbon::parse($booking->end_date)->format('d-m-Y') : null,
            'status'      => $booking->status,
        ];
    });
}


    /**
     * Event untuk memodifikasi sheet Excel setelah data ditulis
     */
    public function registerEvents(): array
    {
        if (!isset($this->startDate) && !isset($this->endDate)) {
            $this->date = Carbon::now()->format('d-m-Y');
        } else {
            $this->date = $this->startDate . ' sampai ' . $this->endDate;
        }

        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Menulis header di A1
                $event->sheet->setCellValue('A1', 'Laporan Transaksi ' . $this->date);
                
                // Menggabungkan sel dari A1 sampai dengan K1 (berdasarkan jumlah kolom yang ada)
                $event->sheet->mergeCells('A1:Q1');

                // Styling heading di A1 (opsional)
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Menambahkan heading di A2
                $event->sheet->setCellValue('A2', 'Mestakara');
                $event->sheet->mergeCells('A2:Q2');
                $event->sheet->getStyle('A2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 20,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Set auto size for columns
                foreach (range('A', 'Q') as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }

                // Menambahkan heading di A3 dengan nama kolom baru
                $event->sheet->setCellValue('A3', 'TGL & BULAN BOOKING');
                $event->sheet->setCellValue('B3', 'NO');
                $event->sheet->setCellValue('C3', 'INVOICE');
                $event->sheet->setCellValue('D3', 'NAMA CUSTOMER');
                $event->sheet->setCellValue('E3', 'ALAMAT');
                $event->sheet->setCellValue('F3', 'JENIS PRODUK');
                $event->sheet->setCellValue('G3', 'KAMAR');
                $event->sheet->setCellValue('H3', 'QTY');
                $event->sheet->setCellValue('I3', 'HARGA');
                $event->sheet->setCellValue('J3', 'DISCOUNT');
                $event->sheet->setCellValue('K3', 'TAX ROOM');
                $event->sheet->setCellValue('L3', 'ADMIN');
                $event->sheet->setCellValue('M3', 'TOTAL BAYAR');
                $event->sheet->setCellValue('N3', 'METODE');
                $event->sheet->setCellValue('O3', 'CHECK IN');
                $event->sheet->setCellValue('P3', 'CHECK OUT');
                $event->sheet->setCellValue('Q3', 'KETERANGAN');
                
                // Menambahkan styling untuk heading di A3
                $event->sheet->getStyle('A3:Q3')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);

                // Memindahkan data mulai dari A4
                $data = $this->collection();
                $rowIndex = 4; // Data dimulai dari A4
                foreach ($data as $row) {
                    $event->sheet->setCellValue('A' . $rowIndex, $row['updated_at']);
                    $event->sheet->setCellValue('B' . $rowIndex, $row['no']);
                    $event->sheet->setCellValue('C' . $rowIndex, $row['code']);
                    $event->sheet->setCellValue('D' . $rowIndex, $row['name']);
                    $event->sheet->setCellValue('E' . $rowIndex, $row['address']);
                    $event->sheet->setCellValue('F' . $rowIndex, $row['service']); // Display service title only
                    $event->sheet->setCellValue('G' . $rowIndex, $row['kamar']);
                    $event->sheet->setCellValue('H' . $rowIndex, $row['qty']);
                    $event->sheet->setCellValue('I' . $rowIndex, $this->formatRupiah($row['total_before_discount']));
                    $event->sheet->setCellValue('J' . $rowIndex, $this->formatRupiah($row['discount']));
                    $event->sheet->setCellValue('K' . $rowIndex, $this->formatRupiah($row['tax']));
                    $event->sheet->setCellValue('L' . $rowIndex, $this->formatRupiah($row['admin']));
                    $event->sheet->setCellValue('M' . $rowIndex, $this->formatRupiah($row['total']));
                    $event->sheet->setCellValue('N' . $rowIndex, $row['payment']);
                    $event->sheet->setCellValue('O' . $rowIndex, $row['start_date']);
                    $event->sheet->setCellValue('P' . $rowIndex, $row['end_date']);
                    $event->sheet->setCellValue('Q' . $rowIndex, $row['status']);
                    $rowIndex++;
                }
            }
        ];
    }

    /**
     * Format Rupiah untuk kolom Total dan Paid
     */
    function formatRupiah($angka) {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}

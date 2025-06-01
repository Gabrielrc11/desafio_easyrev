<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Price;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoomsAndPricesSeeder extends Seeder
{
    public function run()
    {
        $rooms = [
            ['name' => 'Quarto Standard 101', 'type' => 'Standard'],
            ['name' => 'Quarto Deluxe 201', 'type' => 'Deluxe'],
            ['name' => 'Suíte Presidencial', 'type' => 'Suite'],
        ];

        foreach ($rooms as $roomData) {
            $room = Room::create($roomData);

            // Criar preços históricos
            $days = 30;
            for ($i = 0; $i < $days; $i++) {
                $date = Carbon::now()->subDays($days - $i);
                $isWeekend = $date->isWeekend();
                $occupancy = rand(60, 95);
                
                $basePrice = $this->getBasePrice($room->type);
                $price = $this->calculatePredictedPrice(
                    $basePrice,
                    $occupancy,
                    $room->type,
                    $isWeekend
                );

                Price::create([
                    'room_id' => $room->id,
                    'price' => $price,
                    'effective_date' => $date,
                    'occupancy_rate' => $occupancy,
                    'is_holiday_or_weekend' => $isWeekend,
                ]);
            }
        }
    }

    private function getBasePrice($type)
    {
        return match($type) {
            'Standard' => 300.00,
            'Deluxe' => 450.00,
            'Suite' => 600.00,
            default => 300.00,
        };
    }

    private function calculatePredictedPrice($basePrice, $occupancyRate, $roomType, $isHolidayOrWeekend)
    {
        if ($occupancyRate > 80) {
            $basePrice *= 1.10;
        } else {
            $basePrice *= 0.95;
        }

        switch ($roomType) {
            case 'Suite':
                $basePrice *= 1.15;
                break;
            case 'Deluxe':
                $basePrice *= 1.10;
                break;
        }

        if ($isHolidayOrWeekend) {
            $basePrice *= 1.20;
        }

        return round($basePrice, 2);
    }
}
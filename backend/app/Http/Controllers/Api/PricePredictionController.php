<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Models\Room;
use Illuminate\Http\Request;

class PricePredictionController extends Controller
{
    public function getRoomsWithPrices()
    {
        $rooms = Room::with('prices')->get();
        return response()->json($rooms);
    }

    public function predictPrice(Request $request, $roomId)
    {
        $request->validate([
            'occupancy_rate' => 'required|numeric|between:0,100',
            'is_holiday_or_weekend' => 'required|boolean',
        ]);

        $room = Room::findOrFail($roomId);
        $latestPrice = $room->prices()->latest('effective_date')->firstOrFail();

        $predictedPrice = $this->calculatePredictedPrice(
            $latestPrice->price,
            $request->occupancy_rate,
            $room->type,
            $request->is_holiday_or_weekend
        );

        return response()->json([
            'predicted_price' => $predictedPrice,
            'room_type' => $room->type,
            'current_price' => $latestPrice->price,
        ]);
    }

    private function calculatePredictedPrice($basePrice, $occupancyRate, $roomType, $isHolidayOrWeekend)
    {
        // Ajuste por ocupação
        if ($occupancyRate > 80) {
            $basePrice *= 1.10; // Aumento de 10%
        } else {
            $basePrice *= 0.95; // Redução de 5%
        }

        // Ajuste por tipo de quarto
        switch ($roomType) {
            case 'Suite':
                $basePrice *= 1.15;
                break;
            case 'Deluxe':
                $basePrice *= 1.10;
                break;
            // Standard não tem ajuste
        }

        // Ajuste por feriado/fim de semana
        if ($isHolidayOrWeekend) {
            $basePrice *= 1.20;
        }

        return round($basePrice, 2);
    }
}
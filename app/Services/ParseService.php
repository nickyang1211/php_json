<?php

namespace App\Services;
use Illuminate\Support\Carbon;
use DateTime;
use Illuminate\Support\Collection;


class ParseService
{
    private function getData()
    {
        return file_get_contents(storage_path('original.json'));
    }

    public function parse()
    {
        $data = $this->getData();
        $json = json_decode($data);
        $solutions = collect($json->legs[0]->solutions);
        $products = collect($json->products);
        $offers = collect($json->offers);
        $rows = $offers->map(function ($offer) use ($solutions, $products) {
            $solution = $solutions->firstWhere('id', $offer->legSolution);
            $segment = data_get($solution, 'segments.0');
            $offerId = $offer->id;
            $legId = $offer->legSolution;
            $depCode = data_get($segment, 'origin.label');
            $arrCode = data_get($segment,'destination.label');
            $departure = Carbon::parse($solution->departure)->format('Ymd H:i');
            $arrival = Carbon::parse($solution->arrival)->format('Ymd H:i');
            $segmentIds = data_get($segment,'id');
            $segments = data_get($segment,'vehicle.code') . data_get($segment,'vehicle.reference') . $depCode . $departure . $arrival . $arrCode;
            $travelerProduct = implode(data_get($offer, 'fareOffers.0.fares.0.travelers')) . ':' . data_get($offer, 'fareOffers.0.fares.0.productCode');
            $travelerPrice = implode(data_get($offer, 'fareOffers.0.fares.0.travelers')) . ':' . data_get($offer, 'fareOffers.0.prices.billings.0.billingPrice.amount.value');
            $category = data_get($offer, 'comfortCategory.label');
            $flexibility = $products->firstWhere('code', data_get($offer, 'fareOffers.0.fares.0.productCode'))->label;
            $kkdayTicketKey = '';
            $kkdayFareList = 'ALL:' . data_get($offer, 'fareOffers.0.prices.billings.0.billingPrice.amount.value');

            return [
                "offerId"=> $offerId,
                "legId"=> $legId,
                "depCode"=> $depCode,
                "arrCode"=> $arrCode,
                "departure"=> $departure,
                "arrival"=> $arrival,
                "compatibleOffers"=> "",
                "segmentIds"=> $segmentIds,
                "segments"=> $segments,
                "travelerProduct"=> $travelerProduct,
                "travelerPrice"=> $travelerPrice,
                "category"=> $category,
                "flexibility"=> $flexibility,
                "kkdayTicketKey"=> "",
                "kkdayFareList"=> $kkdayFareList
            ];
        });
    return $rows;
    }
}
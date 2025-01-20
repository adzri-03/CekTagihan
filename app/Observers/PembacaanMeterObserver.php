<?php

namespace App\Observers;

use App\Models\PembacaanMeter;
use App\Models\RiwayatPetugas;

class PembacaanMeterObserver
{
    /**
     * Handle the PembacaanMeter "created" event.
     */
    public function created(PembacaanMeter $pembacaanMeter): void
    {
        RiwayatPetugas::create([
            'user_id' => auth('web')->id(), // ID petugas yang sedang login
            'deskripsi' => 'Membuat pembacaan meter untuk pelanggan ' . $pembacaanMeter->customer->name,
            'jenis_tindakan' => 'create',
            'related_id' => $pembacaanMeter->id,
        ]);
    }

    /**
     * Handle the PembacaanMeter "updated" event.
     */
    public function updated(PembacaanMeter $pembacaanMeter): void
    {
        //
    }

    /**
     * Handle the PembacaanMeter "deleted" event.
     */
    public function deleted(PembacaanMeter $pembacaanMeter): void
    {
        //
    }

    /**
     * Handle the PembacaanMeter "restored" event.
     */
    public function restored(PembacaanMeter $pembacaanMeter): void
    {
        //
    }

    /**
     * Handle the PembacaanMeter "force deleted" event.
     */
    public function forceDeleted(PembacaanMeter $pembacaanMeter): void
    {
        //
    }
}

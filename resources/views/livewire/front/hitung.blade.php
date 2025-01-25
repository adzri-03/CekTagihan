@extends('layouts.master')
@section('content')
    <section class="max-w-[640px] w-full mx-auto">
        <h2 class="text-lg font-bold">Form Pengisian</h2>
        <p>ID Customer: {{ $customerId }}</p>
        <form>
            <!-- Tambahkan field sesuai kebutuhan -->
            <div class="mt-4">
                <label for="meterAkhir" class="block">Meter Akhir</label>
                <input type="number" id="meterAkhir" class="w-full border rounded px-2 py-1">
            </div>
            <button type="submit" class="mt-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                Submit
            </button>
        </form>
    </section>
@endsection

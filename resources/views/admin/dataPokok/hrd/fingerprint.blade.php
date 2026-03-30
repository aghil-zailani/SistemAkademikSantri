@extends('layouts.main')
@section('title', 'Data Fingerprint HRD')
@section('content')

<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-base font-semibold text-gray-700">Data Fingerprint HRD</h2>
    </div>

    <form action="{{ route('hrd.updateFingerprint') }}" method="POST">
        @csrf
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 w-12">No</th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4 w-1/4">Mesin</th>
                        <th class="px-6 py-4 w-1/4">Fingerprint ID</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @foreach($hrds as $index => $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">{{ $index + 1 }}</td>
                        <td class="px-6 py-3 font-medium">{{ $item->name }}</td>
                        <td class="px-6 py-3">
                            <select name="fingerprints[{{ $item->id }}][mesin]" class="w-full border-gray-300 rounded border p-1.5 text-sm focus:border-blue-500 text-gray-600 bg-white">
                                <option value="">-- Pilih Mesin --</option>
                                <option value="PIAT12-01" {{ $item->mesin_fingerprint == 'PIAT12-01' ? 'selected' : '' }}>PIAT12-01</option>
                                <option value="PIAT12-02" {{ $item->mesin_fingerprint == 'PIAT12-02' ? 'selected' : '' }}>PIAT12-02</option>
                            </select>
                        </td>
                        <td class="px-6 py-3">
                            <input type="text" name="fingerprints[{{ $item->id }}][id]" value="{{ $item->fingerprint_id }}" class="w-full border-gray-300 rounded border p-1.5 text-sm focus:border-blue-500 text-gray-600 bg-white">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="bg-gray-50 p-4 border-t border-gray-200 flex justify-end">
            <button type="submit" class="bg-[#0056b3] text-white px-6 py-2 rounded text-sm font-medium hover:bg-blue-700 transition flex items-center gap-2">
                <i class="fas fa-save"></i> Simpan Fingerprint
            </button>
        </div>
    </form>
</div>
@endsection
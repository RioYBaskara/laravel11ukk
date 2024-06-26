@extends('layouts.adm-main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 bg-light text-left">
            <a href="{{ route('kategori.create') }}" class="btn btn-md btn-success btn-sm pull-right">TAMBAH</a>
        </div>
        <div class="col-md-6 bg-light text-right">
        <a href="{{ route('kategori.create') }}" class="btn btn-md btn-success btn-sm pull-right">TAMBAH</a>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('kategori.create') }}" class="btn btn-md btn-success mb-3">TAMBAH KATEGORI</a>
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>DESKRIPSI</th>
                        <th>KATEGORI</th>
                        <th style="width: 15%">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $kategoriMap = [
                            'M' => 'Modal',
                            'A' => 'Alat',
                            'BHP' => 'Bahan Habis Pakai',
                            'BTHP' => 'Bahan Tidak Habis Pakai',
                        ];
                    @endphp
                    @forelse ($rsetKategori as $rowkategori)
                        <tr>
                            <td>{{ $rowkategori->id }}</td>
                            <td>{{ $rowkategori->deskripsi }}</td>
                            <td>{{ $kategoriMap[$rowkategori->kategori] ?? $rowkategori->kategori }}</td>
                            <td class="text-center">
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('kategori.destroy', $rowkategori->id) }}" method="POST">
                                    <a href="{{ route('kategori.show', $rowkategori->id) }}" class="btn btn-sm btn-dark"><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('kategori.edit', $rowkategori->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil-alt"></i></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <div class="alert">
                            Data Kategori belum tersedia
                        </div>
                    @endforelse
                </tbody>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('Gagal'))
                    <div class="alert alert-danger">
                        {{ session('Gagal') }}
                    </div>
                @endif
            </table>
            {{-- {{ $kategori->links() }} --}}
        </div>
    </div>
</div>
@endsection

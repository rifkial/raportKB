@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.loader.loader_css')
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/account-setting.css') }}">
    @endpush
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">

            <div class="page-meta mt-3">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent">
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Siswa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">List</li>
                    </ol>
                </nav>
            </div>

            <div class="row" id="cancel-row">

                <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12 d-flex justify-content-between">
                                    <h4>{{ session('title') }}</h4>
                                    @if (Auth::guard('admin')->check())
                                        <div class="form-group row my-auto mx-3">
                                            <label for="inputUsername" class="col-auto col-form-label my-auto">Pilih
                                                Kelas</label>
                                            <div class="col">
                                                <select name="id_class" id="id_class" class="form-control"
                                                    data-type="{{ $type }}">
                                                    <option value="" selected disabled>-- Pilih Kelas --</option>
                                                    @foreach ($classes as $class)
                                                        <option value="{{ $class['slug'] }}"
                                                            {{ isset($_GET['study_class']) && $_GET['study_class'] == $class['slug'] ? 'selected' : '' }}>
                                                            {{ $class['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('setting_scores.assesment_weight.storeOrUpdate') }}" method="post">
                            @csrf
                            <div class="widget-content widget-content-area br-8">
                                <table id="table-list" class="table dt-table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Guru Mapel</th>
                                            <th>Bobot SAM (Sumatif Akhir Materi)</th>
                                            <th>Bobot Sumatif</th>
                                            <th>Bobot UTS</th>
                                            @if ($type == 'uas')
                                                <th>Bobot SAS</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <input type="hidden" name="type" value="{{ $type }}">
                                    <tbody>
                                        @if (isset($_GET['study_class']))
                                            @foreach ($result as $index => $data)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $data['course'] }}</td>
                                                    <td>{{ $data['teacher'] }}</td>
                                                    <input type="hidden" name="id_teacher[]"
                                                        value="{{ $data['id_teacher'] }}">
                                                    <input type="hidden" name="id_course[]"
                                                        value="{{ $data['id_course'] }}">
                                                    <input type="hidden" name="id_study_class[]"
                                                        value="{{ $data['id_study_class'] }}">
                                                    <td>
                                                        <input type="number" name="formative_weight[]" class="form-control"
                                                            value="{{ old('formative_weight.' . $index, $data['formative_weight']) }}">
                                                        @error('formative_weight.' . $index)
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="number" name="sumative_weight[]" class="form-control"
                                                            value="{{ old('sumative_weight.' . $index, $data['sumative_weight']) }}">
                                                        @error('sumative_weight.' . $index)
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input type="number" name="uts_weight[]" class="form-control"
                                                            value="{{ old('uts_weight.' . $index, $data['uts_weight']) }}">
                                                        @error('uts_weight.' . $index)
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    @if ($type == 'uas')
                                                        <td>
                                                            <input type="number" name="uas_weight[]" class="form-control"
                                                                value="{{ old('uas_weight.' . $index, $data['uas_weight']) }}">
                                                            @error('uas_weight.' . $index)
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                            @error('total_weight.' . $index)
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </td>
                                                    @endif

                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center">Harap masukan filter kelas terlebih
                                                    dahulu untuk menampilkan data</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="account-settings-footer">

            <div class="as-footer-container">

                <button id="multiple-reset" class="btn btn-warning">Reset All</button>
                <div class="blockui-growl-message">
                    <i class="flaticon-double-check"></i>&nbsp; Settings Saved Successfully
                </div>


                <button class="btn btn-primary d-none" id="btnLoader">
                    <div class="spinner-grow text-white mr-2 align-self-center loader-sm">
                        Loading...</div>
                    Loading
                </button>
                <button class="btn btn-primary" id="btnSubmit" onclick="submitForm()">Simpan
                    Data</button>

            </div>

        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $("form").submit(function() {
                    $('#btnLoader').removeClass('d-none');
                    $('#btnSubmit').addClass('d-none');
                });

                $('#id_class').change(function() {
                    var type = $(this).data('type'); // Ambil nilai type dari data-type attribute
                    var studyClass = $(this).val(); // Ambil nilai id_class yang dipilih

                    // Bangun URL baru dengan menggunakan nilai type dan study_class
                    var newUrl = type + '?study_class=' + studyClass;

                    // Arahkan ke URL baru
                    window.location.href = newUrl;
                });


            });

            function submitForm() {
                $('form').submit();
            }
        </script>
    @endpush
@endsection

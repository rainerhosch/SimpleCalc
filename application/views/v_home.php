<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>ProUI - Responsive Bootstrap Admin Template</title>

        <meta name="description" content="ProUI is a Responsive Bootstrap Admin Template created by pixelcave and published on Themeforest.">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0">
        <link rel="shortcut icon" href="<?= base_url('assets') ?>/img/favicon.png">
        <link rel="apple-touch-icon" href="<?= base_url('assets') ?>/img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="<?= base_url('assets') ?>/img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="<?= base_url('assets') ?>/img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="<?= base_url('assets') ?>/img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="<?= base_url('assets') ?>/img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="<?= base_url('assets') ?>/img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="<?= base_url('assets') ?>/img/icon152.png" sizes="152x152">
        <link rel="apple-touch-icon" href="<?= base_url('assets') ?>/img/icon180.png" sizes="180x180">
        <link rel="stylesheet" href="<?= base_url('assets') ?>/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url('assets') ?>/css/plugins.css">
        <link rel="stylesheet" href="<?= base_url('assets') ?>/css/main.css">
        <link rel="stylesheet" href="<?= base_url('assets') ?>/css/themes.css">
        <script src="<?= base_url('assets') ?>/js/vendor/modernizr.min.js"></script>
        
        <script src="<?= base_url('assets') ?>/js/vendor/jquery.min.js"></script>
        <script src="<?= base_url('assets') ?>/js/vendor/bootstrap.min.js"></script>
        <script src="<?= base_url('assets') ?>/js/plugins.js"></script>
        <script src="<?= base_url('assets') ?>/js/app.js"></script>
        <style>
            .full-page-container{
                top: 153px;
                background-color: rgb(0 0 0 / 18%);
            }
        </style>
    </head>
    <body>
        <img src="<?= base_url('assets') ?>/img/placeholders/backgrounds/coming_soon_full_bg.jpg" alt="Coming Soon Background" class="animation-pulseSlow full-bg">
        <div class="full-page-container text-center">
            <h1 class="text-light"><i class="gi gi-flash"></i> Kalkulator Trasfer Data Saluran BUS</h1>
            <h4 class="h3 text-light">Sistem perhitungan transferdata pada saluran bus!</h4>
            <hr>
            <div class="row"  style="margin-bottom:20px;">
                <form id="form_konverter">
                    <div class="row">
                        <div class="form-row" style="margin-bottom:50px;">
                        <div class="col-md-3 text-light">
                                <label for="">Ukuran Data</label>
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="form-control" id="input_ukuran_data" placeholder="Ukuran data">
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" id="unit_for_data">
                                <option value="bit">Bit</option>
                                <option value="byte">Byte</option>
                                <option value="kb">KB</option>
                                <option value="mb">MB</option>
                                <option value="gb">GB</option>
                                <option value="tb">TB</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-row" style="margin-bottom:50px;">
                            <div class="col-md-3 text-light">
                                <label for="">Lebar BUS</label>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control" id="lebar_bus">
                                    <option value="8">8 Bit</option>
                                    <option value="16">16 Bit</option>
                                    <option value="32">32 Bit</option>
                                    <option value="64">64 Bit</option>
                                    <option value="128">128 Bit</option>
                                    <option value="256">256 Bit</option>
                                    <option value="512">512 Bit</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <button type="button" class="btn btn-info btn-sm btn_submit" disabled>Hitung</button>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="alert alert-info alert-dismissable" hidden>
                    
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                var ukuran_data = $('#input_ukuran_data').val();
                $('#input_ukuran_data').on('change', function(){
                    ukuran_data = $(this).val();
                    
                    if(ukuran_data === '' || ukuran_data > 0){
                        $('.btn_submit').attr('disabled', false);
                    }else{
                        $('.btn_submit').attr('disabled', true);
                    }
                });
                $(".btn_submit").click(function(e) {
                    let satuan_data = $('#unit_for_data').val()
                    let lebar_bus = $('#lebar_bus').val()
                    let data_hitung_trf = 1;
                    let i= 0;

                    $.ajax({
                        type: "POST",
                        url: "<?=base_url()?>welcome/bus_transfer_calculation",
                        data: {
                            data_size: ukuran_data,
                            data_unit: satuan_data
                        },
                        dataType: "json",
                        success: function (response) {
                            let data = response.data
                            let html=``;
                            console.log(response)
                            
                            if(data.format_binary > lebar_bus){
                                data_hitung_trf = (data.format_binary/lebar_bus);
                                if(!Number.isInteger(data_hitung_trf)){
                                    data_hitung_trf = parseInt(data_hitung_trf)+1
                                }
                            }

                            html += `<table class="table">
                            <tbody>
                                <tr>
                                <th scope="row">1</th>
                                <td>JUMLAH DATA <i>(Desimal)</i></td>
                                <td>${parseInt(data.format_desimal).toLocaleString()} Bit</td>
                                </tr>
                                <tr>
                                <th scope="row">2</th>
                                <td>JUMLAH DATA <i>(Binary)</i></td>
                                <td>${parseInt(data.format_binary).toLocaleString()} Bit</td>
                                </tr>
                            </tbody>
                            </table>
                            <h4>Pengiriman data dilakukan sebanyak : <strong>${parseInt(data_hitung_trf).toLocaleString()}</strong> kali pengiriman</h4>`;
                            $('.alert').attr('hidden', false)
                            $('.alert').html(html)
                        }
                    });
                })
            })
        </script>
    </body>
</html>
@extends('layouts.dashboard')

@section('content')
<!-- begin:: Content -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="home-tab">

                    <div class="card card-rounded" style="border:1px black dashed;">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                    <h4 class="card-title card-title-dash">Daily Reports</h4>
                                </div>
                                <div>

                                    <div style="margin-top:-10px;">
                                        <select id="alldepartments" onchange="showReport()" class="btn btn-default">
                                            <option value="0">Laboratory Report</option>
                                            <option value="1">Pharmacy Report</option>
                                            <option value="2">Radiology Report</option>
                                            <option value="3">Dialysis Report</option>
                                        </select>

                                        <button onclick="refresh()" class="btn btn-dark text-white"><span
                                                class="iconify fs-20"
                                                data-icon="uim:refresh"></span>&nbsp;Refresh</button>
                                    </div>
                                </div>

                            </div>
                            <div class="mt-1">



                                <div id="laboratory_report">
                                    <button class="btn btn-info export-btn" data-table-id="table1"><span class="iconify fs-20"
                                            data-icon="vscode-icons:file-type-excel"></span>&nbsp;Export to
                                        Excel</button>
                                    @if(count($laboratories) > 0)
                                    <table class="table select-table export-table" id="table1">
                                        <thead>
                                            <tr>
                                                <th>Test</th>
                                                <th>Category</th>
                                                <th>Quantity</th>
                                                <th>Amount</th>
                                                <th>Subtotal</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $grand_total = 0;
                                            $current_date = null;
                                            @endphp
                                            @foreach($laboratories as $laboratory)
                                            @php
                                            // Check if we need to display a new date row
                                            if($current_date !== $laboratory->date_created){
                                            // If this is not the first row, output the grand total for the previous date
                                            if($current_date !== null){
                                            echo "<tr>
                                                <td colspan=\"3\"><strong>DATE:</strong>$current_date</td>
                                                <td style='text-align:right;' colspan=\"1\"><strong>GRAND
                                                        TOTAL:</strong></td>
                                                <td>$format_total</td>
                                            </tr>";
                                            }
                                            // Reset the grand total and update the current date
                                            $grand_total = 0;
                                            $current_date = $laboratory->date_created;
                                            }
                                            // Update the grand total
                                            $grand_total += $laboratory->qty * $laboratory->purchase_amount;
                                            $format_total = number_format($grand_total ,2);
                                            @endphp
                                            <tr>
                                                <td>
                                                    <p>{{$laboratory->test}}</p>
                                                </td>
                                                <td>
                                                    <p>{{$laboratory->name}}</p>
                                                </td>
                                                <td>
                                                    <p>{{$laboratory->qty}}</p>
                                                </td>
                                                <td>
                                                    <p>{{ number_format($laboratory->purchase_amount,2) }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ number_format($laboratory->qty *
                                                        $laboratory->purchase_amount,2) }}</p>
                                                </td>

                                            </tr>
                                            @endforeach
                                            <!-- Output the grand total for the last date  -->
                                            <tr class="border-0">
                                                <td colspan="3"><strong>DATE:</strong>{{ $current_date }}</td>
                                                <td style='text-align:right;' colspan="1"><strong>GRAND TOTAL:</strong>
                                                </td>
                                                <td>{{ number_format($grand_total,2) }}</td>


                                            </tr>
                                        </tbody>
                                    </table>
                                    @else
                                    <br>
                                    <small>No Data for Laboratories Report</small>
                                    @endempty
                                </div>

                            
                                <div id="pharmacy_report" style="display:none;">
                                    <button class="btn btn-info export-btn" data-table-id="table2"><span class="iconify fs-20"
                                            data-icon="vscode-icons:file-type-excel"></span>&nbsp;Export to
                                        Excel</button>
                                    @if(count($pharmacies) > 0)
                                    <table class="table select-table export-table" id="table2">
                                        <thead>
                                            <tr>
                                                <th>Medicine</th>
                                                <th>Category</th>
                                                <th>Quantity</th>
                                                <th>Amount</th>
                                                <th>Subtotal</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $grand_total = 0;
                                            $current_date = null;
                                            @endphp
                                            @foreach($pharmacies as $pharmacy)
                                            @php
                                            // Check if we need to display a new date row
                                            if($current_date !== $pharmacy->date_created){
                                            // If this is not the first row, output the grand total for the previous date
                                            if($current_date !== null){
                                            echo "<tr>
                                                <td colspan=\"3\"><strong>DATE:</strong>$current_date</td>
                                                <td style='text-align:right;' colspan=\"1\"><strong>GRAND
                                                        TOTAL:</strong></td>
                                                <td>$format_total</td>
                                            </tr>";
                                            }
                                            // Reset the grand total and update the current date
                                            $grand_total = 0;
                                            $current_date = $pharmacy->date_created;
                                            }
                                            // Update the grand total
                                            $grand_total += $pharmacy->qty * $pharmacy->purchase_amount;
                                            $format_total = number_format($grand_total ,2);
                                            @endphp
                                            <tr>
                                                <td>
                                                    <p>{{$pharmacy->medicine}}</p>
                                                </td>
                                                <td>
                                                    <p>{{$pharmacy->name}}</p>
                                                </td>
                                                <td>
                                                    <p>{{$pharmacy->qty}}</p>
                                                </td>
                                                <td>
                                                    <p>{{ number_format($pharmacy->purchase_amount,2) }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ number_format($pharmacy->qty * $pharmacy->purchase_amount,2)
                                                        }}</p>
                                                </td>

                                            </tr>
                                            @endforeach
                                            <!-- Output the grand total for the last date  -->
                                            <tr class="border-0">
                                                <td colspan="3"><strong>DATE:</strong>{{ $current_date }}</td>
                                                <td style='text-align:right;' colspan="1"><strong>GRAND TOTAL:</strong>
                                                </td>
                                                <td>{{ number_format($grand_total,2) }}</td>


                                            </tr>
                                        </tbody>
                                    </table>
                                    @else
                                    <br>
                                    <small>No data for Pharmacy Report</small>
                                    @endempty
                                  
                                </div>

                                <div id="radiology_report" style="display:none;">
                                  <button class="btn btn-info export-btn" data-table-id="table3"><span class="iconify fs-20"
                                            data-icon="vscode-icons:file-type-excel"></span>&nbsp;Export to
                                        Excel</button>
                                    @if(count($radiologies) > 0)
                                    <table class="table select-table export-table" id="table3">
                                        <thead>
                                            <tr>
                                                <th>Test</th>
                                                <th>Category</th>
                                                <th>Quantity</th>
                                                <th>Amount</th>
                                                <th>Subtotal</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $grand_total = 0;
                                            $current_date = null;
                                            @endphp
                                            @foreach($radiologies as $radiology)
                                            @php
                                            // Check if we need to display a new date row
                                            if($current_date !== $radiology->date_created){
                                            // If this is not the first row, output the grand total for the previous date
                                            if($current_date !== null){
                                            echo "<tr>
                                                <td colspan=\"3\"><strong>DATE:</strong>$current_date</td>
                                                <td style='text-align:right;' colspan=\"1\"><strong>GRAND
                                                        TOTAL:</strong></td>
                                                <td>$format_total</td>
                                            </tr>";
                                            }
                                            // Reset the grand total and update the current date
                                            $grand_total = 0;
                                            $current_date = $radiology->date_created;
                                            }
                                            // Update the grand total
                                            $grand_total += $radiology->qty * $radiology->purchase_amount;
                                            $format_total = number_format($grand_total ,2);
                                            @endphp
                                            <tr>
                                                <td>
                                                    <p>{{$radiology->test}}</p>
                                                </td>
                                                <td>
                                                    <p>{{$radiology->name}}</p>
                                                </td>
                                                <td>
                                                    <p>{{$radiology->qty}}</p>
                                                </td>
                                                <td>
                                                    <p>{{ number_format($radiology->purchase_amount,2) }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ number_format($radiology->qty *
                                                        $radiology->purchase_amount,2) }}</p>
                                                </td>

                                            </tr>
                                            @endforeach
                                            <!-- Output the grand total for the last date  -->
                                            <tr class="border-0">
                                                <td colspan="3"><strong>DATE:</strong>{{ $current_date }}</td>
                                                <td style='text-align:right;' colspan="1"><strong>GRAND TOTAL:</strong>
                                                </td>
                                                <td>{{ number_format($grand_total,2) }}</td>


                                            </tr>
                                        </tbody>
                                    </table>
                                    @else
                                    <br>
                                    <small>No Data for Radiologies Report</small>
                                    @endempty
                                </div>

                                <div id="dialysis_report" style="display:none;">
                                <button class="btn btn-info export-btn" data-table-id="table4"><span class="iconify fs-20"
                                            data-icon="vscode-icons:file-type-excel"></span>&nbsp;Export to
                                        Excel</button>
                                    
                                    @if(count($hemodialysis) > 0)
                                    <table class="table select-table export-table" id="table4">
                                        <thead>
                                            <tr>
                                                <th>Test</th>
                                                <th>Category</th>
                                                <th>Quantity</th>
                                                <th>Amount</th>
                                                <th>Subtotal</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $grand_total = 0;
                                            $current_date = null;
                                            @endphp
                                            @foreach($hemodialysis as $dialysis)
                                            @php
                                            // Check if we need to display a new date row
                                            if($current_date !== $dialysis->date_created){
                                            // If this is not the first row, output the grand total for the previous date
                                            if($current_date !== null){
                                            echo "<tr>
                                                <td colspan=\"3\"><strong>DATE:</strong>$current_date</td>
                                                <td style='text-align:right;' colspan=\"1\"><strong>GRAND
                                                        TOTAL:</strong></td>
                                                <td>$format_total</td>
                                            </tr>";
                                            }
                                            // Reset the grand total and update the current date
                                            $grand_total = 0;
                                            $current_date = $dialysis->date_created;
                                            }
                                            // Update the grand total
                                            $grand_total += $dialysis->qty * $dialysis->purchase_amount;
                                            $format_total = number_format($grand_total ,2);
                                            @endphp
                                            <tr>
                                                <td>
                                                    <p>{{$dialysis->test}}</p>
                                                </td>
                                                <td>
                                                    <p>{{$dialysis->name}}</p>
                                                </td>
                                                <td>
                                                    <p>{{$dialysis->qty}}</p>
                                                </td>
                                                <td>
                                                    <p>{{ number_format($dialysis->purchase_amount,2) }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ number_format($dialysis->qty *
                                                        $dialysis->purchase_amount,2) }}</p>
                                                </td>

                                            </tr>
                                            @endforeach
                                            <!-- Output the grand total for the last date  -->
                                            <tr class="border-0">
                                                <td colspan="3"><strong>DATE:</strong>{{ $current_date }}</td>
                                                <td style='text-align:right;' colspan="1"><strong>GRAND TOTAL:</strong>
                                                </td>
                                                <td>{{ number_format($grand_total,2) }}</td>


                                            </tr>
                                        </tbody>
                                    </table>
                                    @else
                                    <br>
                                    <small>No Data for Hemodialysis Report</small>
                                    @endempty
                                </div>




                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>







        <!-- begin:: Content -->
        @endsection